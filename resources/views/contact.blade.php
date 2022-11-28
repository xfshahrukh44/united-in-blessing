@extends('layouts.app')
@section('keywords', '')
@section('description', '')

<style>
    .container p{
        line-height: 170%;
    }
</style>
@section('content')
    <!-- Begin: Main Slider -->
    <div class="main-slider">
        <img class="w-100" src="{{ asset('assets/images/ban1.jpg') }}" alt="First slide">
        <div class="overlay">
            <h3>CONTACT US</h3>
            <h2>Hello {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }} ({{ Auth::user()->username }})</h2>
        </div>
    </div>
    <!-- END: Main Slider -->

    <section class="contactSec">
        <div class="container">
            <a href="{{route('home')}}" class="backBtn">
                {{--            <i class="fas fa-arrow-to-left"></i>--}}
                Back
            </a>
            <div class="content">
                <h2>Contact US</h2>
                <h3>Hello {{ Auth::user()->username }}</h3>
                <h3>Please Contact An ADMIN</h3>
                <h3>(Chris, Dee or Elliott)</h3>
                <h2>VIA</h2>
                <h3>TELEGRAM <a href=""><i class="fab fa-telegram-plane" aria-hidden="true"></i></a> Message</h3>
                <h3>for</h3>
                <h3>Assistance with Locating Your Username</h3>
            </div>
        </div>
    </section>

@endsection




