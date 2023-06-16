@extends('admin.layouts.app')
@section('title', 'Create New User')
@section('page_css')
    <style>
        .invalid-feedback{
            display: block;
        }
    </style>
@endsection
@section('section')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit User</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active">Create New User</li>
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
                                <h3 class="card-title">Create New User</h3>
                            </div>
                            <form class="attribute-form" method="post" action="{{ route('user.store') }}"
                                  enctype="multipart/form-data">
                                @csrf
                                @if(isset($user))
                                    <input type="hidden" name="new_user_id" value="{{ $user->id }}">
                                @endif
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="name">Username</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="username" id="username"
                                                       value="{{ old('username') }}" required>
                                                @error('username')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="name">Invited By</label>
                                            <div class="form-group">
                                                {{--                                                <input type="text" class="form-control" name="inviters_username"--}}
                                                {{--                                                       id="inviters_username"--}}
                                                {{--                                                       value="{{ isset($user) ? ($user->invitedBy ? $user->invitedBy->username : old('inviters_username')) : old('inviters_username') }}"{{ isset($user) ? 'readonly' : 'required' }}>--}}
                                                <input type="text" class="form-control" name="inviters_username"
                                                       id="inviters_username" value="{{ old('inviters_username') }}"required>

                                                @error('inviters_username')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="name">First Name</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="first_name"
                                                       id="first_name"
                                                       value="{{ old('first_name') }}" required>
                                                @error('first_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="name">Last Name</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="last_name" id="last_name"
                                                       value="{{ old('last_name') }}" required>
                                                @error('last_name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="name">Email</label>
                                            <div class="form-group">
                                                <input type="email" class="form-control" name="email" id="email"
                                                       value="{{ old('email') }}" required>
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="name">Phone</label>
                                            <div class="form-group">
                                                <input type="tel" class="form-control" name="phone" id="phone"
                                                       value="{{ old('phone') }}" required>
                                                @error('phone')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="name">Password</label>
                                            <div class="form-group">
                                                <input type="password" class="form-control" name="password" id="password"
                                                       value="{{ old('password') }}" required>
                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="name">Confirm Password</label>
                                            <div class="form-group">
                                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation"
                                                       value="{{ old('password_confirmation') }}" required>
                                                @error('password_confirmation')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer text-right">
                                    <button type="submit" id="submit" class="btn btn-primary btn-md">Create User</button>
                                    <a href="{{route('users.index')}}" class="btn btn-warning btn-md">Cancel</a>
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
