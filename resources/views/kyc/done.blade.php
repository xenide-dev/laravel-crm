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
<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
<!--begin::Main-->
<div class="d-flex flex-column flex-root">
    <div class="container">
        <div class="card card-custom mb-3">
            <div class="card-body text-center">
                <h2>Thank You!</h2>
                <h3>You can close the browser now</h3>
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
<script src="{{ asset("_custom_assets/_js/util/notify.js?v=" . config("_scripts_versioning.scripts.ver")) }}"></script>
<script src="{{ asset("_custom_assets/_js/kyc/index.js?v=" . config("_scripts_versioning.scripts.ver")) }}"></script>
<script src="{{ asset("_custom_assets/_js/kyc/validation.js?v=" . config("_scripts_versioning.scripts.ver")) }}"></script>
<!--end::Page Scripts-->
</body>
<!--end::Body-->
</html>
