@extends('admin.layouts.app')
@section('title', 'Sell Watch Detail')
@section('page_css')
    <!-- Datatables -->
    <link href="{{ asset('admin/datatables/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/datatables/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/datatables/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/datatables/datatables.net-responsive-bs/css/responsive.bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/datatables/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">
    <style>
        th{
            background-color: #f7f7f7;
        }
    </style>
@endsection
@section('section')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">

                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Sell Watch Detail</li>
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
                            <div class="card-header">
                                <h3 class="card-title">Sell Watch Detail</h3>
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <td colspan="4">{{$data->name ?? ''}}</td>
                                        </tr>
                                        <tr>
                                            <th>Phone</th>
                                            <td colspan="4">{{$data->phone ?? ''}}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td colspan="4">{{$data->email ?? ''}}</td>
                                        </tr>
                                        <tr>
                                            <th>Location</th>
                                            <td>{{$data->location ?? ''}}</td>
                                        </tr>
                                        <tr>
                                            <th>Watch Name</th>
                                            <td>{{$data->watch_name ?? ''}}</td>
                                        </tr>
                                        <tr>
                                            <th>Image 1</th>
                                            <td> <a href="{{ asset('uploads/sellwatches/'.$data->img1) }}" target="_blank" > {{ $data->img1 ?? ''}}</a> </td>
                                        </tr>
                                        <tr>
                                            <th>Image 2</th>
                                            <td> <a href="{{ asset('uploads/sellwatches/'.$data->img2) }}" target="_blank" > {{ $data->img2 ?? ''}}</a> </td>
                                        </tr>
                                        <tr>
                                            <th>Image 3</th>
                                            <td> <a href="{{ asset('uploads/sellwatches/'.$data->img3) }}" target="_blank" > {{ $data->img3 ?? ''}}</a> </td>
                                        </tr>
                                        <tr>
                                            <th>Image 4</th>
                                            <td> <a href="{{ asset('uploads/sellwatches/'.$data->img4) }}" target="_blank" > {{ $data->img4 ?? ''}}</a> </td>
                                        </tr>
                                    </thead>
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

    </div>
@endsection
