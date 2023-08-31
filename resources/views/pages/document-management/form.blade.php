<!DOCTYPE html>
<html lang="en">

{{-- Head --}}

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>{{ config('app.name') }} |
        {{ Request::segment(1) ? ucwords(str_replace('-', ' ', Request::segment(1))) : 'Dashboard' }}</title>
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
                urls: [
                    "{{ asset('/') }}css/fonts.min.css"
                ]
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="{{ asset('/') }}css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('/') }}css/atlantis2.css">

    <!-- CSS Just for demo purpose, don't include it in your project -->
    {{-- <link rel="stylesheet" href="{{ asset('/') }}css/demo.css"> --}}
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.css">

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <link type="text/css" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/south-street/jquery-ui.css"
        rel="stylesheet">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="http://keith-wood.name/js/jquery.signature.js"></script>

    <link rel="stylesheet" type="text/css" href="http://keith-wood.name/css/jquery.signature.css">


    <style>
        .kbw-signature {
            width: 100%;
            height: 200px;
        }

        #sig canvas {
            width: 100% !important;
            height: auto;
        }
    </style>
</head>


<body>
    <div class="wrapper fullwidth-style">

        {{-- Navbar --}}
        @include('includes.navbar')
        <div class="main-panel">
            <div class="container">
                <div class="page-inner mt-md-3">
                    <div class="page-header">
                        <h4 class="page-title">{{ $title }}</h4>
                        <ul class="breadcrumbs">
                            <li class="nav-home">
                                <a href="#">
                                    <i class="flaticon-home"></i>
                                </a>
                            </li>
                            <li class="separator">
                                <i class="flaticon-right-arrow"></i>
                            </li>
                            <li class="nav-item">
                                <a href="#">{{ $title }}</a>
                            </li>
                            @if (Request::segment(2))
                                <li class="separator">
                                    <i class="flaticon-right-arrow"></i>
                                </li>
                                <li class="nav-item">
                                    <a href="#">{{ Request::segment(2) == 'create' ? 'Create' : 'Edit' }}</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    {{-- Content --}}
                    @if ($data['type'] == 'add')
                        <form action="{{ route('document-management.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                        @else
                            <form action="{{ route('document-management.update', $data['data']->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ $data['list'] }}</h4>
                                    <a href="{{ route('document-management.index') }}"
                                        class="btn btn-sm btn-primary mt-3"><span
                                            class="fas fa-long-arrow-alt-left"></span> Back To {{ $data['menu'] }}</a>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group @error('title') has-error has-feedback @enderror">
                                                <label for="errorInput">Title</label>
                                                <input type="text" value="{{ old('title', $data['data']->title) }}"
                                                    class="form-control" name="title">
                                                @error('title')
                                                    <small class="form-text text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3">
                                            <div class="form-group @error('choose') has-error has-feedback @enderror">
                                                <label for="errorInput">Signing</label>
                                                <select name="choose" id="choose" class="form-control">
                                                    <option value="">---Chose Signing---</option>
                                                    <option value="upload"
                                                        {{ old('choose', $data['data']->choose) == 'upload' ? 'selected' : '' }}>
                                                        Upload
                                                        File
                                                    </option>
                                                    <option value="pad"
                                                        {{ old('choose', $data['data']->choose) == 'pad' ? 'selected' : '' }}>
                                                        Signing
                                                        Pad
                                                    </option>
                                                </select>
                                                @error('choose')
                                                    <small class="form-text text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3" id="uploadPad">
                                            <div class="form-group @error('signing') has-error has-feedback @enderror">
                                                <label for="errorInput">Signature</label>
                                                <br />
                                                <div id="sig"></div>
                                                <br />
                                                <button id="clear" class="btn btn-danger btn-sm">Clear
                                                    Signature</button>
                                                <textarea id="signature64" name="signed" style="display: none"></textarea>
                                                @error('signing')
                                                    <small class="form-text text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-3" id="uploadImage">
                                            <div class="form-group @error('signing') has-error has-feedback @enderror">
                                                <label for="errorInput">Upload File Signing</label>
                                                <input type="file" accept="image/png"
                                                    value="{{ old('signing', $data['data']->signing) }}"
                                                    class="form-control" name="signing">
                                                @error('signing')
                                                    <small class="form-text text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-lg-12">
                                            <div class="form-group @error('content') has-error has-feedback @enderror">

                                                <label for="errorInput">Content</label>
                                                <textarea id="summernote" name="content">{{ old('content', $data['data']->content) }}</textarea>
                                                @error('content')
                                                    <small class="form-text text-danger">{{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-action">
                                    <button class="btn btn-success">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- Footer --}}
        @include('includes.footer')
    </div>

    {{-- Javascript --}}
    <!--   Core JS Files   -->
    <script src="{{ asset('/') }}js/core/popper.min.js"></script>
    <script src="{{ asset('/') }}js/core/bootstrap.min.js"></script>
    <!-- jQuery UI -->
    <script src="{{ asset('/') }}js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="{{ asset('/') }}js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Moment JS -->
    <script src="{{ asset('/') }}js/plugin/moment/moment.min.js"></script>

    <!-- Chart JS -->
    <script src="{{ asset('/') }}js/plugin/chart.js/chart.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="{{ asset('/') }}js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <!-- Chart Circle -->
    <script src="{{ asset('/') }}js/plugin/chart-circle/circles.min.js"></script>

    <!-- Datatables -->
    <script src="{{ asset('/') }}js/plugin/datatables/datatables.min.js"></script>

    <!-- Bootstrap Notify -->
    <script src="{{ asset('/') }}js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

    <!-- Bootstrap Toggle -->
    <script src="{{ asset('/') }}js/plugin/bootstrap-toggle/bootstrap-toggle.min.js"></script>

    <!-- jQuery Vector Maps -->
    <script src="{{ asset('/') }}js/plugin/jqvmap/jquery.vmap.min.js"></script>
    <script src="{{ asset('/') }}js/plugin/jqvmap/maps/jquery.vmap.world.js"></script>

    <!-- Google Maps Plugin -->
    <script src="{{ asset('/') }}js/plugin/gmaps/gmaps.js"></script>

    <!-- Dropzone -->
    <script src="{{ asset('/') }}js/plugin/dropzone/dropzone.min.js"></script>

    <!-- Fullcalendar -->
    <script src="{{ asset('/') }}js/plugin/fullcalendar/fullcalendar.min.js"></script>

    <!-- DateTimePicker -->
    <script src="{{ asset('/') }}js/plugin/datepicker/bootstrap-datetimepicker.min.js"></script>

    <!-- Bootstrap Tagsinput -->
    <script src="{{ asset('/') }}js/plugin/bootstrap-tagsinput/bootstrap-tagsinput.min.js"></script>

    <!-- Bootstrap Wizard -->
    <script src="{{ asset('/') }}js/plugin/bootstrap-wizard/bootstrapwizard.js"></script>

    <!-- jQuery Validation -->
    <script src="{{ asset('/') }}js/plugin/jquery.validate/jquery.validate.min.js"></script>

    <!-- Summernote -->
    <script src="{{ asset('/') }}js/plugin/summernote/summernote-bs4.min.js"></script>

    <!-- Select2 -->
    <script src="{{ asset('/') }}js/plugin/select2/select2.full.min.js"></script>

    <!-- Sweet Alert -->
    <script src="{{ asset('/') }}js/plugin/sweetalert/sweetalert.min.js"></script>

    <script>
        // Select2
        $('#basic').select2({
            theme: "bootstrap"
        });
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
                    align: "right",
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
        $('#summernote').summernote({
            placeholder: 'Content',
            fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New'],
            tabsize: 2,
            height: 300
        });
        var sig = $('#sig').signature({
            syncField: '#signature64',
            syncFormat: 'PNG'
        });
        $('#clear').click(function(e) {
            e.preventDefault();
            sig.signature('clear');
            $("#signature64").val('');
        });
        $('#choose').change(function() {
            if ($(this).val() == 'upload') {
                $('#uploadImage').show();
                $('#uploadPad').hide();
            } else if ($(this).val() == 'pad') {
                $('#uploadPad').show();
                $('#uploadImage').hide();
            } else {
                $('#uploadPad').hide();
                $('#uploadImage').hide();
            }
        });
        @if (old('choose', $data['data']->choose) == 'upload')
            $('#uploadPad').hide();
            $('#uploadImage').show();
        @elseif (old('choose', $data['data']->choose) == 'pad')
            $('#uploadImage').hide();
            $('#uploadPad').show();
        @else
            $('#uploadPad').hide();
            $('#uploadImage').hide();
        @endif
    </script>

</body>

</html>
