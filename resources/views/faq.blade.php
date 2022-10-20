@extends('layouts.app')
@section('keywords', '')
@section('description', '')
<style>
    .container p{
        line-height: 170%;
    }
    .list{
        list-style: none;
        margin-left: 40px;
    }
    .list li::before{
        content: "\2022";
        color: black;
        font-weight: bold;
        display: inline-block;
        width: 1em;
        margin-left: -1em;
    }
</style>
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

    <section class="inviterSec">
        <div class="container">
            <ol>
                <li>Who are we?</li><br>
                <li>What is our private gifting community?</li><br>
                <li>Is a gifting community a pyramid?</li><br>
                <li>Is the gifting community a company?</li><br>
                <li>Is the gifting community an MLM or Network Marketing?</li><br>
                <li>Is this type of gifting legal?</li><br>
                <li>Who can participate?</li><br>
                <li>Why should I participate?</li><br>
                <li>What is the gifting activity process?</li><br>
                <li>How is my information used?</li>
            </ol><br><br><br>

            <ol>
                <li>
                    <h6><b>Who are we?</b></h6><br>
                    <p>
                        United in Blessing <b>(UIB)</b> is a private community of U.S. residents who, at will,
                        choose to give monetary gifts to one another.<br><br>
                        We are an invitation only group of 18 years of age and above individuals who
                        willingly and knowingly have come together for the purpose of gifting each
                        another.<br><br>
                        Likeminded participants of integrity who are honest and disciplined have chosen to
                        exercise their right to freely give to others who have joined for the same purpose.
                        Access to the <b>UIB</b> website and participation in the activity are by PERSONAL
                        INVITATION ONLY.<br><br>
                        <b>UIB</b> is <u>not</u> any of the following: an investment club, a business, an MLM, a
                        company, a corporation, a commercial enterprise of any kind nor does its activities
                        include the solicitation of anything. There are no investments, no paychecks, no
                        products or services to sell, no seminars to attend, no tapes or manuals to buy, and
                        no one makes or earns any money.<br><br>
                        There are no profit-making benefits of any kind associated with this activity. No
                        benefit or return of any nature is expressed or implied and no promises or
                        guarantees of any such return are permitted to be made by any participant of this
                        activity.<br><br>
                        By participating in <b>UIB</b>, a person willingly gives a gift to one or more of its
                        participants, the gifter has chosen to extinguish all rights to the gift and cannot
                        rightfully expect or depend on <b>UIB</b> or any of its participants for any type of
                        monetary compensation.<br><br>
                        Anyone seeking to profit from their endeavors are encouraged to investigate the
                        many profit-making opportunities available today - no such program is offered
                        here. Participants give freely and receive freely.
                    </p>
                </li><br><br>

                <li>
                    <h6><b>What is our private gifting community?</b></h6><br>
                    <p>
                        Our private gifting community is a group of likeminded adults who voluntarily
                        give one another monetary gifts.
                    </p>
                </li><br><br>

                <li>
                    <h6><b>Is a gifting community a pyramid?</b></h6><br>
                    <p>
                        No. A gifting community is not a pyramid. A pyramid is defined as a system or
                        structure with an ever-widening base which we do NOT have. Pyramids are
                        associated with a company or a business. We do not sell, recruit, earn
                        commissions, receive salaries, etc. In a pyramid structure, the same person
                        maintains at the “top” position.
                    </p>
                </li><br><br>

                <li>
                    <h6><b>Is the gifting community a company?</b></h6><br>
                    <p>
                        No. The gifting is not a company but a group of people who voluntarily give
                        monetary gifts to one another.
                    </p>
                </li><br><br>

                <li>
                    <h6><b>Is the gifting community an MLM or Network Marketing?</b></h6><br>
                    <p>
                        No. The gifting community is not an MLM (Multi-Level Marketing) nor are we a
                        Network Marketing company.
                    </p>
                </li><br><br>

                <li>
                    <h6><b>Is this type of gifting legal?</b></h6><br>
                    <p>
                        Yes. This type of gifting is legal. In the United States, gifting is referenced in the
                        IRS Tax Code, Title 26, Sections 2501-2504. Also, see IRS Publication 950) that it
                        is legal for individuals to give gifts to one another. <u>The gift tax exclusion for 2022
                            is $16,000 per recipient</u>. As of 2022, the lifetime exemption amount is $12.6 million
                        and $24.12 million for a married couple.
                    </p>
                </li><br><br>

                <li>
                    <h6><b>Who can participate?</b></h6><br>
                    <p>
                        An individual who is 18 years or older may participate by private invitation from a
                        participating member.
                    </p>
                </li><br><br>

                <li>
                    <h6><b>Why should I participate?</b></h6><br>
                    <p>
                        If you are an adult who loves to help your family and others but are not always in
                        the financial position to do so, then our gifting community can help you to help
                        yourself, your family and others to live a better quality of life.
                    </p>
                </li><br><br>

                <li>
                    <h6><b>What is the gifting activity process?</b></h6><br>
                    <p>
                        The gifting activity process consists of Eight (8) gifters who give to a recipient
                        until all gifters move through a system in which he/she becomes a recipient
                        through each of the four 2X3 matrices as you follow your inviter on the same side
                        of the board that he/she is on. This is performed by an automated process. The
                        cycling of this process involves the creation of half-board splits to create a new
                        board and re-entries onto another new board on every level.
                    </p>
                </li><br><br>

                <li>
                    <h6><b>How is my information used?</b></h6><br>
                    <p>
                        Any of the information we collect from you may be used in one of the following
                        ways:
                    </p><br>
                    <ul class="list">
                        <li>To personalize your experience (your information helps us to better respond
                            to your individual needs)</li><br>

                        <li>To better assist you (your information helps us to respond to your requests
                            and support needs)</li>
                    </ul>
                </li><br><br>
            </ol>

        </div>
    </section>

@endsection




