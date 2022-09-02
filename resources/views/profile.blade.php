@extends('layouts.app')
@section('keywords', '')
@section('description', '')

@section('content')
    <main class="loginWrap">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="whitebg">
                        <form class="formStyle row justify-content-between" method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="col-md-12 text-center">
                                <h2>Member Profile</h2>
                            </div>
                            <div class="col-md-12 mb-4">
                                <div class="userProfileCard">
                                    <div class="profilePic">
{{--                                        <img class="profile-pic" src="{{ asset('assets/images/user.jpg') }}">--}}
                                        <img class="profile-pic" src="{{ Auth::user()->user_image ? asset('upload/user/' . Auth::user()->user_image) : asset('assets/images/user.png') }}">
                                        <div class="p-image">
                                            <i class="fa fa-camera upload-button"></i>
                                            <input class="file-upload" type="file" name="user_image" accept="image/*" />
                                        </div>
                                    </div>
                                    <div class="profileDetl">
                                        <h3>{{ Auth::user()->username }}</h3>
                                        <ul>
                                            <li><a href="mailto: {{ Auth::user()->email }}">Email:
                                                {{ Auth::user()->email }}</a></li>
                                            <li class="saperator"></li>
                                            <li><a href="tel: {{ Auth::user()->phone }}">Phone: {{ Auth::user()->phone }}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 mb-4">
                                @if(Session::has('error'))
                                    <div class="alert alert-danger">
                                        {{ Session::get('error')}}
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6 mb-4">
                                <input type="text" class="form-control" placeholder="John" name="first_name" value="{{ Auth::user()->first_name }}">
                                @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <input type="text" class="form-control" placeholder="Smith" name="last_name" value="{{ Auth::user()->last_name }}">
                                @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <input type="tel" class="form-control" placeholder="+123 456 7890" maxlength="12" name="phone" value="{{ Auth::user()->phone }}">
                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <input type="email" class="form-control" placeholder="johnsmith22@gmail.com" name="email" value="{{ Auth::user()->email }}">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
{{--                            <div class="col-md-6 mb-4">--}}
{{--                                <input type="text" class="form-control" placeholder="Password" >--}}
{{--                            </div>--}}
{{--                            <div class="col-md-6 mb-4">--}}
{{--                                <input type="text" class="form-control" placeholder="Confirm Password">--}}
{{--                            </div>--}}

                            <div class="col-md-4">
                                <button class="themeBtn w-100" type="submit"><span></span><text>Update Now</text></button>
                            </div>
                            <div class="col-md-4">
                                <a href="{{ route('home') }}" class="themeBtn w-100"><span></span><text>Exit</text></a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
