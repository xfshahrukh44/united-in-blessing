<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\CollectionProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Validator;

class CollectionProductController extends Controller
{
    public function index()
    {
        try {
            if (request()->ajax()) {
                return datatables()->of(CollectionProduct::with('collections')->groupBy('collection_id')->get())
                    ->addColumn('collection_name', function ($data){
                        return $data->collections->name;
                    })
                    ->addColumn('action', function ($data) {
                        return '<a title="View" href="collectionProducts/show/' . $data->collection_id . '" class="btn btn-dark btn-sm"><i class="fas fa-eye"></i></a>&nbsp;<a title="edit" href="collectionProducts/edit/' . $data->collection_id . '" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>&nbsp;<button title="Delete" type="button" name="delete" id="' . $data->collection_id . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
                    })->rawColumns(['collection_name','action'])->make(true);
            }
        } catch (\Exception $ex) {
            return redirect('/')->with('error', $ex->getMessage());
        }
        return view('admin.collectionProducts.index');
    }

    public function create()
    {
        $collections = Collection::where('status',1)->get();
        $products = Product::where('status',1)->get();

        return view('admin.collectionProducts.create',compact('collections','products'));
    }

    public function store(Request $request)
    {
        // dd($request->all());

        $validator = Validator::make($request->all(), array(
            'collection_id' => 'required',
            'product_id' => 'required',
        ));


        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }


        foreach ($request->get('product_id') as $key => $product){

            CollectionProduct::create([
                'collection_id' => $request->get('collection_id'),
                'product_id' => $product,
            ]);

        }

        return redirect('admin/collectionProducts')->with(['success' => 'collection Products Added Successfully']);
    }

    public function show($id)
    {
        $collectionProduct = CollectionProduct::where('collection_id',$id)->with('collections','products')->firstOrFail();
        $collectionSelectedProducts = CollectionProduct::where('collection_id',$id)->with('collections','products')->get();
//dd($collectionSelectedProducts);
        return view('admin.collectionProducts.show',compact('collectionProduct','collectionSelectedProducts'));
    }

    public function edit($id)
    {
        $collections = Collection::where('status',1)->get();
        $products = Product::where('status',1)->get();
        $collectionProduct = CollectionProduct::where('collection_id',$id)->firstOrFail();
        $collectionSelectedProduct = CollectionProduct::where('collection_id',$id)->pluck('product_id')->toArray();
        return view('admin.collectionProducts.edit',compact('collectionProduct','collections','products','collectionSelectedProduct'));
    }

    public function update(Request $request, $id)
    {
        $collection = CollectionProduct::where('collection_id',$id)->firstOrFail();

        try{
            $this->validate($request, array(
                'collection_id' => 'required',
                'product_id' => 'required',
            ));

            CollectionProduct::where('collection_id', $id)->delete();

            foreach ($request->get('product_id') as $key => $product){
                CollectionProduct::create([
                    'collection_id' => $id,
                    'product_id' => $product,
                ]);

            }
            return redirect(route('collectionProducts.index'))->with('success', 'Collection Updated');

        }catch(\Exception $ex){
            return redirect(route('collectionProducts.index'))->with('error', $ex->getMessage());
        }
    }


    public function destroy(Request $request,$id)
    {
        $collection = CollectionProduct::where('collection_id',$id);

        if($collection->count() > 0){
            $collection->delete();
            return 1;
        }
    }
}
