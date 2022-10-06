@extends('admin.layouts.app')
@section('title', isset($attribute->id) ? 'Edit Testimonial' : 'Edit Testimonial')
@section('section')
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Edit Testimonial Form</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active">Edit Testimonial Form</li>
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
                    <div class="col-md-9">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Edit Testimonial</h3>
                            </div>
                            <form class="attribute-form" method="post" action="{{ route('testimonial.update',$id) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="name">Name</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="name" id="name" value="{{ $faq->name }}" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="name">Designation</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="designation" id="designation" value="{{ $faq->designation }}" placeholder="Designation" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <label for="category">Comment</label>
                                            <textarea class="form-control" name="comment" id="comment" required>{{ $faq->comment }}</textarea>
                                            {!! $errors->first('comment', '<p class="help-block">:message</p>') !!}
                                        </div>
                                    </div>

                                    {{-- <div class="row">
                                        <div class="col ml-2">
                                            <label for="" class="mr-4">Status</label>
                                            <label class="switch">
                                                <input type="checkbox" name="status" data-id="" id="status-switch">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div> --}}

                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer text-center">
                                    <button type="submit" id="submit" class="btn btn-primary btn-md">Submit</button>
                                    <a href="{{route('testimonial.index')}}" class="btn btn-warning btn-md">Cancel</a>
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
    <script src="{{ asset('admin/ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript">
        // window.onload = function () {
        //     CKEDITOR.replace('comment', {
        //         {{--filebrowserUploadUrl: '{{ route('project.document-image-upload',['_token' => csrf_token() ]) }}',--}}
        //         {{--filebrowserUploadMethod: 'form'--}}
        //     });
        // };
    </script>

@endsection
