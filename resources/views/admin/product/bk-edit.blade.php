@extends('admin.layouts.app')
@section('title', 'Edit '. ($product->product_name ?? '') .' Product')
@section('section')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.css" />
    <link rel="stylesheet" href="{{ asset('admin/dropzone/dist/basic.css') }}">
    <style>
        .switch {
            position: relative;
            display: block;
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

        .help-block{
            color:red;
        }
        .has-error{
            border-block-color: red;
        }
    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Product Form</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Product Form</li>
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
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" aria-current="page" href="#product" role="tab" data-toggle="tab">General</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#additionalImages" role="tab" data-toggle="tab">Additional Images</a>
                                    </li>
                                    {{-- <li class="nav-item">
                                        <a class="nav-link" href="#attributes" role="tab" data-toggle="tab">Attributes</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#options" role="tab" data-toggle="tab">Options</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#related_products" role="tab" data-toggle="tab">Related Products</a>
                                    </li> --}}
                                </ul>
                            </div>
                            <form class="category-form" method="post" action="{{url('admin/product').'/'.$product->id}}" enctype="multipart/form-data">
                                <div class="tab-content ">
                                    <div class="tab-pane active" role="tabpanel" class="tab-pane fade in active" id="product">
                                        @method('put')
                                        @csrf
                                        <div class="card-body">
                                            <div class="row">
                                                {{-- <div class="col">
                                                    <label for="exampleInputEmail1">Main Category*</label>
                                                    <select class="form-control {{ $errors->has('main_category') ? 'has-error' : ''}}" name="main_category" id="main-category" required>
                                                        <option value="">Select Category</option>
                                                        @foreach($mainCategories as $category)
                                                            <option value="{{$category->id}}" @if($product->category_id == $category->id) selected @endif>{{$category->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    {!! $errors->first('main_category', '<p class="help-block">:message</p>') !!}
                                                </div> --}}
                                                {{-- <div class="col">
                                                    <label for="exampleInputEmail1">Sub Category</label>
                                                    <select class="form-control" name="sub_category" id="sub-category">
                                                        @foreach($subCategories as $subcategory)
                                                            <option value="{{$subcategory->id}}" @if($product->sub_category_id == $subcategory->id) selected @endif>{{$subcategory->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div> --}}
                                                <div class="col">
                                                    <label for="exampleInputEmail1">Manufacturer</label>
                                                    <select class="form-control" name="manufacturer" id="manufacturer" required>
                                                        <option value="">Select Manufacturer</option>
                                                        @foreach($manufacturers as $manufacturer)
                                                            <option value="{{$manufacturer->id}}" @if($manufacturer->id == $product->manufacturer_id) selected @endif>{{$manufacturer->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <label for="exampleInputEmail1">Product Featured/New</label>
                                                    <select name="product_featured" id="" class="form-control">
                                                        <option value="Feature" @if($product->product_type == "Featured") selected @endif>Featured</option>
                                                        <option value="New" @if($product->product_type == "New") selected @endif>New</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col">
                                                    <label for="exampleInputEmail1">Product Name*</label>
                                                    <input type="text" name="product_name" placeholder="Product Name" class="form-control {{ $errors->has('product_name') ? 'has-error' : ''}}" value="{{$product->product_name}}" required>
                                                    {!! $errors->first('product_name', '<p class="help-block">:message</p>') !!}
                                                </div>

                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col">
                                                    <label for="exampleInputEmail1">Current Price*</label>
                                                    <input type="number" name="current_price" placeholder="Current Price" class="form-control {{ $errors->has('current_price') ? 'has-error' : ''}}" value="{{$product->product_current_price}}" required>
                                                    {!! $errors->first('current_price', '<p class="help-block">:message</p>') !!}
                                                </div>
                                                <div class="col">
                                                    <label for="exampleInputEmail1">Product SKU*</label>
                                                    <input type="text" name="product_sku" placeholder="Product SKU" class="form-control {{ $errors->has('product_sku') ? 'has-error' : ''}}" value="{{$product->sku}}" id="product_sku" required>
                                                    <span id="sku_span"></span>
                                                    {!! $errors->first('product_sku', '<p class="help-block">:message</p>') !!}
                                                </div>
                                                <div class="col">
                                                    <label for="exampleInputEmail1">Product Slug*</label>
                                                    <input type="text" name="product_slug" class="form-control {{ $errors->has('product_slug') ? 'has-error' : ''}}" placeholder="Product Slug" id="product_slug" value="{{$product->slug}}" required>
                                                    <span id="slug_span"></span>
                                                    {!! $errors->first('product_slug', '<p class="help-block">:message</p>') !!}
                                                </div>

                                            </div>
                                            <br>
                                            <br>
                                            <div class="row">
                                                {{-- <div class="col">
                                                    <label for="exampleInputEmail1">Product Sale</label>
                                                    <input type="checkbox" name="product_sale" class="form-control" id="product_sale" style="height: 20px;width: 20px;" value="yes" @if($product->product_sale == "yes") checked @endif>
                                                </div>
                                                <div class="col">
                                                    <label for="exampleInputEmail1">Sale(%)</label>
                                                    <input type="text" name="product_sale_percentage" placeholder="10" class="form-control" @if($product->product_sale == "no") readonly @endif id="product_sale_percentage" value="{{$product->product_sale_percentage}}" required>
                                                </div> --}}
                                                <div class="col">
                                                    <label for="exampleInputEmail1">Product Stock</label>
                                                    <input type="checkbox" name="product_stock" class="form-control" id="product_stock" style="height: 20px;width: 20px;" value="yes" @if($product->product_stock == "yes") checked @endif>
                                                </div>
                                                <div class="col">
                                                    <label for="exampleInputEmail1">Product Stock Qty</label>
                                                    <input type="text" name="product_stock_qty" class="form-control" placeholder="10" @if($product->product_stock == "no") readonly @endif id="product_stock_qty" value="{{$product->product_qty}}" required>
                                                </div>
                                                <div class="col">
                                                    <label for="switch">Status</label>
                                                    <label class="switch"><input type="checkbox" @if($product->status == 1) checked @endif data-id="" id="status-switch" name="status" value="1">
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                {{-- <div class="col">
                                                    <label for="exampleInputEmail1">Length</label>
                                                    <input type="text" name="length" placeholder="Length" class="form-control" id="length" value="{{$product->length}}">
                                                </div> --}}
                                                <div class="col">
                                                    <label for="exampleInputEmail1">Width</label>
                                                    <input type="text" name="width" class="form-control" placeholder="Width" id="width" value="{{$product->width}}">
                                                </div>
                                                {{-- <div class="col">
                                                    <label for="exampleInputEmail1">Height</label>
                                                    <input type="text" name="height" class="form-control" id="height" placeholder="Height" value="{{$product->height}}">
                                                </div>
                                                <div class="col">
                                                    <label for="exampleInputEmail1">Weight</label>
                                                    <input type="text" name="weight" class="form-control" id="weight" value="{{$product->weight}}" placeholder="Weight">
                                                </div> --}}
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="category">Description</label>
                                                    <textarea class="form-control {{ $errors->has('main_category') ? 'has-error' : ''}}" name="description" id="description" placeholder="Description" required>{{$product->description}}</textarea>
                                                    {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col">
                                                    <label for="category">Meta Title</label>
                                                    <input type="text" class="form-control" name="meta-title" id="meta-title"  value="{{$product->product_meta_data->meta_tag_title ?? ''}}" placeholder="Meta Title">
                                                </div>
                                                <div class="col">
                                                    <label for="category">Meta Description</label>
                                                    <textarea class="form-control" name="meta-description" id="meta-description" placeholder="Meta Description">{{$product->product_meta_data->meta_tag_description ?? ''}}</textarea>
                                                </div>
                                                <div class="col">
                                                    <label for="category">Meta Keywords</label>
                                                    <textarea class="form-control" name="meta-keywords" id="meta-keywords"  placeholder="Meta Keywords">{{$product->product_meta_data->meta_tag_keywords ?? ''}}</textarea>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <th>Placeholder</th>
                                                        <th>Select Image</th>
                                                    </tr>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <img src="{{ productImage(@$product->product_image) }}" alt="" id="img_0" style="height: 150px;width: 150px;">
                                                            </td>
                                                            <td>
                                                                <div class="input-group">
                                                                    <div class="custom-file">
                                                                        <input type="file" class="custom-file-input"  name="product_image_first" id="gallery_0" onchange="PreviewImage('0')"   accept="image/*">
                                                                        <label class="custom-file-label" for="category-image">Choose file</label>
                                                                    </div>
                                                                    {!! $errors->first('product_image_first', '<p class="help-block">:message</p>') !!}
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <br>
{{--                                            <div class="row justify-content-center" >--}}
{{--                                                <h4>Additional Images</h4>--}}
{{--                                            </div>--}}
{{--                                            @php--}}
{{--                                                $counter = 0;--}}
{{--                                            @endphp--}}
{{--                                            @forelse($product->product_images as $product_image)--}}
{{--                                                @php--}}
{{--                                                    $counter++;--}}
{{--                                                @endphp--}}
{{--                                                <div class="row" id="row_{{$counter}}">--}}
{{--                                                    <div class="col-md-4" >--}}
{{--                                                        <img src="{{ productImage(@$product_image->product_images) }}" alt="" id="img_{{$counter}}" style="height: 150px;width: 150px;">--}}
{{--                                                        <input type="hidden" name="saved_images[]" value="{{$product_image->id ?? ''}}">--}}
{{--                                                    </div>--}}
{{--                                                    <div class="col-md-8">--}}
{{--                                                        <label for="exampleInputFile"></label>--}}
{{--                                                        <div class="input-group">--}}
{{--                                                            <div class="custom-file">--}}
{{--                                                                <input type="file" class="custom-file-input" name="product_image[]" id="gallery_{{$counter}}" onchange="PreviewImage({{$counter}})" accept="image/*">--}}
{{--                                                                <label class="custom-file-label" for="category-image">Choose file</label>--}}
{{--                                                            </div>--}}
{{--                                                            @if($loop->first)--}}
{{--                                                                <input type="button" class="btn btn-primary" id="addMoreBtn" value="+" onclick="addMorePictures(1)"/>--}}
{{--                                                            @else--}}
{{--                                                                <input type="button" class="btn btn-danger btn-md" id="removeMoreBtn" onclick="removeImgRow('{{$counter}}')" value="-"/>--}}
{{--                                                            @endif--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            @empty--}}
{{--                                                <div class="row">--}}
{{--                                                    <div class="col-md-4" >--}}
{{--                                                        <img src="{{asset('admin/images/placeholder.png')}}" alt="image 2" id="img_1" style="height: 150px;width: 150px;">--}}
{{--                                                    </div>--}}
{{--                                                    <div class="col-md-8">--}}
{{--                                                        <label for="exampleInputFile"></label>--}}
{{--                                                        <div class="input-group">--}}
{{--                                                            <div class="custom-file">--}}
{{--                                                                <input type="file" class="custom-file-input" name="product_image[]" id="gallery_1" onchange="PreviewImage('1')" accept="image/*">--}}
{{--                                                                <label class="custom-file-label" for="category-image">Choose file</label>--}}
{{--                                                            </div>--}}
{{--                                                            <input type="button" class="btn btn-primary" id="addMoreBtn" value="+" onclick="addMorePictures(1)"/>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            @endforelse--}}
{{--                                            <br>--}}
{{--                                            <div id="add_more"></div>--}}
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="gallery"></div>
                                        </div>
                                </div>
                                    <!-- /.card-body -->
                                    <div class="tab-pane" role="tabpanel" class="tab-pane fade in active" id="additionalImages">
                                        <div class="col-md-12 text-right">
                                        </div>
                                        <table class="table">
                                            <tr>
                                                <th  colspan="3" class="text-right">       
                                                    <input type="button" class="btn btn-primary" id="addMoreBtn" value="Add More Images" onclick="addMorePictures(1)"/>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>Product Image</th>
                                                <th>Select Image</th>
                                            </tr>
                                            <tbody id="add_more">
                                            @php
                                                $counter = 0;
                                            @endphp
                                            @forelse($product->product_images as $product_image)
                                                @php
                                                    $counter++;
                                                @endphp
                                                    <tr id="row_{{$counter}}">
                                                        <td class="col-md-2">
                                                            <img src="{{ productImage(@$product_image->product_images) }}" alt="" id="img_{{$counter}}" style="height: 150px;width: 150px;">
                                                            <input type="hidden" name="saved_images[]" value="{{$product_image->id ?? ''}}">
                                                        </td>
                                                        <td>
                                                            <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" name="product_image[]" id="gallery_1" onchange="PreviewImage('1')" accept="image/*">

                                                                    <label class="custom-file-label" for="category-image">Choose file</label>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="col-md-1">
                                                        {{--                                                            
                                                            @if($loop->first)
                                                                <input type="button" class="btn btn-primary" id="addMoreBtn" value="+" onclick="addMorePictures(1)"/>
                                                            @else
                                                                <input type="button" class="btn btn-danger btn-md" id="removeMoreBtn" onclick="removeImgRow('{{$counter}}')" value="-"/>
                                                            @endif 
                                                            
                                                            --}}
                                                            <input type="button" class="btn btn-danger btn-md" id="removeMoreBtn" onclick="removeImgRow('{{$counter}}')" value="-"/>
                                                            
                                                        </td>
                                                    </tr>
                                                @empty
                                                    {{-- <tr id="row_0">
                                                        <td>
                                                            <img src="{{asset('admin/images/placeholder.png')}}" alt="image 2" id="img_1" style="height: 150px;width: 150px;">
                                                        </td>
                                                        <td>
                                                            <div class="input-group">
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" name="product_image[]" id="gallery_1" onchange="PreviewImage('1')" accept="image/*">
                                                                    <label class="custom-file-label" for="category-image">Choose file</label>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <input type="button" class="btn btn-primary" id="addMoreBtn" value="+" onclick="addMorePictures(1)"/>
                                                        </td>
                                                    </tr> --}}
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane" role="tabpanel" class="tab-pane fade in active" id="attributes">
                                        <div class="col-md-12 text-right">
                                            <input type="button" class="btn btn-primary btn-sm" value="Add Attribute" onclick="addMoreAttributes()" style="margin-top: 10px;margin-bottom: 10px;">
                                        </div>
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Attribute</th>
                                                <th>Value</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody id="add_more_attr">
                                            @php $attributeCounter = 0; @endphp
                                            @foreach($product->products_attributes as $products_attribute)
                                                @php $attributeCounter++ @endphp
                                                <tr id="row_attr_{{$attributeCounter}}">
                                                    <td>
                                                        <select id="dino-select" class="form-control" name="attribute[]" required>
                                                            <option value="">Select Attribute</option>
                                                            @foreach($attributeGroups as $attributeGroup)
                                                                <optgroup label="{{$attributeGroup->attribute_group}}">
                                                                    @foreach($attributeGroup->attributes as $attributes)
                                                                        <option value="{{$attributes->id}}" @if($products_attribute->attribute_id == $attributes->id) selected @endif>{{$attributes->attribute_name}}</option>
                                                                    @endforeach
                                                                </optgroup>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td><input type="text" class="form-control" value="{{$products_attribute->value}}" name="attribute_value[]" required></td>
                                                    <td>
                                                        <input type="button" class="btn btn-danger btn-md" value="-" onclick="removeAttrRow({{$attributeCounter}})" id="add_more_attr_btn">
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane" role="tabpanel" class="tab-pane fade in active" id="options">
                                        <div class="col-md-12 text-right">
                                            <input type="button" class="btn btn-primary btn-sm" value="Add Options" onclick="addMoreOptions()" style="margin-top: 10px;margin-bottom: 10px;">
                                        </div>
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Option</th>
                                                <th>Option Value</th>
                                                <th>Price</th>
                                                <th>Qty</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody id="add_more_option">
                                            @php $optionCounter = 0; @endphp
                                            @foreach($product->products_options as $products_options)
                                                @php $optionCounter++ @endphp
                                                    <tr id="row_option_{{$optionCounter}}">
                                                        <td>
                                                            <select id="option_id" class="form-control" name="option_id[]" onchange="getOptionValues('{{$optionCounter}}',this.value)" required>
                                                                <option value="">Select Option</option>
                                                                @foreach($options as $option)
                                                                    <option value="{{$option->id}}" @if($products_options->option_id == $option->id) selected @endif>{{$option->option_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select id="option_value_id_{{$optionCounter}}" class="form-control" name="option_value_id[]" required>
                                                                <option value="">Select Option Value</option>
                                                                @foreach($products_options->option_val as $option_val)
                                                                    <option value="{{$option_val->id}}" selected>{{$option_val->option_value}}</option>
                                                                @endforeach
                                                            </select>
                                                        </td>
                                                        <td><input type="number" class="form-control" value="{{$products_options->price}}" name="option_value_price[]" required></td>
                                                        <td><input type="number" class="form-control" value="{{$products_options->qty}}" name="option_value_qty[]" required></td>
                                                        <td>
                                                            <input type="button" class="btn btn-danger btn-md" value="-" onclick="removeOptionRow({{$optionCounter}})" id="add_more_attr_btn">
                                                        </td>
                                                    </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="tab-pane" role="tabpanel" class="tab-pane fade in active" id="related_products">
                                        <div class="col-md-12 text-right">
                                            <input type="button" class="btn btn-primary btn-sm" value="Add Related Product" onclick="addMoreRelatedProducts()" style="margin-top: 10px;margin-bottom: 10px;">
                                        </div>
                                        <table class="table table-bordered">
                                            <thead>
                                            <tr>
                                                <th>Product Name</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody id="add_more_related">
                                            @php $relatedProdCounter = 0; @endphp
                                            @foreach($relatedProducts as $rProduct)
                                                @php $relatedProdCounter++; @endphp
                                                <tr id="row_related_{{$relatedProdCounter}}" class="row_related_prod">
                                                    <td>
                                                        <select id="related_prod_id_{{$relatedProdCounter}}" class="form-control related_prod" name="related_prod_id[]" required>
                                                            <option value="{{$rProduct->related_id}}">{{ $rProduct->products[0]->product_name }}</option>
                                                        </select>
                                                    </td>
                                                    <td><input type="button" class="btn btn-danger btn-md" value="-" onclick="removeRelatedProdRow({{$relatedProdCounter}})"></td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary" id="submit_btn" style="">Submit</button>
                                    <a href="{{route('product.index')}}" class="btn btn-warning" id="" style="">Cancel</a>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
    </div>
    </div>
@endsection
@section('script')

    <script src="{{ asset('admin/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('admin/dropzone/dist/dropzone.js') }}"></script>
    <script type="text/javascript">
        window.onload = function () {
            CKEDITOR.replace('description', {
                {{--filebrowserUploadUrl: '{{ route('project.document-image-upload',['_token' => csrf_token() ]) }}',--}}
                {{--filebrowserUploadMethod: 'form'--}}
            });
        };


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        //Dependent Category
        $(document).ready(function () {
            $('#main-category').on('change',function(e) {
                var cat_id = e.target.value;
                $.ajax({
                    url:"{{ route('getSubCategories') }}",
                    type:"Get",
                    data: {
                        cat_id: cat_id
                    },
                    success:function (data) {
                        $('#sub-category').empty();
                        $.each(data.subcategories,function(index,subcategory){
                            $('#sub-category').append('<option value="'+subcategory.id+'">'+subcategory.name+'</option>');
                        })
                    }
                })
            });

            //Check Product SKU
            $('#product_sku').on('blur',function(e) {
                var sku = e.target.value;
                $.ajax({
                    url:"{{ route('checkProductSku') }}",
                    type:"Get",
                    data: {
                        sku: sku
                    },
                    success:function (data) {
                        if(data.product_sku > 0){
                            $('#sku_span').html(`<p style="color:red">SKU Already exist!</p>`);
                            $(':input[type="submit"]').prop('disabled', true);
                        }else{
                            $('#sku_span').empty();
                            $(':input[type="submit"]').prop('disabled', false);
                        }

                    }
                })
            });

            //Check Product Slug
            $('#product_slug').on('blur',function(e) {
                var slug = e.target.value;
                $.ajax({
                    url:"{{ route('checkProductSlug') }}",
                    type:"Get",
                    data: {
                        slug: slug
                    },
                    success:function (data) {
                        if(data.product_slug > 0){
                            $('#slug_span').html(`<p style="color:red">SLUG Already exist!</p>`);
                            $(':input[type="submit"]').prop('disabled', true);
                        }else{
                            $('#slug_span').empty();
                            $(':input[type="submit"]').prop('disabled', false);
                        }

                    }
                })
            });

            $('#product_sale').on('click',function (e){
                if($('#product_sale').prop('checked') == true){
                    $('#product_sale_percentage').prop('readonly', false);
                }else{
                    $('#product_sale_percentage').prop('readonly', true);
                }
            });

            $('#product_stock').on('click',function (e){
                if($('#product_stock').prop('checked') == true){
                    $('#product_stock_qty').prop('readonly', false);
                }else{
                    $('#product_stock_qty').prop('readonly', true);
                }
            });
        });

        var counter = @if($counter) {{$counter}} @else 0 @endif;
        function addMorePictures(){
            counter++;
            $('#add_more').append(`<tr id="row_${counter}">
                                        <td class="col-md-4" >
                                            <img src="{{asset('admin/images/placeholder.png')}}" alt="" id="img_${counter}" style="height: 150px;width: 150px;">
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="product_image[]"  id="gallery_${counter}" onchange="PreviewImage('${counter}')" accept="image/*">
                                                    <label class="custom-file-label" for="category-image">Choose file</label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="button" class="btn btn-danger btn-md" id="removeMoreBtn" onclick="removeImgRow('${counter}')" value="-"/>
                                        </td></tr>`);

        }

        function removeImgRow(counter){
            $('#row_'+counter).remove();
        }

        function PreviewImage(counter) {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById('gallery_'+counter).files[0]);

            oFReader.onload = function (oFREvent) {
                document.getElementById('img_'+counter).src = oFREvent.target.result;
            };
        }

        var counter1 = @if($attributeCounter) {{$attributeCounter}} @else 0 @endif;
        function addMoreAttributes(){
            counter1++;
            $('#add_more_attr').append(`<tr id="row_attr_${counter1}">
                                        <td>
                                            <select id="dino-select" class="form-control" name="attribute[]" required>
                                            <option value="">Select Attribute</option>
                                            @foreach($attributeGroups as $attributeGroup)
            <optgroup label="{{$attributeGroup->attribute_group}}">
                                            @foreach($attributeGroup->attributes as $attributes)
            <option value="{{$attributes->id}}">{{$attributes->attribute_name}}</option>
                                            @endforeach
            </optgroup>
@endforeach
            </select>
        </td>
        <td><input type="text" class="form-control" value="" name="attribute_value[]" required></td>
        <td><input type="button" class="btn btn-danger btn-md" value="-" onclick="removeAttrRow(${counter1})" id="add_more_attr_btn"></td></tr>`);
        }

        function removeAttrRow(counter){
            $('#row_attr_'+counter).remove();
        }

        //Dependent OPtion
        function getOptionValues(counter,val) {
            var option_id = val;
            if(option_id !== ''){
                $.ajax({
                    url:"{{ route('getOptionValues') }}",
                    type:"Get",
                    data: {
                        option_id: option_id
                    },
                    success:function (data) {
                        $('#option_value_id_'+counter).empty();
                        $.each(data.OptionValues,function(index,val){
                            $('#option_value_id_'+counter).append('<option value="'+val.id+'">'+val.option_value+'</option>');
                        })
                    }
                })
            }
        }

        var counterO = @if($optionCounter) {{$optionCounter}} @else 0 @endif;
        function addMoreOptions(){
            counterO++;
            $('#add_more_option').append(`<tr id="row_option_${counterO}"><td>
                                            <select id="option_id_${counterO}" class="form-control" name="option_id[]" onchange="getOptionValues(${counterO},this.value)" required>
                                                <option value="">Select Option</option>
                                                @foreach($options as $option)
                                                    <option value="{{$option->id}}">{{$option->option_name}}</option>
                                                @endforeach
                                             </select>
                                        </td>
                                        <td>
                                        <select id="option_value_id_${counterO}" class="form-control" name="option_value_id[]" required></select>
                                            </td>
                                            <td><input type="number" class="form-control" value="" name="option_value_price[]" required></td>
                                            <td><input type="number" class="form-control" value="" name="option_value_qty[]" required></td>
                                            <td><input type="button" class="btn btn-danger btn-md" value="-" onclick="removeOptionRow(${counterO})"></td>
                                        </tr>`);
        }
        function removeOptionRow(counter){
            $('#row_option_'+counter).remove();
        }
        /* Related product functions start */
        var counter2 = '{{++$relatedProdCounter}}';
        function addMoreRelatedProducts(){
            $("#add_more_related").append(`<tr id="row_related_${counter2}" class="row_related_prod"><td>
                <select id="related_prod_id_${counter2}" class="form-control related_prod" name="related_prod_id[]" required>
                   <option value="">Select Product</option>
                   @foreach($products as $product)
                <option value="{{$product->id}}">{{$product->product_name}}</option>
                   @endforeach
                </select>
                </td>
                <td><input type="button" class="btn btn-danger btn-md" value="-" onclick="removeRelatedProdRow(${counter2})"></td>
                </tr>`);
            makeRelatedProdArray();
            removeRelatedProdOption(counter2);
            counter2++;
        }


        var relatedProdOptions = [];
        function makeRelatedProdArray() {
            $('.row_related_prod').each(function (i, o) {
                var closestParent = $(this).closest('tr');
                var value = closestParent.find('.related_prod').val();
                if (value != null && value !== '' && relatedProdOptions.includes(value) === false) {
                    relatedProdOptions.push(value);
                }
            });
        }
        makeRelatedProdArray();
        function removeRelatedProdOption(id){
            relatedProdOptions.forEach(function (i, v) {
                $("#related_prod_id_"+id+" option[value='"+i+"']").remove();
            })
        }
        function removeRelatedProdRow(counter){
            var value = $('#row_related_'+counter).find('.related_prod').val();
            if (value != null && value !== '' && relatedProdOptions.includes(value) === true) {
                const index = relatedProdOptions.indexOf(value);
                if (index > -1) {
                    relatedProdOptions.splice(index, 1);
                }
            }
            $('#row_related_'+counter).remove();
        }
        /* Related product functions end */
    </script>
@endsection
