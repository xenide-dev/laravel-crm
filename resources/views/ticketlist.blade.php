@extends("layouts.app")

@section("subheader_title")
    Main
@endsection

@section("subheader_subtitle")
    #ticketlist
@endsection

@push("page_style_vendors")
    <link href="{{ asset("assets/plugins/custom/datatables/datatables.bundle.css") }}" rel="stylesheet" type="text/css" />
@endpush

@section("content")
    <div class="alert alert-info">
        We will be showing those pending tickets
    </div>
    <div class="card card-custom">
        <div class="card-header">
            <h3 class="card-title">
                Ticket Lists
            </h3>
        </div>
        <form class="form" id="frmSubmitReport" method="POST">
            <div class="card-body">
                <table class="table table-bordered table-hover table-checkable" id="list-datatable" style="margin-top: 13px !important">
                    <thead>
                        <tr>
                            <th>Ticket ID</th>
                            <th>Date</th>
                            <th>From</th>
                            <th>Names</th>
                            <th>Status</th>
                            <th>Other Info</th>
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
                <form class="form" action="{{ route("ticket-create") }}" id="frmCreateItem" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Names:</label>
                            <input id="report_names" class="form-control tagify" name='full_names' placeholder="Add users"/>
                        </div>
                        <div class="separator separator-dashed my-5"></div>
                        <div class="form-group">
                            <label>Message:</label>
                            <div class="alert alert-info">
                                Feel free to modify the provided template
                            </div>
                            <div class="tinymce">
                                <textarea id="tinymce-body" name="message" class="tox-target">
                                </textarea>
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
    <script src="{{ asset("assets/plugins/custom/datatables/datatables.bundle.js") }}"></script>
@endpush

@push("page_scripts")
    <script src="{{ asset("_custom_assets/_js/ticketlist.js?v=" . config("_scripts_versioning.scripts.ver")) }}"></script>
@endpush
