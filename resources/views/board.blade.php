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
    {{--@foreach($boardUsers1 as $count)
        <h4>{{$count}}</h4>
    @endforeach--}}
    <section class="treeSec">
        <div class="container-fluid">
            <div class="row mb-5 justify-content-center">
                <div class="col-md-8">
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
                                            @if($grad->user->inviters->count() == 0)
                                                <h4>{{ $grad['user']->username }}</h4>
                                                @elseif($grad->user->inviters->count() == 1)
                                                    <h4 style="color:red">{{ $grad['user']->username }}</h4>
                                                    @else
                                                        <h4 style="color:green">{{ $grad['user']->username }}</h4>
                                            @endif
                                            <p>{{ ($key + 1) }}</p>
                                        </div>
                                    </div>
                                    <h4>Grad</h4>
                                    <ul>
                                        @php $x = $y = 1 @endphp

                                        @foreach($grad->children as $key => $pregrad)
                                            <li>
                                                <div>
                                                    <div class="inviterCard invitees">
                                                        <img
                                                            src="{{ $pregrad['user']->user_image ? asset('upload/user/' . $pregrad['user']->user_image) : asset('assets/images/user.png') }}"
                                                            alt="">
                                                        @if($pregrad->user->inviters->count() == 0)
                                                            <h4>{{ $pregrad['user']->username }}</h4>
                                                            @elseif($pregrad->user->inviters->count() == 1)
                                                                <h4 style="color:red">{{ $pregrad['user']->username }}</h4>
                                                                @else
                                                                    <h4 style="color:green">{{ $pregrad['user']->username }}</h4>
                                                        @endif
                                                        <p>{{ ($key + 1) }}</p>
                                                    </div>
                                                </div>
                                                <h4>Pregrads</h4>
                                                <ul>
                                                    @foreach($pregrad->children as $undergrad)
                                                        <li>
                                                            <div>
                                                                <div class="inviterCard invitees">
                                                                    <img
                                                                        src="{{ $undergrad['user']->user_image ? asset('upload/user/' . $undergrad['user']->user_image) : asset('assets/images/user.png') }}"
                                                                        alt="">
                                                                    @if($undergrad->user->inviters->count() == 0)
                                                                        <h4>{{ $undergrad['user']->username }}</h4>
                                                                        @elseif($undergrad->user->inviters->count() == 1)
                                                                            <h4 style="color:red">{{ $undergrad['user']->username }}</h4>
                                                                            @else
                                                                                <h4 style="color:green">{{ $undergrad['user']->username }}</h4>
                                                                    @endif

                                                                    <p>{{ ($x++) }}</p>
                                                                </div>
                                                            </div>
                                                            <h4>undergrads</h4>
                                                            <ul>
                                                                @foreach($undergrad->children as $key => $newbie)
                                                                    <li>
                                                                        <div>
                                                                            <div class="inviterCard invitees">
                                                                                <img
                                                                                    src="{{ $newbie['user']->user_image ? asset('upload/user/' . $newbie['user']->user_image) : asset('assets/images/user.png') }}"
                                                                                    alt="">
                                                                                @if($gifts[$newbie['user']->id]->status == "accepted" || $gifts[$newbie['user']->id]->status == "")
                                                                                    <h4>{{ $newbie['user']->username }}</h4>
                                                                                    @else
                                                                                        <h4 style="color:red">{{ $newbie['user']->username }}</h4>
                                                                                @endif
                                                                                {{--@if($newbie->user->inviters->count() == 0)
                                                                                        <h4>{{ $newbie['user']->username }}</h4>
                                                                                    @elseif($newbie->user->inviters->count() == 1)
                                                                                        <h4 style="color:red">{{ $newbie['user']->username }}</h4>
                                                                                        @else
                                                                                            <h4 style="color:green">{{ $newbie['user']->username }}</h4>
                                                                                @endif--}}
                                                                                <p>{{ ($y++) }}</p>
                                                                            </div>
                                                                        </div>
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
