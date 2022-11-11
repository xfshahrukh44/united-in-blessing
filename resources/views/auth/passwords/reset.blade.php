@extends('layouts.app')
@section('keywords', '')
@section('description', '')

@section('css')
    <style>
        .invalid-feedback {
            display: block;
        }

        .menu-toggler {
            display: none !important;
        }

        .navigation-menu {
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
                                <div class="passwordWrap">
                                    <input type="password" class="form-control" placeholder="Password" name="password"
                                           required autofocus>
                                     <button type="button" class="revealPassword">
                                        <i class="fas fa-eye"></i>
                                        <i class="fas fa-eye-slash" style="display: none"></i>
                                    </button>
                                </div>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <div class="passwordWrap">
                                    <input type="password" class="form-control" placeholder="Confirm Password"
                                           name="password_confirmation"
                                           required>
                                     <button type="button" class="revealPassword">
                                        <i class="fas fa-eye"></i>
                                        <i class="fas fa-eye-slash" style="display: none"></i>
                                    </button>
                                </div>
                                @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
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

@section('js')
    <script>
        $('button.revealPassword').click(function () {
            // Show hide password
            if ($(this).siblings('input').prop('type') === 'password') {
                $(this).siblings('input').attr('type', 'text');
                $(this).parent().find('.fa-eye-slash').show();
                $(this).parent().find('.fa-eye').hide();
            } else {
                $(this).siblings('input').attr('type', 'password');
                $(this).parent().find('.fa-eye-slash').hide();
                $(this).parent().find('.fa-eye').show();
            }
        })
    </script>
@endsection
