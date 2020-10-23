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
                url: "/api/kyclist",
                type: 'POST',
                data: {
                    api_token: document.querySelector("meta[name='at']").getAttribute("content")
                },
            },
            columns: [
                {data: 'auth_id'},
                {data: 'created_at'},
                {data: 'id_number'},
                {data: 'name'},
                {data: 'organization'},
                {data: 'completed'},
                {data: 'passbase_status'},
                {data: 'added_by_id'},
                {data: 'options', responsivePriority: -1},
            ],
            columnDefs: [
                {
                    targets: -1,
                    title: 'Actions',
                    orderable: false,
                    render: function(data, type, full, meta) {
                        return `
                            <a href="javascript:;" class="btn btn-sm btn-clean btn-icon kyclink" title="View Link" data-toggle="modal" data-target="#modal-view-item" data-link="${ full.url }">
								<i class="la la-search"></i>
							</a>
							<a href="javascript:;" class="btn btn-sm btn-clean btn-icon" title="Edit details">
								<i class="la la-edit"></i>
							</a>` + (!full.iM ? `
							<a href="javascript:;" class="btn btn-sm btn-clean btn-icon" title="Delete">
								<i class="la la-trash text-danger"></i>
							</a>`: '');
                    },
                },
                {
                    targets: 0,
                    render: function(data, type, full, meta) {
                        return `<span data-container="body" data-toggle="tooltip" data-placement="top" title="${full.auth_id}">${full.auth_id_partial}</span>`;
                    },
                },
            ],
        });
    };

    var reload = function() {
        var table = $('#' + datatable_name_id).DataTable();
        table.ajax.reload();
    };

    return {
        //main function to initiate the module
        init: function() {
            initTable1();
        },
        reload: function() {
            reload();
        },
        initSet: function() {

        }
    };

}();

jQuery(document).ready(function() {
    ListDatatable.init();
    ListDatatable.initSet();
    $("#btnGenerate").on('click', function() {
        Swal.fire({
            title: "Are you sure?",
            text: "This will create a new kyc link",
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
                // send a generate request to api
                $.ajax({
                    url: "/api/kyclist/create",
                    type: "POST",
                    dataType: "json",
                    data: {
                        api_token: document.querySelector("meta[name='at']").getAttribute("content")
                    },
                    success: function(result, status, xhr){
                        // reload table
                        if(result.status == "success"){
                            ListDatatable.reload();
                            notify("Success", "KYC Link has been generated", "success");
                        }
                    },
                    error: function(xhr, status, error){
                        console.log(xhr);
                    }
                });
            } else if (result.dismiss === "cancel") {

            }
        });
    });

    $(document).on('click', '.kyclink', function() {
        $("#kyc_link").val($(this).data("link"));
    });
});
