@if($userData && $userData['user'])
    @if($userData->user_board_roles === 'grad')
        <div>
            <div class="inviterCard invitees {{ $class }}">
                <img
                    src="{{ $userData['user']->user_image ? asset('upload/user/' . $userData['user']->user_image) : asset('assets/images/user.png') }}"
                    alt="">
                <h4 style="color: {{ ($userData->user->acceptedGiftsInviters->count() == 1 && $userData->user->inviters->count() > 0) ? '#ffc107' : (($userData->user->acceptedGiftsInviters->count() > 1 && $userData->user->inviters->count() > 1) ? 'green' : 'black') }}">{{$userData['user']->username}}</h4>
                {{-- <p> {{ ($key + 1) }} </p> --}}
            </div>
        </div>
    @else
        <div>
            <div class="inviterCard invitees {{ $class }}">
                <img
                    src="{{ $userData['user']->user_image ? asset('upload/user/' . $userData['user']->user_image) : asset('assets/images/user.png') }}"
                    alt="">
{{--                @if(count($userData->user->sentByGifts) > 0 && $userData->user->sentByGifts[0]->status === 'pending')--}}
                @if ($userData->user_board_roles !== 'newbie')
                    @if(count($userData->user->_sentByGifts($userData->board_id)) > 0 && $userData->user->_sentByGifts($userData->board_id)[0]->status === 'pending')
                        <h4 style="color: red">{{$userData['user']->username}}</h4>
                    @else
                        @php
                            $colors = ['black', '#ffc107', 'green'];
                            $system_invitees_count = system_invitees_count($userData->user->id);
                            if ($system_invitees_count > 2) {
                                $system_invitees_count = 2;
                            }
                            $color = $colors[$system_invitees_count];
                        @endphp
                        <h4 style="color: {{ $color }}">{{$userData['user']->username}}</h4>
{{--                        <h4 style="color: {{ ($userData->user->acceptedGiftsInviters->count() == 1) ? '#ffc107' : 'green' }}">{{$userData['user']->username}}</h4>--}}
{{--                        <h4 style="color: {{($userData->user_board_roles == 'newbie') ? 'black' : (($userData->user->_acceptedGiftsInviters($userData->board_id)->count() == 1) ? '#ffc107' : (($userData->user->_acceptedGiftsInviters($userData->board_id)->count() == 2) ? 'green' : 'black')) }}">{{$userData['user']->username}}</h4>--}}
                        {{--                    <h4 style="color: {{ ($userData->user->acceptedGiftsInviters->count() == 1) ? '#ffc107' : (($userData->user->acceptedGiftsInviters->count() == 2) ? 'green' : (($userData->user->acceptedGiftsInviters->count() == 0) ? 'red' : 'black')) }}">{{$userData['user']->username}}</h4>--}}
                    @endif
                @else
{{--                    <h4 style="color: {{ ($userData->user->acceptedGiftsInviters->count() == 1) ? '#ffc107' : (($userData->user->acceptedGiftsInviters->count() == 2) ? 'green' : 'black') }}">{{$userData['user']->username}}</h4>--}}
                    @if(count($userData->user->_sentByGifts($userData->board_id)) > 0 && $userData->user->_sentByGifts($userData->board_id)[0]->status === 'pending')
                        <h4 style="color: red">{{$userData['user']->username}}</h4>
                    @else
                        @php
                            $board = \App\Models\Boards::find($userData->board_id);
                        @endphp
                        @if ($board->previous_board_number == '' || is_null($board->previous_board_number))
                            <h4 style="color: {{($userData->user_board_roles == 'newbie') ? 'black' : (($userData->user->_acceptedGiftsInviters($userData->board_id)->count() == 1) ? '#ffc107' : (($userData->user->_acceptedGiftsInviters($userData->board_id)->count() == 2) ? 'green' : 'black')) }}">{{$userData['user']->username}}</h4>
                        @else
                            <h4 style="color: {{(($userData->user->acceptedGiftsInviters->count() == 1) ? '#ffc107' : (($userData->user->acceptedGiftsInviters->count() == 2) ? 'green' : 'black')) }}">{{$userData['user']->username}}</h4>
                        @endif
{{--                                            <h4 style="color: {{ ($userData->user->acceptedGiftsInviters->count() == 1) ? '#ffc107' : (($userData->user->acceptedGiftsInviters->count() == 2) ? 'green' : (($userData->user->acceptedGiftsInviters->count() == 0) ? 'red' : 'black')) }}">{{$userData['user']->username}}</h4>--}}
                    @endif
                @endif
            </div>
        </div>
    @endif
@else
    <div>
        <div class="inviterCard invitees {{ $class }}">
            <img
                src="{{asset('assets/images/user.png') }}"
                alt="">
            <h4>No Invitee</h4>
        </div>
    </div>
@endif
