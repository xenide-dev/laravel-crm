<!DOCTYPE html>
<html lang="en">
    <!--begin::Head-->
    <head><base href="../../../">
        <meta charset="utf-8" />
        <title>Oops! There's something wrong</title>
        <meta name="description" content="" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <link rel="canonical" href="https://keenthemes.com/metronic" />
        <!--begin::Fonts-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
        <!--end::Fonts-->
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
            <!--begin::Error-->
            <div class="d-flex flex-row-fluid flex-column bgi-size-cover bgi-position-center bgi-no-repeat p-10 p-sm-30" style="background-image: url(assets/media/error/bg1.jpg);">
                <!--begin::Content-->
                <h1 class="font-weight-boldest text-dark-75 mt-15" style="font-size: 10rem">404</h1>
                <p class="font-size-h3 text-muted font-weight-normal">OOPS! Something went wrong here</p>
                <a href="{{ route("home") }}">Go home</a>
                <!--end::Content-->
            </div>
            <!--end::Error-->
        </div>
        <!--begin::Global Theme Bundle(used by all pages)-->
        <script src="{{ asset("assets/plugins/global/plugins.bundle.js") }}"></script>
        <script src="{{ asset("assets/plugins/custom/prismjs/prismjs.bundle.js") }}"></script>
        <script src="{{ asset("assets/js/scripts.bundle.js") }}"></script>
        <!--end::Global Theme Bundle-->
    </body>
    <!--end::Body-->
</html>
