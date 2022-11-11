@extends('layouts.app')
@section('keywords', '')
@section('description', '')

@section('css')
    <style>
        .invalid-feedback{
            display: block;
            color: #fff;
        }

        .menu-toggler{
            display: none !important;
        }
        .navigation-menu{
            right: -400px;
        }

        .backBtn {
            position: absolute;
            top: 26%;
            transform: translateY(-25%);
        }
    </style>
@endsection

@section('content')
    <main class="loginWrap">
        <div class="container">
            <a href="{{url('/')}}" class="backBtn">
                {{--            <i class="fas fa-arrow-to-left"></i>--}}
                Back
            </a>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="whitebg">
                        <form class="formStyle row theForm" method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="col-md-12 mb-4 text-center">
                                <h2>Join UIB</h2>
                            </div>
                            <div class="col-md-6 mb-4">
                                <input type="text" class="form-control" placeholder="Please Enter Inviter Username"
                                       name="inviters_username" value="{{ old('inviters_username') }}" required>
                                @error('inviters_username')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <input type="text" class="form-control" placeholder="UserName" name="username" value="{{ old('username') }}" required>
                                @error('username')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <input type="text" class="form-control" placeholder="Please Enter Your First Name" name="first_name" value="{{ old('first_name') }}"
                                       required>
                                @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <input type="text" class="form-control" placeholder="Please Enter Your Last Name" name="last_name" value="{{ old('last_name') }}"
                                       required>
                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <input type="email" class="form-control" placeholder="Email Address" name="email" value="{{ old('email') }}"
                                       required>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <input type="tel" class="form-control" placeholder="123-456-7890" name="phone" value="{{ old('phone') }}" required>
                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <input type="password" class="form-control" placeholder="Password" name="password"
                                       required>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <input type="password" class="form-control" placeholder="Confirm Password"
                                       name="password_confirmation" required>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="flexCheckDefault"
                                           name="accept" required>
                                    <label class="form-check-label" for="flexCheckDefault">Please confirm that you are a US resident in order to proceed. Only CLICK HERE if you choose to place yourself on a $100 board to begin the voluntary gifting activity and  acknowledge that you have read and consent to the Guidelines.</label>
                                </div>
                            </div>
                            <div class="mb-4">
                                <button class="themeBtn w-100" type="submit" onclick=""><span></span>
                                    <text>Join Now</text>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
