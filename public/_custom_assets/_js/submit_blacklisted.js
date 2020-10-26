"use strict";

var datatable_name_id = "list-datatable";
var frm_Item = "frmCreateItem";
var frmValidation = null;
var frmUpdateValidation = null;
var highest = 0;
var orgData = null;
var frm_Item2 = "frmOrgItem";
var frmOrgValidation = null;

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
                {data: 'country'},
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
                        var view = `<a href="javascript:;" class="btn btn-sm btn-clean btn-icon view-item" title="View details" data-toggle="modal" data-target="#modal-view-item" data-id="${full.id}" data-key="${full.id_key}">
                                        <i class="la la-search"></i>
                                    </a>`;
                        var b_delete = `<a href="javascript:;" class="btn btn-sm btn-clean btn-icon delete-item" title="Delete" data-id="${full.id}" data-key="${full.id_key}">
                                            <i class="la la-trash text-danger"></i>
                                        </a>`;
                        var b_update = `<a href="javascript:;" class="btn btn-sm btn-clean btn-icon update-item" title="Update" data-toggle="modal" data-target="#modal-update-item" data-id="${full.id}" data-key="${full.id_key}">
                                            <i class="la la-edit text-primary"></i>
                                        </a>`;


                        return view + (full.user_type != "user" ? b_update + b_delete : '');
                    },
                },
            ],
        });
    };

    var reload = function() {
        var table = $('#' + datatable_name_id).DataTable();
        table.ajax.reload();
    };

    var initCountry = function() {
        var data = $.map(country_list, function (obj) {
            obj.id = `${obj.name}`;
            obj.text = obj.name;
            return obj;
        });
        $('#country').select2({
            placeholder: "Select a country",
            data: data
        });
        $('#update_country').select2({
            placeholder: "Select a country",
            data: data
        });
    }

    var initValidation = function () {
        frmValidation = FormValidation.formValidation(
            document.getElementById(frm_Item),
            {
                fields: {
                    // banned_date: {
                    //     validators: {
                    //         notEmpty: {
                    //             message: 'Date is required'
                    //         },
                    //     }
                    // },
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
        // for update
        frmUpdateValidation = FormValidation.formValidation(
            document.getElementById("frmUpdateItem"),
            {
                fields: {
                    // banned_date: {
                    //     validators: {
                    //         notEmpty: {
                    //             message: 'Date is required'
                    //         },
                    //     }
                    // },
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
                    org_id: {
                        validators: {
                            notEmpty: {
                                message: 'Organization ID number is required'
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
        $("#btnSubmit").on("click", function() {
            initAddField();
            if(frmValidation){
                frmValidation.validate().then(function(status) {
                    if(status == "Valid"){
                        Swal.fire({
                            title: "Are you sure?",
                            text: "This user will be added to the blacklist",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonText: "Yes!",
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
        $("#btnUpdateSubmit").on("click", function() {
            if(frmValidation){
                frmValidation.validate().then(function(status) {
                    if(status == "Valid"){
                        Swal.fire({
                            title: "Are you sure?",
                            text: "",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonText: "Yes!",
                            cancelButtonText: "No, cancel!",
                            reverseButtons: true,
                            customClass: {
                                confirmButton: "btn btn-success",
                                cancelButton: "btn btn-default"
                            }
                        }).then(function(result) {
                            if (result.value) {
                                $("#frmUpdateItem").submit();
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
                                        id_number: $("#org_id").val(),
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

    var initRepeater = function() {
        $('#repeat_item').repeater({
            initEmpty: false,
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

        $('#update_repeat_item').repeater({
            initEmpty: false,
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
        // $('.select2-container').remove();
        $('.org_name').select2({
            placeholder: "Select Value",
            data: data
        });
        $('.select2-container').css('width','100%');
    }


    var initAddField = function() {
        // TODO check here
        try {
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
            // if(repeatVal.org){
            //     repeatVal.org.forEach(function(item, index){
            //         if(highest < index){
            //             highest = index;
            //         }
            //         frmValidation.addField('org[' + index + '][org_name]', {
            //             validators: {
            //                 notEmpty: {
            //                     message: "Please select an organization"
            //                 }
            //             }
            //         });
            //         frmValidation.addField('org[' + index + '][org_position][]', {
            //             validators: {
            //                 notEmpty: {
            //                     message: "The position is required"
            //                 }
            //             }
            //         });
            //     });
            // }
        } catch (err) {
            // console.log(err);
        }
    }

    var initNotes = function () {
        tinymce.init({
            selector: '#tinymce-body, #update-tinymce-body',
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
            initNotes();
            initCountry();
        }
    };

}();

jQuery(document).ready(function() {
    ListDatatable.init();
    ListDatatable.initSet();

    $(document).on('click', '.delete-item', function() {
        var $this = $(this);
        Swal.fire({
            title: "Are you sure?",
            text: "All of the information associated with this user will also be deleted",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it now!",
            cancelButtonText: "No, cancel!",
            reverseButtons: true,
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-default"
            }
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    url: "/api/blacklist/delete",
                    type: "POST",
                    dataType: "json",
                    data: {
                        api_token: document.querySelector("meta[name='at']").getAttribute("content"),
                        id: $this.data("id"),
                        id_key: $this.data("key"),
                    },
                    success: function(result, status, xhr){
                        if(result.status == "success"){
                            notify("Success", "User has been removed to the blacklist", "success")
                            ListDatatable.reload();
                        }
                    },
                    error: function(xhr, status, error){
                        notify("Error", xhr, "danger")
                    }
                });
            }
        });
    });

    $(document).on('click', '.view-item', function() {
        var $this = $(this);
        $.ajax({
            url: "/api/blacklist/get",
            type: "POST",
            dataType: "json",
            data: {
                api_token: document.querySelector("meta[name='at']").getAttribute("content"),
                id: $this.data("id"),
                id_key: $this.data("key"),
            },
            success: function(result, status, xhr){
                $("#modal-view-item input").val('');
                $('.user_organization').html("<h3>Organizations:</h3>");
                if(result.status == "success"){
                    $('#modal-view-item [name="banned_date"]').val(result.banned_date);
                    $('#modal-view-item [name="id_number"]').val(result.user.id_number);
                    $('#modal-view-item [name="fname"]').val(result.user.fname);
                    $('#modal-view-item [name="mname"]').val(result.user.mname);
                    $('#modal-view-item [name="lname"]').val(result.user.lname);
                    $('#modal-view-item [name="email"]').val(result.user.email);
                    $('#modal-view-item [name="phone_number"]').val(result.user.phone_number);
                    $('#modal-view-item [name="country"]').val(result.user.country);
                    $('#modal-view-item #view-tinymce-body').html(result.user.notes);
                    $('#modal-view-item [name="ign"]').val(result.user.ign);
                    var unions = "", clubs = "";
                    result.user.user_organization.forEach(function(item, index){
                        if(clubs == ""){
                            clubs = "<h5>Club/s:</h5><ul>";
                        }
                        if(unions == ""){
                            unions = "<h5>Union/s:</h5><ul>"
                        }
                        if(item.organization.type == "Club"){
                            clubs += `<li>(${item.organization.id_number}) ${item.organization.name}</li>`;
                        }else if(item.organization.type == "Union"){
                            unions += `<li>(${item.organization.id_number}) ${item.organization.name}</li>`;
                        }
                    });
                    if(unions != ""){
                        unions += "</ul>";
                        $('.user_organization').append(unions);
                    }
                    if(clubs != ""){
                        clubs += "</ul>";
                        $('.user_organization').append(clubs);
                    }

                    result.user.blacklist_contact_info.forEach(function(item, index){
                        $('#modal-view-item [name="' + item.name + '"]').val(item.value);
                        // if(item.name == "telegram"){
                        //     $('#modal-view-item [name="telegram"]').val(item.value);
                        // }else if(item.name == "whatsapp"){
                        //     $('#modal-view-item [name="whatsapp"]').val(item.value);
                        // }else if(item.name == "facebook"){
                        //     $('#modal-view-item [name="facebook"]').val(item.value);
                        // }else if(item.name == "twitter"){
                        //     $('#modal-view-item [name="twitter"]').val(item.value);
                        // }else if(item.name == "instagram"){
                        //     $('#modal-view-item [name="instagram"]').val(item.value);
                        // }
                    });
                }
            },
            error: function(xhr, status, error){
                notify("Error", xhr, "danger")
            }
        });
    });

    // for onclick update
    $(document).on('click', '.update-item', function() {
        var $this = $(this);
        $.ajax({
            url: "/api/blacklist/get",
            type: "POST",
            dataType: "json",
            data: {
                api_token: document.querySelector("meta[name='at']").getAttribute("content"),
                id: $this.data("id"),
                id_key: $this.data("key"),
            },
            success: function(result, status, xhr){
                $("#modal-update-item input").val('');
                $('.user_organization').html("<h3>Organizations:</h3>");
                if(result.status == "success"){
                    $('#modal-update-item [name="banned_date"]').val(result.banned_date);
                    $('#modal-update-item [name="id_number"]').val(result.user.id_number);
                    $('#modal-update-item [name="fname"]').val(result.user.fname);
                    $('#modal-update-item [name="mname"]').val(result.user.mname);
                    $('#modal-update-item [name="lname"]').val(result.user.lname);
                    $('#modal-update-item [name="email"]').val(result.user.email);
                    $('#modal-update-item [name="phone_number"]').val(result.user.phone_number);
                    $('#modal-update-item [name="country"]').val(result.user.country);
                    $('#modal-update-item #update-tinymce-body').html(result.user.notes);
                    $('#modal-update-item [name="ign"]').val(result.user.ign);
                    var unions = "", clubs = "";
                    result.user.user_organization.forEach(function(item, index){
                        if(clubs == ""){
                            clubs = "<h5>Club/s:</h5><ul>";
                        }
                        if(unions == ""){
                            unions = "<h5>Union/s:</h5><ul>"
                        }
                        if(item.organization.type == "Club"){
                            clubs += `<li>(${item.organization.id_number}) ${item.organization.name}</li>`;
                        }else if(item.organization.type == "Union"){
                            unions += `<li>(${item.organization.id_number}) ${item.organization.name}</li>`;
                        }
                    });
                    if(unions != ""){
                        unions += "</ul>";
                        $('.user_organization').append(unions);
                    }
                    if(clubs != ""){
                        clubs += "</ul>";
                        $('.user_organization').append(clubs);
                    }

                    result.user.blacklist_contact_info.forEach(function(item, index){
                        $('#modal-update-item [name="' + item.name + '"]').val(item.value);
                        // if(item.name == "telegram"){
                        //     $('#modal-view-item [name="telegram"]').val(item.value);
                        // }else if(item.name == "whatsapp"){
                        //     $('#modal-view-item [name="whatsapp"]').val(item.value);
                        // }else if(item.name == "facebook"){
                        //     $('#modal-view-item [name="facebook"]').val(item.value);
                        // }else if(item.name == "twitter"){
                        //     $('#modal-view-item [name="twitter"]').val(item.value);
                        // }else if(item.name == "instagram"){
                        //     $('#modal-view-item [name="instagram"]').val(item.value);
                        // }
                    });
                }
            },
            error: function(xhr, status, error){
                notify("Error", xhr, "danger")
            }
        });
    });
});

$(document).on('focusin', function(e) {
    if ($(e.target).closest(".tox-tinymce-aux, .moxman-window, .tam-assetmanager-root").length) {
        e.stopImmediatePropagation();
    }
});
