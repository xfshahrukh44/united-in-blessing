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
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                    <tr>
                                        <th>Product</th>
                                        <td colspan="5">{{$product->product_name??''}}</td>
                                    </tr>

                                    <tr>
                                        <th>Category</th>
                                        <td colspan="2">{{$product->category->name??''}}</td>
                                        <th>Sub-Category</th>
                                        <td colspan="2">{{$product->sub_category->name??''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Slug</th>
                                        <td colspan="2">{{$product->slug??''}}</td>
                                        <th>SKU</th>
                                        <td colspan="2">{{$product->sku??''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Current Price</th>
                                        <td colspan="2">{{$product->product_current_price??''}}</td>
                                        <th>Product Sale</th>
                                        <td colspan="2">{{$product->product_sale??''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Product Sale %</th>
                                        <td colspan="2">{{$product->product_sale_percentage??''}}</td>
                                        <th>Product Stock</th>
                                        <td colspan="2">{{$product->product_stock??''}}</td>
                                       
                                    </tr>
                                    <tr>
                                        <th>Meta Tag Title</th>
                                        <td colspan="2">{{$product->product_meta_data->meta_tag_title??''}}</td>
                                        <th>Product Qty</th>
                                        <td>{{$product->product_qty??''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Description</th>
                                        <td colspan="5"> {!! $product->description??'' !!}</td>
                                    </tr>

                                    <tr>
                                        <th>Meta Tag Keywords</th>
                                        <td colspan="5">{{$product->product_meta_data->meta_tag_keywords??''}}</td>
                                    
                                    </tr>
                                    <tr>
                                        <th>Meta Tag Description</th>
                                        <td colspan="5">{{$product->product_meta_data->meta_tag_description??''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Attributes</th>
                                        <td colspan="5">
                                            @foreach($product->products_attributes as $products_attribute)
                                                {{$products_attribute->attribute->attribute_name??''}} - {{$products_attribute->value??''}}
                                                <br>
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Options (Price - Qty)</th>
                                        <td colspan="5">
                                            @foreach($product->products_options as $products_options)
                                                @foreach($products_options->option_val as $option_value)
                                                {{$products_options->option->option_name??''}} - {{$option_value->option_value??''}} - {{$products_options->price}} - {{$products_options->qty}}
                                                <br>
                                                @endforeach
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Width</th>
                                        <td colspan="2">{{$product->width??''}}</td>
                                        <th>Height</th>
                                        <td colspan="2">{{$product->height??''}}</td>

                                    </tr>
                                    <tr>
                                        <th>Length</th>
                                        <td colspan="2">{{$product->length??''}}</td>
                                        <th>Weight</th>
                                        <td colspan="2">{{$product->weight??''}}</td>
                                    </tr>
                                    <tr>
                                        <th>Image</th>
                                        <td colspan="5">
                                            <img src="{{productImage(@$product->product_image)}}" width="100px" height="100px">
                                            @foreach($product->product_images as $product_image)
                                                <img src="{{productImage(@$product_image->product_images)}}" width="100px" height="100px">
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Manufacturer</th>
                                        <td colspan="5">
                                            {{$product->manufacturer->name ?? ''}}
                                        </td>
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

    </div>
@endsection
