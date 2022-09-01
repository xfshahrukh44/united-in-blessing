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
                            <li>
                                @foreach($boardUsers as $bUser)
                                    @if($bUser->user_board_roles == 'grad')
                                        <div>
                                            <div class="inviterCard invitees">
                                                <img src="{{ asset('assets/images/invite-2.jpg') }}" alt="">
                                                <h4>{{ $bUser->user->username }}</h4>
                                            </div>
                                        </div>
                                    @endif
                                    @if($bUser->user_board_roles == 'pregrad' && $bUser->position == 'left')
                                        <ul class="pregrad">
                                            <li class="pregrad-left">
                                                <div>
                                                    <div class="inviterCard invitees">
                                                        <img src="{{ asset('assets/images/invite-2.jpg') }}" alt="">
                                                        <h4>{{ $bUser->user->username }}</h4>
                                                    </div>
                                                </div>
                                                <ul class="undergrad">
                                                    @endif
                                                    @if($bUser->user_board_roles == 'undergrad' && $bUser->position == 'left')
                                                    <li>
                                                        <div>
                                                            <div class="inviterCard invitees">
                                                                <img src="{{ asset('assets/images/invite-2.jpg') }}" alt="">
                                                                <h4>{{ $bUser->user->username }}</h4>
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </li>
                                            @endif

                                            @if($bUser->user_board_roles == 'pregrad' && $bUser->position == 'right')
                                                <li class="pregrad-right">
                                                    <div class="undergrad">
                                                        <div class="inviterCard invitees">
                                                            <img src="{{ asset('assets/images/invite-2.jpg') }}" alt="">
                                                            <h4>{{ $bUser->user->username }}</h4>
                                                        </div>
                                                    </div>
                                                @endif
                                            @if($bUser->user_board_roles == 'undergrad' && $bUser->position == 'right')

                                                </li>
                                        </ul>
                                    @endif
                                @endforeach
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
