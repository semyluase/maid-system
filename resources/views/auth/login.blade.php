<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title . ' - ' . env('APP_NAME', 'Template') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/mazer/dist/assets/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/mazer/dist/assets/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/mazer/dist/assets/css/pages/auth.css') }}">
</head>

<body>
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo h1">
                        <a href="{{ url('') }}">{{ env('APP_NAME', 'Template') }}</a>
                    </div>
                    <h1 class="auth-title">Log in.</h1>
                    <p class="auth-subtitle mb-3">
                        @if (session()->has('alert'))
                            <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert"
                                    aria-hidden="true">&times;</button>
                                {{ session('alert') }}
                            </div>
                        @endif
                    </p>
                    <form action="{{ url('do_login') }}" method="post" id="form-login">
                        @csrf
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="text" class="form-control form-control-xl" name="username" id="username"
                                placeholder="Username">
                            <div class="form-control-icon">
                                <i class="fas fa-user-alt"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control form-control-xl" name="password" id="password"
                                placeholder="Password">
                            <div class="form-control-icon" id="password-icon">
                            </div>
                        </div>
                        <div class="form-check form-check-lg d-flex align-items-end">
                            <input class="form-check-input me-2" type="checkbox" value="" id="rememberMe"
                                name="rememberMe">
                            <label class="form-check-label text-gray-600" for="rememberMe">
                                Remember Me
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right"></div>
            </div>
        </div>
    </div>
</body>

<script src="{{ asset('assets/vendor/fontawesome/js/all.min.js') }}"></script>
<?php
    if (!empty($js)) {
        for ($i=0; $i < count($js); $i++) {
?>
<script src="{{ asset($js[$i]) }}"></script>
<?php
        }
    }
?>

</html>
