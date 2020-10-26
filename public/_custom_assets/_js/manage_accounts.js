"use strict";

var frmValidation = null;
var highest = 0;
var orgData = null;

var ListAccountDataTable = function() {
    var table = $('#list_acct_datatable');

    var initTable1 = function() {
        // begin first table
        table.DataTable({
            responsive: true,
            searchDelay: 500,
            processing: true,
            serverSide: true,
            ajax: {
                url: "/api/list/accounts",
                type: 'POST',
                data: {
                    api_token: document.querySelector("meta[name='at']").getAttribute("content")
                    // parameters for custom backend script demo
                    // columnsDef: [
                    // 	'OrderID', 'Country',
                    // 	'ShipAddress', 'CompanyName', 'ShipDate',
                    // 	'Status', 'Type', 'Actions'],
                },
            },
            columns: [
                {data: 'id_number'},
                {data: 'fname'},
                {data: 'mname'},
                {data: 'lname'},
                {data: 'email'},
                {data: 'user_type'},
                {data: 'last_online_at'},
                {data: 'options', responsivePriority: -1},
            ],
            columnDefs: [
                {
                    targets: -1,
                    title: 'Actions',
                    orderable: false,
                    render: function(data, type, full, meta) {
                        return `
							<div class="dropdown dropdown-inline">
								<a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown">
	                                <i class="la la-cog"></i>
	                            </a>
							  	<div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
									<ul class="nav nav-hoverable flex-column">
									    <li class="nav-item view-item" data-toggle="modal" data-target="#modal-view-item" data-id="${full.id}" data-key="${full.id_key}"><a class="nav-link" href="javascript:;"><i class="nav-icon la la-user"></i><span class="nav-text">View Account</span></a></li>`
							    		+ (!full.iM ? `<li class="nav-item"><a class="nav-link" href="${ BASE_URL + "/accounts/" + full.id + "/privilege/get?isHide=1"}"><i class="nav-icon la la-leaf"></i><span class="nav-text">Update Privileges</span></a></li>` : '') +
                                    `</ul>
							  	</div>
							</div>
							<a href="javascript:;" class="btn btn-sm btn-clean btn-icon" title="Edit details">
								<i class="la la-edit"></i>
							</a>` + (!full.iM ? `
							<a href="javascript:;" class="btn btn-sm btn-clean btn-icon deleteAccount" title="Delete" data-id="${full.id}" data-key="${full.id_key}">
								<i class="la la-trash text-danger"></i>
							</a>`: '');
                    },
                },
                // {
                // 	width: '75px',
                // 	targets: -3,
                // 	render: function(data, type, full, meta) {
                // 		var status = {
                // 			1: {'title': 'Pending', 'class': 'label-light-primary'},
                // 			2: {'title': 'Delivered', 'class': ' label-light-danger'},
                // 			3: {'title': 'Canceled', 'class': ' label-light-primary'},
                // 			4: {'title': 'Success', 'class': ' label-light-success'},
                // 			5: {'title': 'Info', 'class': ' label-light-info'},
                // 			6: {'title': 'Danger', 'class': ' label-light-danger'},
                // 			7: {'title': 'Warning', 'class': ' label-light-warning'},
                // 		};
                // 		if (typeof status[data] === 'undefined') {
                // 			return data;
                // 		}
                // 		return '<span class="label label-lg font-weight-bold' + status[data].class + ' label-inline">' + status[data].title + '</span>';
                // 	},
                // },
                // {
                // 	width: '75px',
                // 	targets: -2,
                // 	render: function(data, type, full, meta) {
                // 		var status = {
                // 			1: {'title': 'Online', 'state': 'danger'},
                // 			2: {'title': 'Retail', 'state': 'primary'},
                // 			3: {'title': 'Direct', 'state': 'success'},
                // 		};
                // 		if (typeof status[data] === 'undefined') {
                // 			return data;
                // 		}
                // 		return '<span class="label label-' + status[data].state + ' label-dot mr-2"></span>' +
                // 			'<span class="font-weight-bold text-' + status[data].state + '">' + status[data].title + '</span>';
                // 	},
                // },
            ],
        });
    };

    var reload = function() {
        var table = $('#list_acct_datatable').DataTable();
        table.ajax.reload();
    };

    var initCountry = function() {
        var data = $.map(country_list, function (obj) {
            obj.id = `${obj.name} (${obj.code}) ${obj.dial_code}`;
            obj.text = obj.name;
            return obj;
        });
        $('#pref_country').select2({
            placeholder: "Select a country",
            data: data
        });
        $("#pref_country").on("select2:select", function(e){
            $("#country_code").text(e.params.data.dial_code);
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
    }

    var initAddField = function() {
        // TODO check here
        try {
            // var repeatVal = $('#repeat_item').repeaterVal();
            // // remove fields
            // for(var i = 0; i <= highest + 2; i++){
            //     console.log(repeatVal);
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
        // $('.select2-container').remove();
        $('.org_name').select2({
            placeholder: "Select Value",
            data: data
        });
        $('.select2-container').css('width','100%');
    }

    var initSettings = function() {
        // for data-switch
        $('[data-switch=true]').bootstrapSwitch();

        // for new account modal: checkboxes
        $('#modify_role').click(function(){
            if($(this).prop("checked") == true){
                $("#send_confirmation").prop("disabled", true);
                $("#send_confirmation").parent("label").toggleClass("checkbox-disabled");
            }
            else if($(this).prop("checked") == false){
                $("#send_confirmation").prop("disabled", false);
                $("#send_confirmation").parent("label").toggleClass("checkbox-disabled");
            }
        });
    }

    var initValidation = function () {
        frmValidation = FormValidation.formValidation(
            document.getElementById('frmCreateAccount'),
            {
                fields: {
                    email: {
                        validators: {
                            notEmpty: {
                                message: 'Email is required'
                            },
                            emailAddress: {
                                message: 'The value is not a valid email address'
                            }
                        }
                    },
                    fname: {
                        validators: {
                            notEmpty: {
                                message: "First Name is required"
                            }
                        }
                    },
                    lname: {
                        validators: {
                            notEmpty: {
                                message: "Last Name is required"
                            }
                        }
                    },
                    country: {
                        validators: {
                            notEmpty: {
                                message: 'Please select a country'
                            }
                        }
                    },
                    phone_number: {
                        validators: {
                            notEmpty: {
                                message: 'Phone Number is required'
                            }
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
                            text: "This account will be created",
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
                                $("#frmCreateAccount").submit();
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

    return {
        //main function to initiate the module
        init: function() {
            initTable1();
        },
        reload: function() {
            reload();
        },
        initSet: function() {
            initCountry();
            initSettings();
            initValidation();
            initRepeater();
            initOrgName();
            initAddField();
        }
    };

}();

jQuery(document).ready(function() {
    ListAccountDataTable.init();
    ListAccountDataTable.initSet();
    $('[data-toggle="tooltip"]').tooltip();

    $(".btn-add-account").on("click", function() {
        ListAccountDataTable.reload();
    })

    $(document).on('click', '.deleteAccount', function() {
        var $this = $(this);
        Swal.fire({
            title: "Are you sure?",
            text: "All of the information associated with this account will also be deleted",
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
                    url: "/api/account/delete",
                    type: "POST",
                    dataType: "json",
                    data: {
                        api_token: document.querySelector("meta[name='at']").getAttribute("content"),
                        id: $this.data("id"),
                        id_key: $this.data("key"),
                    },
                    success: function(result, status, xhr){
                        if(result.status == "success"){
                            notify("Success", "Account has been deleted", "success")
                            ListAccountDataTable.reload();
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
            url: "/api/account/get",
            type: "POST",
            dataType: "json",
            data: {
                api_token: document.querySelector("meta[name='at']").getAttribute("content"),
                id: $this.data("id"),
                id_key: $this.data("key"),
            },
            success: function(result, status, xhr){
                if(result.status == "success"){
                    // clear all fields
                    $("#modal-view-item input").val('');
                    $('.user_organization').html("<h3>Organizations:</h3>");
                    $('#modal-view-item [name="fname"]').val(result.user.fname);
                    $('#modal-view-item [name="mname"]').val(result.user.mname);
                    $('#modal-view-item [name="lname"]').val(result.user.lname);
                    $('#modal-view-item [name="suffix"]').val(result.user.suffix);
                    $('#modal-view-item [name="email"]').val(result.user.email);
                    $('#modal-view-item [name="id_number"]').val(result.user.id_number);
                    $('#modal-view-item [name="ign"]').val(result.user.ign);
                    $('#modal-view-item [name="temporary_password"]').val(result.temp_pass);
                    $('#modal-view-item [name="phone_number"]').val(result.user.country + " " + result.user.phone_number);
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

                    result.user.contact_info.forEach(function(item, index){
                        $('#modal-view-item [name="' + item.name + '"]').val(item.value);
                        // if(item.name == "telegram"){
                        //     $('#modal-view-item [name="telegram"]').val(item.value);
                        // }else if(item.name == "whatsapp"){
                        //     $('#modal-view-item [name="whatsapp"]').val(item.value);
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
