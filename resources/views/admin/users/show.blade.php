@extends('admin.layouts.app')
@section('title', 'Create New User')
@section('page_css')
    <style>
        .invalid-feedback {
            display: block;
        }
    </style>
@endsection
@section('section')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">

                    <div class="col-sm-6 offset-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ url('admin/users') }}">Users</a></li>
                            <li class="breadcrumb-item active">Show User</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- /.card -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">User Details</h3>
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered">
                                    <tbody>
                                    <tr>
                                        <th>First Name</th>
                                        <td>{{ $user->first_name ?? '' }}</td>
                                        <th>Last Name</th>
                                        <td>{{ $user->last_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $user->email ?? '' }}</td>
                                        <th>Phone</th>
                                        <td>{{ $user->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th>Username</th>
                                        <td>{{ $user->username ?? '' }}</td>
                                        <th>Password</th>
                                        <td>{{ $user->latestPassword->value ?? '' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Invited By</th>
                                        <td>{{ $user->invitedBy->username ?? '' }}</td>
                                        <th>Active/Inactive</th>
                                        <td>{{ $user->is_blocked ?? '' }}</td>
                                    </tr>
                                    </tbody>
                                </table>

                            </div>
                            <!-- /.card-body -->
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

                        <!-- /.card -->
{{--                        <div class="card card-primary">--}}
{{--                            <div class="card-header">--}}
{{--                                <h3 class="card-title">Username Change History</h3>--}}
{{--                            </div>--}}
{{--                            <!-- /.card-header -->--}}
{{--                            <div class="card-body">--}}
{{--                                <table id="username-logs-table" class="table table-bordered table-striped">--}}
{{--                                    <thead>--}}
{{--                                    <tr style="text-align: center">--}}
{{--                                        <th>No</th>--}}
{{--                                        <th>Username</th>--}}
{{--                                        <th>Old Username</th>--}}
{{--                                        <th>Date</th>--}}
{{--                                    </tr>--}}
{{--                                    </thead>--}}
{{--                                    <tbody>--}}
{{--                                    @foreach($user->usernameLogs as $key => $log)--}}
{{--                                        <tr>--}}
{{--                                            <td>{{ $key + 1 }}</td>--}}
{{--                                            <td>{{ $log->value }}</td>--}}
{{--                                            <td>{{ $log->old_value }}</td>--}}
{{--                                            <td>{{ date('F d, Y', strtotime($log->created_at)) }}</td>--}}
{{--                                        </tr>--}}
{{--                                    @endforeach--}}
{{--                                    </tbody>--}}
{{--                                </table>--}}
{{--                            </div>--}}
{{--                            <!-- /.card-body -->--}}
{{--                        </div>--}}
                        <!-- /.card -->

                    </div>
                    <!-- /.col -->
                </div>

                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>

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

            // username Logs DataTable
            $('#username-logs-table').DataTable({
                responsive: true,
                processing: true,
                pageLength: 10,
            });
        });
    </script>
@endsection
