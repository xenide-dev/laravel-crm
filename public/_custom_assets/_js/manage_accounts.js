"use strict";

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
                        return '\
							<div class="dropdown dropdown-inline">\
								<a href="javascript:;" class="btn btn-sm btn-clean btn-icon" data-toggle="dropdown">\
	                                <i class="la la-cog"></i>\
	                            </a>\
							  	<div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">\
									<ul class="nav nav-hoverable flex-column">\
							    		<li class="nav-item"><a class="nav-link" href="#"><i class="nav-icon la la-edit"></i><span class="nav-text">Edit Details</span></a></li>\
							    		<li class="nav-item"><a class="nav-link" href="#"><i class="nav-icon la la-leaf"></i><span class="nav-text">Update Status</span></a></li>\
							    		<li class="nav-item"><a class="nav-link" href="#"><i class="nav-icon la la-print"></i><span class="nav-text">Print</span></a></li>\
									</ul>\
							  	</div>\
							</div>\
							<a href="javascript:;" class="btn btn-sm btn-clean btn-icon" title="Edit details">\
								<i class="la la-edit"></i>\
							</a>\
							<a href="javascript:;" class="btn btn-sm btn-clean btn-icon" title="Delete">\
								<i class="la la-trash"></i>\
							</a>\
						';
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
            obj.id = obj.code;
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
        FormValidation.formValidation(
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
                    id_number: {
                        validators: {
                            notEmpty: {
                                message: "ID Number is required"
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
        }
    };

}();

jQuery(document).ready(function() {
    ListAccountDataTable.init();
    ListAccountDataTable.initSet();

    $(".btn-add-account").on("click", function() {
        ListAccountDataTable.reload();
    })
});
