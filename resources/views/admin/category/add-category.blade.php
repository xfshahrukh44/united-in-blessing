@extends('admin.layouts.app')
@section('title', (isset($content->id) ?  'Edit' : 'Add').' Category')
@section('section')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Category Form</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active">Category Form</li>
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
                    <div class="col-md-8">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Category</h3>
                            </div>
                            <form class="category-form" method="post" action="{{!empty($content->id)?url('admin/category-edit/'.$content->id):route('admin.add-category')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    @if(Session::has('msg'))
                                        <div class="alert alert-success">{{Session::get('msg')}}</div>
                                    @endif
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Main Category</label>
                                        <select class="form-control @if(Session::has('err')) is-invalid @endif" name="main-category" id="main-category">
                                            <option value="0">Select Category</option>
                                            @foreach($mainCategories as $category)
                                                <option {{(!empty($content->parent_id)&&$content->parent_id==$category->id)||old('main-category')==$category->id?'selected':''}} value="{{$category->id}}">{{$category->name ?? ''}}</option>
                                            @endforeach
                                        </select>
                                        @if(Session::has('err'))
                                            <span class="invalid-feedback" role="alert">
                                            <strong>{{ Session::get('err') }}</strong>
                                        </span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Category Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" value="{{$content->name?? old('name')}}" placeholder="Category" required>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="category">Description</label>
                                        <textarea class="form-control" name="description" id="description" placeholder="Description" >{{$content->description?? old('description')}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="category">Meta Title</label>
                                        <input type="text" class="form-control" name="meta-title" id="meta-title"  value="{{$content->meta_tag_title?? old('meta-title')}}" placeholder="Meta Title">
                                    </div>
                                    <div class="form-group">
                                        <label for="category">Meta Description</label>
                                        <textarea class="form-control" name="meta-description" id="meta-description" placeholder="Meta Description">{{$content->meta_tag_description?? old('meta-description')}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="category">Meta Keywords</label>
                                        <textarea class="form-control" name="meta-keywords" id="meta-keywords"  placeholder="Meta Keywords">{{$content->meta_tag_keywords?? old('meta-keywords')}}</textarea>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <label for="exampleInputFile">Category Image</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="file" id="category-image">
                                                        <label class="custom-file-label" for="category-image">Choose file</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3" >
                                            <img src="{{asset(isset($content->category_image) ?'uploads/category/'.$content->category_image : 'admin/images/placeholder.png')}}" alt="" id="img_0" style="height: 150px;width: 150px;">
                                        </div>

                                    </div>

                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer text-center">
                                    <button type="submit" class="btn btn-primary btn-md">Submit</button>
                                    <a href="{{route('category')}}" class="btn btn-warning btn-md">Cancel</a>
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
