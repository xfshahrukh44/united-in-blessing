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
        <a href="{{ url()->previous() }}" class="backBtn">
{{--            <i class="fas fa-arrow-to-left"></i>--}}
            Back
        </a>
        <div class="container">
            <div class="row my-5 justify-content-center">
                <div class="col-md-8">
                    <div class="container-fluid">
                        <div class="row justify-content-between">
                            <div class="col-md-12 justify-content-center mb-4">
                                <div class="titles">
                                    <p>${{ $board->amount }} Board</p>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="titles">
                                    <p>Board No: </p>
                                    <p>Previous Board No:</p>
                                </div>
                                <div class="info">
                                    <p>{{ $board->board_number }}</p>
                                    <p>132456</p>
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
                                        <div class="inviterCard invitees grad">
                                            <img
                                                src="{{ $grad['user']->user_image ? asset('upload/user/' . $grad['user']->user_image) : asset('assets/images/user.png') }}"
                                                alt="">
                                            <h4 style="color: {{ ($grad->user->inviters->count() == 0) ? '' : (($grad->user->inviters->count() == 1) ? '#ffc107' : 'green') }}">{{$grad['user']->username}}</h4>
{{--                                            <p>{{ ($key + 1) }}</p>--}}
                                        </div>
                                    </div>
                                    <h4>Grad</h4>
                                    <ul>
                                        @php $x = $y = 1 @endphp

                                        @foreach($grad->boardChildren(Request::segment(2)) as $key => $pregrad)
                                            @if($key == 1)
                                            <li class="heading">
                                                <h4>Pre-grads</h4>
                                                <h4>Undergrads</h4>
                                                <h4>Newbies</h4>
                                            </li>
                                            @endif
                                            <li>
                                                <div>
                                                    <div class="inviterCard invitees pregrad">
                                                        <img
                                                            src="{{ $pregrad['user']->user_image ? asset('upload/user/' . $pregrad['user']->user_image) : asset('assets/images/user.png') }}"
                                                            alt="">
                                                        <h4 style="color: {{ ($pregrad->user->inviters->count() == 0) ? '' : (($pregrad->user->inviters->count() == 1) ? '#ffc107' : 'green') }}">{{$pregrad['user']->username}}</h4>
{{--                                                        <p>{{ ($key + 1) }}</p>--}}
                                                    </div>
                                                </div>
{{--                                                <h4>Pregrads</h4>--}}
                                                <ul>
                                                    @foreach($pregrad->boardChildren(Request::segment(2)) as $key => $undergrad)
                                                        <li>
                                                            <div>
                                                                <div class="inviterCard invitees undergrad">
                                                                    <img
                                                                        src="{{ $undergrad['user']->user_image ? asset('upload/user/' . $undergrad['user']->user_image) : asset('assets/images/user.png') }}"
                                                                        alt="">
                                                                    <h4 style="color: {{ ($undergrad->user->inviters->count() == 0) ? 'black' : (($undergrad->user->inviters->count() == 1) ? '#ffc107' : 'green') }}">{{$undergrad['user']->username}}</h4>

{{--                                                                    <p>{{ ($x++) }}</p>--}}
                                                                </div>
                                                            </div>
{{--                                                            <h4>undergrads</h4>--}}
                                                            <ul>
                                                                @forelse($undergrad->boardChildren(Request::segment(2)) as $key => $newbie)
                                                                    @if($undergrad->boardChildren(Request::segment(2))->count() == 1 && $newbie->position == 'right')
                                                                        <li>
                                                                            <div>
                                                                                <div class="inviterCard invitees newbie">
                                                                                    <h4>No Invitee</h4>
{{--                                                                                    <p>{{ ($y++) }}</p>--}}
                                                                                </div>
                                                                            </div>
{{--                                                                            <h4>Newbies</h4>--}}
                                                                        </li>
                                                                    @endif
                                                                    <li>
                                                                        <div>
                                                                            <div class="inviterCard invitees newbie">
                                                                                <img
                                                                                    src="{{ $newbie['user']->user_image ? asset('upload/user/' . $newbie['user']->user_image) : asset('assets/images/user.png') }}"
                                                                                    alt="">
                                                                                <h4 style="color: {{ ($newbie->board->user_gift($newbie->user->id)->status == 'not_sent' || $newbie->board->user_gift($newbie->user->id)->status == 'pending') ? 'red' : '' }}">{{$newbie['user']->username}}</h4>
{{--                                                                                <p>{{ ($y++) }}</p>--}}
                                                                            </div>
                                                                        </div>
{{--                                                                        <h4>Newbies</h4>--}}
                                                                    </li>
                                                                    @if($undergrad->boardChildren(Request::segment(2))->count() == 1 && $newbie->position == 'left')
                                                                        <li>
                                                                            <div>
                                                                                <div class="inviterCard invitees newbie">
                                                                                    <h4>No Invitee</h4>
{{--                                                                                    <p>{{ ($y++) }}</p>--}}
                                                                                </div>
                                                                            </div>
{{--                                                                            <h4>Newbies</h4>--}}
                                                                        </li>
                                                                    @endif
                                                                @empty
                                                                    <li>
                                                                        <div>
                                                                            <div class="inviterCard invitees newbie">
                                                                                <img
                                                                                    src="{{asset('assets/images/user.png') }}"
                                                                                    alt="">
                                                                                <h4>No Invitee</h4>
{{--                                                                                <p>{{ ($y++) }}</p>--}}
                                                                            </div>
                                                                        </div>
{{--                                                                        <h4>Newbies</h4>--}}
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <div class="inviterCard invitees newbie">
                                                                                <img
                                                                                    src="{{asset('assets/images/user.png') }}"
                                                                                    alt="">
                                                                                <h4>No Invitee</h4>
{{--                                                                                <p>{{ ($y++) }}</p>--}}
                                                                            </div>
                                                                        </div>
{{--                                                                        <h4>Newbies</h4>--}}
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
