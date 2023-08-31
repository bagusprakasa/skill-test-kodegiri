<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Verify Email</title>
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

<body class="page-not-found">
    <div class="wrapper not-found">
        @if (Session::has('success'))
            <div class="desc animated fadeIn">{{ Session::get('success') }}</div>
        @elseif(Session::has('error'))
            <h1 class="animated fadeIn"><span>OOPS!</span></h1>
            <div class="desc animated fadeIn">{{ Session::get('error') }}</div>
            <a href="#" onclick="logout()" class="btn btn-primary btn-back-home mt-4 animated fadeInUp">
                <span class="btn-label mr-2">
                    <i class="fas fa-home"></i>
                </span>
                Logout
            </a>
            <a href="{{ route('register.resend', Auth::user()->id) }}?key={{ Hash::make(Auth::user()->id) }}"
                class="btn btn-primary btn-back-home mt-4 animated fadeInUp">
                <span class="btn-label mr-2">
                    <i class="fas fa-envelope"></i>
                </span>
                Resend Email Activation
            </a>
            <form method="POST" action="{{ route('logout') }}" id="logout">
                @csrf
            </form>
        @else
            <h1 class="animated fadeIn"><span>OOPS!</span></h1>
            <div class="desc animated fadeIn">Looks like your account not activated</div>
            <a href="#" onclick="logout()" class="btn btn-primary btn-back-home mt-4 animated fadeInUp">
                <span class="btn-label mr-2">
                    <i class="fas fa-home"></i>
                </span>
                Logout
            </a>
            <a href="{{ route('register.resend', Auth::user()->id) }}?key={{ Hash::make(Auth::user()->id) }}"
                class="btn btn-primary btn-back-home mt-4 animated fadeInUp">
                <span class="btn-label mr-2">
                    <i class="fas fa-envelope"></i>
                </span>
                Resend Email Activation
            </a>
            <form method="POST" action="{{ route('logout') }}" id="logout">
                @csrf
            </form>
        @endif

    </div>
    <script src="{{ asset('/') }}js/core/jquery.3.2.1.min.js"></script>
    <script src="{{ asset('/') }}js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
    <script src="{{ asset('/') }}js/core/popper.min.js"></script>
    <script src="{{ asset('/') }}js/core/bootstrap.min.js"></script>
    <script>
        function logout() {
            $('#logout').submit();
        }
    </script>
</body>

</html>
