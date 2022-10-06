<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Collection;
use App\Models\CollectionProduct;
use Illuminate\Http\Request;
use Validator;

class CollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            if (request()->ajax()) {
                return datatables()->of(Collection::get())
                    ->addColumn('order_by_no', function ($data) {
                        return $data->order_by_no;
                    })
                    ->addColumn('status', function ($data){
                        if($data->status == 0){
                            return '<label class="switch"><input type="checkbox"  data-id="'.$data->id.'" data-val="1"  id="status-switch"><span class="slider round"></span></label>';
                        }else{
                            return '<label class="switch"><input type="checkbox" checked data-id="'.$data->id.'" data-val="0"  id="status-switch"><span class="slider round"></span></label>';
                        }
                    })
                    ->addColumn('action', function ($data) {
                        return '<a title="View" href="collection/' . $data->id . '" class="btn btn-dark btn-sm"><i class="fas fa-eye"></i></a>&nbsp;<a title="edit" href="collection/' . $data->id . '/edit" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>&nbsp;<button title="Delete" type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
                    })->rawColumns(['order_by_no','status', 'action'])->make(true);
            }
        } catch (\Exception $ex) {
            return redirect('/')->with('error', $ex->getMessage());
        }
        return view('admin.collection.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.collection.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), array(
            'name' => 'required',
            'order_by_no' => 'required',
        ));

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $collections = Collection::where('name',$request->get('name'))->count();

        if($collections > 0){
            return redirect()->back()->withErrors('This Collection Already Exist!')->withInput();
        }

        $collectionsOrder = Collection::where('order_by_no',$request->get('order_by_no'))->count();

        if($collectionsOrder > 0){
            return redirect()->back()->withErrors('This Collection Display Order Already Exist!')->withInput();
        }

         Collection::create([
            'name' => $request->get('name'),
            'order_by_no' => $request->get('order_by_no'),
        ]);

        return redirect('admin/collection')->with(['success' => 'Collection Added Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $collection = Collection::where('id',$id)->firstOrFail();
        return view('admin.collection.show',compact('collection'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $collection = Collection::where('id',$id)->firstOrFail();
        return view('admin.collection.edit',compact('collection'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $collection = Collection::where('id',$id)->firstOrFail();

        try{
            $this->validate($request, array(
                'name' => 'required',
                'order_by_no' => 'required',
            ));

            $collection->name = $request->input('name');
            $collection->order_by_no = $request->input('order_by_no');
            $collection->save();

            return redirect(route('collection.index'))->with('success', 'Collection Updated');

        }catch(\Exception $ex){
            return redirect(route('collection.index'))->with('error', $ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $collection = Collection::where('id',$id);

        if($collection->count() > 0){
            $collection->delete();
            return 1;
        }
    }
}
