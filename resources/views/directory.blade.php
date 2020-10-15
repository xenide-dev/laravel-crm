@extends("layouts.app")

@section("subheader_title")
    Main
@endsection

@section("subheader_subtitle")
    #blacklisted
@endsection

@push("page_style_vendors")
    <link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
@endpush

@section("content")
    <div class="alert alert-warning">
        This section is under development
    </div>
    <div class="card">
        <div class="card-header ribbon ribbon-top ribbon-ver">
            <div class="ribbon-target bg-dark" style="top: -2px; right: 20px;">
                Beware
            </div>
            <h3 class="card-title">
                Directory Listing (Blacklisted)
            </h3>
        </div>
        <div class="card-body">
            <div class="alert alert-custom alert-light-warning fade show mb-5" role="alert">
                <div class="alert-icon"><i class="flaticon-warning"></i></div>
                <div class="alert-text">Hello! We disabled the account of the following users due to the increased number of reports. If you have the contact from the list kindly remove it, ASAP. Thank you!</div>
            </div>
            <!--begin: Datatable-->
            <table class="table table-bordered table-hover table-checkable" id="blacklist" style="margin-top: 13px !important">
                <thead>
                    <tr>
                        <th>System ID</th>
                        <th>Player ID</th>
                        <th>Full Name</th>
                        <th>Position</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
            <!--end: Datatable-->
        </div>
    </div>
@endsection

@push("page_vendors")
    <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
@endpush

@push("page_scripts")
{{--    <script src="assets/js/pages/crud/datatables/data-sources/ajax-server-side.js"></script>--}}
@endpush
