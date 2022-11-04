@extends('layouts.app')
@section('keywords', '')
@section('description', '')
<style>
    .menu-toggler{
        display: none !important;
    }
    .navigation-menu{
        right: -400px !important;
    }
</style>
@section('content')
    <main class="loginWrap landingWrap">
        <div class="container">
            <div class="row whitebg p-0">
                <div class="col-lg-6">
                    <div class="orangeSide">
                        <a href="{{ url('register') }}" class="themeBtn mb-5"><span></span><text>Join</text></a>
                        <img src="{{ asset('assets/images/christmas-gift.png') }}" alt="">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="whiteSide">
                        <a href="{{ url('login') }}" class="themeBtn"><span></span><text>Login</text></a>
                        <div class="center">
                            <h2 class="wlcm">Welcome <br> to</h2>
                            <img src="{{ url('assets/images/logo.png') }}" alt="">
                            <h2><em>We are Blessed</em><em>to be A Blessing!</em></h2>
                            <a href="#">(U.S. RESIDENTS ONLY)</a>
                        </div>
                        <div class="botom">
                            <a href="{{ url('/') }}">UnitedInBlessing.com</a>
                            <p>© 2022 Copyright</p>
                            <p>All Rights Reserved</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
