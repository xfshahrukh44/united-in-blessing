@extends('layouts.app')
@section('keywords', '')
@section('description', '')

@section('css')
    <style>
        .invalid-feedback {
            display: block;
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
                <div class="col-lg-6">
                    <div class="whitebg">
                        <form class="formStyle" method="POST" action="{{ route('password.email') }}">
                            @csrf
                            <div class="mb-4 text-center">
                                <h2>Reset Password</h2>
                            </div>
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <div class="mb-4">
                                <input type="text" class="form-control" placeholder="johndoe" name="username"
                                       value="{{ old('username') }}" required autofocus>
                                @error('username')
                                <span class="invalid-feedback text-white" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <button class="themeBtn w-100"><span></span>
                                    <text>{{ __('Send Password Reset Link') }}</text>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
