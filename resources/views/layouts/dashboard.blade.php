<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title>Simetri AR</title>

    <meta name="description" content="Simetri AR Monitoring">
    <meta name="author" content="pixelcave">
    <meta name="robots" content="noindex, nofollow">

    <!-- Open Graph Meta -->
    <meta property="og:title" content="Simetri AR Monitoring">
    <meta property="og:site_name" content="iqbalf">
    <meta property="og:description" content="Simetri AR Monitoring">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="">

    <!-- Icons -->
    <link rel="shortcut icon" href="{{ asset('/') }}public/media/favicons/logo.png">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('/') }}public/media/favicons/logo.png">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/') }}public/media/favicons/logo.png">
    {{-- <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet"> --}}
    <!-- END Icons -->

    <!-- Stylesheets -->

    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('/') }}public/js/plugins/datatables/dataTables.bootstrap4.css" />
    <link rel="stylesheet" href="{{ asset('/') }}public/js/plugins/slick/slick.css">
    <link rel="stylesheet" href="{{ asset('/') }}public/js/plugins/slick/slick-theme.css">
    <link rel="stylesheet"
        href="{{ asset('/') }}public/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css">
    <link rel="stylesheet"
        href="{{ asset('/') }}public/js/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css">
    <link rel="stylesheet" href="{{ asset('/') }}public/js/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('/') }}public/js/plugins/jquery-tags-input/jquery.tagsinput.min.css">
    <link rel="stylesheet"
        href="{{ asset('/') }}public/js/plugins/jquery-auto-complete/jquery.auto-complete.min.css">
    <link rel="stylesheet" href="{{ asset('/') }}public/js/plugins/ion-rangeslider/css/ion.rangeSlider.css">
    <link rel="stylesheet" href="{{ asset('/') }}public/js/plugins/dropzonejs/dist/dropzone.css">

    <!-- Fonts and Codebase framework -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,400i,600,700">
    <link rel="stylesheet" id="css-main" href="{{ asset('/') }}public/css/codebase.min.css">
</head>

<style>
    .input-group-text i.fa-calendar {
        font-size: 1rem;
    }

    .input-group-text.align-self-center {
        height: calc(1.5em + .75rem + 2px);
        padding: .375rem .75rem;
    }

    .input-group-text.align-self-center i {
        display: inline-block;
        margin-top: 2px;
    }

    .tableMedium {
        max-width: 1100px !important;
        font-size: 0.875rem
    }

    .tableLarge {
        max-width: 1500px !important;
    }

    .tableExtraLarge {
        max-width: 1700px !important;
    }

    .navy {
        color: #446993;
    }

    .bg-navy {
        background-color: #3C5291;
    }

    .disabled-link {
        cursor: default;
        pointer-events: none;
        text-decoration: none;
    }

    .content2 {
        font-size: 0.875rem;
    }
</style>

<body>
    <div id="app">
        <div id="page-container"
            class="sidebar-o enable-page-overlay side-scroll page-header-modern main-content-boxed">
            <main id="main-container">
                <x-navbar></x-navbar>
                <x-sidebar></x-sidebar>
                <div class="main-content container-fluid">
                    <section class="section">
                        <div class="row mb-2">
                            <div class="col-md-12">
                                @yield('content')
                                <footer id="page-footer" class="opacity-0">
                                    <div class="content py-20 font-size-xs clearfix tableLarge">
                                        <div class="float-right">
                                            Ver. 1.0 <a class="font-w600" href="#" target="_blank"></a>
                                        </div>
                                        <div class="float-left">
                                            <a class="font-w600" href="https://sinarmetrindo.co.id" target="_blank">PT.
                                                Sinar Metrindo
                                                Perkasa</a>
                                            &copy; <span class="js-year-copy"></span>
                                        </div>
                                    </div>
                                </footer>
                            </div>
                        </div>
                    </section>
                </div>
            </main>
        </div>
    </div>
    </div>

    <script src="https://kit.fontawesome.com/7a10396990.js" crossorigin="anonymous"></script>
    <script src="{{ asset('/') }}public/js/codebase.core.min.js"></script>

    <!--
            Codebase JS

            Custom functionality including Blocks/Layout API as well as other vital and optional helpers
            webpack is putting everything together at {{ asset('/') }}_es6/main/app.js
        -->
    <script src="{{ asset('/') }}public/js/codebase.app.min.js"></script>

    <!-- Page JS Plugins -->
    <script src="{{ asset('/') }}public/js/plugins/chartjs/Chart.bundle.min.js"></script>
    <script src="{{ asset('/') }}public/js/plugins/slick/slick.min.js"></script>
    <script src="{{ asset('/') }}public/js/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('/') }}public/js/plugins/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('/') }}public/js/plugins/pwstrength-bootstrap/pwstrength-bootstrap.min.js"></script>
    <script src="{{ asset('/') }}public/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
    <script src="{{ asset('/') }}public/js/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <script src="{{ asset('/') }}public/js/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js"></script>
    <script src="{{ asset('/') }}public/js/plugins/select2/js/select2.full.min.js"></script>
    <script src="{{ asset('/') }}public/js/plugins/jquery-tags-input/jquery.tagsinput.min.js"></script>
    <script src="{{ asset('/') }}public/js/plugins/jquery-auto-complete/jquery.auto-complete.min.js"></script>
    <script src="{{ asset('/') }}public/js/plugins/masked-inputs/jquery.maskedinput.min.js"></script>
    <script src="{{ asset('/') }}public/js/plugins/ion-rangeslider/js/ion.rangeSlider.min.js"></script>
    <script src="{{ asset('/') }}public/js/plugins/dropzonejs/dropzone.min.js"></script>
    <script src="{{ asset('/') }}public/js/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="{{ asset('/') }}public/js/plugins/jquery-validation/additional-methods.js"></script>
    <script src="{{ asset('/') }}public/js/plugins/bootstrap-wizard/jquery.bootstrap.wizard.js"></script>

    <!-- Page JS Code -->
    <script src="{{ asset('/') }}public/js/pages/be_tables_datatables.min.js"></script>
    <script src="{{ asset('/') }}public/js/pages/be_forms_plugins.min.js"></script>
    <script src="{{ asset('/') }}public/js/pages/be_pages_dashboard.min.js"></script>
    <script src="{{ asset('/') }}public/js/pages/be_ui_animations.min.js"></script>
    <script src="{{ asset('/') }}public/js/pages/be_forms_validation.min.js"></script>
    <script src="{{ asset('/') }}public/js/pages/be_forms_wizard.min.js"></script>

    <!-- Page JS Helpers (BS Datepicker + BS Colorpicker + BS Maxlength + Select2 + Masked Input + Range Sliders + Tags Inputs plugins) -->
    <script>
        jQuery(function() {
            Codebase.helpers(['datepicker', 'colorpicker', 'maxlength', 'select2', 'masked-inputs', 'rangeslider',
                'tags-inputs'
            ]);
        });
    </script>
    <script>
        jQuery(function() {
            Codebase.helpers('select2');
        });
    </script>

</body>

</html>
