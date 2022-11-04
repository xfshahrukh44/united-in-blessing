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
    <link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/custom.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.min.css') }}"/>

    <!-- Plugins -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css')}}">

    @if(Request::is('board-tree/*') || Request::is('admin/board/members/*'))
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
    <div class="container-fluid h-100">
        <div class="row h-100">
            <div class="col-12 navigation-wrapper">
                <div class="nav-inner">
                    <ul class="list-inline">
                        <li class="nav-item">
                            <a href="{{ url('home') }}" class="nav-link"><i class="fas fa-home"></i> HOME</a>
                        </li>

                        @if(Auth::check())
                            @if(Auth::user()->role == 'admin')
                                <li class="nav-item">
                                    <a href="{{ route('dashboard') }}" class="nav-link">Admin Dashboard</a>
                                </li>
                            @endif
                            <li class="nav-item">
                                <a href="{{ url('profile') }}" class="nav-link"><i class="fas fa-user"></i>My PROFILE</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('front.work')}}" class="nav-link"><i class="fas fa-tasks-alt"></i>How it works</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('front.guidelines')}}" class="nav-link"><i class="fas fa-file-alt"></i>Guidelines</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('front.faq')}}" class="nav-link"><i class="fas fa-question"></i>FAQs</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('front.gifting-forms')}}" class="nav-link"><i class="fas fa-gifts"></i>Gifting Forms</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('front.privacy-statement')}}" class="nav-link"><i class="fas fa-user-secret"></i>Privacy Statement</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('front.contact-us')}}" class="nav-link"><i class="fas fa-envelope"></i>Contact Us</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('logout') }}" class="nav-link" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i>LOGOUT</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ url('register') }}" class="nav-link">JOIN</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ url('login') }}" class="nav-link">LOGIN</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- navigation -->

@yield('content')

{{-- INACTIVITY MODAL--}}
<div class="modal fade" id="inactivity" tabindex="-1" role="dialog" aria-labelledby="inactivity" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Inactivity</h5>
            </div>
            <div class="modal-body">
                You have been logged out due to inactivity.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="reload()">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/2.1.3/TweenMax.min.js"></script>
<script src="{{ asset('assets/js/jquery.fancybox.min.js') }}"></script>
<script src="{{ asset('assets/js/slick.min.js') }}"></script>
<script src="{{ asset('assets/js/custom.min.js') }}"></script>
<script src="{{ asset('assets/plugins/toastr/toastr.min.js')}}"></script>

{{--input masking--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>

<script>
    let global = 15;

    $(document).ready(function () {
        // Input Masking for phone number
        $('input[name="phone"]').inputmask('999-999-9999');

        // Logout user due to inactivity
    })

    $('html').mousemove(function (event) {
        resetGlobal();
    });

    function resetGlobal() {
        global = 15;
    }

    function reload() {
        location.reload();
    }

    setInterval(function () {
        noMovement()
    }, 60000); //every minute

    function noMovement() {
        if (global == 0) {
            userLogout();
            resetGlobal();
            $('#inactivity').modal('show');
        } else {
            global--;
        }
    }

    function userLogout() {
        $.ajax({
            url: '{{route('logout')}}',
            type: 'POST',
            data: {
                "_token": "{{ csrf_token() }}"
            },
            success: function (res) {
                console.log(res);
            },
            error: function () {

            }
        })
    }
</script>

@yield('js')

@if(session()->has('success'))
    <script type="text/javascript">  toastr.success('{{ session('success')}}');</script>
@endif
@if(session()->has('error'))
    <script type="text/javascript"> toastr.error('{{ session('error')}}');</script>
@endif

</body>
</html>
