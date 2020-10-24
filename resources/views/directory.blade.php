@extends("layouts.app")

@section("subheader_title")
    Main
@endsection

@section("subheader_subtitle")
    #blacklisted
@endsection

@push("page_style_vendors")
    <link href="{{ asset("assets/plugins/custom/datatables/datatables.bundle.css") }}" rel="stylesheet" type="text/css" />
@endpush

@section("content")
    <div class="alert alert-warning">
        This section is under development
    </div>
    @error("id_number")
    <div class="alert alert-custom alert-danger">
        <div class="alert-icon"><i class="flaticon-warning"></i></div>
        <div class="alert-text">Error! {{ $message }}</div>
    </div>
    @enderror
    @if (session('status'))
        <div class="alert alert-success">
            Success! The user has been added to the blacklist
        </div>
    @endif
    <div class="card card-custom">
        <div class="card-header ribbon ribbon-top ribbon-ver">
            <div class="ribbon-target bg-dark" style="top: -2px; @can("add-directory") right: 180px; @endcan @cannot("add-directory") right: 20px; @endcan">
                Beware
            </div>
            <h3 class="card-title">
                Directory Listing (Blacklisted)
            </h3>
            @can("add-directory")
                <div class="card-toolbar">
                    <a class="btn btn-primary font-weight-bolder" data-toggle="modal" data-target="#modal-add-item">
                    <span class="svg-icon svg-icon-md">
                        <!--begin::Svg Icon | path:assets/media/svg/icons/Design/Flatten.svg-->
                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <rect x="0" y="0" width="24" height="24" />
                                <circle fill="#000000" cx="9" cy="15" r="6" />
                                <path d="M8.8012943,7.00241953 C9.83837775,5.20768121 11.7781543,4 14,4 C17.3137085,4 20,6.6862915 20,10 C20,12.2218457 18.7923188,14.1616223 16.9975805,15.1987057 C16.9991904,15.1326658 17,15.0664274 17,15 C17,10.581722 13.418278,7 9,7 C8.93357256,7 8.86733422,7.00080962 8.8012943,7.00241953 Z" fill="#000000" opacity="0.3" />
                            </g>
                        </svg>
                    </span>
                        Add User
                    </a>
                </div>
            @endcan
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover table-checkable" id="list-datatable" style="margin-top: 13px !important">
                <thead>
                    <tr>
                        <th>Player ID</th>
                        <th>Date</th>
                        <th>Full Name</th>
                        <th>Organization(Union/Club)</th>
                        <th>Added by</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    <div class="modal fade" id="modal-add-item" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal-add-item" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add user to the list</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <form class="form" action="{{ route("blacklist-create") }}" id="frmCreateItem" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label>Date: <span class="text-danger">*</span></label>
                                <div class="form-group">
                                    <input class="form-control" name="banned_date" type="datetime-local" id="example-datetime-local-input"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Player ID Number: <span class="text-danger">*</span></label>
                                    <input type="text" name="id_number" class="form-control" placeholder="Enter player ID number"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>IGN:</label>
                                    <input type="text" name="ign" class="form-control" placeholder="Enter player IGN"/>
                                </div>
                            </div>
                        </div>
                        <div class="separator separator-dashed my-5"></div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Telegram:</label>
                                    <input type="text" name="telegram" class="form-control" placeholder="Enter telegram number"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Whatsapp:</label>
                                    <input type="text" name="whatsapp" class="form-control" placeholder="Enter whatsapp number"/>
                                </div>
                            </div>
                        </div>
                        <div class="separator separator-dashed my-5"></div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email:</label>
                                    <input type="email" name="email" class="form-control" placeholder="Enter email address"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phone:</label>
                                    <input type="text" name="phone_number" class="form-control" placeholder="Enter phone number"/>
                                </div>
                            </div>
                        </div>
                        <div class="separator separator-dashed my-5"></div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Facebook:</label>
                                    <input type="text" name="facebook" class="form-control" placeholder="Enter facebook address / name"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Instagram:</label>
                                    <input type="text" name="instagram" class="form-control" placeholder="Enter instagram username"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Twitter:</label>
                                    <input type="text" name="twitter" class="form-control" placeholder="Enter twitter username"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>First Name:</label>
                                    <input type="text" name="fname" class="form-control" placeholder="Enter first name"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Middle Name:</label>
                                    <input type="text" name="mname" class="form-control" placeholder="Enter middle name"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Last Name:</label>
                                    <input type="text" name="lname" class="form-control" placeholder="Enter last name"/>
                                </div>
                            </div>
                        </div>
                        <div class="separator separator-dashed my-5"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Notes:</label>
                                    <div class="tinymce">
                                        <textarea id="tinymce-body" name="notes" class="tox-target"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="separator separator-dashed my-5"></div>
                        <div id="repeat_item">
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label text-right">Organization:</label>
                                <div data-repeater-list="org" class="col-lg-10">
                                    <div data-repeater-item="" class="form-group row align-items-center">
                                        <div class="col-md-5">
                                            <label>Name:</label>
                                            <select class="form-control select2 org_name" name="org_name">
                                                <option value=""></option>
                                            </select>
                                            <div class="d-md-none mb-2"></div>
                                        </div>
                                        <div class="col-md-4">
                                            <label>Position:</label>
                                            <div class="checkbox-inline">
                                                <label class="checkbox">
                                                    <input name="org_position" value="head" type="checkbox"/>
                                                    <span></span>
                                                    Org. Head
                                                </label>
                                                <label class="checkbox">
                                                    <input name="org_position" value="agent" type="checkbox"/>
                                                    <span></span>
                                                    Agent
                                                </label>
                                                <label class="checkbox">
                                                    <input name="org_position" value="player" type="checkbox"/>
                                                    <span></span>
                                                    Player
                                                </label>
                                            </div>
                                            <div class="d-md-none mb-2"></div>
                                        </div>
                                        <div class="col-md-2">
                                            <a href="javascript:;" data-repeater-delete="" class="btn btn-sm font-weight-bolder btn-light-danger">
                                                <i class="la la-trash-o"></i>Delete
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label text-right"></label>
                                <div class="col-lg-4">
                                    <a href="javascript:;" data-repeater-create="" class="btn btn-sm font-weight-bolder btn-light-primary">
                                        <i class="la la-plus"></i>Add</a>
                                </div>
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
    <div class="modal fade" id="modal-view-item" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal-view-item" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">View details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <form class="form" action="{{ route("blacklist-create") }}" id="frmCreateItem" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label>Date:</label>
                                <div class="form-group">
                                    <input class="form-control" name="banned_date" type="text" readonly/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Player ID Number:</label>
                                    <input type="text" name="id_number" class="form-control" placeholder="Enter player ID number" readonly/>
                                </div>
                            </div>
                        </div>
                        <div class="separator separator-dashed my-5"></div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Telegram:</label>
                                    <input type="text" name="telegram" class="form-control" placeholder="Enter telegram number" readonly/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Whatsapp:</label>
                                    <input type="text" name="whatsapp" class="form-control" placeholder="Enter whatsapp number" readonly/>
                                </div>
                            </div>
                        </div>
                        <div class="separator separator-dashed my-5"></div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Email:</label>
                                    <input type="email" name="email" class="form-control" placeholder="Enter email address" readonly/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Phone:</label>
                                    <input type="text" name="phone_number" class="form-control" placeholder="Enter phone number" readonly/>
                                </div>
                            </div>
                        </div>
                        <div class="separator separator-dashed my-5"></div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Facebook:</label>
                                    <input type="text" name="facebook" class="form-control" placeholder="Enter facebook address / name" readonly/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Instagram:</label>
                                    <input type="text" name="instagram" class="form-control" placeholder="Enter instagram username" readonly/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Twitter:</label>
                                    <input type="text" name="twitter" class="form-control" placeholder="Enter twitter username" readonly/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>First Name:</label>
                                    <input type="text" name="fname" class="form-control" placeholder="Enter first name" readonly/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Middle Name:</label>
                                    <input type="text" name="mname" class="form-control" placeholder="Enter middle name" readonly/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Last Name:</label>
                                    <input type="text" name="lname" class="form-control" placeholder="Enter last name" readonly/>
                                </div>
                            </div>
                        </div>
                        <div class="separator separator-dashed my-5"></div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Notes:</label>
                                    <div id="tinymce-body"></div>
                                </div>
                            </div>
                        </div>
                        <div class="separator separator-dashed my-5"></div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Union:</label>
                                    <input type="text" name="union_id" class="form-control" readonly/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Club:</label>
                                    <input type="text" name="club_id" class="form-control" readonly/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push("page_vendors")
    <script src="{{ asset("assets/plugins/custom/datatables/datatables.bundle.js") }}"></script>
    <script src="{{ asset("assets/plugins/custom/tinymce/tinymce.bundle.js") }}"></script>
@endpush

@push("page_scripts")
    <script src="{{ asset("_custom_assets/_js/util/notify.js") }}"></script>
    <script src="{{ asset("_custom_assets/_js/submit_blacklisted.js") }}"></script>
@endpush
