@extends('layouts.app')
@section('keywords', '')
@section('description', '')

<style>
    .container p{
        line-height: 170%;
    }
</style>

@section('content')
    <!-- Begin: Main Slider -->
    <div class="main-slider">
        <img class="w-100" src="{{ asset('assets/images/ban1.jpg') }}" alt="First slide">
        <div class="overlay">
            <h3>GIFTING FORMS</h3>
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
            <div class="text-center mt-5">
                <h4>Send Gifting Forms by Email</h4><br>
                <h4>Or <a href="{{ asset('assets/pdf/gifting-form-statement-and-non-solicitation.pdf') }}" download>CLICK HERE</a> to download PDF printable forms</h4>
            </div>
            <br><br>
            <p>Enter the USERNAME of the member who you are gifting and CLICK SUBMIT.
                A new window will open that displays your Gifting Statement and Non-
                Solicitation forms. Fill in the<br> amount of YOUR GIFT and type YOUR
                SIGNATURE at the bottom of the form. The forms will automatically be sent to
                the recipient by Email.</p>
            <div class="text-center mt-5">
                <form action="{{ route('send-gifting-form') }}" method="POST">
                    @csrf
                    <div class="row align-items-center">
                        <div class="col-3">
                            <h4>RECIPIENT&#39;S USERNAME</h4>
                        </div>
                        <div class="col-6">
                            <input type="text" class="form-control" name="username">
                        </div>
                        <div class="col-auto">
                            <input type="submit" class="themeBtn" value="Submit" name="submit">
                        </div>
                    </div>
{{--                    <div class="row">--}}
{{--                        <div class="col">--}}
{{--                        </div>--}}
{{--                        <div class="col">--}}

{{--                        </div>--}}
{{--                    </div>--}}
                </form>
            </div>

            <div style="margin-top: 10%">
                <h3 class="text-center">NON-SOLICITATION</h3><br><br>
                <p>I, the undersigned, hereby confirm with full personal and legal responsibility, that I
                    have requested this information of my own free will and accord, and that I am not
                    seeking investment opportunities. I hereby affirm that the information that I am
                    requesting is about a private gifting activity.<br><br>

                    I hereby confirm that neither you nor anyone on your behalf or anyone else
                    associated with your activity has solicited me in any way. All parties state as truth
                    that they are not employees or officials in or of any agency and are not a member
                    of the media whose purpose is to collect information for defamation or
                    prosecution. All parties agree that falsification of this criteria entitles the party
                    defrauded thereby is entitled to $100,000.00 (U.S.) for violation of rights against
                    forced association. Any documents or information received by me will not be
                    construed as solicitation in any way whatsoever. I further affirm that I have been
                    told that the nature of these activities is that of charity and I affirm that my
                    involvement with gifting is solely a voluntary act of my own accord. I also
                    understand that should I get involved with gifting that my gift will be just that, a
                    gift, and it is nothing to which I may lay claim in the future; it is a gift. It is agreed
                    that a fax or email copy will be considered legal and enforceable as an original.<br><br>

                    I hereby confirm that neither you nor anyone on your behalf or anyone else
                    associated with your activity has solicited me in any way. All parties state as truth
                    that they are not employees or officials in or of any agency and are not a member
                    of the media whose purpose is to collect information for defamation or
                    prosecution. All parties agree that falsification of this criteria entitles the party defrauded
                    thereby is entitled to $100,000.00 (U.S.) for violation of rights against
                    forced association.<br><br>

                    Any documents or information received by me will not be construed as solicitation
                    in any way whatsoever. I further affirm that I have been told that the nature of
                    these activities is that of charity and I affirm that my involvement with gifting is
                    solely a voluntary act of my own accord. I also understand that should I get
                    involved with gifting that my gift will be just that, a gift, and it is nothing to which
                    I may lay claim in the future; it is a gift. It is agreed that a fax or email copy will be
                    considered legal and enforceable as an original.
                </p>
            </div>

            <div style="margin-top: 10%">
                <div class="text-center">
                    <h3>GIFTING STATEMENT</h3>
                    <h5>Gifting Statement Title 26, United States<br>
                        Code Section: 2501, 2502, 2504, 2511</h5>
                </div>
                <br><br>
                <p>I, the undersigned, hereby confirm with full personal and legal responsibility, that I
                    have requested this information of my own free will and accord, and that I am not
                    seeking investment opportunities. I hereby affirm that the information that I am
                    requesting is about a private gifting activity.<br><br>

                    I hereby confirm that neither you nor anyone on your behalf or anyone else
                    associated with your activity has solicited me in any way. All parties state as truth
                    that they are not employees or officials in or of any agency and are not a member
                    of the media whose purpose is to collect information for defamation or
                    prosecution. All parties agree that falsification of this criteria entitles the party
                    defrauded thereby is entitled to $100,000.00 (U.S.) for violation of rights against
                    forced association.<br><br>

                    Any documents or information received by me will not be construed as solicitation
                    in any way whatsoever. I further affirm that I have been told that the nature of
                    these activities is that of charity and I affirm that my involvement with gifting is
                    solely a voluntary act of my own accord. I also understand that should I get
                    involved with gifting that my gift will be just that, a gift, and it is nothing to which
                    I may lay claim in the future; it is a gift. It is agreed that a fax or email copy will be
                    considered legal and enforceable as an original.<br><br>

                    <b>I</b>, ______________________________________, do hereby declare under
                    penalties of perjury that the following statements are true and correct to the very
                    best of my knowledge.<br><br>

                    Any and all property of any nature that I transfer from my ownership and
                    possession to the recipient of my gift, is intended as a gift and not as an
                    investment. I have not been sold anything and I have not purchased anything, and I
                    have not been offered any opportunity to do so. I have been told not to expect any
                    return of any nature, and I have received no license or privilege of soliciting or
                    recruiting other parties to participate in this gifting activity. With this statement, I
                    waive any and all my rights to civil or criminal remedies against the recipient of
                    my gift and the gifting activity as a whole.<br><br>

                    I perceive no agreement between myself and the recipient of my gift, and I expect
                    no profit, benefit, or opportunity of any nature in consideration of the property that
                    I have been transferred as a gift. I believe that I am totally within the law, as it
                    pertains to my activities herein described.<br><br>

                    My intent is to give a gift of $______________ to _____________________ as an
                    individual, and I do not intend the gift as an investment, or as a payment for which
                    I am owed anything of any value or nature, and I acknowledge that my gift does
                    not entitle me to any future opportunity or benefit of any nature.<br><br>

                    I understand that the gifting activity accepts only gifts and that they absolutely do
                    not accept any property offered with the intent of its owner that a future return or
                    opportunity be obtained or secured by virtue of their having transferred said gift to
                    another individual.<br><br>

                    I have agreed under this gift contract to not reassert any rights to the property that
                    I now give freely as a gift to another individual. I am a fully informed and
                    consenting adult and I have not been misled in anyway.<br><br>

                    I do hereby declare under penalties of perjury that the foregoing statement is true
                    and correct and are binding upon me to the full extent expressed therein.

                    <b>Executed this</b><br><br> ________ <b>day of</b> ________________________, ______________.<br><br>

                    <div class="text-center">
                        _________________________________________________________________<br><br>

                        <b>SIGNATURE</b>
                    </div>
                <br><br><br><br>

                    <p>
                        <b>BY PARTICIPATING IN THIS ACTIVITY, YOU HAVE IN NO WAY
                            PURCHASED A &quot;POSITION&quot; OR &quot;SPOT&quot;. YOU HAVE NOT
                            PURCHASED THE RIGHT TO MAKE MONEY OR PROCEEDS AND
                            YOU HAVE IN NO WAY PURCHASED THE RIGHT TO BENEFIT FROM
                            GIFTING. IT SIMPLY MEANS THAT YOU HAVE GIVEN A GIFT AND THE PARTICIPATION WITH THIS ACTIVITY IS LOGGED
                            AND  RECORDED.</b>
                    </p>
                </p>
            </div>
        </div>
    </section>

@endsection




