<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head><base href="">
    <meta charset="utf-8" />
    <title>Welcome to Omniscient - KYC</title>
    <meta name="description" content="Welcome to Omniscient - KYC" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link rel="canonical" href="https://omniscient.poker" />
    <!--begin::Fonts-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Page Custom Styles(used by this page)-->
    <link href="{{ asset("assets/css/pages/wizard/wizard-1.css") }}" rel="stylesheet" type="text/css" />
    <!--end::Page Custom Styles-->
    <!--begin::Page Custom Styles(used by this page)-->
    <link href="{{ asset("assets/css/pages/login/classic/login-5.css") }}" rel="stylesheet" type="text/css" />
    <!--end::Page Custom Styles-->
    <!--begin::Global Theme Styles(used by all pages)-->
    <link href="{{ asset("assets/plugins/global/plugins.bundle.css") }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset("assets/plugins/custom/prismjs/prismjs.bundle.css") }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset("assets/css/style.bundle.css") }}" rel="stylesheet" type="text/css" />
    <!--end::Global Theme Styles-->
    <!--begin::Layout Themes(used by all pages)-->
    <link href="{{ asset("assets/css/themes/layout/header/base/light.css") }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset("assets/css/themes/layout/header/menu/light.css") }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset("assets/css/themes/layout/brand/dark.css") }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset("assets/css/themes/layout/aside/dark.css") }}" rel="stylesheet" type="text/css" />
    <!--end::Layout Themes-->
    <link rel="shortcut icon" href="{{ asset("assets/media/logos/favicon.ico") }}" />
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading" data-kid="{{ $uuid_kyc }}" data-lid="{{ $kyc->id }}">
<!--begin::Main-->
<div class="d-flex flex-column flex-root">
    <div class="container">
        <div class="card card-custom mb-3">
            <div class="card-body text-center">
                <h2>Welcome to Omniscient</h2>
            </div>
        </div>
        <div class="card card-custom" id="kyc_card">
            <div class="card-body">
                <div class="wizard wizard-1" id="kt_wizard" data-wizard-state="step-first" data-wizard-clickable="false">
                    <!--begin::Wizard Nav-->
                    <div class="wizard-nav border-bottom">
                        <div class="wizard-steps p-8 p-lg-10">
                            <div class="wizard-step" data-wizard-type="step" data-wizard-state="current">
                                <div class="wizard-label">
                                    <i class="wizard-icon flaticon-responsive"></i>
                                    <h3 class="wizard-title">1. Identity Verification</h3>
                                </div>
                                <span class="svg-icon svg-icon-xl wizard-arrow">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1" />
                                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                            </div>
                            <div class="wizard-step" data-wizard-type="step">
                                <div class="wizard-label">
                                    <i class="wizard-icon flaticon-user"></i>
                                    <h3 class="wizard-title">2. Complete your personal information</h3>
                                </div>
                                <span class="svg-icon svg-icon-xl wizard-arrow">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1" />
                                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                            </div>
                            <div class="wizard-step" data-wizard-type="step">
                                <div class="wizard-label">
                                    <i class="wizard-icon flaticon-globe"></i>
                                    <h3 class="wizard-title">3. Review and Submit</h3>
                                </div>
                                <span class="svg-icon svg-icon-xl wizard-arrow last">
                                    <!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Arrow-right.svg-->
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <rect fill="#000000" opacity="0.3" transform="translate(12.000000, 12.000000) rotate(-90.000000) translate(-12.000000, -12.000000)" x="11" y="5" width="2" height="14" rx="1" />
                                            <path d="M9.70710318,15.7071045 C9.31657888,16.0976288 8.68341391,16.0976288 8.29288961,15.7071045 C7.90236532,15.3165802 7.90236532,14.6834152 8.29288961,14.2928909 L14.2928896,8.29289093 C14.6714686,7.914312 15.281055,7.90106637 15.675721,8.26284357 L21.675721,13.7628436 C22.08284,14.136036 22.1103429,14.7686034 21.7371505,15.1757223 C21.3639581,15.5828413 20.7313908,15.6103443 20.3242718,15.2371519 L15.0300721,10.3841355 L9.70710318,15.7071045 Z" fill="#000000" fill-rule="nonzero" transform="translate(14.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-14.999999, -11.999997)" />
                                        </g>
                                    </svg>
                                    <!--end::Svg Icon-->
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center my-10 px-8 my-lg-15 px-lg-10">
                        <div class="col-xl-12 col-xxl-7">
                            <form class="form" action="{{ route("kyc-submit", [ "uuid_kyc" => $uuid_kyc, "knowYourClient" => $kyc->id])  }}" id="kt_form" method="POST">
                                @csrf
                                <div class="pb-5" data-wizard-type="step-content" data-wizard-state="current">
                                    <h3 class="mb-10 font-weight-bold text-dark">Setup Your Current Location</h3>
                                    <div class="row">
                                        <div class="col-xl-12 align-center">
                                            <div id="passbase-button"></div>
                                        </div>
                                    </div>
                                    <div class="row mt-5">
                                        <div class="col-xl-12 align-center">
                                            <div class="form-group">
                                                <label>Verification Key</label>
                                                <input type="password" class="form-control form-control-solid form-control-lg" name="verkey" id="ver_key" placeholder="Please click 'Verify me' to get the verification key" readonly/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pb-5" data-wizard-type="step-content">
                                    <h3 class="mb-10 font-weight-bold text-dark">Please complete your personal information</h3>
                                    <div class="row">
                                        <div class="col-xl-3">
                                            <div class="form-group">
                                                <label>First Name: <small class="text-danger">*</small></label>
                                                <input type="text" class="form-control form-control-solid form-control-lg" name="fname" placeholder="First Name" id="fname"/>
                                            </div>
                                        </div>
                                        <div class="col-xl-3">
                                            <div class="form-group">
                                                <label>Middle Name:</label>
                                                <input type="text" class="form-control form-control-solid form-control-lg" name="mname" placeholder="Middle Name" id="mname"/>
                                            </div>
                                        </div>
                                        <div class="col-xl-3">
                                            <div class="form-group">
                                                <label>Last Name: <small class="text-danger">*</small></label>
                                                <input type="text" class="form-control form-control-solid form-control-lg" name="lname" placeholder="Last Name" id="lname"/>
                                            </div>
                                        </div>
                                        <div class="col-xl-3">
                                            <div class="form-group">
                                                <label>Extension (if any):</label>
                                                <input type="text" class="form-control form-control-solid form-control-lg" name="suffix" placeholder="Name Extension (jr, sr, etc)" id="suffix"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-3">
                                            <div class="form-group">
                                                <label>ID Number: <small class="text-danger">*</small></label>
                                                <input type="text" class="form-control form-control-solid form-control-lg" name="id_number" placeholder="ID Number" id="id_number" />
                                            </div>
                                        </div>
                                        <div class="col-xl-6">
                                            <div class="form-group">
                                                <label>Email: <small class="text-danger">*</small></label>
                                                <input type="email" class="form-control form-control-solid form-control-lg" name="email" placeholder="Email Address" id="user_email" />
                                            </div>
                                        </div>
                                        <div class="col-xl-3">
                                            <div class="form-group">
                                                <label>Contact Number:</label>
                                                <input type="text" class="form-control form-control-solid form-control-lg" name="phone_number" placeholder="Contact Number" id="contact_number" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="separator separator-dashed my-5"></div>
                                    <div class="row">
                                        <div class="col-xl-4">
                                            <div class="form-group">
                                                <label>In-Game Name (IGN): <small class="text-danger">*</small></label>
                                                <input type="text" class="form-control form-control-solid form-control-lg" name="ign" placeholder="IGN" id="ign" />
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="form-group">
                                                <label>Club ID/s:</label>
                                                <input type="text" class="form-control form-control-solid form-control-lg" name="club_id" placeholder="Club ID (comma separated values)" id="club_ids" />
                                            </div>
                                        </div>
                                        <div class="col-xl-4">
                                            <div class="form-group">
                                                <label>Union ID/s:</label>
                                                <input type="text" class="form-control form-control-solid form-control-lg" name="union_id" placeholder="Union ID (comma separated values)" id="union_ids" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pb-5" data-wizard-type="step-content">
                                    <h4 class="mb-10 font-weight-bold text-dark">Review your details and submit</h4>
                                    <h6 class="font-weight-bolder mb-3">Personal Information:</h6>
                                    <div class="text-dark-50 line-height-lg">
                                        <div>Name: <b id="final_name"></b></div>
                                        <div>ID Number: <b id="final_id_number"></b></div>
                                        <div>Email Address: <b id="final_email"></b></div>
                                        <div>Contact Number: <b id="final_contact_number"></b></div>
                                    </div>
                                    <div class="separator separator-dashed my-5"></div>
                                    <h6 class="font-weight-bolder mb-3">Other Infos:</h6>
                                    <div class="text-dark-50 line-height-lg">
                                        <div>IGN: <b id="final_ign"></b></div>
                                        <div>Unions/s: <b id="final_unions"></b></div>
                                        <div>Club/s: <b id="final_clubs"></b></div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between border-top mt-5 pt-10">
                                    <div class="mr-2">
                                        <button type="button" class="btn btn-light-primary font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-prev">Previous</button>
                                    </div>
                                    <div>
                                        <button type="button" class="btn btn-success font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-submit">Submit</button>
                                        <button type="button" class="btn btn-primary font-weight-bolder text-uppercase px-9 py-4" data-wizard-type="action-next">Next</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--end::Global Config-->
<!--begin::Global Theme Bundle(used by all pages)-->
<script src="{{ asset("assets/plugins/global/plugins.bundle.js") }}"></script>
<script src="{{ asset("assets/plugins/custom/prismjs/prismjs.bundle.js") }}"></script>
<script src="{{ asset("assets/js/scripts.bundle.js") }}"></script>
<!--end::Global Theme Bundle-->
<!--begin::Page Scripts(used by this page)-->
{{--<script type="text/javascript" src="https://unpkg.com/@passbase/button@v3/button.js"></script>--}}
<script
    type="text/javascript"
    src="https://unpkg.com/@passbase/button/button.js"
></script>
<script src="{{ asset("_custom_assets/_js/util/notify.js") }}"></script>
<script src="{{ asset("_custom_assets/_js/kyc/index.js") }}"></script>
<script src="{{ asset("_custom_assets/_js/kyc/validation.js") }}"></script>
<!--end::Page Scripts-->
</body>
<!--end::Body-->
</html>
