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

        .treeSec form button.cancelBtn{
            right: 200px;
        }

        select[readonly]{
            pointer-events: none;
        }
    </style>
    <!-- Begin: Main Slider -->
    <div class="main-slider">
        <img class="w-100" src="{{ asset('assets/images/ban1.jpg') }}" alt="First slide">
        <div class="overlay">
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
                                    <p>{{ ucfirst($board->status) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div>
                        <form action="{{ route('admin.update.board.members', $board->id) }}" method="POST" id="updateBoardForm">
                            @csrf
{{--                            <button class="themeBtn" type="submit">Update Board</button>--}}
{{--                            <button class="themeBtn cancelBtn" type="button" onClick="window.location.reload();" style="display:none">Cancel Selection</button>--}}
                            <ul class="tree vertical">
                                @forelse($boardGrad as $key => $grad)
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
{{--                                                <p>{{ ($key + 1) }}</p>--}}
                                            </div>
                                        </div>
                                        <h4>Grad</h4>
                                        <ul>
                                            @php $x = $y = 1 @endphp

                                            @forelse($grad->boardChildren($board->id) as $key => $pregrad)
                                                @if($key == 1)
                                                    <li class="heading">
                                                        <h4>Pre-grads</h4>
                                                        <h4>Undergrads</h4>
                                                        <h4>Newbies</h4>
                                                    </li>
                                                @endif
                                                @if($grad->boardChildren($board->id)->count() == 1 && $pregrad->position == 'right')
                                                    <li>
                                                        <div>
                                                            <div class="inviterCard invitees noimg">
                                                                <select name="pregrad[{{ $grad->user_id }}][left]"
                                                                        id="">
                                                                    <option value="">Please Select Pregrad</option>
                                                                    @foreach($users as $user)
                                                                        <option
                                                                            value="{{ $user->id }}">{{ $user->username }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
{{--                                                        <h4>Pregrads</h4>--}}
                                                    </li>
                                                @endif
                                                <li>
                                                    <div>
                                                        <div class="inviterCard invitees">
                                                            <img
                                                                src="{{ $pregrad['user']->user_image ? asset('upload/user/' . $pregrad['user']->user_image) : asset('assets/images/user.png') }}"
                                                                alt="">
                                                            <select
                                                                name="pregrad[{{ $grad->user_id }}][{{ $pregrad->position }}]"
                                                                id="pregrad[{{ $grad->user_id }}][{{ $pregrad->position }}]">
                                                                @foreach($users as $user)
                                                                    <option
                                                                        value="{{ $user->id }}" {{ $pregrad->user_id == $user->id ? 'selected' : '' }}>{{ $user->username }}</option>
                                                                @endforeach
                                                            </select>
{{--                                                            <p>{{ ($key + 1) }}</p>--}}
                                                        </div>
                                                    </div>
{{--                                                    <h4>Pregrads</h4>--}}
                                                    <ul>
                                                        @forelse($pregrad->boardChildren($board->id) as $key => $undergrad)
                                                            @if($pregrad->boardChildren($board->id)->count() == 1 && $undergrad->position == 'right')
                                                                <li>
                                                                    <div>
                                                                        <div class="inviterCard invitees noimg">
                                                                            <select name="undergrads[{{ $pregrad->user_id }}][left]" id="">
                                                                                <option value="">Please Select Undergrad</option>
                                                                                @foreach($users as $user)
                                                                                    <option
                                                                                        value="{{ $user->id }}">{{ $user->username }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>
                                                                    </div>
{{--                                                                    <h4>Undergrads</h4>--}}
                                                                </li>
                                                            @endif
                                                            <li>
                                                                <div>
                                                                    <div class="inviterCard invitees">
                                                                        <img
                                                                            src="{{ $undergrad['user']->user_image ? asset('upload/user/' . $undergrad['user']->user_image) : asset('assets/images/user.png') }}"
                                                                            alt="">
                                                                        <select
                                                                            name="undergrads[{{ $pregrad->user_id }}][{{ $undergrad->position }}]"
                                                                            id="undergrad">
                                                                            @foreach($users as $user)
                                                                                <option
                                                                                    value="{{ $user->id }}" {{ $undergrad->user_id == $user->id ? 'selected' : '' }}>{{ $user->username }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        {{--                                                                        <h4 style="color: {{ ($undergrad->user->inviters->count() == 0) ? 'black' : (($undergrad->user->inviters->count() == 1) ? 'red' : 'green') }}">{{$undergrad['user']->username}}</h4>--}}
{{--                                                                        <p>{{ ($x++) }}</p>--}}
                                                                    </div>
                                                                </div>
{{--                                                                <h4>undergrads</h4>--}}
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
{{--                                                                                <h4>Newbies</h4>--}}
                                                                            </li>
                                                                        @endif
                                                                        <li>
                                                                            <div>
                                                                                <div class="inviterCard invitees">
                                                                                    <img
                                                                                        src="{{ $newbie['user']->user_image ? asset('upload/user/' . $newbie['user']->user_image) : asset('assets/images/user.png') }}"
                                                                                        alt="">
                                                                                    <a href="{{ route('admin.destroy.board.member', [$board->id, $newbie->user_id]) }}"><i
                                                                                            class="fa fa-trash"></i></a>
                                                                                    <select
                                                                                        name="newbie[{{ $undergrad->user_id }}][{{ $newbie->position }}]"
                                                                                        id="newbie">
                                                                                        @foreach($users as $user)
                                                                                            <option
                                                                                                value="{{ $user->id }}" {{ $newbie->user_id == $user->id ? 'selected' : '' }}>{{ $user->username }}</option>
                                                                                        @endforeach
                                                                                    </select>
{{--                                                                                    <p>{{ ($y++) }}</p>--}}
                                                                                </div>
                                                                            </div>
{{--                                                                            <h4>Newbies</h4>--}}
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
{{--                                                                                        <p>{{ ($y++) }}</p>--}}
                                                                                    </div>
                                                                                </div>
{{--                                                                                <h4>Newbies</h4>--}}
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
{{--                                                                                    <p>{{ ($y++) }}</p>--}}
                                                                                </div>
                                                                            </div>
{{--                                                                            <h4>Newbies</h4>--}}
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
{{--                                                                                    <p>{{ ($y++) }}</p>--}}
                                                                                </div>
                                                                            </div>
{{--                                                                            <h4>Newbies</h4>--}}
                                                                        </li>
                                                                    @endforelse
                                                                </ul>
                                                            </li>
                                                                @if($pregrad->boardChildren($board->id)->count() == 1 && $undergrad->position == 'left')
                                                                    <li>
                                                                        <div>
                                                                            <div class="inviterCard invitees noimg">
                                                                                <select name="undergrads[{{ $pregrad->user_id }}][right]" id="">
                                                                                    <option value="">Please Select Undergrad</option>
                                                                                    @foreach($users as $user)
                                                                                        <option
                                                                                            value="{{ $user->id }}">{{ $user->username }}</option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                        </div>
{{--                                                                        <h4>Undergrads</h4>--}}
                                                                    </li>
                                                                @endif
                                                        @empty
                                                            <li>
                                                                <div>
                                                                    <div class="inviterCard invitees noimg">
                                                                        <select name="undergrads[{{ $pregrad->user_id }}][left]" id="">
                                                                            <option value="">Please Select Undergrad</option>
                                                                            @foreach($users as $user)
                                                                                <option
                                                                                    value="{{ $user->id }}">{{ $user->username }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
{{--                                                                <h4>Undergrads</h4>--}}
                                                            </li>
                                                            <li>
                                                                <div>
                                                                    <div class="inviterCard invitees noimg">
                                                                        <select name="undergrads[{{ $pregrad->user_id }}][right]" id="">
                                                                            <option value="">Please Select Undergrad</option>
                                                                            @foreach($users as $user)
                                                                                <option
                                                                                    value="{{ $user->id }}">{{ $user->username }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
{{--                                                                <h4>Undergrads</h4>--}}
                                                            </li>
                                                        @endforelse
                                                    </ul>
                                                </li>
                                                @if($grad->boardChildren($board->id)->count() == 1 && $pregrad->position == 'left')
                                                    <li>
                                                        <div>
                                                            <div class="inviterCard invitees noimg">
                                                                <select name="pregrad[{{ $grad->user_id }}][right]"
                                                                        id="">
                                                                    <option value="">Please Select Pregrad</option>
                                                                    @foreach($users as $user)
                                                                        <option
                                                                            value="{{ $user->id }}">{{ $user->username }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
{{--                                                        <h4>Pregrads</h4>--}}
                                                    </li>
                                                @endif
                                            @empty
                                                <li>
                                                    <div>
                                                        <div class="inviterCard invitees noimg">
                                                            <select name="pregrad[{{ $grad->user_id }}][left]" id="">
                                                                <option value="">Please Select Pregrad</option>
                                                                @foreach($users as $user)
                                                                    <option
                                                                        value="{{ $user->id }}">{{ $user->username }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
{{--                                                    <h4>Pregrads</h4>--}}
                                                </li>
                                                <li>
                                                    <div>
                                                        <div class="inviterCard invitees noimg">
                                                            <select name="pregrad[{{ $grad->user_id }}][right]" id="">
                                                                <option value="">Please Select Pregrad</option>
                                                                @foreach($users as $user)
                                                                    <option
                                                                        value="{{ $user->id }}">{{ $user->username }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
{{--                                                    <h4>Pregrads</h4>--}}
                                                </li>
                                            @endforelse
                                        </ul>
                                    </li>
                                @empty
                                    <li>
                                        <div>
                                            <div class="inviterCard invitees noimg">
                                                <select name="grad" id="grad">
                                                    <option value="">Please Select Grad</option>
                                                    @foreach($users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->username }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <h4>Grad</h4>
                                    </li>
                                @endforelse
                            </ul>
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
            $('select').attr('readonly', true);
            $('.cancelBtn').show()
            $(this).attr('readonly', false);

            $('#updateBoardForm').submit();


           /* $('select').each(function () {
                $('select').find('option').removeAttr('disabled');
            });
            $('select').each(function () {
                if ($(this).val() != '') {
                    $('select').not($(this)).find('option[value=' + $(this).val() + ']').attr('disabled', 'disabled');
                }
            });
            $('select').each(function () {
                $('select').not($(this)).attr('disabled', 'disabled')
            });*/
        })
    </script>
@endsection
