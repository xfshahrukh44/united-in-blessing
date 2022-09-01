@extends('layouts.app')
@section('keywords', '')
@section('description', '')

@section('content')
    <!-- Begin: Main Slider -->
    <div class="main-slider">
        <img class="w-100" src="{{ asset('assets/images/ban1.jpg') }}" alt="First slide">
        <div class="overlay">
            <h3>Welcome UIB</h3>
            <h2>Username ({{ Auth::user()->username }})</h2>
        </div>
    </div>
    <!-- END: Main Slider -->

    <section class="inviterSec">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12 text-center mb-5">
                    <h3>My Inviter</h3>
                </div>
                <div class="col-lg-5">
                    <div class="inviterCard">
                        <img src="{{ asset('assets/images/inviter.jpg') }}" alt="">
                        <h4>Big_Giver</h4>
                        <p>Barbara Harris</p>
                    </div>
                </div>
                <div class="col-lg-12 text-center my-5">
                    <h3>My Invitees</h3>
                </div>
                <div class="col-lg-3">
                    <div class="inviterCard invitees">
                        <img src="{{ asset('assets/images/invite-1.jpg') }}" alt="">
                        <h4>Sarah_Jones</h4>
                        <p>Barbara Harris</p>
                        <a href="tel:3237777654"><i class="fa fa-phone"></i> 323-777-7654</a>
                        <a href="mailto:email@uib.com"><i class="fa fa-envelope"></i> email@uib.com</a>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="inviterCard invitees">
                        <img src="{{ asset('assets/images/invite-2.jpg') }}" alt="">
                        <h4>Barbara_Smith</h4>
                        <p>Barbara Harris</p>
                        <a href="tel:3237777654"><i class="fa fa-phone"></i> 323-777-7654</a>
                        <a href="mailto:email@uib.com"><i class="fa fa-envelope"></i> email@uib.com</a>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="inviterCard invitees">
                        <img src="{{ asset('assets/images/invite-3.jpg') }}" alt="">
                        <h4>Sarah_Jones</h4>
                        <p>Barbara Harris</p>
                        <a href="tel:3237777654"><i class="fa fa-phone"></i> 323-777-7654</a>
                        <a href="mailto:email@uib.com"><i class="fa fa-envelope"></i> email@uib.com</a>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="inviterCard invitees">
                        <img src="{{ asset('assets/images/invite-4.jpg') }}" alt="">
                        <h4>Barbara_Smith</h4>
                        <p>Barbara Harris</p>
                        <a href="tel:3237777654"><i class="fa fa-phone"></i> 323-777-7654</a>
                        <a href="mailto:email@uib.com"><i class="fa fa-envelope"></i> email@uib.com</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="boardSec">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12 text-center mb-5">
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
                                    <td>${{ $uboard->board->amount }}</td>
                                    <td><span>{{ $uboard->board->board_number }}</span></td>
                                    <td>{{ $uboard->boardGrad->user->username }}</td>
                                    <td>
                                        <a href="{{ route('board.index', $uboard->board->id) }}" class="themeBtn w-100"><span></span>
                                            <text>{{ $uboard->board->status }}</text>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td>No Records Found</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-12 text-center my-5">
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
                                <th>GRAD</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Option</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>$100</td>
                                <td>12345</td>
                                <td>Newbie: #1</td>
                                <td>newbiesname</td>
                                <td>310-123-4567</td>
                                <td>astar@uib.com</td>
                                <td>
                                    <div class="btnWrap">
                                        <button class="themeBtn w-100"><span></span>
                                            <text>Confirm</text>
                                        </button>
                                        <a href="#" class="tableIconBtn"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>$100</td>
                                <td>12345</td>
                                <td>Newbie: #1</td>
                                <td>newbiesname</td>
                                <td>310-123-4567</td>
                                <td>astar@uib.com</td>
                                <td>
                                    <div class="btnWrap">
                                        <button class="themeBtn w-100"><span></span>
                                            <text>Confirm</text>
                                        </button>
                                        <a href="#" class="tableIconBtn"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>$100</td>
                                <td>12345</td>
                                <td>Newbie: #1</td>
                                <td>newbiesname</td>
                                <td>310-123-4567</td>
                                <td>astar@uib.com</td>
                                <td>
                                    <div class="btnWrap">
                                        <button class="themeBtn w-100"><span></span>
                                            <text>Confirm</text>
                                        </button>
                                        <a href="#" class="tableIconBtn"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>$100</td>
                                <td>12345</td>
                                <td>Newbie: #1</td>
                                <td>newbiesname</td>
                                <td>310-123-4567</td>
                                <td>astar@uib.com</td>
                                <td>
                                    <div class="btnWrap">
                                        <button class="themeBtn w-100"><span></span>
                                            <text>Confirm</text>
                                        </button>
                                        <a href="#" class="tableIconBtn"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-12 text-center my-5">
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
                            <tr>
                                <td>$100</td>
                                <td>12345</td>
                                <td>Newbie: #1</td>
                                <td>newbiesname</td>
                                <td>310-123-4567</td>
                                <td>astar@uib.com</td>
                                <td>
                                    <button class="themeBtn w-100"><span></span>
                                        <text>Cancel</text>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>$100</td>
                                <td>12345</td>
                                <td>Newbie: #1</td>
                                <td>newbiesname</td>
                                <td>310-123-4567</td>
                                <td>astar@uib.com</td>
                                <td>
                                    <button class="themeBtn w-100"><span></span>
                                        <text>Cancel</text>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>$100</td>
                                <td>12345</td>
                                <td>Newbie: #1</td>
                                <td>newbiesname</td>
                                <td>310-123-4567</td>
                                <td>astar@uib.com</td>
                                <td>
                                    <button class="themeBtn w-100"><span></span>
                                        <text>Cancel</text>
                                    </button>
                                </td>
                            </tr>
                            <tr>
                                <td>$100</td>
                                <td>12345</td>
                                <td>Newbie: #1</td>
                                <td>newbiesname</td>
                                <td>310-123-4567</td>
                                <td>astar@uib.com</td>
                                <td>
                                    <button class="themeBtn w-100"><span></span>
                                        <text>Cancel</text>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection