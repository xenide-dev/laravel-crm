"use strict";

var datatable_name_id = "list-datatable";
var frm_Item = "frmCreateItem";

var ListDatatable = function() {
    var table = $('#' + datatable_name_id);

    var initTable1 = function() {
        // begin first table
        table.DataTable({
            responsive: true,
            searchDelay: 500,
            processing: true,
            serverSide: true,
            ajax: {
                url: "/api/list/organizations",
                type: 'POST',
                data: {
                    api_token: document.querySelector("meta[name='at']").getAttribute("content")
                },
            },
            columns: [
                {data: 'id'},
                {data: 'created_at'},
                {data: 'name'},
                {data: 'type'},
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
        var frmValidation = FormValidation.formValidation(
            document.getElementById(frm_Item),
            {
                fields: {
                    name: {
                        validators: {
                            notEmpty: {
                                message: 'Organization Name is required'
                            },
                        }
                    },
                    type: {
                        validators: {
                            notEmpty: {
                                message: "Organization Type is required"
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
        }
    };

}();

jQuery(document).ready(function() {
    ListDatatable.init();
    ListDatatable.initSet();
});
