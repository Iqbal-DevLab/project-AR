<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title>Simetri AR | Login</title>

    <meta name="description" content="Simetri AR Monitoring">
    <meta name="author" content="iqbalf">
    <meta name="robots" content="noindex, nofollow">

    <!-- Open Graph Meta -->
    <meta property="og:title" content="Simetri AR Monitoring">
    <meta property="og:site_name" content="Simetri">
    <meta property="og:description" content="Simetri AR Monitoring">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="">

    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <link rel="shortcut icon" href="{{ asset('public/media/favicons/logo.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('public/media/favicons/logo.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('public/media/favicons/logo.png') }}">
    <!-- END Icons -->

    <!-- Stylesheets -->

    <!-- Fonts and Codebase framework -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,400i,600,700">
    <link rel="stylesheet" id="css-main" href="{{ asset('public/css/codebase.min.css') }}">

    <!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
    <!-- <link rel="stylesheet" id="css-theme" href=/css/themes/flat.min.css"> -->
    <!-- END Stylesheets -->
</head>

<body>
    <div id="auth">

        <div>
            @yield('auth_content')
        </div>

    </div>
    <script src="{{ asset('public/js/codebase.core.min.js') }}"></script>
    <script src="https://kit.fontawesome.com/7a10396990.js" crossorigin="anonymous"></script>

    <!--
            Codebase JS

            Custom functionality including Blocks/Layout API as well as other vital and optional helpers
            webpack is putting everything together at/_es6/main/app.js
        -->
    <script src="{{ asset('public/js/codebase.app.min.js') }}"></script>

    <!-- Page JS Plugins -->
    <script src="{{ asset('public/js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>

    <!-- Page JS Code -->
    <script src="{{ asset('public/js/pages/op_auth_signin.min.js') }}"></script>
</body>

</html>
