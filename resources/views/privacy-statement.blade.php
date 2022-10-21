@extends('layouts.app')
@section('keywords', '')
@section('description', '')

<style>
    .container p{
        line-height: 170%;
    }
    .list{
        list-style: none;
        margin-left: 40px;
    }
    .list li::before{
        content: "\2022";
        color: black;
        font-weight: bold;
        display: inline-block;
        width: 1em;
        margin-left: -1em;
    }
</style>

@section('content')
    <!-- Begin: Main Slider -->
    <div class="main-slider">
        <img class="w-100" src="{{ asset('assets/images/ban1.jpg') }}" alt="First slide">
        <div class="overlay">
            <h3>PRIVACY STATEMENT</h3>
            <h2>Hello {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }} ({{ Auth::user()->username }})</h2>
        </div>
    </div>
    <!-- END: Main Slider -->

    <section class="inviterSec">
        <div class="container">
            <h5>What information do we collect?</h5><br>
            <p>
                We collect information from you when you complete the Membership Info/Form
                on our website.<br><br>
                The Membership Info/Form requests your name, phone number and email address.
            </p><br><br>

            <h5>How do we use your information?</h5><br>
            <p>
                Any of the information we collect from you may be used in one of the following
                ways:
                <ul class="list">
                    <li>To personalize your experience<br>
                        (your information helps us to better respond to your individual needs)</li><br>
                    <li>To better assist you<br>
                        (your information helps us to respond to your requests and support
                        needs)</li>
                </ul>
            </p><br>

            <h5>Do we disclose any information to outside parties?</h5><br>
            <p>
                We do <u>not</u> sell, trade, or otherwise transfer to outside parties any of your personal
                information.
            </p><br>

            <h5>Your Consent</h5><br>
            <p>
                By using our site, you consent to our website’s privacy policy.
            </p><br>

            <h5>Changes to our Privacy Policy</h5><br>
            <p>
                If we decide to change our privacy policy, we will post those changes on this
                page.
            </p>


        </div>
    </section>

@endsection




