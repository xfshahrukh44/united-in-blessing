@extends('admin.layouts.app')
@section('title', 'Users')
@section('section')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Users</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Users</li>
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
                        <div class="card">
                            <div class="card-header text-right">
                                <a class="btn btn-primary pull-right addBtn" href="{{route('user.create')}}">Create New
                                    User</a>
                            </div>
                            <div class="col-md-12">

                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="users-table" class="table table-bordered table-striped">
                                    <thead>
                                    <tr style="text-align: center">
                                        <th>No</th>
                                        <th>Username</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <div id="confirmModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #343a40;
            color: #fff;">
                        <h2 class="modal-title">Confirmation</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <h4 align="center" style="margin: 0;">Are you sure you want to delete this user?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="yes_delete" name="yes_delete" class="btn btn-danger">Delete</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="selectUserModal" class="modal fade" role="dialog">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #343a40; color: #fff;">
                        <h2 class="modal-title">Select User To Replace</h2>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <form action="">
{{--                            <h4 align="left" style="margin: 0;">Select user to replace with the old user</h4>--}}
                            <select name="replace_user" id="replace_user" class="form-control" required>
                                <option value="">Select User to replace</option>
                                @foreach($users as $user)
                                    <option value={{ $user->id }}>{{ $user->username }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="ok_delete" name="ok_delete" class="btn btn-danger">Replace</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            var DataTable = $("#users-table").DataTable({
                dom: "Blfrtip",
                responsive: true,
                processing: true,
                serverSide: true,
                pageLength: 50,
                ajax: {
                    url: `{{route('users.index')}}`,
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'username', name: 'username'},
                    {data: 'name', name: 'name'},
                    {data: 'email', name: 'email'},
                    {data: 'phone', name: 'phone'},
                    {data: 'action', name: 'action', orderable: false}
                ]

            });
            var delete_id;
            $(document, this).on('click', '.delete', function () {
                delete_id = $(this).attr('id');
                $('#confirmModal').modal('show');
            });

            $(document).on('click', '#yes_delete', function () {
                $('#confirmModal').modal('hide');
                $('#selectUserModal').modal('show');
            });

            $(document).on('click', '#ok_delete', function () {
                let deleteId = delete_id !== 'ok_delete' && delete_id !== undefined ? delete_id : $(this).data('deleting_id')
                $.ajax({
                    url: "{{url('admin/user/destroy')}}/" + deleteId,
                    type: 'post',
                    data: {
                        delete_user_id: deleteId,
                        new_user_id: $('#replace_user').val(),
                        "_method": 'DELETE',
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function () {
                        $('#ok_delete').text('Replacing User...');
                        $('#ok_delete').attr("disabled", true);
                    },
                    success: function (data) {
                        DataTable.ajax.reload();
                        $('#ok_delete').text('Replace User');
                        $('#ok_delete').attr("disabled", false);
                        $('#confirmModal').modal('hide');
                        //   js_success(data);
                        if (data == 1) {
                            toastr.success('Record Delete Successfully');
                            location.reload();
                        } else {
                            toastr.error(data);
                        }
                    }
                })
            });
        })
    </script>


@endsection
