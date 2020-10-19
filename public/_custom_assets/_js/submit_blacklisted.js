"use strict";

var datatable_name_id = "list-datatable";
var frm_Item = "frmCreateItem";
var frmValidation = null;
var highest = 0;

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
                {data: 'position'},
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
                    fname: {
                        validators: {
                            notEmpty: {
                                message: 'First Name is required'
                            },
                        }
                    },
                    lname: {
                        validators: {
                            notEmpty: {
                                message: 'Last Name is required'
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
                    initAddField();
                    $(this).slideUp(deleteElement);
                }
            }
        });
    }

    var initOrgName = function() {
        // var data = $.map(country_list, function (obj) {
        //     obj.id = obj.code;
        //     obj.text = obj.name;
        //     return obj;
        // });
        $('.select2-container').remove();
        $('.select2').select2({
            placeholder: "Select Value",
            allowClear: true
        });
        $('.select2-container').css('width','100%');
    }


    var initAddField = function() {
        // TODO check here
        var repeatVal = $('#repeat_item').repeaterVal();
        console.log(highest);
        // remove fields
        for(var i = 0; i <= highest + 2; i++){
            try {
                frmValidation.removeField('org[' + i + '][org_position][]');
            }catch(err){
                console.log(err);
            }
        }
        // readd again
        repeatVal.org.forEach(function(item, index){
            if(highest < index){
                highest = index;
            }
            frmValidation.addField('org[' + index + '][org_position][]', {
                validators: {
                    notEmpty: {
                        message: "The position is required"
                    }
                }
            });
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
        }
    };

}();

jQuery(document).ready(function() {
    ListDatatable.init();
    ListDatatable.initSet();
});
