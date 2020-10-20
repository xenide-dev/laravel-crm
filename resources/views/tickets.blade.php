@extends("layouts.app")

@section('subheader_title')
    Main
@endsection

@section('subheader_subtitle')
    #ticket_lists
@endsection

@section("content")
    <div class="alert alert-warning">
        This section is under development
    </div>
    <div class="card card-custom">
        <div class="card-header">
            <h3 class="card-title">
                Ticket Lists
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
                    Create Ticket
                </a>
                <!--end::Button-->
            </div>
        </div>
        <form class="form" id="frmSubmitReport" method="POST">
            <div class="card-body">
                <table class="table table-bordered table-hover table-checkable" id="blacklist" style="margin-top: 13px !important">
                    <thead>
                        <tr>
                            <th>Ticket ID</th>
                            <th>Date</th>
                            <th>Full Name</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </form>
    </div>
    <!-- Modal: Add Account -->
    <div class="modal fade" id="modal-add-item" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal-add-item" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Ticket</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <form class="form" id="frmCreateItem" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Full Name:</label>
                            <input type="email" class="form-control" placeholder="Enter full name"/>
                        </div>
                        <div class="separator separator-dashed my-5"></div>
                        <div class="form-group">
                            <label>Message:</label>
                            <div class="tinymce">
                                <textarea id="tinymce-body" name="kt-tinymce-3" class="tox-target"></textarea>
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
    <script src="{{ asset("assets/plugins/custom/tinymce/tinymce.bundle.js") }}"></script>
@endpush

@push("page_scripts")
    <script src="{{ asset("_custom_assets/_js/submit_ticket.js") }}"></script>
@endpush

