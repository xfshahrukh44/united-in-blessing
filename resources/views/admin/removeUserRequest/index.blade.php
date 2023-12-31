@extends('admin.layouts.app')
@section('title', 'Users')
@section('section')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Requests</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Requests</li>
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
                            {{--                            <div class="card-header text-right">--}}
                            {{--                                <a class="btn btn-primary pull-right addBtn" href="{{route('user.create')}}">Create New User</a>--}}
                            {{--                            </div>--}}
                            <div class="col-md-12">

                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="remove-user-request-table" class="table table-bordered table-striped">
                                    <thead>
                                    <tr style="text-align: center">
                                        <th>No</th>
                                        <th>Newbie</th>
                                        <th>Board #</th>
                                        <th>Requested By</th>
                                        <th>Status</th>
                                        {{--                                        <th>Action</th>--}}
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
                        <h4 align="center" style="margin: 0;">Are you sure you want to delete this?</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="ok_delete" name="ok_delete" class="btn btn-danger">Delete</button>
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
            var DataTable = $("#remove-user-request-table").DataTable({
                dom: "Blfrtip",
                responsive: true,
                processing: true,
                serverSide: true,
                pageLength: 10,
                ajax: {
                    url: `{{route('admin.remove-user-request.index')}}`,
                },
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'user_id', name: 'user_id'},
                    {data: 'board_id', name: 'board_id'},
                    {data: 'requested_by', name: 'requested_by'},
                    {data: 'status', name: 'status'},
                    // {data: 'action', name: 'action', orderable: false}
                ]

            });
            var delete_id;
            $(document, this).on('click', '.delete', function () {
                delete_id = $(this).attr('id');
                $('#confirmModal').modal('show');
            });

            $(document).on('click', '#ok_delete', function () {
                $.ajax({
                    url: "{{url('admin/user/destroy')}}/" + delete_id,
                    type: 'post',
                    data: {
                        id: delete_id,
                        "_method": 'DELETE',
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    beforeSend: function () {
                        $('#ok_delete').text('Deleting...');
                        $('#ok_delete').attr("disabled", true);
                    },
                    success: function (data) {
                        DataTable.ajax.reload();
                        $('#ok_delete').text('Delete');
                        $('#ok_delete').attr("disabled", false);
                        $('#confirmModal').modal('hide');
                        //   js_success(data);
                        if (data == 0) {
                            toastr.error('Something went wrong');
                        } else {
                            toastr.success('Record Delete Successfully');
                        }
                    }
                })
            });

            $(document).on('change', '.requestStatus', function () {
                let id = $(this).find(':selected').attr('data-id');
                let value = $(this).val();
                $.ajax({
                    url: "{{ url('admin/remove-user-request/update') }}/" + id,
                    type: 'POST',
                    data: {
                        id: id,
                        value: value,
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        DataTable.ajax.reload();
                        if (data) {
                            toastr.error(data);
                        } else {
                            toastr.success('Record updated successfully');
                        }
                    }
                })
            })
        })
    </script>


@endsection
