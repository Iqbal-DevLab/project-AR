@extends('layouts.auth')
@section('auth_content')
    {{-- <div class="row">
        <div class="col-md-4 col-sm-12 mx-auto">
            <div class="card pt-4">
                <div class="card-body">
                    <div class="text-center mb-5">
                        <img src="public/assets/images/logo-simetri.png" height="80" class='mb-4'>
                        <h2 class="text-dark">Login</h2>
                        <h4 class="text-dark">Accounts Receivable Monitoring</h4>
                    </div>
                    <form action="/authlogin" method="POST">
                        @csrf
                        <div class="form-group position-relative has-icon-left">
                            <label for="username">NIK</label>
                            <div class="position-relative">
                                <input type="text" class="form-control @error('nik_karyawan') is-invalid @enderror"
                                    id="nik_karyawan" name="nik_karyawan">
                                <div class="form-control-icon">
                                    <i data-feather="user"></i>
                                </div>
                            </div>
                            @error('nik_karyawan')
                                <span class="text-danger py-2">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>
                        <div class="form-group position-relative has-icon-left">
                            <div class="clearfix">
                                <label for="password">Password</label>
                            </div>
                            <div class="position-relative">
                                <input type="password" class="form-control" id="password" name="password">
                                <div class="form-control-icon">
                                    <i data-feather="lock"></i>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix">
                            <button class="btn btn-dark w-100">Masuk</button>
                        </div>
                        @if ($message = Session::get('error'))
                            <div class="pt-2 text-center text-danger">
                                <p>{{ $message }}</p>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
        @include('sweetalert::alert')
    </div> --}}

    <div id="page-container" class="main-content-boxed">

        <!-- Main Container -->
        <main id="main-container">

            <!-- Page Content -->
            <div class="bg-image" style="background-image: url('{{ asset('public/media/photos/photo34@2x.jpg') }}');">
                <div class="row mx-0 bg-black-op">
                    <div class="hero-static col-md-6 col-xl-8 d-none d-md-flex align-items-md-end">
                        <div class="p-30 invisible" data-toggle="appear">
                            <p class="font-size-h3 font-w600 text-white">
                                EMPOWERING THE WORLD
                            </p>
                            {{-- <div style="position: relative; right: 360px;">
                            <img class="mx-auto d-block w-25" src="public/assets/images/empowering.jpg" alt="Empowering the World" style="border-radius: 5px;"/>
                            </div> --}}
                            <p class="font-italic text-white-op">
                                Copyright &copy; <span class="js-year-copy">2023</span>
                            </p>
                        </div>
                    </div>
                    <div class="hero-static col-md-6 col-xl-4 d-flex align-items-center bg-white invisible"
                        data-toggle="appear" data-class="animated fadeInRight">
                        <div class="content content-full">
                            <!-- Header -->
                            <div class="text-center">
                                <img class="mx-auto d-block w-25 h-25" src="public/assets/images/logo-simetri.png" />
                                <div class="px-30 py-10">
                                    <a class="link-effect font-w700" href="/simetri-ar/">
                                        <span class="font-size-xl text-primary-dark">Simetri </span><span
                                            class="font-size-xl">AR</span>
                                    </a>
                                    <h1 class="h3 font-w700 mt-30 mb-10">Account Receivable Monitoring</h1>
                                    <h2 class="h5 font-w400 text-muted mb-0">Please log in</h2>
                                </div>
                            </div>

                            <!-- END Header -->

                            <!-- Sign In Form -->
                            <!-- jQuery Validation functionality is initialized with .js-validation-signin class in js/pages/op_auth_signin.min.js which was auto compiled from _es6/pages/op_auth_signin.js -->
                            <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                            <form class="js-validation-signin px-30" action={{ route('authlogin') }} method="POST">
                                @csrf
                                <div class="form-group row">
                                    <div class="col-12">
                                        <div class="form-material floating">
                                            <input type="text" class="form-control" id="nik_karyawan"
                                                name="nik_karyawan">
                                            <label for="nik_karyawan">Username</label>
                                        </div>
                                    </div>
                                    @error('nik_karyawan')
                                        <span class="text-danger py-2">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group row">
                                    <div class="col-12">
                                        <div class="form-material floating">
                                            <input type="password" class="form-control" id="password" name="password">
                                            <label for="password">Password</label>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="form-group row">
                                    <div class="col-12">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="login-remember-me"
                                                name="login-remember-me">
                                            <label class="custom-control-label" for="login-remember-me">Remember
                                                Me</label>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="form-group text-right">
                                    <button type="submit" class="btn btn-sm btn-hero btn-alt-primary">
                                        <i class="si si-login mr-10"></i> Log in
                                    </button>
                                    @if ($message = Session::get('error'))
                                        <div class="pt-2 text-center text-danger">
                                            <p>{{ $message }}</p>
                                        </div>
                                    @endif
                                    {{-- <div class="mt-30">
                                        <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="#">
                                            <i class="fa fa-plus mr-5"></i> Create Account
                                        </a>
                                        <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="#">
                                            <i class="fa fa-warning mr-5"></i> Forgot Password
                                        </a>
                                    </div> --}}
                                </div>
                            </form>
                            <!-- END Sign In Form -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- END Page Content -->
            @include('sweetalert::alert')
        </main>
        <!-- END Main Container -->
    </div>
@endsection
