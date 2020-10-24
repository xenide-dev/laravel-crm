@extends("layouts.app")

@section("subheader_title")
    Data Entry
@endsection

@section("subheader_subtitle")
    #organization
@endsection

@push("page_style_vendors")
    <link href="{{ asset("assets/plugins/custom/datatables/datatables.bundle.css") }}" rel="stylesheet" type="text/css" />
@endpush

@section("content")
    @error("name")
    <div class="alert alert-custom alert-danger">
        <div class="alert-icon"><i class="flaticon-warning"></i></div>
        <div class="alert-text">Error! {{ $message }}</div>
    </div>
    @enderror
    @if (session('status'))
        <div class="alert alert-success">
            Success! The organization has been created
        </div>
    @endif
    <div class="card card-custom">
        <div class="card-header">
            <h3 class="card-title">
                Organization Lists
            </h3>
            <div class="card-toolbar">
                <!--begin::Button-->
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
                        <!--end::Svg Icon-->
                    </span>
                    Add Organization
                </a>
                <!--end::Button-->
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover table-checkable" id="list-datatable" style="margin-top: 13px !important">
                <thead>
                <tr>
                    <th>Sys ID</th>
                    <th>Org ID</th>
                    <th>Date</th>
                    <th>Name</th>
                    <th>Type</th>
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
                    <h5 class="modal-title" id="exampleModalLabel">Add Organization</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <form class="form" action="{{ route("organization-create") }}" id="frmCreateItem" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Organization ID Number:</label>
                            <input type="text" name="id_number" class="form-control" placeholder="Enter organization id number"/>
                        </div>
                        <div class="form-group">
                            <label>Organization Name:</label>
                            <input type="email" name="name" class="form-control" placeholder="Enter organization name"/>
                        </div>
                        <div class="form-group">
                            <label>Organization Type:</label>
                            <select class="form-control selectpicker" name="type">
                                <option value="">-- Please select a value --</option>
                                <option value="Union">Union</option>
                                <option value="Club">Club</option>
                            </select>
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
    <script src="{{ asset("_custom_assets/_js/submit_organization.js") }}"></script>
@endpush
