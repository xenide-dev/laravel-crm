"use strict";

var datatable_name_id = "list-datatable";
var frm_Item = "frmCreateItem";
var frmValidation = null;
var highest = 0;
var orgData = null;

var ListDatatable = function() {
    var table = $('#' + datatable_name_id);

    var initTable1 = function() {
        // begin first table
        table.DataTable({
            responsive: true,
            // searchDelay: 500,
            ajax: {
                url: "/api/list/blacklisted",
                type: 'POST',
                data: {
                    api_token: document.querySelector("meta[name='at']").getAttribute("content")
                },
            },
            columns: [
                {data: 'id_number'},
                {data: 'created_at'},
                {data: 'name'},
                {data: 'organizations'},
                {data: 'added_by'},
                {data: 'options', responsivePriority: -1},
            ],
            columnDefs: [
                {
                    targets: -1,
                    title: 'Actions',
                    orderable: false,
                    render: function(data, type, full, meta) {
                        return `
							<a href="javascript:;" class="btn btn-sm btn-clean btn-icon" title="Edit details">
								<i class="la la-edit"></i>
							</a>` + (!full.iM ? `
							<a href="javascript:;" class="btn btn-sm btn-clean btn-icon" title="Delete">
								<i class="la la-trash text-danger"></i>
							</a>`: '');
                    },
                },
            ],
        });
    };

    var reload = function() {
        var table = $('#' + datatable_name_id).DataTable();
        table.ajax.reload();
    };

    var initValidation = function () {
        frmValidation = FormValidation.formValidation(
            document.getElementById(frm_Item),
            {
                fields: {
                    banned_date: {
                        validators: {
                            notEmpty: {
                                message: 'Date is required'
                            },
                        }
                    },
                    id_number: {
                        validators: {
                            notEmpty: {
                                message: 'Player ID number is required'
                            },
                        }
                    },
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap(),
                    submitButton: new FormValidation.plugins.SubmitButton(),
                    // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
                }
            }
        );
        $("#btnSubmit").on("click", function() {
            initAddField();
            if(frmValidation){
                frmValidation.validate().then(function(status) {
                    if(status == "Valid"){
                        Swal.fire({
                            title: "Are you sure?",
                            text: "This organization will be created",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonText: "Yes, create it now!",
                            cancelButtonText: "No, cancel!",
                            reverseButtons: true,
                            customClass: {
                                confirmButton: "btn btn-success",
                                cancelButton: "btn btn-default"
                            }
                        }).then(function(result) {
                            if (result.value) {
                                $("#" + frm_Item).submit();
                            } else if (result.dismiss === "cancel") {

                            }
                        });
                    }else{
                        Swal.fire({
                            text: "Sorry, looks like there are some errors detected, please try again.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn font-weight-bold btn-light"
                            }
                        });
                    }
                });
            }
        });
    }

    var initRepeater = function() {
        $('#repeat_item').repeater({
            initEmpty: false,
            defaultValues: {
                'text-input': 'foo'
            },
            show: function() {
                initAddField();
                initOrgName();
                $(this).slideDown();
            },
            hide: function(deleteElement) {
                if(confirm('Are you sure you want to delete this element?')) {
                    var repeatVal = $('#repeat_item').repeaterVal();
                    // remove fields
                    for(var i = 0; i <= highest + 2; i++){
                        console.log(repeatVal);
                        try {
                            frmValidation.removeField('org[' + i + '][org_position][]');
                            frmValidation.removeField('org[' + i + '][org_name]');
                        }catch(err){
                            // console.log(err);
                        }
                    }
                    $(this).slideUp(deleteElement);
                }
            },
        });
    }

    var initOrgName = function() {
        if(!orgData){
            $.ajax({
                url: "/api/basicload/organizations",
                type: "POST",
                dataType: "json",
                data: {
                    api_token: document.querySelector("meta[name='at']").getAttribute("content")
                },
                success: function(result, status, xhr){
                    orgData = result;
                    initSelect2();
                },
                error: function(xhr, status, error){
                    console.log(xhr);
                }
            });
        }else{
            initSelect2();
        }
    }

    var initSelect2 = function() {
        var data = $.map(orgData, function (obj) {
            var org_name = obj.name;
            if(org_name){
                obj.text = obj.id_number + " (" + org_name + ")";
            }else{
                obj.text = obj.id_number;
            }
            return obj;
        });
        $('.select2-container').remove();
        $('.select2').select2({
            placeholder: "Select Value",
            data: data
        });
        $('.select2-container').css('width','100%');
    }


    var initAddField = function() {
        // TODO check here
        try {
            var repeatVal = $('#repeat_item').repeaterVal();
            // remove fields
            for(var i = 0; i <= highest + 2; i++){
                console.log(repeatVal);
                try {
                    frmValidation.removeField('org[' + i + '][org_position][]');
                    frmValidation.removeField('org[' + i + '][org_name]');
                }catch(err){
                    // console.log(err);
                }
            }
            // readd again
            if(repeatVal.org){
                repeatVal.org.forEach(function(item, index){
                    if(highest < index){
                        highest = index;
                    }
                    frmValidation.addField('org[' + index + '][org_name]', {
                        validators: {
                            notEmpty: {
                                message: "Please select an organization"
                            }
                        }
                    });
                    frmValidation.addField('org[' + index + '][org_position][]', {
                        validators: {
                            notEmpty: {
                                message: "The position is required"
                            }
                        }
                    });
                });
            }
        } catch (err) {
            // console.log(err);
        }
    }

    var initNotes = function () {
        tinymce.init({
            selector: '#tinymce-body',
            placeholder: 'Add some notes here',
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | preview',
            plugins : 'advlist autolink link lists charmap preview',
        });
    }

    return {
        //main function to initiate the module
        init: function() {
            initTable1();
        },
        reload: function() {
            reload();
        },
        initSet: function() {
            initValidation();
            initRepeater();
            initOrgName();
            initAddField();
            initNotes()
        }
    };

}();

jQuery(document).ready(function() {
    ListDatatable.init();
    ListDatatable.initSet();
});
