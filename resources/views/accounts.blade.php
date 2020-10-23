@extends("layouts.app")

@section("subheader_title")
    Accounts
@endsection

@section("subheader_subtitle")
    #manage_accounts
@endsection

@push("page_style_vendors")
    <link href="{{ asset("assets/plugins/custom/datatables/datatables.bundle.css") }}" rel="stylesheet" type="text/css" />
@endpush

@section("content")
    @error("email")
        <div class="alert alert-custom alert-danger">
            <div class="alert-icon"><i class="flaticon-warning"></i></div>
            <div class="alert-text">Error! {{ $message }}</div>
        </div>
    @enderror
    @error("id_number")
        <div class="alert alert-custom alert-danger">
            <div class="alert-icon"><i class="flaticon-warning"></i></div>
            <div class="alert-text">Error! {{ $message }}</div>
        </div>
    @enderror

    @if (session('status'))
        <div class="alert alert-success">
            Success! The account has been created {{ (session('notified') ? " and notified" : '') }}
        </div>
    @endif
    @if (session('event') == "updated")
        <div class="alert alert-success">
            Success! The account has been created {{ (session('notified') ? " and notified" : '') }}
        </div>
    @endif
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
                    <th>Email</th>
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
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <form class="form" action="{{ route("accounts-create") }}" id="frmCreateAccount" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>First Name: <span class="text-danger">*</span></label>
                                    <input type="text" name="fname" class="form-control" placeholder="Please enter the first name" value="{{ old("fname") }}"/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Middle Name:</label>
                                    <input type="text" name="mname" class="form-control" placeholder="Please enter the middle name" value="{{ old("mname") }}"/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Last Name: <span class="text-danger">*</span></label>
                                    <input type="text" name="lname" class="form-control" placeholder="Please enter the last name" value="{{ old("lname") }}"/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Suffix (jr, sr, etc.):</label>
                                    <input type="text" name="suffix" class="form-control" placeholder="Optional" value="{{ old("suffix") }}"/>
                                </div>
                            </div>
                        </div>
                        <div class="separator separator-dashed my-5"></div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>E-mail: <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control" name="email" placeholder="Please enter the email address"/>
                                    <span class="form-text text-muted">We will send a confirmation message to this email</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Player ID Number: <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="id_number" placeholder="Please enter the ID number" value="{{ old("id_number") }}"/>
                                    <span class="form-text text-muted">Enter player ID number</span>
                                </div>
                            </div>
                        </div>
                        <div class="separator separator-dashed my-5"></div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Club ID:</label>
                                    <input type="text" class="form-control" name="club_id" placeholder="Please enter club ID" value="{{ old("club_id") }}"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Union ID:</label>
                                    <input type="text" class="form-control" name="union_id" placeholder="Please enter union ID" value="{{ old("union_id") }}"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>IGN:</label>
                                    <input type="text" class="form-control" name="ign" placeholder="Please enter IGN" value="{{ old("ign") }}"/>
                                </div>
                            </div>
                        </div>
                        <div class="separator separator-dashed my-5"></div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Telegram:</label>
                                    <input type="text" class="form-control" name="telegram" placeholder="Please enter telegram number" value="{{ old("club_id") }}"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Whatsapp:</label>
                                    <input type="text" class="form-control" name="whatsapp" placeholder="Please enter whatsapp number" value="{{ old("union_id") }}"/>
                                </div>
                            </div>
                        </div>
                        <div class="separator separator-dashed my-5"></div>
                        <div class="form-group">
                            <label>Phone Number: <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <select class="form-control select2" id="pref_country" name="country">
                                        <option value=""></option>
                                    </select>
                                    <span class="input-group-text" id="country_code">--</span>
                                </div>
                                <input type="text" class="form-control" name="phone_number"/>
                            </div>
                        </div>
                        <div class="separator separator-dashed my-5"></div>
                        <div class="form-group row">
                            <label class="col-form-label text-right col-md-6">Mark as admin? <span class="fa fa-exclamation-circle text-danger" data-toggle="tooltip" data-placement="top" data-title="Be careful when making an account as admin"></span></label>
                            <div class="col-md-6">
                                <input data-switch="true" type="checkbox" data-on-color="danger" data-on-text="Yes" data-off-color="success" data-off-text="No" name="mark_as_admin"/>
                            </div>
                        </div>
                        <div class="separator separator-dashed my-5"></div>
                        <div class="form-group">
                            <label>Settings:</label>
                            <div class="checkbox-list">
                                <label class="checkbox">
                                    <input type="checkbox" id="send_confirmation" name="is_send_confirmation" checked/>
                                    <span></span>
                                    Send confirmation message through e-mail after creation &nbsp;<div class="fa fa-exclamation-circle text-primary" data-toggle="tooltip" data-placement="top" data-title="We will send the system generated password together with the confirmation message through e-mail"></div>
                                </label>
                                <label class="checkbox">
                                    <input type="checkbox" id="modify_role" name="is_modify_role"/>
                                    <span></span>
                                    Modify role' privilege after account creation
                                    <div class="text-danger">( "send confirmation message" will be disabled )</div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary font-weight-bold" id="btnSubmit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push("page_vendors")
    <script src="{{ asset("assets/plugins/custom/datatables/datatables.bundle.js") }}"></script>
@endpush

@push("page_scripts")
    <script src="{{ asset("_custom_assets/_js/_country_codes.js") }}"></script>
    <script src="{{ asset("_custom_assets/_js/manage_accounts.js") }}"></script>
@endpush
