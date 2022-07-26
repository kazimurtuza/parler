<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <meta name="robots" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Retina Soft : Admin Template" />
    <meta property="og:title" content="Retina Soft : Admin Template" />
    <meta property="og:description" content="Retina Soft : Admin Template" />
    <meta property="og:image" content="#" />
    <meta name="format-detection" content="telephone=no">

    <!-- PAGE TITLE HERE -->
    <title>{{$common_data->title ?? ''}} | Alvira's Beauty Care</title>

    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="{{ asset('logo/favicon.png') }}" />

    @yield('css_plugins')
    <link href="{{ asset('assets/backend/vendor/jquery-nice-select/css/nice-select.css') }}" rel="stylesheet">
    <!-- Style css -->
    <link href="{{ asset('assets/backend/css/toastr.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/backend/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/backend/css/preloader.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/backend/css/button.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/backend/css/checkbox.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/backend/css/rs.css') }}" rel="stylesheet">
    @yield('css')
</head>
