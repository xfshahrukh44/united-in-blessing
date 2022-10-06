@extends('admin.layouts.app')
@section('title','Collection Products Create')
@section('section')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-selection__choice{
            background-color: #504a4a !important;
            padding: 1px !important;
        }
    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Collection Products Form</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active">Collection Products Form</li>
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
                                <h3 class="card-title">Collection Products </h3>
                            </div>
                            <form class="category-form" method="post" action="{{route('collectionProducts.store')}}" enctype="multipart/form-data">
                                @csrf
                                <div class="card-body">
                                    @if(Session::has('msg'))
                                        <div class="alert alert-success">{{Session::get('msg')}}</div>
                                    @endif
                                    @if($errors->any())
                                        {!! implode('', $errors->all('<div class="text-center" style="color:red">:message</div>')) !!}
                                    @endif
                                    <div class="form-group">
                                        <label for="name">Collection</label>
                                        <select name="collection_id"  class="form-control @error('collection_id') is-invalid @enderror" id="collection_id" required>
                                            <option value="">Select Collection</option>
                                            @foreach($collections as $collection)
                                                <option value="{{$collection->id}}" @if($collection->id == old('collection_id')) selected @endif>{{$collection->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('collection_id')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Products</label>
                                        <select name="product_id[]"  class="form-control @error('product_id') is-invalid @enderror" id="product_id" multiple required>
                                            @foreach($products as $product)
                                                <option value="{{$product->id}}" @if($product->id == old('product_id')) selected @endif>{{$product->product_name}}</option>
                                            @endforeach
                                        </select>
                                        @error('product_id')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer text-center">
                                    <button type="submit" class="btn btn-primary btn-md">Submit</button>
                                    <a href="{{route('collectionProducts.index')}}" class="btn btn-warning btn-md">Cancel</a>
                                </div>
                            </form>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js" defer></script>
    <script>
        $('document').ready(function () {
            $('#product_id').select2();
        });
    </script>
@endsection
