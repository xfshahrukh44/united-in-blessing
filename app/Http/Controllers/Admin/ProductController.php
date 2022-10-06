<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\OptionValue;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductMetaData;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            // dd(Product::with('manufacturer', 'orderItems')->get());
            if (request()->ajax()) {
                return datatables()->of(Product::with('manufacturer', 'orderItems')->where('status', 1)->get())
                    ->addIndexColumn()
                    ->addColumn('product_stock', function ($data) {
                        if ($data->product_stock == 'yes')
                            return '<span class="badge badge-success">In Stock</span>';
                        else
                            return '<span class="badge badge-danger">Out Of Stock</span>';
                    })
                    ->addColumn('action', function ($data) {
                        $content = '<a title="View" href="product/' . $data->id . '" class="btn btn-dark btn-sm"><i class="fas fa-eye"></i></a>&nbsp;';
                        $content .= '<a title="edit" href="product/' . $data->id . '/edit" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>&nbsp;';
//                        $content .= '<a title="Out Of Stock" href="product/' . $data->id . '/labels" class="btn btn-warning btn-sm"><i class="fas fa-tags"></i></a>';
                        $content .= '<button title="Delete" type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
                        return $content;
                    })
                    ->rawColumns(['product_stock', 'action'])
                    ->make(true);

                // return datatables()->of(Product::with('manufacturer', 'orderItems')->where('status', 1)->orderBy('created_at', 'desc')->get())
                //     ->addIndexColumn()
                //     /*->addColumn('manufacturer_id', function ($data) {
                //         return $data->manufacturer->name ?? '';
                //     })*/
                //     ->addColumn('product_current_price', function ($data) {
                //         return $data->product_current_price ?? '';
                //     })
                //     /* ->addColumn('remaining_qty', function ($data) {
                //          $purchase_qty = 0;
                //          foreach ($data->orderItems as $itemss) {
                //              $purchase_qty += $itemss->product_qty;
                //          }
                //          return $data->product_qty - $purchase_qty;
                //      })*/
                //     //                    ->addColumn('status', function ($data) {
                //     //                        if ($data->status == 0) {
                //     //                            return '<label class="switch"><input type="checkbox"  data-id="' . $data->id . '" data-val="1"  id="status-switch"><span class="slider round"></span></label>';
                //     //                        } else {
                //     //                            return '<label class="switch"><input type="checkbox" checked data-id="' . $data->id . '" data-val="0"  id="status-switch"><span class="slider round"></span></label>';
                //     //                        }
                //     //                    })
                //     ->addColumn('action', function ($data) {
                //         $content = '<a title="View" href="product/' . $data->id . '" class="btn btn-dark btn-sm"><i class="fas fa-eye"></i></a>&nbsp;<a title="edit" href="product/' . $data->id . '/edit" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>&nbsp;';;
                //         $content .= '<a title="Labels" href="product/' . $data->id . '/labels" class="btn btn-warning btn-sm"><i class="fas fa-tags"></i></a>';
                //         return $content;
                //     })->rawColumns(['status', 'category_id', 'action'])->make(true);
            }
        } catch (\Exception $ex) {
            return redirect('/')->with('error', 'SomeThing Went Wrong baby');
        }
        return view('admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('status', 1)->get();
        return view('admin.product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse|Redirector
     */
    public function store(Request $request)
    {
        //        dd($request->all());

        $validator = Validator::make($request->all(), array(
            'product_name' => 'required',
            'product_current_price' => 'required|numeric',
            'category_id' => 'required',
            'description' => 'required',
            'weight' => 'required',
            'product_stock' => 'required',
            'additional_information' => 'nullable',
        ));
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        //image uploading
        DB::beginTransaction();
        try {
            /*if ($request->file('product_image_first')) {
                $product_image_first = time() . '_' . $request->file('product_image_first')->getClientOriginalName();
                //            $product_image_first_path = $request->file('product_image_first')->storeAs('products', $product_image_first);
                $request->file('product_image_first')->move(public_path() . '/uploads/products/', $product_image_first);
            } else {
                $product_image_first = null;
            }*/

            $product = Product::create($request->only('product_name', 'product_current_price', 'category_id', 'weight', 'product_stock', 'description', 'additional_information'));

            if ($request->get('meta-title') !== null && $request->get('meta-description') !== null && $request->get('meta-keywords') !== null) {
                ProductMetaData::create([
                    'product_id' => $product->id,
                    'meta_tag_title' => $request->get('meta-title'),
                    'meta_tag_description' => $request->get('meta-description'),
                    'meta_tag_keywords' => $request->get('meta-keywords'),
                    'status' => 1,
                ]);
            }

            if ($request->file('product_image')) {

                foreach ($request->file('product_image') as $key => $product_image) {
                    $product_image_ad = time() . '_' . $product_image->getClientOriginalName();
                    //                    $product_image_ad_path = $product_image->storeAs('products', $product_image_ad);
                    $product_image->move(public_path() . '/uploads/products/', $product_image_ad);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'product_images' => $product_image_ad
                    ]);
                }
            }

            //            if ($request->file('ribbon_images')) {
            //
            //                foreach ($request->file('ribbon_images') as $key => $ribbon_image) {
            //                    $ribbon_image_ad = time() . '_' . $ribbon_image->getClientOriginalName();
            ////                    $product_image_ad_path = $product_image->storeAs('products', $product_image_ad);
            //                    $ribbon_image->move(public_path() . '/uploads/products/', $ribbon_image_ad);
            //
            //                    ProductImage::create([
            //                        'product_id' => $product->id,
            //                        'product_images' => $ribbon_image_ad,
            //                        'image_type' => 'ribbon'
            //                    ]);
            //                }
            //            }

            //Attributes
            /*if (!empty($request->get('attribute'))) {
                foreach ($request->get('attribute') as $keyA => $attributes) {
                    ProductAttribute::create([
                        'product_id' => $product->id,
                        'attribute_id' => $attributes,
                        'value' => $request->get('attribute_value')[$keyA],
                    ]);
                }
            }*/

            //Options
            /*if (!empty($request->get('option_id'))) {
                foreach ($request->get('option_id') as $keyO => $options) {
                    OptionProduct::create([
                        'product_id' => $product->id,
                        'option_id' => $options,
                        'option_val_id' => $request->get('option_value_id')[$keyO],
                        'price' => $request->get('option_value_price')[$keyO],
                        'qty' => $request->get('option_value_qty')[$keyO]
                    ]);
                }
            }*/
            // Related Products
            /*if (!empty($request->get('related_prod_id'))) {
                foreach ($request->get('related_prod_id') as $relatedProduct) {
                    RelatedProduct::create([
                        'product_id' => $product->id,
                        'related_id' => $relatedProduct
                    ]);
                }
            }*/
        } catch (\Illuminate\Database\QueryException $e) {
            // back to form with errors
            // dd($e->getMessage());
            DB::rollback();
            return Redirect()->back()
                ->with('error', $e->getMessage())
                ->withInput();
        } catch (\Exception $e) {
            // dd($e->getMessage());
            DB::rollback();
            return Redirect()->back()
                ->with('error', $e->getMessage())
                ->withInput();
        } finally {
            DB::commit();
        }

        return redirect('/admin/product')->with(['success' => 'Product Added Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::where('status', 1)->get();
        return view('admin.product.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //        dd($request->all());

        $this->validate($request, array(
            'product_name' => 'required',
            'product_current_price' => 'required|numeric',
            'category_id' => 'required',
            'description' => 'required',
            'weight' => 'required',
            'product_stock' => 'required',
            'additional_information' => 'nullable',
        ));

        try {
            DB::beginTransaction();

            $product = Product::where('id', $id)->first();

            //image uploading

            /*if ($request->file('product_image_first')) {
                $product_image_first = time() . '_' . $request->product_image_first->getClientOriginalName();
                //            $product_image_first_path = $request->file('product_image_first')->storeAs('products', $product_image_first);
                $request->file('product_image_first')->move(public_path() . '/uploads/products/', $product_image_first);
                $product->product_image = $product_image_first;
            } else {
                $product_image_first = null;
            }*/

            $product->category_id = $request->get('category_id') ?? null;
            //        $product->sub_category_id = $request->get('sub_category') ?? 0;
            $product->product_name = $request->get('product_name');
            $product->description = $request->get('description');
            $product->additional_information = $request->get('additional_information');
            $product->product_current_price = $request->get('product_current_price');
            //        $product->sku = $request->get('product_sku');
            //        $product->slug = $request->get('product_slug');
            //        $product->product_sale = $request->get('product_sale') ?? 'no';
            //        $product->product_sale_percentage = $request->get('product_sale_percentage') ?? 0;
            $product->product_stock = $request->get('product_stock');
            //        $product->product_qty = $request->get('product_stock_qty');
            //        $product->product_type = $request->get('product_featured');
            //        $product->length = $request->get('length') ?? 0;
            //        $product->width = $request->get('width');
            //        $product->height = $request->get('height') ?? 0;
                    $product->weight = $request->get('weight') ?? 0;
            //        $product->status = $request->get('status') ?? 0;
            //        $product->manufacturer_id = $request->input('manufacturer') ? $request->input('manufacturer') : 0;
            $product->save();


            if ($request->get('meta-title') !== null && $request->get('meta-description') !== null && $request->get('meta-keywords') !== null) {
                ProductMetaData::updateOrCreate([
                    'product_id' => $product->id,
                ], [
                    'product_id' => $product->id,
                    'meta_tag_title' => $request->get('meta-title'),
                    'meta_tag_description' => $request->get('meta-description'),
                    'meta_tag_keywords' => $request->get('meta-keywords'),
                    'status' => 1,
                ]);
            }

            /* Removing additional images other than ids */
            if (!empty($request->input('saved_images'))) {
                $savedImages = ProductImage::where([
                    ['product_id', $id],
                    ['image_type', 'gallery']
                ])->whereNotIn('id', $request->input('saved_images'))->get();
                if (count($savedImages) > 0) {
                    foreach ($savedImages as $image) {
                        $image->delete();
                    }
                }
            } else {
                $savedImages = ProductImage::where([
                    ['product_id', $id],
                    ['image_type', 'gallery'],
                ])->get();
                if (count($savedImages) > 0) {
                    foreach ($savedImages as $image) {
                        $image->delete();
                    }
                }
            }

            if (!empty($request->input('saved_ribbons'))) {
                $savedImages = ProductImage::where([
                    ['product_id', $id],
                    ['image_type', 'ribbon']
                ])->whereNotIn('id', $request->input('saved_ribbons'))->get();
                if (count($savedImages) > 0) {
                    foreach ($savedImages as $image) {
                        $image->delete();
                    }
                }
            } else {
                $savedImages = ProductImage::where([
                    ['product_id', $id],
                    ['image_type', 'ribbon'],
                ])->get();
                if (count($savedImages) > 0) {
                    foreach ($savedImages as $image) {
                        $image->delete();
                    }
                }
            }
            /* Add additional images */
            if ($request->file('product_image')) {
                foreach ($request->file('product_image') as $key => $product_image) {
                    $product_image_ad = time() . '_' . $product_image->getClientOriginalName();
                    //                $product_image_ad_path = $product_image->storeAs('products', $product_image_ad);
                    $product_image->move(public_path() . '/uploads/products/', $product_image_ad);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'product_images' => $product_image_ad,
                    ]);
                }
            }

            if ($request->file('ribbon_images')) {

                foreach ($request->file('ribbon_images') as $key => $ribbon_image) {
                    $ribbon_image_ad = time() . '_' . $ribbon_image->getClientOriginalName();
                    //                    $product_image_ad_path = $product_image->storeAs('products', $product_image_ad);
                    $ribbon_image->move(public_path() . '/uploads/products/', $ribbon_image_ad);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'product_images' => $ribbon_image_ad,
                        'image_type' => 'ribbon'
                    ]);
                }
            }
        } catch (\Exception $e) {
            // dd($e->getMessage());
            DB::rollback();
            return Redirect()->back()
                ->with('error', $e->getMessage())
                ->withInput();
        } finally {
            DB::commit();
        }

        return redirect()->back()->with(['success' => 'Product Updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $check = OrderItem::where('product_id', $id)->count();
        if ($check > 0) {
            echo 0;
            return;
        }
        // $collectionCheck = CollectionProduct::where('product_id', $id)->count();
        // if ($collectionCheck > 0) {
        //     echo 2;
        //     return;
        // }
        // $content = Product::find($id);
        // CustomerWishlist::where('product_id', $id)->delete();
        // $content->delete(); //
        $content = Product::where('id', $id);

        if ($content->count() > 0) {
            $content->update(['status' => 0]);
            echo 1;
        } else {
            echo 0;
        }
    }

    public function getSubCategories(Request $request)
    {

        $parent_id = $request->cat_id;

        $subcategories = Category::where('parent_id', $parent_id)->get();
        return response()->json([
            'subcategories' => $subcategories
        ]);
    }

    public function checkProductSku(Request $request)
    {

        $sku = $request->sku;

        $product_sku = Product::where('sku', $sku)->count();

        return response()->json([
            'product_sku' => $product_sku
        ]);
    }

    public function checkProductSlug(Request $request)
    {
        $slug = $request->slug;

        $product_slug = Product::where('slug', $slug)->count();

        return response()->json([
            'product_slug' => $product_slug
        ]);
    }

    public function changeProductStatus(Request $request, $id)
    {

        $product = Product::where('id', $id);

        if ($product->count() > 0) {
            $product->update(['status' => $request->val]);
            return 1;
        }
    }

    public function getOptionValues(Request $request)
    {
        $option_id = $request->option_id;

        $OptionValue = OptionValue::where('option_id', $option_id)->get();
        return response()->json([
            'OptionValues' => $OptionValue
        ]);
    }
}
