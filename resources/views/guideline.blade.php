@extends('layouts.app')
@section('keywords', '')
@section('description', '')

<style>
.container p {
    line-height: 170%;
}

ol li {
    line-height: 170%;
}

table {
    border: 1px solid black;
}

td {
    padding: 0 25px;
}
</style>

@section('content')
<!-- Begin: Main Slider -->
<div class="main-slider">
    <img class="w-100" src="{{ asset('assets/images/ban1.jpg') }}" alt="First slide">
    <div class="overlay">
        <h3>GUIDELINES</h3>
        <h2>Hello {{ Auth::user()->first_name . ' ' . Auth::user()->last_name }} ({{ Auth::user()->username }})</h2>
    </div>
</div>
<!-- END: Main Slider -->

<section class="inviterSec">
    <div class="container">
        <a href="{{route('home')}}" class="backBtn">
            {{--            <i class="fas fa-arrow-to-left"></i>--}}
            Back
        </a>
        <p>These Guidelines have been established to maintain the integrity and high
            standards of this activity and to encourage respect for Members and the law as it
            pertains to gifting. Members are prohibited from representing the activity of
            <b>UnitedInBlessing.com (“UIB“)</b> as anything other than a private gifting
            activity/community. Maintaining the integrity of this activity and the privacy of its
            Members are essential to ensure that this activity retains long-term viability.
        </p><br><br>

        <ol>
            <li>Any Member violating <b>any of these Guidelines</b> is subject to <u>the immediate
                    removal from this activity, and the revocation of any and all rights thereof</u>,
                and with the understanding that ALL GIFTS that have been given are
                literally GIFTS (IRS Tax Code, Title 26, Sections 2501-2504 and 2511.)
            </li><br><br>

            <li>As a Member of <b>UIB</b>, I choose to participate in its rotation process.</li><br><br>

            <li>As a Member of UIB, you agree that you will not advertise our website
                address <b>UIB</b> does not tolerate Members sending out our web site address
                <b>(www.UnitedInBlessings.com)</b> in any form of a public marketing campaign
                such as post cards, letters, phone or fax blasts and ALL other sources of
                advertising including message boards, nor any type of social medial and
                search engines.<b>UIB</b> is a <b><u>private activity</u></b> and <b><u>Members must invite
                        privately</u></b>. Violation of this policy will result in <u>removal from this activity
                    and the revocation of any and all rights thereof</u>.
            </li><br><br>

            <li>
                No public meetings. Violation of this will result in <u>the immediate removal
                    from this activity and the revocation of any and all rights thereof</u>.
            </li><br><br>

            <li>Members cannot give income projections or falsely misrepresent
                the <b>UIB</b> activity.</li><br><br>

            <li>Members cannot give tax or legal advice in accordance with <b>UIB</b> activity and
                advertise tax or legal advice.</li><br><br>

            <li>Members SHALL NOT record and share any form of recorded Zooms,
                phone calls, web-based, play-back files, conference recording, message
                lines, or the like nor any other medium, without the express, written
                permission of the Administration (Admin.”) <u>Violation of this will result in
                    the immediate removal from this activity and the revocation of any and all
                    rights thereof</u>.</li><br><br>

            <li>
                <h6><b>Spam Policy</b></h6><br>
                <p><b>UIB</b> has a <b>ZERO TOLERANCE SPAM POLICY</b>, which means that spam
                    activity of ANY kind by any Member will result in <u>the immediate removal
                        from this activity and the revocation of any and all rights thereof</u>. Spam
                    consists of advertising of services and goods by email to anyone without
                    specific prior request or in the absence of a previously established
                    relationship. Messages sent to unknown parties for the purpose of creating a
                    request shall also be deemed as spam, even if specific services or goods are
                    not mentioned. Also considered spam are any messages posted to message
                    boards or use net groups that are not related to their discussions. In the event
                    of a dispute, the burden of proof is on the Member, not the recipient.
                    <b>SOCIAL MEDIAL ADVERTISING IS PROHIBITED. ALSO, SPAM WILL <u>NOT</u>
                        BE TOLERATED IN ANY CONTEXT WHATSOEVER! ANY SPAMMING
                        WILL RESULT IN IMMEDIATE REMOVAL FROM THIS ACTIVITY AND
                        THE REVOCATION OF ANY AND ALL RIGHTS THEREOF!</b>
                </p>
            </li><br><br>

            <li>
                <h6><b>Terminlogy</b></h6><br>
                <p>It is <b>EXTREMELY IMPORTANT</b> that the appropriate terminology be
                    used in order to maintain the integrity and legal guidelines of this private
                    activity.</p>
            </li><br><br>
        </ol>

        <p>The <b>CORRECT</b> terminology is <b>EXTREMELY IMPORTANT</b> for MEMBERS
            to use when referring to this <b>private gifting activity</b>. For example:</p><br>

        <center class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <td><b>INAPPROPRIATE</b> terminology:</td>
                        <td><b>APPROPRIATE</b> terminology:</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <br>
                            Paid/Pay/Getting Paid/Payout<br>
                            Purchase/Buy in/Bought<br>
                            Money/My Money<br>
                            Investment/Invest<br>
                            Earnings/Income/Profits/Dividends<br>
                            Downline/Upline<br>
                            Return/Net<br>
                            Sold/Sell<br>
                            Sponsor/Sign up/ Recruit<br>
                            Guarantee/Earn
                        </td>

                        <td>
                            <br>
                            Gift/Give/Giving/ Gifter<br>
                            Receive<br>
                            I have gifted<br>
                            I have received<br>
                            Participation<br>
                            Invited by<br>
                            I gave/blessed<br>
                            Participant<br>
                            Activity/Community<br>
                            Invitation/Invite
                        </td>
                    </tr>
                </tbody>
            </table>
        </center>


    </div>
</section>

@endsection