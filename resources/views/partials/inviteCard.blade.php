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
                @if(count($userData->user->sentByGifts) > 0 && $userData->user->sentByGifts[0]->status === 'pending')
                    <h4 style="color: red">{{$userData['user']->username}}</h4>
                @else
                    <h4 style="color: {{ ($userData->user->acceptedGiftsInviters->count() == 1) ? '#ffc107' : (($userData->user->acceptedGiftsInviters->count() == 2) ? 'green' : 'black') }}">{{$userData['user']->username}}</h4>
                    {{--                    <h4 style="color: {{ ($userData->user->acceptedGiftsInviters->count() == 1) ? '#ffc107' : (($userData->user->acceptedGiftsInviters->count() == 2) ? 'green' : (($userData->user->acceptedGiftsInviters->count() == 0) ? 'red' : 'black')) }}">{{$userData['user']->username}}</h4>--}}
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
