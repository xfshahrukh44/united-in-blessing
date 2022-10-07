@extends('layouts.app')
@section('keywords', '')
@section('description', '')

@section('content')
    <!-- Begin: Main Slider -->
    <div class="main-slider">
        <img class="w-100" src="{{ asset('assets/images/ban1.jpg') }}" alt="First slide">
        <div class="overlay">
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
                        <form action="{{ route('admin.update.board.members', $board->id) }}" method="POST">
                            @csrf
                            <ul class="tree vertical">
                                @foreach($boardGrad as $key => $grad)
                                    <li>
                                        <div>
                                            <div class="inviterCard invitees">
                                                <img
                                                    src="{{ $grad['user']->user_image ? asset('upload/user/' . $grad['user']->user_image) : asset('assets/images/user.png') }}"
                                                    alt="">
                                                <select name="grad" id="grad">
                                                    @foreach($users as $user)
                                                        <option
                                                            value="{{ $user->id }}" {{ $grad->user_id == $user->id ? 'selected' : '' }}>{{ $user->username }}</option>
                                                    @endforeach
                                                </select>
                                                {{--                                            <h4 style="color: {{ ($grad->user->inviters->count() == 0) ? '' : (($grad->user->inviters->count() == 1) ? 'red' : 'green') }}">{{$grad['user']->username}}</h4>--}}
                                                <p>{{ ($key + 1) }}</p>
                                            </div>
                                        </div>
                                        <h4>Grad</h4>
                                        <ul>
                                            @php $x = $y = 1 @endphp

                                            @foreach($grad->boardChildren($board->id) as $key => $pregrad)
                                                <li>
                                                    <div>
                                                        <div class="inviterCard invitees">
                                                            <img
                                                                src="{{ $pregrad['user']->user_image ? asset('upload/user/' . $pregrad['user']->user_image) : asset('assets/images/user.png') }}"
                                                                alt="">
                                                            <select name="pregrad_{{ $pregrad->position }}"
                                                                    id="pregrad_{{ $pregrad->position }}">
                                                                @foreach($users as $user)
                                                                    <option
                                                                        value="{{ $user->id }}" {{ $pregrad->user_id == $user->id ? 'selected' : '' }}>{{ $user->username }}</option>
                                                                @endforeach
                                                            </select>
                                                            {{--                                                            <h4 style="color: {{ ($pregrad->user->inviters->count() == 0) ? '' : (($pregrad->user->inviters->count() == 1) ? 'red' : 'green') }}">{{$pregrad['user']->username}}</h4>--}}
                                                            <p>{{ ($key + 1) }}</p>
                                                        </div>
                                                    </div>
                                                    <h4>Pregrads</h4>
                                                    <ul>
                                                        @foreach($pregrad->boardChildren($board->id) as $key => $undergrad)
                                                            <li>
                                                                <div>
                                                                    <div class="inviterCard invitees">
                                                                        <img
                                                                            src="{{ $undergrad['user']->user_image ? asset('upload/user/' . $undergrad['user']->user_image) : asset('assets/images/user.png') }}"
                                                                            alt="">
                                                                        <select
                                                                            name="undergrad_{{ $x . '_' . $undergrad->position }}"
                                                                            id="undergrad">
                                                                            @foreach($users as $user)
                                                                                <option
                                                                                    value="{{ $user->id }}" {{ $undergrad->user_id == $user->id ? 'selected' : '' }}>{{ $user->username }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        {{--                                                                        <h4 style="color: {{ ($undergrad->user->inviters->count() == 0) ? 'black' : (($undergrad->user->inviters->count() == 1) ? 'red' : 'green') }}">{{$undergrad['user']->username}}</h4>--}}
                                                                        <p>{{ ($x++) }}</p>
                                                                    </div>
                                                                </div>
                                                                <h4>undergrads</h4>
                                                                <ul>
                                                                    @forelse($undergrad->boardChildren($board->id) as $key => $newbie)
                                                                        @if($undergrad->boardChildren($board->id)->count() == 1 && $newbie->position == 'right')
                                                                            <li>
                                                                                <div>
                                                                                    <div class="inviterCard invitees">
                                                                                        <select
                                                                                            name="newbie[{{ $undergrad->user_id }}][{{ $newbie->position == 'left' ? 'right' : 'left' }}]"
                                                                                            id="newbie">
                                                                                            <option value="">No
                                                                                                invitee
                                                                                            </option>
                                                                                            @foreach($users as $user)
                                                                                                <option
                                                                                                    value="{{ $user->id }}">{{ $user->username }}</option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                        {{--                                                                                        <h4>No Invitee</h4>--}}
                                                                                        <p>{{ ($y++) }}</p>
                                                                                    </div>
                                                                                </div>
                                                                                <h4>Newbies</h4>
                                                                            </li>
                                                                        @endif
                                                                        <li>
                                                                            <div>
                                                                                <div class="inviterCard invitees">
                                                                                    <img
                                                                                        src="{{ $newbie['user']->user_image ? asset('upload/user/' . $newbie['user']->user_image) : asset('assets/images/user.png') }}"
                                                                                        alt="">
                                                                                    {{--                                                                                    <select name="newbie_{{ $y . '_' . $newbie->position }}" id="newbie">--}}
                                                                                    <select
                                                                                        name="newbie[{{ $undergrad->user_id }}][{{ $newbie->position }}]"
                                                                                        id="newbie">
                                                                                        @foreach($users as $user)
                                                                                            <option
                                                                                                value="{{ $user->id }}" {{ $newbie->user_id == $user->id ? 'selected' : '' }}>{{ $user->username }}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                    <p>{{ ($y++) }}</p>
                                                                                </div>
                                                                            </div>
                                                                            <h4>Newbies</h4>
                                                                        </li>
                                                                        @if($undergrad->boardChildren($board->id)->count() == 1 && $newbie->position == 'left')
                                                                            <li>
                                                                                <div>
                                                                                    <div class="inviterCard invitees">
                                                                                        <select
                                                                                            name="newbie[{{ $undergrad->user_id }}][{{ $newbie->position == 'left' ? 'right' : 'left' }}]"
                                                                                            id="newbie">
                                                                                            <option value="">No
                                                                                                invitee
                                                                                            </option>
                                                                                            @foreach($users as $user)
                                                                                                <option
                                                                                                    value="{{ $user->id }}">{{ $user->username }}</option>
                                                                                            @endforeach
                                                                                        </select>
                                                                                        {{--                                                                                        <h4>No Invitee</h4>--}}
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
                                                                                    <select
                                                                                        name="newbie[{{ $undergrad->user_id }}][left]"
                                                                                        id="newbie">
                                                                                        <option value="">No invitee
                                                                                        </option>
                                                                                        @foreach($users as $user)
                                                                                            <option
                                                                                                value="{{ $user->id }}">{{ $user->username }}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                    {{--                                                                                    <h4>No Invitee</h4>--}}
                                                                                    <p>{{ ($y++) }}</p>
                                                                                </div>
                                                                            </div>
                                                                            <h4>Newbies</h4>
                                                                        </li>
                                                                        <li>
                                                                            <div>
                                                                                <div class="inviterCard invitees noimg">
                                                                                    <select
                                                                                        name="newbie[{{ $undergrad->user_id }}][right]"
                                                                                        id="newbie">
                                                                                        <option value="">No invitee
                                                                                        </option>
                                                                                        @foreach($users as $user)
                                                                                            <option
                                                                                                value="{{ $user->id }}">{{ $user->username }}</option>
                                                                                        @endforeach
                                                                                    </select>
                                                                                    {{--                                                                                    <h4>No Invitee</h4>--}}
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
                            <button class="btn btn-success" type="submit">Update Board</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            $('select').each(function () {
                if ($(this).val() != '') {
                    $('select').not($(this)).find('option[value=' + $(this).val() + ']').attr('disabled', 'disabled');
                }
            })
        })

        $('select').change(function () {
            $('select').each(function () {
                $('select').find('option').removeAttr('disabled');
            });
            $('select').each(function () {
                if ($(this).val() != '') {
                    $('select').not($(this)).find('option[value=' + $(this).val() + ']').attr('disabled', 'disabled');
                }
            });
        })
    </script>
@endsection
