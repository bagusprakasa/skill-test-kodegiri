<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Register</title>
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
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div
                    class="form-group @error('name')
                            has-error has-feedback
                        @enderror">
                    <label for="errorInput">Fullname</label>
                    <input type="text" id="errorInput" value="{{ old('name') }}" name="name"
                        class="form-control" placeholder="Fullname">
                    @error('name')
                        <small id="nameHelp" class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div
                    class="form-group @error('email')
                            has-error has-feedback
                        @enderror">
                    <label for="errorInput">Email</label>
                    <input type="email" id="errorInput" value="{{ old('email') }}" name="email"
                        class="form-control" placeholder="Email">
                    @error('email')
                        <small id="emailHelp" class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div
                    class="form-group @error('phone')
                            has-error has-feedback
                        @enderror">
                    <label for="errorInput">Phone Number</label>
                    <input type="number" id="errorInput" value="{{ old('phone') }}" name="phone"
                        class="form-control" placeholder="Phone Number">
                    @error('phone')
                        <small id="phoneHelp" class="form-text text-danger">{{ $message }}</small>
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
                <div
                    class="form-group @error('confirmation')
                            has-error has-feedback
                        @enderror">
                    <label for="errorInput">Confirmation Password</label>
                    <input type="password" id="errorInput" value="{{ old('confirmation') }}" name="confirmation"
                        class="form-control">
                    @error('confirmation')
                        <small id="confirmationHelp" class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-action">
                    <a href="{{ route('login') }}" id="show-signin"
                        class="btn btn-danger btn-link btn-login mr-3">Cancel</a>
                    <button type="submit" class="btn btn-primary btn-rounded btn-login">Sign Up</button>
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
                title: "Shayna",
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
                title: "Shayna",
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
