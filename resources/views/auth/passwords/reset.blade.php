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
                        <form class="formStyle" method="POST" action="{{ route('password.update') }}">
                            @csrf
                            <div class="mb-4 text-center">
                                <h2>{{ __('Update Password') }}</h2>
                            </div>
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="mb-4">
                                <input type="email" class="form-control" placeholder="john@domain.com" name="email"
                                       value="{{ $email ?? old('email') }}" required readonly>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <input type="password" class="form-control" placeholder="Password" name="password"
                                       required autofocus>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <input type="password" class="form-control" placeholder="Confirm Password" name="password_confirmation"
                                       required>
                            </div>
                            <div class="mb-4">
                                <button class="themeBtn w-100"><span></span>
                                    <text>{{ __('Reset Password') }}</text>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection