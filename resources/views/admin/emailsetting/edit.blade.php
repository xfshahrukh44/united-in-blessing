@extends('admin.layouts.app')
@section('title', 'Admin Setting')
@section('section')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Email Setting</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Email Setting</li>
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
                                <h3 class="card-title">Site Settings Email</h3>
                            </div>
                            <form class="category-form" method="post"  action="{{route('emailsetting')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                    <div class="col-md-6">
                                        {{-- <input type="text" name="dasdas" required id=""> --}}
                                        <div class="form-group">
                                            <label for="name">Mail Domain</label>
                                            <input type="text" class="form-control" name="mail_domain" id="mail_domain"
                                                   value="{{$content->mail_domain ?? ''}}" placeholder="site title" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Mail Host</label>
                                            <input type="text" class="form-control" name="mail_host" id="name"
                                                   value="{{$content->mail_host??''}}" placeholder="mail_host"
                                                   required>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">MAIL ENCRYPTION</label>
                                            <select name="ssl" id="ssl" class="form-control" >
                                                <option value="ssl" @if($content->ssl == 'ssl') {{ "selected" }} @endif >ssl</option>
                                                <option value="tls" @if($content->ssl == 'tls') {{ "selected" }} @endif>tls</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Username</label>
                                            <input type="text" class="form-control" name="username" id="name"
                                                   value="{{$content->username??''}}" placeholder="username"
                                                   required>
                                        </div>
                                        

                                    </div>
                                    <div class="col-md-6">
                                        
                                        <div class="form-group">
                                            <label for="name">Password</label>
                                            <input type="password" class="form-control" name="password" id="name"
                                                   value="{{$content->password??''}}" placeholder="password"
                                                   required>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Mail Port</label>
                                            <input type="text" class="form-control" name="mail_port" id="name"
                                                   value="{{$content->mail_port??''}}" placeholder="mail_port"
                                                   required>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">From Address</label>
                                            <input type="text" class="form-control" name="from_address" id="name"
                                                   value="{{$content->from_address??''}}" placeholder="from_address"
                                                   required>
                                        </div>
                                    <!-- /.card-body -->
                                        
                                    </div>
                                    <div class="card-footer float-right">
                                        <input type="submit" onclick="validateinputs()" class="btn btn-primary" value="Submit">
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
    {{-- <script src="{{URL::asset('admin/custom_js/custom.js')}}"></script> --}}
@endsection

