@extends('admin.layouts.app')
@section('title', 'Send Newsletter')
@section('section')
{{-- <style>
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

    </style> --}}
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Send Newsletter Form</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Send Newsletter Form</li>
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
                            <h3 class="card-title">Send Newsletter</h3>
                        </div>
                        <form class="category-form" method="post" action="{{ route('sendnewsletteremail') }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                @if (Session::has('msg'))
                                    <div class="alert alert-success">{{ Session::get('msg') }}</div>
                                @endif
                                <div class="form-group">
                                    <label for="subject">Subject *</label>
                                    <input type="text" class="form-control" name="subject" id="subject"
                                        value="{{ old('subject') }}" required placeholder="Subject">
                                </div>
                                <div class="form-group">
                                    <label for="newslettermessagebody">Message *</label><br />
                                    <textarea class="form-control" name="message" id="message"
                                        required>
                                        {{old('message')}}
                                    </textarea>
                                    <span style="color:red;">{!! $errors->first('message', '<p class="help-block">:message</p>') !!}</span>
                                </div>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer text-center">
                                <button type="submit" class="btn btn-primary btn-md">Submit</button>
                                <a href="{{ route('newsletter.index') }}" class="btn btn-warning btn-md">Cancel</a>
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
<script src="{{ asset('admin/dropzone/dist/dropzone.js') }}"></script>
<script type="text/javascript">
    window.onload = function() {
        CKEDITOR.replace('message', {
            {{-- filebrowserUploadUrl: '{{ route('project.document-image-upload',['_token' => csrf_token() ]) }}', --}}
            {{-- filebrowserUploadMethod: 'form' --}}
        });
    };

   function validateTextarea(){
       var txt=document.getElementById("message").value;

       if(txt==""){
           alert(txt);
       }
   } 

</script>
@endsection
