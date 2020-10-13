@extends("layouts.app")

@section("subheader_title")
    Accounts
@endsection

@section("subheader_subtitle")
    #manage_accounts
@endsection

@push("page_style_vendors")
    <link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
@endpush

@section("content")
    <div class="card card-custom">
        <div class="card-header">
            <h3 class="card-title">
                List of Accounts
            </h3>
            <div class="card-toolbar">
                <!--begin::Button-->
                <a class="btn btn-primary font-weight-bolder" data-toggle="modal" data-target="#modal-add-account">
                    <span class="svg-icon svg-icon-md">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <circle fill="#000000" cx="9" cy="15" r="6" />
                                <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
                            </g>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    New Account
                </a>
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <!--begin: Datatable-->
            <table class="table table-bordered table-hover table-checkable" id="list_acct_datatable" style="margin-top: 13px !important">
                <thead>
                <tr>
                    <th>ID Number</th>
                    <th>First Name</th>
                    <th>Middle Name</th>
                    <th>Last Name</th>
                    <th>User Type</th>
                    <th>Last Active</th>
                    <th>Actions</th>
                </tr>
                </thead>
            </table>
            <!--end: Datatable-->
        </div>
    </div>
    <!-- Modal: Add Account -->
    <div class="modal fade" id="modal-add-account" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal-add-account" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form class="form">
                        <div class="form-group">
                            <label>Full Name:</label>
                            <input type="email" class="form-control" placeholder="Enter full name"/>
                            <span class="form-text text-muted">Please enter your full name</span>
                        </div>

                        <div class="separator separator-dashed my-5"></div>

                        <div class="form-group">
                            <label>Email address:</label>
                            <input type="email" class="form-control" placeholder="Enter email"/>
                            <span class="form-text text-muted">We'll never share your email with anyone else</span>
                        </div>

                        <div class="separator separator-dashed my-5"></div>

                        <div class="form-group">
                            <label>Subscription</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text" >$</span></div>
                                <input type="text" class="form-control" placeholder="99.9"/>
                            </div>
                        </div>

                        <div class="separator separator-dashed my-5"></div>

                        <div class="form-group">
                            <label>Communication:</label>
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    <input type="checkbox"/>
                                    <span></span>
                                    Email
                                </label>
                                <label class="checkbox">
                                    <input type="checkbox"/>
                                    <span></span>
                                    SMS
                                </label>
                                <label class="checkbox">
                                    <input type="checkbox"/>
                                    <span></span>
                                    Phone
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary font-weight-bold">Submit</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push("page_vendors")
    <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
@endpush

@push("page_scripts")
    <script src="_custom_assets/_js/manage_accounts.js"></script>
@endpush
