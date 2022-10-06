@extends('admin.layouts.app')
@section('title', 'Shipping Services')
@section('section')
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Shipping Services Form</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Shipping Services</li>
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
                                <h3 class="card-title">Shipping Services</h3>
                            </div>
                            <form class="category-form" method="post" action="{{route('shippingServices')}}"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                {{-- start  --}}
                                                {{-- <label for="name">Payment Options</label> --}}
                                                <div id="accordion">
                                                    <div class="card">
                                                        <div class="card-header bg-dark" id="headingOne">
                                                            <h5 class="mb-0">
                                                                <div class="btn btn-link text-white text-left"
                                                                     style="width:100%;" data-toggle="collapse"
                                                                     data-target="#collapseOne" aria-expanded="true"
                                                                     aria-controls="collapseOne">
                                                                    UPS
                                                                </div>
                                                            </h5>
                                                        </div>

                                                        <div id="collapseOne" class="collapse border border-dark"
                                                             aria-labelledby="headingOne" data-parent="#accordion">
                                                            <div class="card-body">
                                                                <div class="row mb-4">
                                                                    <div class="col-md-3">
                                                                        Select Environment:
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input type="radio" name="ups[env]" required
                                                                               id="ups_env_live"
                                                                               @if(isset($content['UPS']['env']) && $content['UPS']['env'] == 'live') checked
                                                                               @endif value="live"> Live &nbsp;
                                                                        <input type="radio" name="ups[env]" required
                                                                               id="ups_env_testing"
                                                                               @if(isset($content['UPS']['env']) && $content['UPS']['env'] == 'testing') checked
                                                                               @endif  value="testing"> Testing
                                                                    </div>
                                                                </div>

                                                                <div class="row mb-4">
                                                                    <div class="col-md-3">
                                                                        Username:
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input type="text" name="ups[user_id]"
                                                                               id="ups_username" required
                                                                               class="form-control"
                                                                               value="{{$content['UPS']['user_id'] ?? ''}}">
                                                                    </div>
                                                                </div>

                                                                <div class="row mb-4">
                                                                    <div class="col-md-3">
                                                                        Password:
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input type="text" name="ups[password]"
                                                                               id="ups_password" required
                                                                               class="form-control"
                                                                               value="{{$content['UPS']['password']??''}}">
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-4">
                                                                    <div class="col-md-3">
                                                                        Access Key:
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input type="text" name="ups[access_key]"
                                                                               id="usps_key" required
                                                                               class="form-control"
                                                                               value="{{$content['UPS']['access_key']??''}}">
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-4">
                                                                    <div class="col-md-3">
                                                                        Shipper Number:
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input type="text" name="ups[shipper_number]"
                                                                               id="ups_shipper_number" required
                                                                               class="form-control"
                                                                               value="{{$content['UPS']['shipper_number']??''}}">
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-4">
                                                                    <div class="col-md-3">
                                                                        Status:
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <label class="switch">
                                                                            <input type="checkbox" name="ups[status]"
                                                                                   @if(isset($content['UPS']['status']) && $content['UPS']['status'] == '1') checked
                                                                                   @endif value="1" data-id=""
                                                                                   id="usps_switch">
                                                                            <span class="slider round"></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- third item --}}

                                                </div>
                                                {{-- end --}}

                                                {{-- start  --}}
                                                {{-- <label for="name">Payment Options</label> --}}
                                                <div id="accordion">
                                                    <div class="card">
                                                        <div class="card-header bg-dark" id="headingTwo">
                                                            <h5 class="mb-0">
                                                                <div class="btn btn-link text-white text-left"
                                                                     style="width:100%;" data-toggle="collapse"
                                                                     data-target="#collapseTwo" aria-expanded="true"
                                                                     aria-controls="collapseTwo">
                                                                    USPS
                                                                </div>
                                                            </h5>
                                                        </div>

                                                        <div id="collapseTwo" class="collapse border border-dark"
                                                             aria-labelledby="headingTwo" data-parent="#accordion">
                                                            <div class="card-body">
                                                                <div class="row mb-4">
                                                                    <div class="col-md-3">
                                                                        Select Environment:
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input type="radio" name="usps[env]" required
                                                                               id="usps_env_live"
                                                                               @if(isset($content['USPS']['env']) && $content['USPS']['env'] == 'live') checked
                                                                               @endif value="live"> Live &nbsp;
                                                                        <input type="radio" name="usps[env]" required
                                                                               id="usps_env_testing"
                                                                               @if(isset($content['USPS']['env']) && $content['USPS']['env'] == 'testing') checked
                                                                               @endif  value="testing"> Testing
                                                                    </div>
                                                                </div>

                                                                <div class="row mb-4">
                                                                    <div class="col-md-3">
                                                                        URL:
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input type="text" name="usps[url]"
                                                                               id="usps_url" required
                                                                               class="form-control"
                                                                               value="{{$content['USPS']['url'] ?? ''}}">
                                                                    </div>
                                                                </div>

                                                                <div class="row mb-4">
                                                                    <div class="col-md-3">
                                                                        Username:
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input type="text" name="usps[username]"
                                                                               id="usps_username" required
                                                                               class="form-control"
                                                                               value="{{$content['USPS']['username'] ?? ''}}">
                                                                    </div>
                                                                </div>

                                                                <div class="row mb-4">
                                                                    <div class="col-md-3">
                                                                        Password:
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <input type="text" name="usps[password]"
                                                                               id="usps_password" required
                                                                               class="form-control"
                                                                               value="{{$content['USPS']['password']??''}}">
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-4">
                                                                    <div class="col-md-3">
                                                                        Status:
                                                                    </div>
                                                                    <div class="col-md-9">
                                                                        <label class="switch">
                                                                            <input type="checkbox" name="usps[status]"
                                                                                   @if(isset($content['USPS']['status']) && $content['USPS']['status'] == '1') checked
                                                                                   @endif value="1" data-id=""
                                                                                   id="usps_switch">
                                                                            <span class="slider round"></span>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    {{-- third item --}}

                                                </div>
                                                {{-- end --}}

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
@endsection

<script>

    function validateInputs() {
        //paypal
        var paypal_env_live = document.getElementById("paypal_env_live").value;
        var paypal_env_testing = document.getElementById("paypal_env_live").value;
        var paypal_client_id = document.getElementById("paypal_client_id").value;
        var paypal_secret_key = document.getElementById("paypal_secret_key").value;
        var paypal_collapseOne = document.getElementById("collapseOne");
        //stripe
        var stripe_env_live = document.getElementById("paypal_env_live").value;
        var stripe_env_testing = document.getElementById("paypal_env_live").value;
        var stripe_publishable_key = document.getElementById("stripe_publishable_key").value;
        var stripe_secret_key = document.getElementById("stripe_secret_key").value;
        var stripe_collapseTwo = document.getElementById("collapseTwo");
        //authorize.net


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


    }//end validateInputs

</script>
