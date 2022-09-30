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
        <a href="{{route('home')}}" class="backBtn">
            <i class="fas fa-arrow-to-left"></i>
        </a>
        <div class="container">
            <div class="row my-5 justify-content-center">
                <div class="col-md-8">
                    <div class="container-fluid">
                        <div class="row justify-content-between">
                            <div class="col-md-5">
                                <div class="titles">
                                    <p>Board: </p>
                                    <p>Previous Board No:</p>
                                </div>
                                <div class="info">
                                    <p>{{ $board->board_number }}</p>
                                    <p>{{ $board->previous_board_number }}</p>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="titles">
                                    <p>Previous GRAD: </p>
                                    <p>Board Status: </p>
                                </div>
                                <div class="info">
                                    <p>Username</p>
                                    <p>{{ $board->status }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div>
                        <ul class="tree vertical">
                            @foreach($boardGrad as $key => $grad)
                                <li>
                                    <div>
                                        <div class="inviterCard invitees">
                                            <img
                                                src="{{ $grad['user']->user_image ? asset('upload/user/' . $grad['user']->user_image) : asset('assets/images/user.png') }}"
                                                alt="">
                                            <h4 style="color: {{ ($grad->user->inviters->count() == 0) ? '' : (($grad->user->inviters->count() == 1) ? 'red' : 'green') }}">{{$grad['user']->username}}</h4>
                                            <p>{{ ($key + 1) }}</p>
                                        </div>
                                    </div>
                                    <h4>Grad</h4>
                                    <ul>
                                        @php $x = $y = 1 @endphp

                                        @foreach($grad->boardChildren(Request::segment(2)) as $key => $pregrad)
                                            <li>
                                                <div>
                                                    <div class="inviterCard invitees">
                                                        <img
                                                            src="{{ $pregrad['user']->user_image ? asset('upload/user/' . $pregrad['user']->user_image) : asset('assets/images/user.png') }}"
                                                            alt="">
                                                        <h4 style="color: {{ ($pregrad->user->inviters->count() == 0) ? '' : (($pregrad->user->inviters->count() == 1) ? 'red' : 'green') }}">{{$pregrad['user']->username}}</h4>
                                                        <p>{{ ($key + 1) }}</p>
                                                    </div>
                                                </div>
                                                <h4>Pregrads</h4>
                                                <ul>
                                                    @foreach($pregrad->boardChildren(Request::segment(2)) as $undergrad)
                                                        <li>
                                                            <div>
                                                                <div class="inviterCard invitees">
                                                                    <img
                                                                        src="{{ $undergrad['user']->user_image ? asset('upload/user/' . $undergrad['user']->user_image) : asset('assets/images/user.png') }}"
                                                                        alt="">
                                                                    <h4 style="color: {{ ($undergrad->user->inviters->count() == 0) ? 'black' : (($undergrad->user->inviters->count() == 1) ? 'red' : 'green') }}">{{$undergrad['user']->username}}</h4>

                                                                    <p>{{ ($x++) }}</p>
                                                                </div>
                                                            </div>
                                                            <h4>undergrads</h4>
                                                            <ul>
                                                                @forelse($undergrad->boardChildren(Request::segment(2)) as $key => $newbie)
                                                                    <li>
                                                                        <div>
                                                                            <div class="inviterCard invitees">
                                                                                <img
                                                                                    src="{{ $newbie['user']->user_image ? asset('upload/user/' . $newbie['user']->user_image) : asset('assets/images/user.png') }}"
                                                                                    alt="">
                                                                                <h4 style="color: {{ ($newbie->user->inviters->count() == 0) ? '' : (($newbie->user->inviters->count() == 1) ? 'red' : 'green') }}">{{$newbie['user']->username}}</h4>

                                                                                <p>{{ ($y++) }}</p>
                                                                            </div>
                                                                        </div>
                                                                        <h4>Newbies</h4>
                                                                    </li>
                                                                    @if($undergrad->boardChildren(Request::segment(2))->count() == 1)
                                                                        <li>
                                                                            <div>
                                                                                <div class="inviterCard invitees">
                                                                                    <h4>No Invitee</h4>
                                                                                    <p>{{ ($y++) }}</p>
                                                                                </div>
                                                                            </div>
                                                                            <h4>Newbies</h4>
                                                                        </li>
                                                                    @endif
                                                                @empty
                                                                    <li>
                                                                        <div>
                                                                            <div class="inviterCard invitees noimg">
                                                                                <h4>No Invitee</h4>
                                                                                <p>{{ ($y++) }}</p>
                                                                            </div>
                                                                        </div>
                                                                        <h4>Newbies</h4>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <div class="inviterCard invitees noimg">
                                                                                <h4>No Invitee</h4>
                                                                                <p>{{ ($y++) }}</p>
                                                                            </div>
                                                                        </div>
                                                                        <h4>Newbies</h4>
                                                                    </li>
                                                                @endforelse
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
