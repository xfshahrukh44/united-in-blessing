<!DOCTYPE html>
<html lang="en">

<head>
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Required meta tags -->
    <meta charset="utf-8"/>
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"/>
    <link rel="stylesheet" href="{{ asset('assets/css/jquery.fancybox.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/slick.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/slick-theme.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/custom.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.min.css') }}"/>

    <!-- Plugins -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css')}}">

    @if(\Illuminate\Support\Facades\Request::has('tree'))
        <link rel="stylesheet" href="{{ asset('assets/css/tree.css') }}"/>
    @endif

    @yield('css')
</head>

<body>
<header>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <a href="{{ url('/') }}"><img src="{{ asset('assets/images/logo.png') }}" alt="Logo"></a>
            </div>
            <div class="col-md-6">
                <button class="menu-toggler" type="button" data-target="#overlayNavigation">
                    <div class="d-inline-flex navbar-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </button>
            </div>
        </div>
    </div>
</header>
<!-- navigation -->
<div class="navigation-menu" id="overlayNavigation">
    <div class="navigation-bg one"></div>
    <div class="navigation-bg two"></div>
    <div class="container-fluid h-100">
        <div class="row h-100">
            <div class="offset-md-6 col-md-6 navigation-wrapper">
                <div class="nav-inner">
                    <ul class="list-inline">
                        <li class="nav-item">
                            <a href="{{ url('home') }}" class="nav-link">HOME</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('register') }}" class="nav-link">JOIN</a>
                        </li>
                        <li class="nav-item">
                            @if(Auth::check())
                                <a href="{{ url('logout') }}" class="nav-link" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">Logout</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            @else
                                <a href="{{ url('login') }}" class="nav-link">LOGIN</a>
                            @endif
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('/') }}" class="nav-link">LANDING</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ url('profile') }}" class="nav-link">PROFILE</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- navigation -->

@yield('content')

<script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.3/TweenMax.min.js"></script>
<script src="{{ asset('assets/js/jquery.fancybox.min.js') }}"></script>
<script src="{{ asset('assets/js/slick.min.js') }}"></script>
<script src="{{ asset('assets/js/custom.min.js') }}"></script>
<script src="{{ asset('assets/plugins/toastr/toastr.min.js')}}"></script>

@if(session()->has('success'))
    <script type="text/javascript">  toastr.success('{{ session('success')}}');</script>
@endif
@if(session()->has('error'))
    <script type="text/javascript"> toastr.error('{{ session('error')}}');</script>
@endif

</body>
</html>
