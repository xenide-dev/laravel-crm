"use strict";

var datatable_name_id = "list-datatable";
var whitelistJSON = [];
var frm_Item = "frmCreateItem";
var frm_Item2 = "frmOrgItem";
var frmValidation = null;
var frmOrgValidation = null;
var highest = 0;
var orgData = null;

// Class definition
var ListDatatable = function () {
    var table = $('#' + datatable_name_id);

    function notify(title = "", message, type = "success") {
        var icon_name = "fas fa-check-circle";
        if(type == "danger"){
            icon_name = "fas fa-times-circle";
        }else if(type == "warning"){
            icon_name = "fas fa-exclamation-triangle";
        }else if(type == "info") {
            icon_name = "fas fa-exclamation-circle";
        }
        var content = {
            title: title,
            icon: 'icon ' + icon_name,
            message: message
        };

        var notify = $.notify(content, {
            type: type,
            allow_dismiss: true,
            newest_on_top: true,
            timer: 5000,
            z_index: 10000,
            animate: {
                enter: 'animate__animated animate__swing',
                exit: 'animate__animated animate__fadeOut'
            }
        });
    }

    var initValidation = function () {
        frmValidation = FormValidation.formValidation(
            document.getElementById(frm_Item),
            {
                fields: {
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
        frmOrgValidation = FormValidation.formValidation(
            document.getElementById(frm_Item2),
            {
                fields: {
                    org_name: {
                        validators: {
                            notEmpty: {
                                message: 'Organization Name is required'
                            },
                        }
                    },
                    org_type: {
                        validators: {
                            notEmpty: {
                                message: 'Organization Type is required'
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
        // for Reported User
        $("#btnSubmit").on("click", function() {
            initAddField();
            if(frmValidation){
                frmValidation.validate().then(function(status) {
                    if(status == "Valid"){
                        Swal.fire({
                            title: "Are you sure?",
                            text: "This user will be added to the reported list",
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
                                // TODO update send to api
                                // var object = {};
                                // var formData = $("#frmCreateItem").serializeArray();
                                // formData.forEach((value, key) => {
                                //     // Reflect.has in favor of: object.hasOwnProperty(key)
                                //     if(!Reflect.has(object, key)){
                                //         object[key] = value;
                                //         return;
                                //     }
                                //     if(!Array.isArray(object[key])){
                                //         object[key] = [object[key]];
                                //     }
                                //     object[key].push(value);
                                // });
                                // var json = JSON.stringify(object);
                                // $.ajax({
                                //     url: "/api/reported_user/create",
                                //     type: "POST",
                                //     dataType: "json",
                                //     data: {
                                //         api_token: document.querySelector("meta[name='at']").getAttribute("content"),
                                //         data: object
                                //     },
                                //     success: function(result, status, xhr){
                                //         if(result.status == "success"){
                                //
                                //         }else{
                                //             console.log("error creating");
                                //         }
                                //     },
                                //     error: function(xhr, status, error){
                                //         xhr.responseJSON.errors.name.forEach(function(item, index) {
                                //             notify("Error", item, "danger");
                                //         });
                                //     }
                                // });
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
        // for Organization
        $("#btnOrgSubmit").on("click", function() {
            if(frmOrgValidation){
                frmOrgValidation.validate().then(function(status) {
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
                                $.ajax({
                                    url: "/api/organization/create",
                                    type: "POST",
                                    dataType: "json",
                                    data: {
                                        api_token: document.querySelector("meta[name='at']").getAttribute("content"),
                                        name: $("#org_name").val(),
                                        type: $("#org_type").val(),
                                    },
                                    success: function(result, status, xhr){
                                        if(result.status == "success"){
                                            // reload org list
                                            initOrgName(true);
                                            notify("Success", "The organization has been created", "success");
                                            document.getElementById("frmOrgItem").reset();
                                            $("#org_type").selectpicker("refresh");
                                            $('#modal-add-org').modal('toggle');
                                        }else{
                                            console.log("error creating");
                                        }
                                    },
                                    error: function(xhr, status, error){
                                        xhr.responseJSON.errors.name.forEach(function(item, index) {
                                            notify("Error", item, "danger");
                                            document.getElementById("frmOrgItem").reset();
                                            $("#org_type").selectpicker("refresh");
                                            frmOrgValidation.resetForm(true);
                                        });
                                    }
                                });
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

    var initTable1 = function() {
        // begin first table
        table.DataTable({
            responsive: true,
            // searchDelay: 500,
            ajax: {
                url: "/api/ticketlist",
                type: 'POST',
                data: {
                    api_token: document.querySelector("meta[name='at']").getAttribute("content")
                },
            },
            columns: [
                {data: 'id'},
                {data: 'created_at'},
                {data: 'from'},
                {data: 'input_names'},
                {data: 'status'},
                {data: 'other_info'},
                {data: 'options', responsivePriority: -1},
            ],
            columnDefs: [
                {
                    targets: -1,
                    title: 'Actions',
                    orderable: false,
                    render: function(data, type, full, meta) {
                        return `
							<a href="/ticketlist/${full.uuid_ticket}/${full.id}" class="btn btn-sm btn-clean btn-icon" title="View details">
								<i class="la la-ticket"></i>
							</a>
							<div class="dropdown dropdown-inline">
								<a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown">
	                                <i class="la la-cog"></i>
	                            </a>
							  	<div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
									<ul class="nav nav-hoverable flex-column">
									    <li class="nav-item">
									        <a class="nav-link" href="javascript:;">
									            <i class="nav-icon la la-ticket"></i>
                                                <span class="nav-text">View</span>
                                            </a>
									    </li>
									</ul>
							  	</div>
							</div>
                            <a href="javascript:;" class="btn btn-sm btn-clean btn-icon" title="Delete">
								<i class="la la-trash text-danger"></i>
							</a>`;
                    },
                },
            ],
        });
    };

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
                    $(this).slideUp(deleteElement);
                }
            },
            isFirstItemUndeletable: true
        });
    }

    var initOrgName = function(isReload = false) {
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
            if(isReload){
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
    }

    var initSelect2 = function() {
        var data = $.map(orgData, function (obj) {
            obj.text = obj.name;
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
        var repeatVal = $('#repeat_item').repeaterVal();
        // remove fields
        for(var i = 0; i <= highest + 2; i++){
            try {
                frmValidation.removeField('org[' + i + '][org_position][]');
                frmValidation.removeField('org[' + i + '][org_name]');
            }catch(err){
                // console.log(err);
            }
        }
        // readd again
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

    return {
        // public functions
        init: function() {
            initTable1();
        },
        initSet: function() {
            initValidation();
            initRepeater();
            initOrgName();
            initAddField();
        }
    };
}();

// Initialization
jQuery(document).ready(function() {
    ListDatatable.init();
    ListDatatable.initSet();

    $(document).on('click', '.reported-user', function() {
        var $this = $(this);
        $("#full_name").val($this.data("value"));
    })
});
