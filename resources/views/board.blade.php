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
                            @foreach($boardUsers['grad'] as $grad)
                                <li>
                                    <div>
                                        <div class="inviterCard invitees">
                                            <img src="{{ asset('assets/images/invite-2.jpg') }}" alt="">
                                            <h4>{{ $grad['user']->first_name }}</h4>
                                        </div>
                                    </div>
                                    <ul>
                                        @foreach($grad->children as $pregrad)
                                            <li>
                                                <div>
                                                    <div class="inviterCard invitees">
                                                        <img src="{{ asset('assets/images/invite-2.jpg') }}" alt="">
                                                        <h4>{{$pregrad['user']->first_name}}</h4>
                                                    </div>
                                                </div>
                                                <ul>
                                                    @foreach($pregrad->children as $undergrad)
                                                        <li>
                                                            <div>
                                                                <div class="inviterCard invitees">
                                                                    <img src="{{ asset('assets/images/invite-2.jpg') }}" alt="">
                                                                    <h4>{{$undergrad['user']->first_name}}</h4>
                                                                </div>
                                                            </div>
                                                            <ul>
                                                                @foreach($undergrad->children as $newbie)
                                                                    <li>
                                                                        <div>
                                                                            <div class="inviterCard invitees">
                                                                                <img src="{{ asset('assets/images/invite-2.jpg') }}" alt="">
                                                                                <h4>{{$newbie['user']->first_name}}</h4>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @endforeach
{{--                                        @for($y = 1; $y < 3; $y++)--}}
{{--                                            @for($z = 1; $z < 3; $z++)--}}
{{--                                                @for($a = 1; $a < 3; $a++)--}}
{{--                                                @endfor--}}
{{--                                            @endfor--}}
{{--                                        @endfor--}}
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
