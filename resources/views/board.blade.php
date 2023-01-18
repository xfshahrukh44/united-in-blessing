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

    <section class="treeSec">
        <a href="{{ url()->previous() }}" class="backBtn">
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
                                    @include('partials.inviteCard', ['userData' => $grad, 'class' => 'grad'])
                                    <h4>Grad</h4>
                                    <ul>
                                        @php $x = $y = 1 @endphp

                                        @forelse($grad->boardChildren(Request::segment(2)) as $key => $pregrad)
                                            @if($key == 1)
                                                <li class="heading">
                                                    <h4>Pre-grads</h4>
                                                    <h4>Undergrads</h4>
                                                    <h4>Newbies</h4>
                                                </li>
                                            @endif
                                            @if($grad->boardChildren(Request::segment(2))->count() == 1 && $pregrad->position == 'right')
                                                <li>
                                                    @include('partials.inviteCard', ['userData' => null, 'class' => 'pregrad'])
                                                    <ul>
                                                        <li>
                                                            @include('partials.inviteCard', ['userData' => null, 'class' => 'undergrad'])
                                                            <ul>
                                                                <li>
                                                                    @include('partials.inviteCard', ['userData' => null, 'class' => 'newbie'])
                                                                </li>
                                                                <li>
                                                                    @include('partials.inviteCard', ['userData' => null, 'class' => 'newbie'])
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li>
                                                            @include('partials.inviteCard', ['userData' => null, 'class' => 'undergrad'])
                                                            <ul>
                                                                <li>
                                                                    @include('partials.inviteCard', ['userData' => null, 'class' => 'newbie'])
                                                                </li>
                                                                <li>
                                                                    @include('partials.inviteCard', ['userData' => null, 'class' => 'newbie'])
                                                                </li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </li>
                                            @endif
                                            <li>
                                                @include('partials.inviteCard', ['userData' => $pregrad, 'class' => 'pregrad'])
                                                <ul>
                                                    @forelse($pregrad->boardChildren(Request::segment(2)) as $key => $undergrad)
                                                        <li>
                                                            @include('partials.inviteCard', ['userData' => $undergrad, 'class' => 'undergrad'])
                                                            <ul>
                                                                @forelse($undergrad->boardChildren(Request::segment(2)) as $key => $newbie)
                                                                    @if($undergrad->boardChildren(Request::segment(2))->count() == 1 && $newbie->position == 'right')
                                                                        <li>
                                                                            @include('partials.inviteCard', ['userData' => null, 'class' => 'newbie'])
                                                                        </li>
                                                                    @endif
                                                                    <li>
                                                                        @include('partials.inviteCard', ['userData' => $newbie, 'class' => 'newbie'])
                                                                    </li>
                                                                    @if($undergrad->boardChildren(Request::segment(2))->count() == 1 && $newbie->position == 'left')
                                                                        <li>
                                                                            @include('partials.inviteCard', ['userData' => null, 'class' => 'newbie'])
                                                                        </li>
                                                                    @endif
                                                                @empty
                                                                    <li>
                                                                        @include('partials.inviteCard', ['userData' => null, 'class' => 'undergrad'])
                                                                    </li>
                                                                    <li>
                                                                        @include('partials.inviteCard', ['userData' => null, 'class' => 'undergrad'])
                                                                    </li>
                                                                @endforelse
                                                            </ul>
                                                        </li>
                                                        @if($pregrad->boardChildren(Request::segment(2))->count() === 1)
                                                            <li>
                                                                @include('partials.inviteCard', ['userData' => null, 'class' => 'newbie'])
                                                                <ul>
                                                                    <li>
                                                                        @include('partials.inviteCard', ['userData' => null, 'class' => 'newbie'])
                                                                    </li>
                                                                    <li>
                                                                        @include('partials.inviteCard', ['userData' => null, 'class' => 'newbie'])
                                                                    </li>
                                                                </ul>
                                                            </li>
                                                        @endif
                                                    @empty
                                                        <li>
                                                            @include('partials.inviteCard', ['userData' => null, 'class' => 'undergrad'])
                                                            <ul>
                                                                <li>
                                                                    @include('partials.inviteCard', ['userData' => null, 'class' => 'newbie'])
                                                                </li>
                                                                <li>
                                                                    @include('partials.inviteCard', ['userData' => null, 'class' => 'newbie'])
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li>
                                                            @include('partials.inviteCard', ['userData' => null, 'class' => 'undergrad'])
                                                            <ul>
                                                                <li>
                                                                    @include('partials.inviteCard', ['userData' => null, 'class' => 'newbie'])
                                                                </li>
                                                                <li>
                                                                    @include('partials.inviteCard', ['userData' => null, 'class' => 'newbie'])
                                                                </li>
                                                            </ul>
                                                        </li>
                                                    @endforelse
                                                </ul>
                                            </li>
                                            @if($grad->boardChildren(Request::segment(2))->count() == 1 && $pregrad->position == 'left')
                                                <li>
                                                    @include('partials.inviteCard', ['userData' => null, 'class' => 'pregrad'])
                                                    <ul>
                                                        <li>
                                                            @include('partials.inviteCard', ['userData' => null, 'class' => 'undergrad'])
                                                            <ul>
                                                                <li>
                                                                    @include('partials.inviteCard', ['userData' => null, 'class' => 'newbie'])
                                                                </li>
                                                                <li>
                                                                    @include('partials.inviteCard', ['userData' => null, 'class' => 'newbie'])
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li>
                                                            @include('partials.inviteCard', ['userData' => null, 'class' => 'undergrad'])
                                                            <ul>
                                                                <li>
                                                                    @include('partials.inviteCard', ['userData' => null, 'class' => 'newbie'])
                                                                </li>
                                                                <li>
                                                                    @include('partials.inviteCard', ['userData' => null, 'class' => 'newbie'])
                                                                </li>
                                                            </ul>
                                                        </li>
                                                    </ul>
                                                </li>
                                            @endif
                                        @empty
                                            <li>
                                                @include('partials.inviteCard', ['userData' => null, 'class' => 'pregrad'])
                                                <ul>
                                                    <li>
                                                        @include('partials.inviteCard', ['userData' => null, 'class' => 'undergrad'])
                                                        <ul>
                                                            <li>
                                                                @include('partials.inviteCard', ['userData' => null, 'class' => 'newbie'])
                                                            </li>
                                                            <li>
                                                                @include('partials.inviteCard', ['userData' => null, 'class' => 'newbie'])
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        @include('partials.inviteCard', ['userData' => null, 'class' => 'undergrad'])
                                                        <ul>
                                                            <li>
                                                                @include('partials.inviteCard', ['userData' => null, 'class' => 'newbie'])
                                                            </li>
                                                            <li>
                                                                @include('partials.inviteCard', ['userData' => null, 'class' => 'newbie'])
                                                            </li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="heading">
                                                <h4>Pre-grads</h4>
                                                <h4>Undergrads</h4>
                                                <h4>Newbies</h4>
                                            </li>
                                            <li>
                                                @include('partials.inviteCard', ['userData' => null, 'class' => 'pregrad'])
                                                <ul>
                                                    <li>
                                                        @include('partials.inviteCard', ['userData' => null, 'class' => 'undergrad'])
                                                        <ul>
                                                            <li>
                                                                @include('partials.inviteCard', ['userData' => null, 'class' => 'newbie'])
                                                            </li>
                                                            <li>
                                                                @include('partials.inviteCard', ['userData' => null, 'class' => 'newbie'])
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        @include('partials.inviteCard', ['userData' => null, 'class' => 'undergrad'])
                                                        <ul>
                                                            <li>
                                                                @include('partials.inviteCard', ['userData' => null, 'class' => 'newbie'])
                                                            </li>
                                                            <li>
                                                                @include('partials.inviteCard', ['userData' => null, 'class' => 'newbie'])
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
