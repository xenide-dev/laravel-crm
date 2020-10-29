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
                    // id_number: {
                    //     validators: {
                    //         notEmpty: {
                    //             message: 'Player ID number is required'
                    //         },
                    //     }
                    // },
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
                            confirmButtonText: "Yes, add it now!",
                            cancelButtonText: "No, cancel!",
                            reverseButtons: true,
                            customClass: {
                                confirmButton: "btn btn-success",
                                cancelButton: "btn btn-default"
                            }
                        }).then(function(result) {
                            if (result.value) {
                                $("#" + frm_Item).submit();
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
                {data: 'subjects'},
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
        // var repeatVal = $('#repeat_item').repeaterVal();
        // // remove fields
        // for(var i = 0; i <= highest + 2; i++){
        //     try {
        //         frmValidation.removeField('org[' + i + '][org_position][]');
        //         frmValidation.removeField('org[' + i + '][org_name]');
        //     }catch(err){
        //         // console.log(err);
        //     }
        // }
        // // readd again
        // repeatVal.org.forEach(function(item, index){
        //     if(highest < index){
        //         highest = index;
        //     }
        //     frmValidation.addField('org[' + index + '][org_name]', {
        //         validators: {
        //             notEmpty: {
        //                 message: "Please select an organization"
        //             }
        //         }
        //     });
        //     frmValidation.addField('org[' + index + '][org_position][]', {
        //         validators: {
        //             notEmpty: {
        //                 message: "The position is required"
        //             }
        //         }
        //     });
        // });
    }

    var initNotes = function() {
        tinymce.init({
            selector: '#other_info',
            placeholder: 'Add some notes here',
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | image | preview ',
            plugins : 'advlist autolink link lists charmap preview image',
            image_title: true,
            automatic_uploads: true,
            file_picker_types: 'image',
            file_picker_callback: function (cb, value, meta) {
                var input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');

                /*
                  Note: In modern browsers input[type="file"] is functional without
                  even adding it to the DOM, but that might not be the case in some older
                  or quirky browsers like IE, so you might want to add it to the DOM
                  just in case, and visually hide it. And do not forget do remove it
                  once you do not need it anymore.
                */

                input.onchange = function () {
                    var file = this.files[0];

                    var reader = new FileReader();
                    reader.onload = function () {
                        /*
                          Note: Now we need to register the blob in TinyMCEs image blob
                          registry. In the next release this part hopefully won't be
                          necessary, as we are looking to handle it internally.
                        */
                        var id = 'blobid' + (new Date()).getTime();
                        var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
                        var base64 = reader.result.split(',')[1];
                        var blobInfo = blobCache.create(id, file, base64);
                        blobCache.add(blobInfo);

                        /* call the callback and populate the Title field with the file name */
                        cb(blobInfo.blobUri(), { title: file.name });
                    };
                    reader.readAsDataURL(file);
                };

                input.click();
            },
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:14px }'
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
            initNotes();
        }
    };
}();

// Initialization
jQuery(document).ready(function() {
    ListDatatable.init();
    ListDatatable.initSet();

    $(document).on('click', '.reported-user', function() {
        $("#id_number").val('');
        $("#full_name").val('');

        var $this = $(this);
        if(!isNaN(parseInt($this.data("value")))){
            $("#id_number").val($this.data("value"));
        }else{
            $("#full_name").val($this.data("value"));
        }
    })
});

$(document).on('focusin', function(e) {
    if ($(e.target).closest(".tox-tinymce-aux, .moxman-window, .tam-assetmanager-root").length) {
        e.stopImmediatePropagation();
    }
});

