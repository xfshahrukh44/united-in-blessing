@extends('admin.layouts.app')
@section('title', 'Admin Setting')
@section('section')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Setting Form</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Setting</li>
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
                                <h3 class="card-title">Site Settings</h3>
                            </div>
                            <form class="category-form" method="post"  action="{{route('settings')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="name">Site Title</label>
                                            <input type="text" class="form-control" name="site_title" id="name"
                                                   value="{{$content->site_title??''}}" placeholder="site title"
                                                   required>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Company Name</label>
                                            <input type="text" class="form-control" name="company_name" id="name"
                                                   value="{{$content->company_name??''}}" placeholder="company_name"
                                                   required>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Shipping Rate</label>
                                            <input type="number" name="shipping_rate" class="form-control" step="0.01" value="{{$content->shipping_rate??0}}" placeholder="Shipping Rate">
                                            {{--<select name="shipping_rate" id="shipping_rate" class="form-control" >
                                                <option value="">Select Shipping Rate</option>
                                                @foreach($shippingRates as $shippingRate)
                                                    <option value="{{$shippingRate->id}}" @if($content->shipping_rate == $shippingRate->id) selected @endif>{{$shippingRate->rate}}</option>
                                                @endforeach
                                            </select>--}}
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Email</label>
                                            <input type="email" class="form-control" name="email" id="email"
                                                   value="{{$content->email??''}}" placeholder="email"
                                                   required>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Phone No 1 </label>
                                            <input type="number" class="form-control" name="phone_no_1" id="name"
                                                   value="{{$content->phone_no_1??''}}" placeholder="Phone Number 1"
                                                   required>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Phone No 2 </label>
                                            <input type="number" class="form-control" name="phone_no_2" id="name"
                                                   value="{{$content->phone_no_2??''}}" placeholder="Phone Number 2">
                                        </div>

                                   <div class="form-group">
                                             {{-- start  --}}
                                            {{-- <label for="name">Payment Options</label>

                                        <div id="accordion">
                                            <div class="card">
                                              <div class="card-header" id="headingOne">
                                                <h5 class="mb-0">
                                                  <div class="btn btn-link" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                                    Paypal
                                                  </div>
                                                </h5>
                                              </div>

                                              <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            Select Environment:
                                                        </div>
                                                        <div class="col-md-8">
                                                             <input type="radio" name="paypal_env" required id="paypal_env_live"  @if($content->paypal_env == "Live") checked @endif value="Live"> Live &nbsp;
                                                            <input type="radio" name="paypal_env" required id="paypal_env_testing"  @if($content->paypal_env == "Testing") checked @endif value="Testing"> Testing
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            Client ID:
                                                        </div>
                                                        <div class="col-md-8"><input type="text" name="paypal_client_id" id="paypal_client_id" required class="form-control" value="{{$content->paypal_client_id??''}}"></div>
                                                    </div>
                                                    <br/>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            Secret Key:
                                                        </div>
                                                        <div class="col-md-8"><input type="text" name="paypal_secret_key" id="paypal_secret_key" required  class="form-control" value="{{$content->paypal_secret_key??''}}" ></div>
                                                    </div>
                                                </div>
                                              </div>
                                            </div>
                                            <div class="card">
                                              <div class="card-header" id="headingTwo">
                                                <h5 class="mb-0">
                                                  <div class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                    Stripe
                                                  </div>
                                                </h5>
                                              </div>
                                              <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            Select Environment:
                                                        </div>
                                                        <div class="col-md-8">
                                                             <input type="radio" name="stripe_env" @if($content->stripe_env == "Live") checked @endif required id="" value="Live"> Live &nbsp;
                                                            <input type="radio" name="stripe_env" @if($content->stripe_env == "Testing") checked @endif required id="" value="Testing"> Testing
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            Publishable Key:
                                                        </div>
                                                        <div class="col-md-8"><input type="text" name="stripe_publishable_key"  id="stripe_publishable_key" required class="form-control" value="{{$content->stripe_publishable_key??''}}"></div>
                                                    </div>
                                                    <br/>
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            Secret Key:
                                                        </div>
                                                        <div class="col-md-8"><input type="text" name="stripe_secret_key" id="stripe_secret_key" required  class="form-control" value="{{$content->stripe_secret_key??''}}"></div>
                                                    </div>
                                                </div>
                                              </div>
                                            </div>

                                          </div> --}}
                                        {{-- end --}}
                                        {{-- <div class="input-group-btn">
                                                    <div class="file-btn mt-4">
                                                        <span style="font-weight: bold;margin-right: 10px;">Paypal</span><input type="checkbox" id="paypal" @if($content->paypal_check == "yes") checked @endif name="paypal_check" value="yes">
                                                    </div>
                                                    <div class="file-btn mt-4">
                                                        <span style="font-weight: bold;margin-right: 10px;">Stripe</span><input type="checkbox" id="stipe" @if($content->stripe_check == "yes") checked @endif name="stripe_check" value="yes">
                                                    </div>
                                        </div> --}}
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Address</label>
                                            <input type="text" class="form-control" name="address" id="address"
                                                   value="{{$content->address??''}}" placeholder="address"
                                                   required>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Zip Code</label>
                                            <input type="text" class="form-control" name="zip_code" id="zip_code"
                                                   value="{{$content->zip_code??''}}" placeholder="11234"
                                                   required>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Facebook</label>
                                            <input type="url" class="form-control" name="facebook" id="facebook"
                                                   value="{{$content->facebook??''}}" placeholder="facebook"
                                                   >
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Twitter</label>
                                            <input type="text" class="form-control" name="tweeter" id="tweeter"
                                                   value="{{$content->tweeter??''}}" placeholder="Tweeter"
                                                   >
                                        </div>

                                        <div class="form-group">
                                            <label for="name">LinkedIn</label>
                                            <input type="text" class="form-control" name="LinkedIn" id="LinkedIn"
                                                   value="{{$content->linkedIn??''}}" placeholder="LinkedIn"
                                                   >
                                        </div>

                                        <div class="form-group">
                                            <label for="name">Instagram</label>
                                            <input type="text" class="form-control" name="instagram" id="instagram"
                                                   value="{{$content->instagram??''}}" placeholder="instagram"
                                                   >
                                        </div>

                                            <div class="form-group">
                                                <label for="name">Logo</label>
                                                 <div class="input-group-btn">
                                                    <div class="image-upload">
                                                        <img src="{{asset(!empty($content->logo) && file_exists('uploads/settings/'.$content->logo) ? 'uploads/settings/'.$content->logo:'admin/dist/img/placeholder.png')}}" class="img-responsive" width="100px" height="100px">
                                                            <div class="file-btn mt-4">
                                                                <input type="file" id="logo" name="logo" accept=".jpg,.png">
                                                                <input type="text" id="logo" name="logo" value="{{ !empty($content->logo) ? $content->logo : '' }}" hidden="">
                                                            </div>
                                                        </div>
                                                </div>
                                            </div>



                                    <!-- /.card-body -->
                                        <div class="card-footer float-right">
                                            <button type="submit" onclick="validateinputs()" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
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

