@extends('admin.layouts.app')
@section('title', 'Add Product')
@section('section')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.css"/>
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

        .help-block {
            color: red;
        }

        .has-error {
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
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Product Form</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content-header -->

        <section class="content">
            <div class="container-fluid">
                {{-- <div id="product-root"></div>--}}

                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <form class="category-form" method="post" action="{{route('product.store')}}"
                              enctype="multipart/form-data">
                        @csrf
                        <!-- general form elements -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                            <a class="nav-link active" aria-current="page" href="#product" role="tab"
                                               data-toggle="tab">General</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#galleryImages" role="tab" data-toggle="tab">Product
                                                Images</a>
                                        </li>
                                        {{-- <li class="nav-item">--}}
                                        {{-- <a class="nav-link" href="#ribbons" role="tab" data-toggle="tab">Ribbons</a>--}}
                                        {{-- </li>--}}
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content ">
                                        <div class="tab-pane active" role="tabpanel" id="product">

                                            <div class="row">
                                                <div class="col">
                                                    <label for="exampleInputEmail1">Product Name*</label>
                                                    <input type="text" name="product_name" placeholder="Product Name"
                                                           class="form-control {{ $errors->has('product_name') ? 'has-error' : ''}}"
                                                           value="{{old('product_name')}}" required>
                                                    {!! $errors->first('product_name', '<p class="help-block">:message</p>') !!}
                                                </div>
                                                <div class="col">
                                                    <label for="exampleInputEmail1">Current Price*</label>
                                                    <input type="number" step="0.01" name="product_current_price"
                                                           placeholder="Current Price"
                                                           class="form-control {{ $errors->has('product_current_price') ? 'has-error' : ''}}"
                                                           value="{{old('product_current_price')}}" required>
                                                    {!! $errors->first('product_current_price', '<p class="help-block">:message</p>') !!}
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="category_id">Select Category</label>
                                                    <select name="category_id" id="category_id"
                                                            class="form-control {{ $errors->has("category_id") ? 'has-error' : '' }}"
                                                            value="{{ old('category_id') }}">
                                                        <option value="">Select Category</option>
                                                        @foreach($categories as $category)
                                                            <option
                                                                value="{{ $category->id }}" {{ ($category->id == 1) ? 'selected' : '' }}>{{ $category->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    {!! $errors->first('category_id') !!}
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col">
                                                    <label for="product_weight">Product Weight* (LBS)</label>
                                                    <input type="number" step=".01" name="weight"
                                                           placeholder="Product Weight"
                                                           class="form-control {{ $errors->has('weight') ? 'has-error' : ''}}"
                                                           required>
                                                    {!! $errors->first('weight', '<p class="help-block">:message</p>') !!}
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="product_stock">Stock</label>
                                                    <select name="product_stock" id="product_stock"
                                                            class="form-control {{ $errors->has('product_stock') ? 'has-error' : '' }}"
                                                            value="{{ old('category_id') }}">
                                                        <option value="">Select Stock Status</option>
                                                        <option value="yes">In Stock</option>
                                                        <option value="no">Out Of Stock</option>
                                                    </select>
                                                    {!! $errors->first('category_id') !!}
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="category">Description</label>
                                                    <textarea class="form-control" name="description" id="description"
                                                              placeholder="Description"
                                                              required>{{old('description')}}</textarea>
                                                    {!! $errors->first('description', '<p class="help-block">:message</p>') !!}
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="category">Additional Information</label>
                                                    <textarea class="form-control" name="additional_information"
                                                              id="additional_information"
                                                              placeholder="Additional Information"
                                                              required>{{old('additional_information')}}</textarea>
                                                    {!! $errors->first('additional_information', '<p class="help-block">:message</p>') !!}
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col">
                                                    <label for="category">Meta Title</label>
                                                    <input type="text"
                                                           class="form-control {{ $errors->has('meta-title') ? 'has-error' : ''}}"
                                                           name="meta-title" id="meta-title"
                                                           value="{{old('meta-title')}}" placeholder="Meta Title">
                                                    {!! $errors->first('meta-title', '<p class="help-block">:message</p>') !!}
                                                </div>
                                                <div class="col">
                                                    <label for="category">Meta Description</label>
                                                    <textarea
                                                        class="form-control {{ $errors->has('meta-description') ? 'has-error' : ''}}"
                                                        name="meta-description" id="meta-description"
                                                        placeholder="Meta Description">{{old('meta-description')}}</textarea>
                                                    {!! $errors->first('meta-description', '<p class="help-block">:message</p>') !!}
                                                </div>
                                                <div class="col">
                                                    <label for="category">Meta Keywords</label>
                                                    <textarea
                                                        class="form-control {{ $errors->has('meta-keywords') ? 'has-error' : ''}}"
                                                        name="meta-keywords" id="meta-keywords"
                                                        placeholder="Meta Keywords">{{old('meta-keywords')}}</textarea>
                                                    {!! $errors->first('meta-keywords', '<p class="help-block">:message</p>') !!}
                                                </div>
                                            </div>
                                            <br>
                                        </div>
                                        <div class="tab-pane" role="tabpanel" id="galleryImages">
                                            <table class="table">
                                                <tr>
                                                    <th>Product Image</th>
                                                    <th>Select Image</th>
                                                </tr>
                                                <tbody id="add_more">
                                                <tr>
                                                    <td class="col-md-2">
                                                        <img src="{{asset('admin/images/placeholder.png')}}" alt=""
                                                             id="img_1" style="height: 150px;width: 150px;">
                                                    </td>
                                                    <td>
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input"
                                                                       name="product_image[]" id="gallery_1"
                                                                       onchange="PreviewImage('1')" accept="image/*">
                                                                <label class="custom-file-label" for="category-image">Choose
                                                                    file</label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="col-md-1">
                                                        <input type="button" class="btn btn-md btn-primary" value="+"
                                                               onclick="addMorePictures(1)"/>
                                                    </td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        {{-- <div class="tab-pane" role="tabpanel" id="ribbons">--}}
                                        {{-- <table class="table">--}}
                                        {{-- <tr>--}}
                                        {{-- <th>Ribbon Image</th>--}}
                                        {{-- <th>Select Image</th>--}}
                                        {{-- </tr>--}}
                                        {{-- <tbody id="add_more_ribbon">--}}
                                        {{-- <tr>--}}
                                        {{-- <td class="col-md-2">--}}
                                        {{-- <img src="{{asset('admin/images/placeholder.png')}}" alt=""--}}
                                        {{-- id="rb_img_1" style="height: 150px;width: 150px;">--}}
                                        {{-- </td>--}}
                                        {{-- <td>--}}
                                        {{-- <div class="input-group">--}}
                                        {{-- <div class="custom-file">--}}
                                        {{-- <input type="file" class="custom-file-input"--}}
                                        {{-- name="ribbon_images[]" id="rb_gallery_1"--}}
                                        {{-- onchange="PreviewRBImage('1')" accept="image/*">--}}
                                        {{-- <label class="custom-file-label" for="category-image">Choose--}}
                                        {{-- file</label>--}}
                                        {{-- </div>--}}
                                        {{-- </div>--}}
                                        {{-- </td>--}}
                                        {{-- <td class="col-md-1">--}}
                                        {{-- <input type="button" class="btn btn-md btn-primary"--}}
                                        {{-- value="+" onclick="addMoreRibbons(1)"/>--}}
                                        {{-- </td>--}}
                                        {{-- </tr>--}}
                                        {{-- </tbody>--}}
                                        {{-- </table>--}}
                                        {{-- </div>--}}
                                    </div>


                                </div>
                                <div class="card-footer text-right">
                                    <button type="submit" class="btn btn-primary" id="submit_btn" style="">Submit
                                    </button>
                                    <a href="{{route('product.index')}}" class="btn btn-warning" id=""
                                       style="">Cancel</a>
                                </div>
                            </div>
                        </form>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('script')
    {{-- <script src="{{ asset('js/create-product.js') }}"></script>--}}

    <script src="{{ asset('admin/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('admin/dropzone/dist/dropzone.js') }}"></script>
    <script type="text/javascript">
        window.onload = function () {
            let editor1 = CKEDITOR.replace('description');
            let editor2 = CKEDITOR.replace('additional_information');
            editor1.config.allowedContent = true;
            editor2.config.allowedContent = true;
        };


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        //Dependent Category
        $(document).ready(function () {
            $('#main-category').on('change', function (e) {
                var cat_id = e.target.value;
                $.ajax({
                    url: "{{ route('getSubCategories') }}",
                    type: "Get",
                    data: {
                        cat_id: cat_id
                    },
                    success: function (data) {
                        $('#sub-category').empty();
                        $.each(data.subcategories, function (index, subcategory) {
                            $('#sub-category').append('<option value="' + subcategory.id + '">' + subcategory.name + '</option>');
                        })
                    }
                })
            });

            //Check Product SKU
            $('#product_sku').on('blur', function (e) {
                var sku = e.target.value;
                $.ajax({
                    url: "{{ route('checkProductSku') }}",
                    type: "Get",
                    data: {
                        sku: sku
                    },
                    success: function (data) {
                        if (data.product_sku > 0) {
                            $('#sku_span').html(`<p style="color:red">SKU Already exist!</p>`);
                            $(':input[type="submit"]').prop('disabled', true);
                        } else {
                            $('#sku_span').empty();
                            $(':input[type="submit"]').prop('disabled', false);
                        }

                    }
                })
            });

            //Check Product Slug
            $('#product_slug').on('blur', function (e) {
                var slug = e.target.value;
                $.ajax({
                    url: "{{ route('checkProductSlug') }}",
                    type: "Get",
                    data: {
                        slug: slug
                    },
                    success: function (data) {
                        if (data.product_slug > 0) {
                            $('#slug_span').html(`<p style="color:red">SLUG Already exist!</p>`);
                            $(':input[type="submit"]').prop('disabled', true);
                        } else {
                            $('#slug_span').empty();
                            $(':input[type="submit"]').prop('disabled', false);
                        }

                    }
                })
            });

            $('#product_sale').on('click', function (e) {
                if ($('#product_sale').prop('checked') == true) {
                    $('#product_sale_percentage').prop('readonly', false);
                } else {
                    $('#product_sale_percentage').prop('readonly', true);
                }
            });

            $('#product_stock').on('click', function (e) {
                if ($('#product_stock').prop('checked') == true) {
                    $('#product_stock_qty').prop('readonly', false);
                } else {
                    $('#product_stock_qty').prop('readonly', true);
                }
            });
        });

        var counter = 1;

        function addMorePictures() {
            counter++;
            $('#add_more').append(`<tr id="row_${counter}">
                                        <td class="col-md-2">
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
                                        </td>
                                    </tr>`);

        }

        function removeImgRow(counter) {
            $('#row_' + counter).remove();
        }

        function PreviewImage(counter) {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById('gallery_' + counter).files[0]);

            oFReader.onload = function (oFREvent) {
                document.getElementById('img_' + counter).src = oFREvent.target.result;
            };
        }


        let ribbonCounter = 1;

        function addMoreRibbons() {
            ribbonCounter++;
            $('#add_more_ribbon').append(`<tr id="rb_row_${ribbonCounter}">
                                        <td class="col-md-2">
                                            <img src="{{asset('admin/images/placeholder.png')}}" alt="" id="rb_img_${ribbonCounter}" style="height: 150px;width: 150px;">
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" name="ribbon_images[]"  id="rb_gallery_${ribbonCounter}" onchange="PreviewRBImage('${ribbonCounter}')" accept="image/*">
                                                    <label class="custom-file-label" for="category-image">Choose file</label>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="button" class="btn btn-danger btn-md" onclick="removeRBImgRow('${ribbonCounter}')" value="-"/>
                                        </td>
                                    </tr>`);

        }

        function removeRBImgRow(counter) {
            $('#rb_row_' + counter).remove();
        }

        function PreviewRBImage(counter) {
            var oFReader = new FileReader();
            oFReader.readAsDataURL(document.getElementById('rb_gallery_' + counter).files[0]);

            oFReader.onload = function (oFREvent) {
                document.getElementById('rb_img_' + counter).src = oFREvent.target.result;
            };
        }


        var counter1 = 1;


        function removeAttrRow(counter) {
            $('#row_attr_' + counter).remove();
        }

        //Dependent OPtion
        function getOptionValues(counter, val) {
            var option_id = val;
            if (option_id !== '') {
                $.ajax({
                    url: "{{ route('getOptionValues') }}",
                    type: "Get",
                    data: {
                        option_id: option_id
                    },
                    success: function (data) {
                        $('#option_value_id_' + counter).empty();
                        $.each(data.OptionValues, function (index, val) {
                            $('#option_value_id_' + counter).append('<option value="' + val.id + '">' + val.option_value + '</option>');
                        })
                    }
                })
            }
        }

        var counterO = 1;


        function removeOptionRow(counter) {
            $('#row_option_' + counter).remove();
        }

        /* Related product functions start */
        var counter2 = 1;


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

        function removeRelatedProdOption(id) {
            relatedProdOptions.forEach(function (i, v) {
                $("#related_prod_id_" + id + " option[value='" + i + "']").remove();
            })
        }

        function removeRelatedProdRow(counter) {
            var value = $('#row_related_' + counter).find('.related_prod').val();
            if (value != null && value !== '' && relatedProdOptions.includes(value) === true) {
                const index = relatedProdOptions.indexOf(value);
                if (index > -1) {
                    relatedProdOptions.splice(index, 1);
                }
            }
            $('#row_related_' + counter).remove();
        }

        /* Related product functions end */
    </script>

@endsection
