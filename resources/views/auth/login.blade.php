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
    </style>
@endsection

@section('content')
    <main class="loginWrap">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="whitebg">
                        <form class="formStyle" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="mb-4 text-center">
                                <h2>Member Login</h2>
                            </div>
                            @if(Session::has('error'))
                                <div class="alert alert-danger">
                                    {{ Session::get('error')}}
                                </div>
                            @endif
                            <div class="mb-4">
                                <input type="text" class="form-control" placeholder="john" name="username"
                                       value="{{ old('username') }}" required autofocus>
                                <div class="text-end"><a href="{{ route('forgot.username') }}">Forgot Username?</a></div>
                                @error('username')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <div class="passwordWrap">
                                    <input type="password" class="form-control" placeholder="Password" name="password"
                                       required>
                                    <button type="button" class="revealPassword">
                                        <i class="fas fa-eye"></i>
                                        <i class="fas fa-eye-slash"></i>
                                    </button>
                                </div>
                                <div class="text-end">
                                    @if (Route::has('password.request'))
                                        <a class="" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember"
                                           id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="flexCheckDefault">Remember Me</label>
                                </div>
                            </div>
                            <div class="mb-4">
                                <button class="themeBtn w-100"><span></span>
                                    <text>Login</text>
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
