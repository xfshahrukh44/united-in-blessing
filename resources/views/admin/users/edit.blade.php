@extends('admin.layouts.app')
@section('title', 'Edit User')
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
                            <li class="breadcrumb-item active">Edit User</li>
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
                                <h3 class="card-title">Edit User</h3>
                            </div>
                            <form class="attribute-form" method="post" action="{{ route('user.update',$user->id) }}"
                                  enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="name">First Name</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="first_name" id="first_name"
                                                       value="{{ $user->first_name }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="name">Last Name</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="last_name" id="last_name"
                                                       value="{{ $user->last_name }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="name">Email</label>
                                            <div class="form-group">
                                                <input type="email" class="form-control" name="email" id="email"
                                                       value="{{ $user->email }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="name">Phone</label>
                                            <div class="form-group">
                                                <input type="tel" class="form-control" name="phone" id="phone"
                                                       value="{{ $user->phone }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="name">Username</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="username" id="username"
                                                       value="{{ $user->username }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="name">Invited By</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="invited_by" id="invited_by"
                                                       value="{{ $user->invitedBy->username }}" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer text-right">
                                    <button type="submit" id="submit" class="btn btn-primary btn-md">Update User</button>
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
