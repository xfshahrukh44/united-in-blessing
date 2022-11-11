@extends('layouts.app')
@section('keywords', '')
@section('description', '')

@section('content')
    <!-- Begin: Main Slider -->
    <div class="main-slider">
        <img class="w-100" src="{{ asset('assets/images/ban1.jpg') }}" alt="First slide">
        <div class="overlay">
            <h3>FAQs</h3>
            <h2>Hello {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }} ({{ Auth::user()->username }})</h2>
        </div>
    </div>
    <!-- END: Main Slider -->

    <section class="faqSec">
        <div class="container">
            <a href="{{route('home')}}" class="backBtn">
                {{--            <i class="fas fa-arrow-to-left"></i>--}}
                Back
            </a>
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="accordion" id="accordionExample">
                        <div class="item">
                            <div class="item-header" id="headingOne">
                                <h2 class="mb-0">
                                    <button class="btn btn-link " type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="true"
                                            aria-controls="collapseOne">
                                        <span>01.</span>
                                        <span> Who are we?</span>
                                        <i class="fas fa-caret-down"></i>
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseOne" class="collapse show" aria-labelledby="headingOne"
                                 data-bs-parent="#accordionExample">
                                <div class="t-p">
                                    <p>
                                        United in Blessing <b>(UIB)</b> is a private community of U.S. residents who, at
                                        will,
                                        choose to give monetary gifts to one another.</p>
                                    <p>
                                        We are an invitation only group of 18 years of age and above individuals who
                                        willingly and knowingly have come together for the purpose of gifting each
                                        another.</p>
                                    <p>
                                        Likeminded participants of integrity who are honest and disciplined have chosen
                                        to
                                        exercise their right to freely give to others who have joined for the same
                                        purpose.
                                        Access to the <b>UIB</b> website and participation in the activity are by
                                        PERSONAL
                                        INVITATION ONLY.</p>
                                    <p>
                                        <b>UIB</b> is <u>not</u> any of the following: an investment club, a business,
                                        an MLM, a
                                        company, a corporation, a commercial enterprise of any kind nor does its
                                        activities
                                        include the solicitation of anything. There are no investments, no paychecks, no
                                        products or services to sell, no seminars to attend, no tapes or manuals to buy,
                                        and
                                        no one makes or earns any money.</p>
                                    <p>
                                        There are no profit-making benefits of any kind associated with this activity.
                                        No
                                        benefit or return of any nature is expressed or implied and no promises or
                                        guarantees of any such return are permitted to be made by any participant of
                                        this
                                        activity.</p>
                                    <p>
                                        By participating in <b>UIB</b>, a person willingly gives a gift to one or more
                                        of its
                                        participants, the gifter has chosen to extinguish all rights to the gift and
                                        cannot
                                        rightfully expect or depend on <b>UIB</b> or any of its participants for any
                                        type of
                                        monetary compensation.</p>
                                    <p>
                                        Anyone seeking to profit from their endeavors are encouraged to investigate the
                                        many profit-making opportunities available today - no such program is offered
                                        here. Participants give freely and receive freely.

                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-header" id="headingTwo">
                                <h2 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseTwo" aria-expanded="false"
                                            aria-controls="collapseTwo">
                                        <span>02.</span>
                                        <span> What is our private gifting community?</span>
                                        <i class="fas fa-caret-down"></i>
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                 data-bs-parent="#accordionExample">
                                <div class="t-p">
                                    <p>
                                        Our private gifting community is a group of likeminded adults who voluntarily
                                        give one another monetary gifts.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-header" id="headingThree">
                                <h2 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseThree" aria-expanded="false"
                                            aria-controls="collapseThree">
                                        <span>03.</span>
                                        <span>Is a gifting community a pyramid?</span>
                                        <i class="fas fa-caret-down"></i>
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                 data-bs-parent="#accordionExample">
                                <div class="t-p">
                                    <p>
                                        No. A gifting community is not a pyramid. A pyramid is defined as a system or
                                        structure with an ever-widening base which we do NOT have. Pyramids are
                                        associated with a company or a business. We do not sell, recruit, earn
                                        commissions, receive salaries, etc. In a pyramid structure, the same person
                                        maintains at the “top” position.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-header" id="headingFour">
                                <h2 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseFour" aria-expanded="false"
                                            aria-controls="collapseFour">
                                        <span>04.</span>
                                        <span> Is the gifting community a company?</span>
                                        <i class="fas fa-caret-down"></i>
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseFour" class="collapse" aria-labelledby="headingFour"
                                 data-bs-parent="#accordionExample">
                                <div class="t-p">
                                    <p>
                                        No. The gifting is not a company but a group of people who voluntarily give
                                        monetary gifts to one another.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-header" id="headingFive">
                                <h2 class="mb-0">
                                    <button class="btn btn-link " type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseFive" aria-expanded="true"
                                            aria-controls="collapseFive">
                                        <span>05.</span>
                                        <span> Is the gifting community an MLM or Network Marketing?</span>
                                        <i class="fas fa-caret-down"></i>
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseFive" class="collapse" aria-labelledby="headingFive"
                                 data-bs-parent="#accordionExample">
                                <div class="t-p">
                                    <p>
                                        No. The gifting community is not an MLM (Multi-Level Marketing) nor are we a
                                        Network Marketing company.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-header" id="headingSix">
                                <h2 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseSix" aria-expanded="false"
                                            aria-controls="collapseSix">
                                        <span>06.</span>
                                        <span> Is this type of gifting legal?</span>
                                        <i class="fas fa-caret-down"></i>
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseSix" class="collapse" aria-labelledby="headingSix"
                                 data-bs-parent="#accordionExample">
                                <div class="t-p">
                                    <p>
                                        Yes. This type of gifting is legal. In the United States, gifting is referenced
                                        in the
                                        IRS Tax Code, Title 26, Sections 2501-2504. Also, see IRS Publication 950) that
                                        it
                                        is legal for individuals to give gifts to one another. <u>The gift tax exclusion
                                            for 2022
                                            is $16,000 per recipient</u>. As of 2022, the lifetime exemption amount is
                                        $12.6 million
                                        and $24.12 million for a married couple.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-header" id="headingSeven">
                                <h2 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseSeven" aria-expanded="false"
                                            aria-controls="collapseSeven">
                                        <span>07.</span>
                                        <span>Who can participate?</span>
                                        <i class="fas fa-caret-down"></i>
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven"
                                 data-bs-parent="#accordionExample">
                                <div class="t-p">
                                    <p>
                                        An individual who is 18 years or older may participate by private invitation
                                        from a
                                        participating member.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-header" id="headingEight">
                                <h2 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseEight" aria-expanded="false"
                                            aria-controls="collapseEight">
                                        <span>08.</span>
                                        <span>Why should I participate?</span>
                                        <i class="fas fa-caret-down"></i>
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseEight" class="collapse" aria-labelledby="headingEight"
                                 data-bs-parent="#accordionExample">
                                <div class="t-p">
                                    <p>
                                        If you are an adult who loves to help your family and others but are not always
                                        in
                                        the financial position to do so, then our gifting community can help you to help
                                        yourself, your family and others to live a better quality of life.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-header" id="headingNine">
                                <h2 class="mb-0">
                                    <button class="btn btn-link " type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseNine" aria-expanded="true"
                                            aria-controls="collapseNine">
                                        <span>09.</span>
                                        <span> What is the gifting activity process?</span>
                                        <i class="fas fa-caret-down"></i>
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseNine" class="collapse show" aria-labelledby="headingNine"
                                 data-bs-parent="#accordionExample">
                                <div class="t-p">
                                    <p>
                                        The gifting activity process consists of Eight (8) gifters who give to a
                                        recipient
                                        until all gifters move through a system in which he/she becomes a recipient
                                        through each of the four 2X3 matrices as you follow your inviter on the same
                                        side
                                        of the board that he/she is on. This is performed by an automated process. The
                                        cycling of this process involves the creation of half-board splits to create a
                                        new
                                        board and re-entries onto another new board on every level.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="item-header" id="headingTen">
                                <h2 class="mb-0">
                                    <button class="btn btn-link collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseTen" aria-expanded="false"
                                            aria-controls="collapseTen">
                                        <span>10.</span>
                                        <span> How is my information used?</span>
                                        <i class="fas fa-caret-down"></i>
                                    </button>
                                </h2>
                            </div>
                            <div id="collapseTen" class="collapse" aria-labelledby="headingTen"
                                 data-bs-parent="#accordionExample">
                                <div class="t-p">
                                    <p>
                                        Any of the information we collect from you may be used in one of the following
                                        ways:
                                    </p>
                                    <ul class="list">
                                        <li>To personalize your experience (your information helps us to better respond
                                            to your individual needs)
                                        </li>
                                        <br>

                                        <li>To better assist you (your information helps us to respond to your requests
                                            and support needs)
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection




