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
                                                <input type="text" class="form-control" name="first_name"
                                                       id="first_name"
                                                       value="{{ $user->first_name ?? '' }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="name">Last Name</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="last_name" id="last_name"
                                                       value="{{ $user->last_name ?? '' }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="name">Email</label>
                                            <div class="form-group">
                                                <input type="email" class="form-control" name="email" id="email"
                                                       value="{{ $user->email ?? '' }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="name">Phone</label>
                                            <div class="form-group">
                                                <input type="tel" class="form-control" name="phone" id="phone"
                                                       value="{{ $user->phone ?? '' }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="name">Username</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="username" id="username"
                                                       value="{{ $user->username ?? '' }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="password">Password</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="password" id="password"
                                                       value="{{ $password->value ?? '' }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="name">Invited By</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="invited_by"
                                                       id="invited_by"
                                                       value="{{ $user->invitedBy->username ?? '' }}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="block">Active/Inactive</label>
                                            <div class="form-group">
                                                <select name="is_blocked" id="block" class="form-control">
                                                    <option
                                                        value="yes" {{ $user->is_blocked == 'yes' ? 'selected' : '' }} data-value="inactive" data-route="{{ route('user.create', $user->id) }}">
                                                        Inactive
                                                    </option>
                                                    <option
                                                        value="no" {{ $user->is_blocked == 'no' ? 'selected' : '' }} data-value="active">
                                                        Active
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer text-right">
                                    <button type="submit" id="submit" class="btn btn-primary btn-md">Update User
                                    </button>
                                    <a href="{{route('users.index')}}" class="btn btn-warning btn-md">Cancel</a>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->

                        <!-- /.card -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Invitees</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="invitees-table" class="table table-bordered table-striped">
                                    <thead>
                                    <tr style="text-align: center">
                                        <th>No</th>
                                        <th>Username</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($user->inviters as $key => $invitee)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $invitee->username }}</td>
                                                <td>{{ $invitee->first_name }} {{ $invitee->last_name }}</td>
                                                <td>{{ $invitee->email }}</td>
                                                <td>{{ $invitee->phone }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div id="confirmModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header"  style="background-color: #343a40;
            color: #fff;">
                    <h2 class="modal-title">Confirmation</h2>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <h4 align="center" style="margin: 0;">Do you want to replace user ?</h4>
                </div>
                <div class="modal-footer">
                    <a href="" id="replace_user" class="btn btn-warning">Yes</a>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function (){
            // Invitees DataTable
            $('#invitees-table').DataTable({
                responsive: true,
                processing: true,
                pageLength: 10,
            });

            $('[name="is_blocked"]').on('change', () => {
                if($('option:selected', this).data('value') === 'inactive') {
                    $('#confirmModal').modal('show');
                    $('#replace_user').attr('href', $('option:selected', this).data('route'));
                }
            });
        });
    </script>
@endsection
