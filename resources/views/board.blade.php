@extends('layouts.app')
@section('keywords', '')
@section('description', '')

@section('content')
    <!-- Begin: Main Slider -->
    <div class="main-slider">
        <img class="w-100" src="{{ asset('assets/images/ban1.jpg') }}" alt="First slide">
        <div class="overlay">
            <!--            <h2>Lorem Ipsum</h2>-->
        </div>
    </div>
    <!-- END: Main Slider -->

    <section class="treeSec">
        <div class="container-fluid">
            <div class="row mb-5 justify-content-center">
                <div class="col-md-5">
                    <div class="inviterCard invitees boardCard">
                        <div class="titles">
                            <p>Board: </p>
                            <p>Previous Board No:</p>
                            <p>Previous GRAD: </p>
                            <p>Board Status: </p>
                        </div>
                        <div class="info">
                            <p>{{ $board->board_number }}</p>
                            <p>132456</p>
                            <p>Username</p>
                            <p>{{ $board->status }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div>
                        <ul class="tree vertical">
                            @foreach($boardUsers['grad'] as $key => $grad)
                                <li>
                                    <div>
                                        <div class="inviterCard invitees">
                                            <img
                                                src="{{ $grad['user']->user_image ? asset('upload/user/' . $grad['user']->user_image) : asset('assets/images/user.png') }}"
                                                alt="">
                                            <h4>{{ $grad['user']->username }}</h4>
                                        </div>
                                    </div>
                                    <p>{{ $key + 1 }}</p>
                                    <h4>Grad</h4>
                                    <ul>
                                        {{ $x = $y = 1 }}

                                        @foreach($grad->children as $key => $pregrad)
                                            <li>
                                                <div>
                                                    <div class="inviterCard invitees">
                                                        <img
                                                            src="{{ $pregrad['user']->user_image ? asset('upload/user/' . $pregrad['user']->user_image) : asset('assets/images/user.png') }}"
                                                            alt="">
                                                        <h4>{{$pregrad['user']->username}}</h4>
                                                    </div>
                                                </div>
                                                <p>{{ $key + 1 }}</p>
                                                <h4>Pregrads</h4>
                                                <ul>
                                                    @foreach($pregrad->children as $undergrad)
                                                        <li>
                                                            <div>
                                                                <div class="inviterCard invitees">
                                                                    <img
                                                                        src="{{ $undergrad['user']->user_image ? asset('upload/user/' . $undergrad['user']->user_image) : asset('assets/images/user.png') }}"
                                                                        alt="">
                                                                    <h4>{{$undergrad['user']->username}}</h4>
                                                                </div>
                                                            </div>
                                                            <p>{{ $x++ }}</p>
                                                            <h4>undergrads</h4>
                                                            <ul>
                                                                @foreach($undergrad->children as $key => $newbie)
                                                                    <li>
                                                                        <div>
                                                                            <div class="inviterCard invitees">
                                                                                <img
                                                                                    src="{{ $newbie['user']->user_image ? asset('upload/user/' . $newbie['user']->user_image) : asset('assets/images/user.png') }}"
                                                                                    alt="">
                                                                                <h4>{{$newbie['user']->username}}</h4>
                                                                            </div>
                                                                        </div>
                                                                        <p>{{ $y++ }}</p>
                                                                        <h4>Newbies</h4>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
