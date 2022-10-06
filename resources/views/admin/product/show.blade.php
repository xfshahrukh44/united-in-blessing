@extends('admin.layouts.app')
@section('title', $product->product_name ?? 'Product')
@section('page_css')
    <style>
        th {
            background-color: #f7f7f7;
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
                            <li class="breadcrumb-item active">Product</li>
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
                                <h3 class="card-title">Product Detail</h3>
                            </div>

                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="example1" class="table table-bordered">
                                    <tbody>
                                    <tr>
                                        <th>Product</th>
                                        <td>{{$product->product_name ?? ''}}</td>
                                        <th>Current Price</th>
                                        <td>{{$product->product_current_price??''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Description</th>
                                        <td colspan="3">{!! $product->description??'' !!}</td>
                                    </tr>
                                    <tr>
                                        <th>Additional Information</th>
                                        <td colspan="3">{!! $product->additional_information??'' !!}</td>
                                    </tr>
                                    <tr>
                                        <th>Meta Tag Title</th>
                                        <td>{{$product->product_meta_data->meta_tag_title??''}}</td>
                                        <th>Meta Tag Keywords</th>
                                        <td>{{$product->product_meta_data->meta_tag_keywords??''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Meta Tag Description</th>
                                        <td colspan="3">{{$product->product_meta_data->meta_tag_description??''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Gallery</th>
                                        <td colspan="5">
                                            @foreach($product->product_images as $product_image)
                                                <img src="{{asset('uploads/products/'.$product_image->product_images)}}"
                                                     width="100px" height="100px">
                                            @endforeach
                                        </td>
                                    </tr>
{{--                                    <tr>--}}
{{--                                        <th>Ribbons</th>--}}
{{--                                        <td colspan="5">--}}
{{--                                            @foreach($product->product_ribbons as $product_image)--}}
{{--                                                <img src="{{asset('uploads/products/'.$product_image->product_images)}}"--}}
{{--                                                     width="100px" height="100px">--}}
{{--                                            @endforeach--}}
{{--                                        </td>--}}
{{--                                    </tr>--}}
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

    </div>
@endsection
