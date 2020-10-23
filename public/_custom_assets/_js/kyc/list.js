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
                    url: "/api/basicload/reported",
                    type: "POST",
                    dataType: "json",
                    data: {
                        api_token: document.querySelector("meta[name='at']").getAttribute("content")
                    },
                    success: function(result, status, xhr){
                        whitelistJSON = result;
                    },
                    error: function(xhr, status, error){
                        console.log(xhr);
                    }
                });
            } else if (result.dismiss === "cancel") {

            }
        });
    })
});
