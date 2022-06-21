@extends('layouts.app')

@section('content')

    <body class="bg-pattern">
        <div class="bg-overlay"></div>
        <div class="account-pages my-5 pt-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-4 col-lg-6 col-md-8">
                        <div class="card">
                            <div class="card-body p-4">
                                <div class="">
                                    <div class="text-center">
                                        <a href="index.html" class="">
                                            <img src="assets/images/logo-dark.png" alt="" height="24"
                                                class="auth-logo logo-dark mx-auto">
                                            <img src="assets/images/logo-light.png" alt="" height="24"
                                                class="auth-logo logo-light mx-auto">
                                        </a>
                                    </div>
                                    <!-- end row -->
                                    <h4 class="font-size-18 text-muted mt-2 text-center">Welcome Back !</h4>
                                    <p class="mb-5 text-center">Sign in to continue to Upzet.</p>
                                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="mb-4">
                                                    <label class="form-label" for="email">Email adress</label>
                                                    <input id="email" type="email"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        value="{{ old('email') }}" required autocomplete="email" autofocus
                                                        placeholder="Enter e-mail">
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                                <div class="mb-4">
                                                    <label class="form-label" for="password">Password</label>
                                                    <input id="password" type="password"
                                                        class="form-control @error('password') is-invalid @enderror"
                                                        name="password" required autocomplete="current-password">
                                                    @error('password')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>

                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" name="remember"
                                                                id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                            <label class="form-label" class="form-check-label"
                                                                for="customControlInline">Remember me</label>
                                                        </div>
                                                    </div>
                                                    @if (Route::has('password.request'))
                                                        <div class="col-7">
                                                            <div class="text-md-end mt-3 mt-md-0">
                                                                <a href="{{ route('password.request') }}"
                                                                    class="text-muted"><i class="mdi mdi-lock"></i>
                                                                    Forgot your password?</a>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="d-grid mt-4">
                                                    <button class="btn btn-primary waves-effect waves-light"
                                                        type="submit">Log In</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 text-center">
                            <p class="text-white-50">Don't have an account ? <a href="{{ route('register') }}"
                                    class="fw-medium text-primary"> Register </a> </p>
                        </div>
                    </div>
                </div>
                <!-- end row -->

            </div>
        </div>
        <!-- end Account pages -->

        <!-- JAVASCRIPT -->
        <script src="assets/libs/jquery/jquery.min.js"></script>
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/node-waves/waves.min.js"></script>
        <script src="assets/js/app.js"></script>

    </body>

@endsection
