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

    <section class="inviterSec">
        <div class="container">
            <div class="text-center mt-5">
                <h3>PLEASE SEE OUR</h3>
                <br><br><br><br><br><br>
                <h1>“UNITED IN BLESSING”</h1>
                <br><br><br><br><br><br>
                <h3><a href="#">TELEGRAM GROUP</a></h3>

                <p class="mt-5"><i class="fab fa-telegram-plane" aria-hidden="true" style="font-size: 30px"  ></i></p>

            </div>
        </div>
    </section>

@endsection




