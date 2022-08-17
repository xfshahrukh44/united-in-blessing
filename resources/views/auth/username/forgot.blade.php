@extends('layouts.app')
@section('keywords', '')
@section('description', '')

@section('css')
    <style>
        .invalid-feedback {
            display: block;
        }
    </style>
@endsection

@section('content')
    <main class="loginWrap">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="whitebg">
                        <form class="formStyle" method="POST" action="{{ route('request.username.change') }}">
                            @csrf
                            <div class="mb-4 text-center">
                                <h3>Contact Administrator for assistance with locating your UserName</h3>
                            </div>
                            @if (session('success'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('success') }}
                                </div>
                            @endif
                            <div class="mb-4">
                                <input type="text" class="form-control" placeholder="new_username" name="username"
                                       value="{{ old('username') }}" required autofocus>
                                @error('username')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <input type="email" class="form-control" placeholder="john@domain.com" name="email"
                                       value="{{ old('email') }}" required autofocus>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <textarea name="username_change_message" id="username_change_message" cols="30" rows="10" class="form-control" placeholder="Username Change Message">{{ old('username_change_message') }}</textarea>
                                @error('username_change_message')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <button class="themeBtn w-100"><span></span>
                                    <text>{{ __('Locate My Username') }}</text>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
