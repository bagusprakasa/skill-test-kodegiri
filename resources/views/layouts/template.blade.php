<!DOCTYPE html>
<html lang="en">

{{-- Head --}}
@include('includes.head')

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
                    @yield('content')
                </div>
            </div>
        </div>
        {{-- Footer --}}
        @include('includes.footer')
    </div>

    {{-- Javascript --}}
    @include('includes.script')
</body>

</html>
