@extends('layouts.app')
@section('keywords', '')
@section('description', '')


@section('content')
    <!-- Begin: Main Slider -->
    <div class="main-slider">
        <img class="w-100" src="{{ asset('assets/images/ban1.jpg') }}" alt="First slide">
        <div class="overlay">
            <h3>Welcome UIB</h3>
            <h2>{{ Auth::user()->first_name . ' ' . Auth::user()->last_name }} ({{ Auth::user()->username }})</h2>
        </div>
    </div>
    <!-- END: Main Slider -->

    <section class="inviterSec">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12 text-center">
                    <h3>My Inviter</h3>
                </div>
                <div class="col-lg-5">
                    @if($inviter->invitedBy != null)
                        <div class="inviterCard">
                            <img
                                src="{{ $inviter->invitedBy->user_image ? asset('upload/user/' . $inviter->invitedBy->user_image) : asset('assets/images/user.png') }}"
                                alt="">
                            <h4>{{ $inviter->invitedBy->username }}</h4>
                            <p>{{ $inviter->invitedBy->first_name . ' ' . $inviter->invitedBy->last_name }}</p>
                        </div>
                    @else
                        <div class="inviterCard">
                            <img src="{{ asset('assets/images/user.png') }}" alt="">
                            <p>No Inviter Found</p>
                        </div>
                    @endif
                </div>
                <div class="col-lg-12 text-center mt-3">
                    <h3>My Invitees</h3>
                </div>

                @forelse($invitees as $invitee)
                    <div class="col-lg-3">
                        <div class="inviterCard invitees">
                            <img
                                src="{{ $invitee->user_image ? asset('upload/user/' . $invitee->user_image) : asset('assets/images/user.png') }}"
                                alt="">
                            <h4>{{ $invitee->username }}</h4>
                            <p>{{ $invitee->first_name . ' ' . $invitee->last_name }}</p>
                            <a href="tel:{{ $invitee->phone }}"><i class="fa fa-phone"></i> {{ $invitee->phone }}</a>
                            <a href="mailto:{{ $invitee->email }}"><i class="fa fa-envelope"></i> {{ $invitee->email }}
                            </a>
                        </div>
                    </div>
                @empty
{{--                    <p class="text-center font-weight-bold">No Invitee Found</p>--}}
                @endforelse
            </div>
        </div>
    </section>

    <section class="boardSec">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12 text-center">
                    <h3>My Boards</h3>
                </div>
                <div class="col-lg-7">
                    <div class="table-responsive">
                        <table class="table tableStyle">
                            <thead>
                            <tr>
                                <th>Value</th>
                                <th>Board #</th>
                                <th>GRAD</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($userBoards as $uboard)
                                <tr>
                                    <td>${{ $uboard->board->amount ?? '' }}</td>
                                    <td><span>{{ $uboard->board->board_number ?? '' }}</span></td>
                                    <td>{{ $uboard->boardGrad->user->username ?? '' }}</td>
                                    <td>
                                        <a href="{{ route('board.index', $uboard->board->id ?? $uboard->id) }}" class="themeBtn w-100"><span></span>
                                            <text>{{ $uboard->board->status ?? 'Active' }}</text>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
{{--                                    <td>No Records Found</td>--}}
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-12 text-center mt-3">
                    <h3>Pending Incoming Gifts</h3>
                </div>
                <div class="col-lg-9">
                    <div class="table-responsive">
                        <table class="table tableStyle">
                            <thead>
                            <tr>
                                <th>Value</th>
                                <th>Board #</th>
                                <th>Position</th>
                                <th>Username</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Option</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($pendingIncomingGifts as $gift)
                                <tr>
                                    <td>${{ round($gift->amount) }}</td>
                                    <td>{{ $gift->board->board_number ?? '---' }}</td>
                                    <td class="text-capitalize">{{ $gift->userBoardPosition($gift->board->id, $gift->sender->id)->formatted_user_board_roles ?? '---' }}</td>
                                    <td>{{ $gift->sender->username ?? '---' }}</td>
                                    <td>{{ $gift->sender->phone ?? '---' }}</td>
                                    <td>{{ $gift->sender->email ?? '---' }}</td>
                                    <td>
                                        <div class="btnWrap">
                                            <a href="{{ route('update-gift-status', [$gift->id, 'accepted']) }}"
                                               class="themeBtn w-100"><span style="left: -8px; top: 1705px;"></span>
                                                <text>Confirm</text>
                                            </a>
                                            <a href="javascript:void(0)" data-href="{{ route('update-gift-status', [$gift->id, 'not_sent']) }}"
                                               class="tableIconBtn giftDeleteButton" title="Delete"><i class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
{{--                                    <td colspan="7">No records found</td>--}}
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-12 text-center mt-3">
                    <h3>Pending Outgoing Gifts</h3>
                </div>
                <div class="col-lg-9">
                    <div class="table-responsive">
                        <table class="table tableStyle">
                            <thead>
                            <tr>
                                <th>Value</th>
                                <th>Board #</th>
                                <th>Position</th>
                                <th>GRAD</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Option</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($pendingOutgoingGifts as $gift)
                                <tr>
                                    <td>${{ round($gift->amount) }}</td>
                                    <td>{{ $gift->board->board_number ?? '---' }}</td>
                                    <td class="text-capitalize">{{ $gift->userBoardPosition($gift->board->id, $gift->sender->id)->user_board_roles ?? '---' }}</td>
                                    <td>{{ $gift->receiver->username ?? '---' }}</td>
                                    <td>{{ $gift->receiver->phone ?? '---' }}</td>
                                    <td>{{ $gift->receiver->email ?? '---' }}</td>
                                    <td>
                                        <a href="javascript:void(0)" data-href="{{ route('update-gift-status', [$gift->id, ($gift->status != 'pending') ? 'pending' : 'not_sent']) }}"
                                           class="themeBtn w-100 newbieGiftDeleteButton"><span></span>
                                            <text>{{ ($gift->status == 'pending') ? 'cancel' : 'send' }}</text>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
{{--                                    <td colspan="7">No records found</td>--}}
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        $('.giftDeleteButton').on('click', function (){
            let link = $(this).attr('data-href');
            if (confirm('Are you sure you want to Remove this Member from your board?')){
                window.location.href = link;
            }
        });

        $('.newbieGiftDeleteButton').on('click', function (){
            let link = $(this).attr('data-href');
            if (confirm('Are you sure you want to Cancel your position on this board?')){
                window.location.href = link;
            }
        })
    </script>
@endsection


