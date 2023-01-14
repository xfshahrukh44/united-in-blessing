@extends('layouts.app')
@section('keywords', '')
@section('description', '')

@section('content')
    <style>
        .backBtn {
            position: absolute;
            top: 5%;
            left: 10%;
            transform: translate(-10%, -5%);
            background-color: var(--primary);
            border-radius: 30px;
            padding: 0.75em 2em;
            color: #fff;
            font-size: 1.25rem;
            z-index: 1;
            border: 1px solid var(--primary);
            transition: all 0.3s ease-in-out;
        }
    </style>
    <!-- Begin: Main Slider -->
    {{--    <div class="main-slider">--}}
    {{--        <img class="w-100" src="{{ asset('assets/images/ban1.jpg') }}" alt="First slide">--}}
    {{--        <div class="overlay">--}}
    {{--        </div>--}}
    {{--    </div>--}}
    <!-- END: Main Slider -->

    <section class="treeSec">
        <a href="{{ url()->previous() }}" class="backBtn">
            {{--            <i class="fas fa-arrow-to-left"></i>--}}
            Back
        </a>
        <div class="container">
            <div class="row m-0 justify-content-center">
                <div class="col-12">
                    <h3 class="text-black text-center mt-3">
                        Hello {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }}
                        ({{ Auth::user()->username }})</h3>
                </div>
                <div class="col-md-6">
                    <div class="container-fluid">
                        <div class="row justify-content-between">
                            <div class="col-md-12 justify-content-center mb-4">
                                <div class="titles">
                                    <p>${{ $board->amount }} Board</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="titles">
                                    <p>Board No: </p>
                                    <p>Previous Board No:</p>
                                </div>
                                <div class="info">
                                    <p>{{ $board->board_number }}</p>
                                    <p>132456</p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="titles">
                                    <p>Previous GRAD: </p>
                                    <p>Board Status: </p>
                                </div>
                                <div class="info">
                                    <p>Username</p>
                                    <p>{{ $board->status }}</p>
                                </div>
                            </div>

                            <div class="invitees-color mt-4 text-center">
                                <div class="col-3">
                                    <p class="text-uppercase" style="color: red">gift pending</p>
                                </div>
                                <div class="col-3">
                                    <p class="text-uppercase">0 Invitees</p>
                                </div>
                                <div class="col-3">
                                    <p class="text-uppercase" style="color: #ffc107">1 Invitee</p>
                                </div>
                                <div class="col-3">
                                    <p class="text-uppercase" style="color: green">2 Invitees</p>
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
                                        </div>
                                    </div>
                                        @php $x = $y = 1 @endphp
                                        {{--                                        @foreach($grad->boardChildren(Request::segment(2)) as $key => $pregrad)--}}
                                        {{--                                            --}}
                                        {{--                                        @endforeach--}}
                                        @forelse($grad->boardChildren(Request::segment(2)) as $key => $pregrad)
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
                                                    </div>
                                                </div>
                                                <ul>
                                                    @forelse($pregrad->boardChildren(Request::segment(2)) as $key => $undergrad)
                                                        <li>
                                                            <div>
                                                                <div class="inviterCard invitees undergrad">
                                                                    <img
                                                                        src="{{ $undergrad['user']->user_image ? asset('upload/user/' . $undergrad['user']->user_image) : asset('assets/images/user.png') }}"
                                                                        alt="">
                                                                    <h4 style="color: {{ ($undergrad->user->inviters->count() == 0) ? 'black' : (($undergrad->user->inviters->count() == 1) ? '#ffc107' : 'green') }}">{{$undergrad['user']->username}}</h4>
                                                                </div>
                                                            </div>
                                                            <ul>
                                                                @forelse($undergrad->boardChildren(Request::segment(2)) as $key => $newbie)
                                                                    @if($undergrad->boardChildren(Request::segment(2))->count() == 1 && $newbie->position == 'right')
                                                                        <li>
                                                                            <div>
                                                                                <div
                                                                                    class="inviterCard invitees newbie">
                                                                                    <h4 style="font-size: 14px;">No
                                                                                        Invitee</h4>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    @endif
                                                                    <li>
                                                                        <div>
                                                                            <div class="inviterCard invitees newbie">
                                                                                <img
                                                                                    src="{{ $newbie['user']->user_image ? asset('upload/user/' . $newbie['user']->user_image) : asset('assets/images/user.png') }}"
                                                                                    alt="">
                                                                                <h4 style="color: {{ ($newbie->board->user_gift($newbie->user->id)->status == 'not_sent' || $newbie->board->user_gift($newbie->user->id)->status == 'pending') ? 'red' : (($newbie->user->inviters->count() == 0) ? '' : (($newbie->user->inviters->count() == 1) ? '#ffc107' : 'green')) }}">{{$newbie['user']->username}}</h4>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                    @if($undergrad->boardChildren(Request::segment(2))->count() == 1 && $newbie->position == 'left')
                                                                        <li>
                                                                            <div>
                                                                                <div
                                                                                    class="inviterCard invitees newbie">
                                                                                    <img
                                                                                        src="{{asset('assets/images/user.png') }}"
                                                                                        alt="">
                                                                                    <h4 style="font-size: 14px;">No
                                                                                        Invitee</h4>
                                                                                </div>
                                                                            </div>
                                                                        </li>
                                                                    @endif
                                                                @empty
                                                                    <li>
                                                                        <div>
                                                                            <div class="inviterCard invitees newbie">
                                                                                <img
                                                                                    src="{{asset('assets/images/user.png') }}"
                                                                                    alt="">
                                                                                <h4 style="font-size: 14px;">No
                                                                                    Invitee</h4>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <div class="inviterCard invitees newbie">
                                                                                <img
                                                                                    src="{{asset('assets/images/user.png') }}"
                                                                                    alt="">
                                                                                <h4 style="font-size: 14px;">No
                                                                                    Invitee</h4>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                @endforelse
                                                            </ul>
                                                        </li>
                                                        @if($pregrad->boardChildren(Request::segment(2))->count() === 1)
                                                            <li>
                                                                <div>
                                                                    <div class="inviterCard invitees newbie">
                                                                        <img
                                                                            src="{{asset('assets/images/user.png') }}"
                                                                            alt="">
                                                                        <h4 style="font-size: 14px;">No Invitee</h4>
                                                                    </div>
                                                                </div>
                                                                <ul>
                                                                    <li>
                                                                        <div>
                                                                            <div class="inviterCard invitees newbie">
                                                                                <img
                                                                                    src="{{asset('assets/images/user.png') }}"
                                                                                    alt="">
                                                                                <h4 style="font-size: 14px;">No
                                                                                    Invitee</h4>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div>
                                                                            <div class="inviterCard invitees newbie">
                                                                                <img
                                                                                    src="{{asset('assets/images/user.png') }}"
                                                                                    alt="">
                                                                                <h4 style="font-size: 14px;">No
                                                                                    Invitee</h4>
                                                                            </div>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                        @endif
                                                    @empty
                                                        <li>
                                                            <div>
                                                                <div class="inviterCard invitees newbie">
                                                                    <img
                                                                        src="{{asset('assets/images/user.png') }}"
                                                                        alt="">
                                                                    <h4 style="font-size: 14px;">No Invitee</h4>
                                                                </div>
                                                            </div>
                                                            <ul>
                                                                <li>
                                                                    <div>
                                                                        <div class="inviterCard invitees newbie">
                                                                            <img
                                                                                src="{{asset('assets/images/user.png') }}"
                                                                                alt="">
                                                                            <h4 style="font-size: 14px;">No Invitee</h4>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div>
                                                                        <div class="inviterCard invitees newbie">
                                                                            <img
                                                                                src="{{asset('assets/images/user.png') }}"
                                                                                alt="">
                                                                            <h4 style="font-size: 14px;">No Invitee</h4>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li>
                                                            <div>
                                                                <div class="inviterCard invitees newbie">
                                                                    <img
                                                                        src="{{asset('assets/images/user.png') }}"
                                                                        alt="">
                                                                    <h4 style="font-size: 14px;">No Invitee</h4>
                                                                </div>
                                                            </div>
                                                            <ul>
                                                                <li>
                                                                    <div>
                                                                        <div class="inviterCard invitees newbie">
                                                                            <img
                                                                                src="{{asset('assets/images/user.png') }}"
                                                                                alt="">
                                                                            <h4 style="font-size: 14px;">No Invitee</h4>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div>
                                                                        <div class="inviterCard invitees newbie">
                                                                            <img
                                                                                src="{{asset('assets/images/user.png') }}"
                                                                                alt="">
                                                                            <h4 style="font-size: 14px;">No Invitee</h4>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                    @endforelse
                                                </ul>
                                            </li>
                                        @empty
{{--                                    <h4>Grad</h4>--}}
                                    <ul>
{{--                                            <li class="heading">--}}
{{--                                                <h4>Pre-grads</h4>--}}
{{--                                                <h4>Undergrads</h4>--}}
{{--                                                <h4>Newbies</h4>--}}
{{--                                            </li>--}}

                                            <li>
                                                <div>
                                                    <div class="inviterCard invitees pregrad">
                                                        <img
                                                            src="{{asset('assets/images/user.png') }}"
                                                            alt="">
                                                        <h4 style="font-size: 14px;">No Invitee</h4>
                                                    </div>
                                                </div>
                                                <ul>
                                                    <li>
                                                        <div>
                                                            <div class="inviterCard invitees undergrad">
                                                                <img
                                                                    src="{{asset('assets/images/user.png') }}"
                                                                    alt="">
                                                                <h4 style="font-size: 14px;">No Invitee</h4>
                                                            </div>
                                                        </div>
                                                        <ul>
                                                            <li>
                                                                <div>
                                                                    <div class="inviterCard invitees newbie">
                                                                        <img
                                                                            src="{{asset('assets/images/user.png') }}"
                                                                            alt="">
                                                                        <h4 style="font-size: 14px;">No Invitee</h4>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div>
                                                                    <div class="inviterCard invitees newbie">
                                                                        <img
                                                                            src="{{asset('assets/images/user.png') }}"
                                                                            alt="">
                                                                        <h4 style="font-size: 14px;">No Invitee</h4>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <div>
                                                            <div class="inviterCard invitees newbie">
                                                                <img
                                                                    src="{{asset('assets/images/user.png') }}"
                                                                    alt="">
                                                                <h4 style="font-size: 14px;">No Invitee</h4>
                                                            </div>
                                                        </div>
                                                        <ul>
                                                            <li>
                                                                <div>
                                                                    <div class="inviterCard invitees newbie">
                                                                        <img
                                                                            src="{{asset('assets/images/user.png') }}"
                                                                            alt="">
                                                                        <h4 style="font-size: 14px;">No Invitee</h4>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div>
                                                                    <div class="inviterCard invitees newbie">
                                                                        <img
                                                                            src="{{asset('assets/images/user.png') }}"
                                                                            alt="">
                                                                        <h4 style="font-size: 14px;">No Invitee</h4>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li>
                                                <div>
                                                    <div class="inviterCard invitees pregrad">
                                                        <img
                                                            src="{{asset('assets/images/user.png') }}"
                                                            alt="">
                                                        <h4 style="font-size: 14px;">No Invitee</h4>
                                                    </div>
                                                </div>
                                                <ul>
                                                    <li>
                                                        <div>
                                                            <div class="inviterCard invitees undergrad">
                                                                <img
                                                                    src="{{asset('assets/images/user.png') }}"
                                                                    alt="">
                                                                <h4 style="font-size: 14px;">No Invitee</h4>
                                                            </div>
                                                        </div>
                                                        <ul>
                                                            <li>
                                                                <div>
                                                                    <div class="inviterCard invitees newbie">
                                                                        <img
                                                                            src="{{asset('assets/images/user.png') }}"
                                                                            alt="">
                                                                        <h4 style="font-size: 14px;">No Invitee</h4>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div>
                                                                    <div class="inviterCard invitees newbie">
                                                                        <img
                                                                            src="{{asset('assets/images/user.png') }}"
                                                                            alt="">
                                                                        <h4 style="font-size: 14px;">No Invitee</h4>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <div>
                                                            <div class="inviterCard invitees newbie">
                                                                <img
                                                                    src="{{asset('assets/images/user.png') }}"
                                                                    alt="">
                                                                <h4 style="font-size: 14px;">No Invitee</h4>
                                                            </div>
                                                        </div>
                                                        <ul>
                                                            <li>
                                                                <div>
                                                                    <div class="inviterCard invitees newbie">
                                                                        <img
                                                                            src="{{asset('assets/images/user.png') }}"
                                                                            alt="">
                                                                        <h4 style="font-size: 14px;">No Invitee</h4>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div>
                                                                    <div class="inviterCard invitees newbie">
                                                                        <img
                                                                            src="{{asset('assets/images/user.png') }}"
                                                                            alt="">
                                                                        <h4 style="font-size: 14px;">No Invitee</h4>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                        @endforelse
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
