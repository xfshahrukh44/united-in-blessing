@extends('admin.layouts.app')
@section('title', 'All Reports')
<style>

    .pdfCont {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #000;
        padding: 0.5rem;
        border: 1px solid #000;
        transition: all 0.25s ease-in-out;
    }

    .pdfCont:hover{
        background-color: #000;
        color: #fff;
    }

    .pdfCont p {
        margin: 0;
        font-size: 1.25rem;
    }

    .report_row{
        gap: 1rem 0;
    }

    .pdfCont i:last-of-type{
        margin-left: auto;
    }
</style>
@section('section')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>All Reports</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">All Reports</li>
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
                                <h3 class="card-title">All Reports</h3>
                            </div>
                            <div class="card-body">
                                <div class="container-fluid">
                                    <div class="row report_row">
                                        @foreach($reports as $key => $report)
                                            <div class="col-lg-3 col-md-4 col-sm-6">
                                                <a class="pdfCont" href="{{ url('upload/reports') . '/' . $report['filename'] }}"
                                                   target="_blank">
                                                    <i class="fa fa-file-pdf"></i>
                                                    <p>{{ $report['filename'] }}</p>
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
