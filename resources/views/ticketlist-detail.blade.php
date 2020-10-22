@extends("layouts.app")

@section("subheader_title")
    Main
@endsection

@section("subheader_subtitle")
    #ticket_details
@endsection

@section("content")
    <div class="card card-custom">
        <div class="card-header">
            <div class="d-flex align-items-center my-2">
                <a href="{{ route("ticketlist") }}" class="btn btn-clean btn-icon btn-sm mr-6" data-inbox="back">
                    <i class="flaticon2-left-arrow-1"></i>
                </a>
                <h3 class="card-title">
                    Ticket Details
                </h3>
            </div>
        </div>
        <form class="form" id="frmSubmitReport" method="POST">
            <div class="card-body">
                <!--begin::Top-->
                <div class="d-flex align-items-center">
                    <!--begin::Symbol-->
                    <div class="symbol symbol-45 symbol-light mr-5">
                        <div class="symbol symbol-50 symbol-circle">
                            <img alt="Pic" src="{{ asset("assets/media/users/default.jpg") }}"/>
                        </div>
                    </div>
                    <!--end::Symbol-->
                    <!--begin::Info-->
                    <div class="d-flex flex-column flex-grow-1">
                        <a href="#" class="text-dark-75 text-hover-primary mb-1 font-size-lg font-weight-bolder">{{ $ticket->user->full_name }}</a>
                        <div class="d-flex">
                            <div class="d-flex align-items-center pr-5">
                                <span class="text-muted font-weight-bold"><i class="fas fa-calendar-alt text-primary"></i> {{ date('j M',strtotime($ticket->created_at)) }}</span>
                            </div>
                            <div class="d-flex align-items-center pr-5">
                                <span class="text-muted font-weight-bold"><i class="fas fa-clock text-primary"></i> {{ date('h:i a',strtotime($ticket->created_at)) }}</span>
                            </div>
                        </div>
                    </div>
                    <!--end::Info-->
                </div>
                <!--end::Top-->
                <!--begin::Bottom-->
                <div class="pt-3">
                    <!--begin::Text-->
                    <div class="mb-6">
                        {!! $ticket->message !!}
                    </div>
                    <div class="separator separator-solid my-6"></div>
                    <div class="mb-6">
                        <p class="font-weight-bold">Reported Names:</p>
                        @foreach($input_names as $input_name)
                            @if($input_name != "")
                                <button type="button" class="btn btn-warning btn-sm mr-2 reported-user" data-toggle="modal" data-target="#modal-add-item" data-value="{{ $input_name }}">{{ $input_name }}</button>
                            @endif
                        @endforeach
                    </div>
                    <div class="separator separator-solid my-6"></div>
                    <!--end::Text-->
                    <!--begin::Action-->
                    <div class="pt-6">
                        <a href="#" class="btn btn-light-primary btn-sm rounded font-weight-bolder font-size-sm p-2">
                            <span class="svg-icon svg-icon-md pr-2">
                                <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Group-chat.svg-->
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24" />
                                        <path d="M16,15.6315789 L16,12 C16,10.3431458 14.6568542,9 13,9 L6.16183229,9 L6.16183229,5.52631579 C6.16183229,4.13107011 7.29290239,3 8.68814808,3 L20.4776218,3 C21.8728674,3 23.0039375,4.13107011 23.0039375,5.52631579 L23.0039375,13.1052632 L23.0206157,17.786793 C23.0215995,18.0629336 22.7985408,18.2875874 22.5224001,18.2885711 C22.3891754,18.2890457 22.2612702,18.2363324 22.1670655,18.1421277 L19.6565168,15.6315789 L16,15.6315789 Z" fill="#000000" />
                                        <path d="M1.98505595,18 L1.98505595,13 C1.98505595,11.8954305 2.88048645,11 3.98505595,11 L11.9850559,11 C13.0896254,11 13.9850559,11.8954305 13.9850559,13 L13.9850559,18 C13.9850559,19.1045695 13.0896254,20 11.9850559,20 L4.10078614,20 L2.85693427,21.1905292 C2.65744295,21.3814685 2.34093638,21.3745358 2.14999706,21.1750444 C2.06092565,21.0819836 2.01120804,20.958136 2.01120804,20.8293182 L2.01120804,18.32426 C1.99400175,18.2187196 1.98505595,18.1104045 1.98505595,18 Z M6.5,14 C6.22385763,14 6,14.2238576 6,14.5 C6,14.7761424 6.22385763,15 6.5,15 L11.5,15 C11.7761424,15 12,14.7761424 12,14.5 C12,14.2238576 11.7761424,14 11.5,14 L6.5,14 Z M9.5,16 C9.22385763,16 9,16.2238576 9,16.5 C9,16.7761424 9.22385763,17 9.5,17 L11.5,17 C11.7761424,17 12,16.7761424 12,16.5 C12,16.2238576 11.7761424,16 11.5,16 L9.5,16 Z" fill="#000000" opacity="0.3" />
                                    </g>
                                </svg>
                                <!--end::Svg Icon-->
                            </span> Add reply
                        </a>
                    </div>
                    <!--end::Action-->
                    <!--begin::Item-->
                    <div class="d-flex pt-5">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-40 symbol-light-success mr-5 mt-1">
                            <span class="symbol-label">
                                <img src="assets/media/svg/avatars/009-boy-4.svg" class="h-75 align-self-end" alt="" />
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Info-->
                        <div class="d-flex flex-column flex-row-fluid">
                            <!--begin::Info-->
                            <div class="d-flex align-items-center flex-wrap">
                                <a href="#" class="text-dark-75 text-hover-primary mb-1 font-size-lg font-weight-bolder pr-6">Mr. Anderson</a>
                                <span class="text-muted font-weight-normal flex-grow-1 font-size-sm">1 Day ago</span>
                                <span class="text-muted font-weight-normal font-size-sm">Reply</span>
                            </div>
                            <span class="text-dark-75 font-size-sm font-weight-normal pt-1">Long before you sit dow to put digital pen to paper you need to make sure you have to sit down and write.</span>
                            <!--end::Info-->
                        </div>
                        <!--end::Info-->
                    </div>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <div class="d-flex pt-6">
                        <!--begin::Symbol-->
                        <div class="symbol symbol-40 symbol-light-success mr-5 mt-1">
                            <span class="symbol-label">
                                <img src="assets/media/svg/avatars/003-girl-1.svg" class="h-75 align-self-end" alt="" />
                            </span>
                        </div>
                        <!--end::Symbol-->
                        <!--begin::Info-->
                        <div class="d-flex flex-column flex-row-fluid">
                            <!--begin::Info-->
                            <div class="d-flex align-items-center flex-wrap">
                                <a href="#" class="text-dark-75 text-hover-primary mb-1 font-size-lg font-weight-bolder pr-6">Mrs. Anderson</a>
                                <span class="text-muted font-weight-normal flex-grow-1 font-size-sm">2 Days ago</span>
                                <span class="text-muted font-weight-normal font-size-sm">Reply</span>
                            </div>
                            <span class="text-dark-75 font-size-sm font-weight-normal pt-1">Long before you sit down to put digital pen to paper</span>
                            <!--end::Info-->
                        </div>
                        <!--end::Info-->
                    </div>
                    <!--end::Item-->
                </div>
                <!--end::Bottom-->
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
                            <label>Name:</label>
                            <input id="full_name" class="form-control" name='full_name' readonly="readonly"/>
                        </div>
                        <div class="form-group">
                            <label>ID Number:</label>
                            <input id="id_number" class="form-control" name='id_number'/>
                        </div>
                        <div class="separator separator-dashed my-5"></div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Tool:</label>
                            <div class="col-md-10">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-add-org"><i class="fas fa-plus-circle"></i> Add Organization</button>
                            </div>
                        </div>
                        <div class="separator separator-dashed my-5"></div>
                        <div id="repeat_item">
                            <div class="form-group row">
                                <label class="col-lg-2 col-form-label">Organization:</label>
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
    <div class="modal fade" id="modal-add-org" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="modal-add-org" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content border border-warning">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Organization</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <form class="form" action="{{ route("ticket-create") }}" id="frmOrgItem" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Organization Name:</label>
                            <input type="email" id="org_name" name="org_name" class="form-control" placeholder="Enter organization name"/>
                        </div>
                        <div class="form-group">
                            <label>Organization Type:</label>
                            <select class="form-control selectpicker" id="org_type" name="org_type">
                                <option value="">-- Please select a value --</option>
                                <option value="Union">Union</option>
                                <option value="Club">Club</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-primary font-weight-bold" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary font-weight-bold" id="btnOrgSubmit">Submit</button>
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
    <script src="{{ asset("_custom_assets/_js/ticketlist.js") }}"></script>
@endpush
