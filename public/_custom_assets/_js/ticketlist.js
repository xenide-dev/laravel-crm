"use strict";

var datatable_name_id = "list-datatable";
var tagifyTo = null;
var whitelistJSON = [];
var frm_Item = "frmCreateItem";
var frmValidation = null;

// Class definition
var ListDatatable = function () {
    var table = $('#' + datatable_name_id);

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

    return {
        // public functions
        init: function() {
            initTable1();
        },
        initSet: function() {

        }
    };
}();

// Initialization
jQuery(document).ready(function() {
    ListDatatable.init();
    ListDatatable.initSet();
});
