@extends('admin.layouts.app')
@section('title', 'Payment Gateways')
@section('section')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Payment Gateways Form</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Payment Gateways</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content-header -->

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Payment Gateways</h3>
                            </div>
                            <form class="category-form" method="post" action="{{route('paymentgatway')}}"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                {{-- start  --}}
                                                <label for="name">Payment Options</label>
                                                <div id="accordion">
                                                    <div class="card">
                                                        <div class="card-header bg-dark" id="headingOne">
                                                            <h5 class="mb-0">
                                                                <div class="btn btn-link text-white text-left"
                                                                     style="width:100%;" data-toggle="collapse"
                                                                     data-target="#collapseOne" aria-expanded="true"
                                                                     aria-controls="collapseOne">
                                                                    Paypal
                                                                </div>
                                                            </h5>
                                                        </div>

                                                        <div id="collapseOne"
                                                             class="collapse border border-dark collapse show"
                                                             aria-labelledby="headingOne" data-parent="#accordion">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        Select Environment:
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input type="radio" name="paypal_env"
                                                                               id="paypal_env_live"
                                                                               @if($content->paypal_env == "Live") checked
                                                                               @endif value="Live"> Live &nbsp;
                                                                        <input type="radio" name="paypal_env"
                                                                               id="paypal_env_testing"
                                                                               @if($content->paypal_env == "Testing") checked
                                                                               @endif value="Testing"> Testing
                                                                    </div>
                                                                </div>
                                                                <br>
                                                                <div class="paypal-live-credentials">
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            Client ID:
                                                                        </div>
                                                                        <div class="col-md-9">
                                                                            <input type="text" name="paypal_client_id"
                                                                                   id="paypal_client_id"
                                                                                   class="form-control"
                                                                                   value="{{$content->paypal_client_id??''}}">
                                                                        </div>
                                                                    </div>
                                                                    <br/>
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            Secret Key:
                                                                        </div>
                                                                        <div class="col-md-9">
                                                                            <input type="text" name="paypal_secret_key"
                                                                                   id="paypal_secret_key"
                                                                                   class="form-control"
                                                                                   value="{{$content->paypal_secret_key??''}}">
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="paypal-testing-credentials">
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            Testing Client ID:
                                                                        </div>
                                                                        <div class="col-md-9">
                                                                            <input type="text"
                                                                                   name="paypal_testing_client_id"
                                                                                   id="paypal_testing_client_id"
                                                                                   class="form-control"
                                                                                   value="{{$content->paypal_testing_client_id??''}}">
                                                                        </div>
                                                                    </div>
                                                                    <br/>
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            Testing Secret Key:
                                                                        </div>
                                                                        <div class="col-md-9">
                                                                            <input type="text"
                                                                                   name="paypal_testing_secret_key"
                                                                                   id="paypal_testing_secret_key"
                                                                                   class="form-control"
                                                                                   value="{{$content->paypal_testing_secret_key??''}}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card">
                                                        <div class="card-header bg-dark" id="headingTwo">
                                                            <h5 class="mb-0">
                                                                <div class="btn btn-link collapsed text-white text-left"
                                                                     style="width:100%;" data-toggle="collapse"
                                                                     data-target="#collapseTwo" aria-expanded="false"
                                                                     aria-controls="collapseTwo">
                                                                    Stripe
                                                                </div>
                                                            </h5>
                                                        </div>
                                                        <div id="collapseTwo" class="collapse border border-dark"
                                                             aria-labelledby="headingTwo" data-parent="#accordion">
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-md-3">
                                                                        Select Environment:
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input type="radio" name="stripe_env"
                                                                               @if($content->stripe_env == "Live") checked
                                                                               @endif required id="stripe_env_live"
                                                                               value="Live"> Live &nbsp;
                                                                        <input type="radio" name="stripe_env"
                                                                               @if($content->stripe_env == "Testing") checked
                                                                               @endif required id="stripe_env_testing"
                                                                               value="Testing"> Testing
                                                                    </div>
                                                                </div>
                                                                <br>
                                                                <div class="stripe-live-credentials">
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            Publishable Key:
                                                                        </div>
                                                                        <div class="col-md-9">
                                                                            <input type="text"
                                                                                   name="stripe_publishable_key"
                                                                                   id="stripe_publishable_key"
                                                                                   class="form-control"
                                                                                   value="{{$content->stripe_publishable_key??''}}">
                                                                        </div>
                                                                    </div>
                                                                    <br/>
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            Secret Key:
                                                                        </div>
                                                                        <div class="col-md-9">
                                                                            <input type="text" name="stripe_secret_key"
                                                                                   id="stripe_secret_key"
                                                                                   class="form-control"
                                                                                   value="{{$content->stripe_secret_key??''}}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="stripe-testing-credentials">
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            Testing Publishable Key:
                                                                        </div>
                                                                        <div class="col-md-9">
                                                                            <input type="text"
                                                                                   name="stripe_testing_publishable_key"
                                                                                   id="stripe_testing_publishable_key"
                                                                                   class="form-control"
                                                                                   value="{{$content->stripe_testing_publishable_key??''}}">
                                                                        </div>
                                                                    </div>
                                                                    <br/>
                                                                    <div class="row">
                                                                        <div class="col-md-3">
                                                                            Testing Secret Key:
                                                                        </div>
                                                                        <div class="col-md-9">
                                                                            <input type="text" name="stripe_testing_secret_key"
                                                                                   id="stripe_testing_secret_key"
                                                                                   class="form-control"
                                                                                   value="{{$content->stripe_testing_secret_key??''}}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{--                                                    <div class="card">--}}
                                                    {{--                                                        <div class="card-header bg-dark" id="headingThree">--}}
                                                    {{--                                                            <h5 class="mb-0">--}}
                                                    {{--                                                                <div class="btn btn-link collapsed text-white text-left"--}}
                                                    {{--                                                                     style="width:100%;" data-toggle="collapse"--}}
                                                    {{--                                                                     data-target="#collapseThree" aria-expanded="false"--}}
                                                    {{--                                                                     aria-controls="collapseThree">--}}
                                                    {{--                                                                    Authorize.net--}}
                                                    {{--                                                                </div>--}}
                                                    {{--                                                            </h5>--}}
                                                    {{--                                                        </div>--}}
                                                    {{--                                                        <div id="collapseThree" class="collapse border border-dark"--}}
                                                    {{--                                                             aria-labelledby="headingThree" data-parent="#accordion">--}}
                                                    {{--                                                            <div class="card-body">--}}
                                                    {{--                                                                <div class="row">--}}
                                                    {{--                                                                    <div class="col-md-3">--}}
                                                    {{--                                                                        Select Environment:--}}
                                                    {{--                                                                    </div>--}}
                                                    {{--                                                                    <div class="col-md-9">--}}
                                                    {{--                                                                        <input type="radio" name="authorize_env"--}}
                                                    {{--                                                                               @if($content->authorize_env == "Live") checked--}}
                                                    {{--                                                                               @endif id="authorize_env_live"--}}
                                                    {{--                                                                               value="Live"> Live &nbsp;--}}
                                                    {{--                                                                        <input type="radio" name="authorize_env"--}}
                                                    {{--                                                                               @if($content->authorize_env == "Testing") checked--}}
                                                    {{--                                                                               @endif--}}
                                                    {{--                                                                               id="authorize_env_testing"--}}
                                                    {{--                                                                               value="Testing"> Testing--}}
                                                    {{--                                                                    </div>--}}
                                                    {{--                                                                </div>--}}
                                                    {{--                                                                <br>--}}
                                                    {{--                                                                <div class="row">--}}
                                                    {{--                                                                    <div class="col-md-3">--}}
                                                    {{--                                                                        Merchant Login ID:--}}
                                                    {{--                                                                    </div>--}}
                                                    {{--                                                                    <div class="col-md-9">--}}
                                                    {{--                                                                        <input type="text"--}}
                                                    {{--                                                                               name="authorize_merchant_login_id"--}}
                                                    {{--                                                                               id="authorize_merchant_login_id"--}}
                                                    {{--                                                                               class="form-control"--}}
                                                    {{--                                                                               value="{{$content->authorize_merchant_login_id??''}}">--}}
                                                    {{--                                                                    </div>--}}
                                                    {{--                                                                </div>--}}
                                                    {{--                                                                <br/>--}}
                                                    {{--                                                                <div class="row">--}}
                                                    {{--                                                                    <div class="col-md-3">--}}
                                                    {{--                                                                        Merchant Transaction Key:--}}
                                                    {{--                                                                    </div>--}}
                                                    {{--                                                                    <div class="col-md-9">--}}
                                                    {{--                                                                        <input type="text"--}}
                                                    {{--                                                                               name="authorize_merchant_transaction_key"--}}
                                                    {{--                                                                               id="authorize_merchant_transaction_key"--}}
                                                    {{--                                                                               class="form-control"--}}
                                                    {{--                                                                               value="{{$content->authorize_merchant_transaction_key??''}}">--}}
                                                    {{--                                                                    </div>--}}
                                                    {{--                                                                </div>--}}
                                                    {{--                                                            </div>--}}
                                                    {{--                                                        </div>--}}
                                                    {{--                                                    </div>--}}
                                                </div>
                                            </div>
                                            {{-- end --}}
                                            <div class="input-group-btn">
                                                <div class="file-btn mt-4">
                                                    <span style="font-weight: bold;margin-right: 10px;">Paypal</span>
                                                    <input type="checkbox" id="paypal"
                                                           @if($content->paypal_check == "yes") checked
                                                           @endif name="paypal_check" value="yes">
                                                </div>
                                                <div class="file-btn mt-4">
                                                    <span style="font-weight: bold;margin-right: 10px;">Stripe</span>
                                                    <input type="checkbox" id="stipe"
                                                           @if($content->stripe_check == "yes") checked
                                                           @endif name="stripe_check" value="yes">
                                                </div>
{{--                                                <div class="file-btn mt-4">--}}
{{--                                                    <span--}}
{{--                                                        style="font-weight: bold;margin-right: 10px;">Authorize.net</span>--}}
{{--                                                    <input type="checkbox" id="authorize"--}}
{{--                                                           @if($content->authorize_check == "yes") checked--}}
{{--                                                           @endif name="authorize_check" value="yes">--}}
{{--                                                </div>--}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer float-right">
                                    <button type="submit" onclick="validateInputs()" class="btn btn-primary">Submit
                                    </button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('script')
    <script src="{{URL::asset('admin/custom_js/custom.js')}}"></script>

    <script>
        $(document).ready(function () {
            checkPaypalEnv();
            checkStripeEnv();
        })

        $('input[name="paypal_env"]').on('click', function () {
            checkPaypalEnv();
        });

        $('input[name="stripe_env"]').on('click', function () {
            checkStripeEnv();
        })

        function checkPaypalEnv() {
            if ($('input[name="paypal_env"]:checked').val() == 'Live') {
                $('.paypal-testing-credentials').addClass('d-none');
                $('.paypal-live-credentials').removeClass('d-none');
            } else {
                $('.paypal-testing-credentials').removeClass('d-none');
                $('.paypal-live-credentials').addClass('d-none');
            }
        }

        function checkStripeEnv(){
            if ($('input[name="stripe_env"]:checked').val() == 'Live') {
                $('.stripe-testing-credentials').addClass('d-none');
                $('.stripe-live-credentials').removeClass('d-none');
            } else {
                $('.stripe-testing-credentials').removeClass('d-none');
                $('.stripe-live-credentials').addClass('d-none');
            }

        }

        function validateInputs() {
            //paypal
            var paypal_env_live = document.getElementById("paypal_env_live").value;
            var paypal_env_testing = document.getElementById("paypal_env_testing").value;
            var paypal_client_id = document.getElementById("paypal_client_id").value;
            var paypal_secret_key = document.getElementById("paypal_secret_key").value;
            var paypal_testing_client_id = document.getElementById("paypal_testing_client_id").value;
            var paypal_testing_secret_key = document.getElementById("paypal_testing_secret_key").value;
            var paypal_collapseOne = document.getElementById("collapseOne");

            //stripe
            var stripe_env_live = document.getElementById("paypal_env_live").value;
            var stripe_env_testing = document.getElementById("paypal_env_live").value;
            var stripe_publishable_key = document.getElementById("stripe_publishable_key").value;
            var stripe_secret_key = document.getElementById("stripe_secret_key").value;
            var stripe_testing_publishable_key = document.getElementById("stripe_testing_publishable_key").value;
            var stripe_testing_secret_key = document.getElementById("stripe_testing_secret_key").value;
            var stripe_collapseTwo = document.getElementById("collapseTwo");

            //authorize.net
            var authorize_env_live = document.getElementById("authorize_env_live").value;
            var authorize_env_testing = document.getElementById("authorize_env_testing").value;
            var authorize_merchant_login_id = document.getElementById("authorize_merchant_login_id").value;
            var authorize_merchant_transaction_key = document.getElementById("authorize_merchant_transaction_key").value;
            var authorize_collapseThree = document.getElementById("collapseThree");


            if (paypal_env_live != "checked" || paypal_env_testing != "checked") {
                if (paypal_client_id == "" || paypal_secret_key == "") {
                    paypal_collapseOne.setAttribute("class", "show");
                }
            }
            if (stripe_env_live != "checked" || stripe_env_testing != "checked") {
                if (stripe_publishable_key == "" || stripe_secret_key == "") {
                    stripe_collapseTwo.setAttribute("class", "show");
                }
            }
            if (authorize_env_live != "checked" || authorize_env_testing != "checked") {
                if (authorize_merchant_login_id == "" || authorize_merchant_transaction_key == "") {
                    authorize_collapseThree.setAttribute("class", "show");
                }
            }


        }//end validateInputs

    </script>
@endsection
