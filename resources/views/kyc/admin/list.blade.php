@extends("layouts.app")

@section("subheader_title")
    KYC
@endsection

@section("subheader_subtitle")
    #list
@endsection

@push("page_style_vendors")
    <link href="{{ asset("assets/plugins/custom/datatables/datatables.bundle.css") }}" rel="stylesheet" type="text/css" />
@endpush

@section("content")
    <div class="card card-custom">
        <div class="card-header ribbon ribbon-top ribbon-ver">
            <h3 class="card-title">
                KYC List
            </h3>
            @can("add-directory")
                <div class="card-toolbar">
                    <a class="btn btn-primary font-weight-bolder" id="btnGenerate">
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
                        Generate KYC Link
                    </a>
                </div>
            @endcan
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover table-checkable" id="list-datatable" style="margin-top: 13px !important">
                <thead>
                <tr>
                    <th>Auth ID</th>
                    <th>Date</th>
                    <th>ID Number</th>
                    <th>Name</th>
                    <th>Organization</th>
                    <th>Completed</th>
                    <th>Passbase Status</th>
                    <th>Added by</th>
                    <th>Actions</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection

@push("page_vendors")
    <script src="{{ asset("assets/plugins/custom/datatables/datatables.bundle.js") }}"></script>
@endpush

@push("page_scripts")
    <script src="{{ asset("_custom_assets/_js/kyc/list.js") }}"></script>
@endpush

