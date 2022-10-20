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
            <h3>HOW IT WORKS</h3>
            <h2>Hello {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }} ({{ Auth::user()->username }})</h2>
        </div>
    </div>
    <!-- END: Main Slider -->

    <section class="inviterSec">
        <div class="container">
            <p>We only have FOUR (4) <u>2x3 matrix boards:</u> <strong>$100, $400, $1000, and $2,000</strong>.</p><br>

            <p>When you become a <b>GRAD on your 1 st $100 board</b>, you <b>receive $800 in GIFTS</b> from
                eight NEWBIES on that board. When you receive the 1 st four $100 GIFTS, you GIVE
                that to the GRAD on a NEW $400 board and take a position as a NEWBIE. When you
                receive the LAST $100 GIFT of your eight GIFTS, you will GIFT the GRAD on your
                NEW board and take a position as a NEWBIE.</p><br>

            <p>This is referred to as RE-ENTERING onto a NEW board which is also known as a RE-
                ENTRY board. In this instance, you <b>keep $300 in GIFTS as a GRAD out of the $800
                    on your 1 st $100 board.</b></p><br>

            <p>In fact, you <b>ALWAYS use your LAST GIFT to RE-ENTER onto a NEW board</b> of
                the same value of your previous board.</p><br>

            <p>For example, when you are a GRAD on a <b>$100 board</b> and receive your LAST GIFT, you
                will RE-ENTER onto a NEW $100 board; GIFT the GRAD on that board with $100 and
                take a position as a NEWBIE.</p><br>

            <p>When you are a GRAD on a <b>$400 board</b> and receive your LAST GIFT, you will RE-
                ENTER onto a NEW $400 board; GIFT the GRAD on that board with $400 and take a
                position as a NEWBIE.</p><br>

            <p>When you are a GRAD on a <b>$1,000 board</b> and receive your LAST GIFT, you will RE-
                ENTER onto a NEW $1,000 board; GIFT the GRAD on that board with $1,000 and take
                a position as a NEWBIE.</p><br>

            <p>When you are a GRAD on a <b>$2,000 board</b>, and receive your LAST GIFT, you will RE-
                ENTER onto a NEW $2,000 board; GIFT the GRAD on that board with $2,000 and take
                a position as a NEWBIE.</p><br><br>

            <div class="text-center">
                <p><b>KEEP IN MIND THAT</b></p><br>

                <p><b>YOU CAN BE ON THE $100, $400, $1,000 AND $2,000 BOARD SIMULTANEOUSLY.</b></p><br>

                <div class="text-center">
                    <p><b>In each of your FIRST</b> positions, <b>you</b> will receive the following <b>GIFTS</b>:</p>
                    <br>
                    <div class="table">
                        <th><b>$ 100 Board</b></th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <th><b>$ 300</b></th>
                    </div>
                    <div class="table">
                        <th><b>$ 400 Board</b></th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <th><b>$ 1,800</b></th>
                    </div>
                    <div class="table">
                        <th><b>$ 1,000 Board</b></th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <th><b>$ 5,000</b></th>
                    </div>
                    <div class="table">
                        <th><b>$ 2,000 Board</b></th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <th><b>$ <u>14,000</u></b></th>
                    </div>
                    <div class="table">
                        <th></th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <th><b>$ 21,100</b></th>
                    </div>
                </div>
                <br><br>

                <div class="text-center">
                    <p><b>In each of your 2nd and subsequent</b> positions, <b>you</b> will receive the following
                        <b>GIFTS</b>:</p>
                    <br>
                    <div class="table">
                        <th><b>$ 100 Board</b></th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <th><b>$ 700</b></th>
                    </div>
                    <div class="table">
                        <th><b>$ 400 Board</b></th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <th><b>$ 2,800</b></th>
                    </div>
                    <div class="table">
                        <th><b>$ 1,000 Board</b></th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <th><b>$ 7,000</b></th>
                    </div>
                    <div class="table">
                        <th><b>$ 2,000 Board</b></th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <th><b>$ <u>14,000</u></b></th>
                    </div>
                    <div class="table">
                        <th></th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        <th><b>$ 24,500</b></th>
                    </div>
                </div>
                <br><br><br>

                <p><b>YOU CAN CYCLE OVER AND OVER, AGAIN AND AGAIN !</b></p><br><br>

                <p><b>You Can Receive This Blessing For A
                    <br><u>One-Time GIFT Of $100</u></b>
                </p>


            </div>


        </div>
    </section>

@endsection




