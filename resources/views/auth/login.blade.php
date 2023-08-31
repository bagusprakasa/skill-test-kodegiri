<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Login</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="{{ asset('/') }}img/icon.ico" type="image/x-icon" />

    <!-- Fonts and icons -->
    <script src="{{ asset('/') }}js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                "families": ["Lato:300,400,700,900"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
                    "simple-line-icons"
                ],
                urls: ['{{ asset('/') }}css/fonts.min.css']
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('/') }}css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('/') }}css/atlantis.css">
</head>

<body class="login">
    <div class="wrapper wrapper-login">
        <div class="container container-login animated fadeIn">
            <h3 class="text-center">Sign In To Admin</h3>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="login-form">
                    <div
                        class="form-group @error('email')
                            has-error has-feedback
                        @enderror">
                        <label for="errorInput">Email</label>
                        <input type="email" id="errorInput" value="{{ old('email') }}" name="email"
                            class="form-control">
                        @error('email')
                            <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div
                        class="form-group @error('password')
                            has-error has-feedback
                        @enderror">
                        <label for="errorInput">Password</label>
                        <input type="password" id="errorInput" value="{{ old('password') }}" name="password"
                            class="form-control">
                        @error('password')
                            <small id="passwordHelp" class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-action mb-3">
                        <button type="submit" class="btn btn-primary btn-rounded btn-login">Sign In</button>
                    </div>
                    <div class="login-account">
                        <span class="msg">Don't have an account yet ?</span>
                        <a href="{{ route('register') }}" id="show-signup" class="link">Sign Up</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="{{ asset('/') }}js/core/jquery.3.2.1.min.js"></script>
    <script src="{{ asset('/') }}js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script src="{{ asset('/') }}js/core/popper.min.js"></script>
    <script src="{{ asset('/') }}js/core/bootstrap.min.js"></script>
    <script src="{{ asset('/') }}js/atlantis.min.js"></script>
    <!-- Bootstrap Notify -->
    <script src="{{ asset('/') }}js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
    <script>
        // Notif
        @if (Session::has('success'))
            $.notify({
                icon: "fas fa-check-circle ",
                title: "Test skill",
                message: "{{ Session::get('success') }}",
            }, {
                type: "success",
                placement: {
                    from: "top",
                    align: "center",
                },
                time: 1000,
            });
        @endif
        @if (Session::has('error'))
            $.notify({
                icon: "fas fa-exclamation-triangle",
                title: "Test skill",
                message: "{{ Session::get('error') }}",
            }, {
                type: "danger",
                placement: {
                    from: "top",
                    align: "right",
                },
                time: 1000,
            });
        @endif
    </script>
</body>

</html>
