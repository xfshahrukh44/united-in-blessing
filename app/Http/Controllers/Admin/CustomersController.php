<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customers;
use App\Models\Order;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    final public function index()
    {
        try {
            if (request()->ajax()) {
                return datatables()->of(Customers::all()->sortByDesc('id'))
                    ->addIndexColumn()
                    ->addColumn('action', function ($data) {
                        return '<a title="View" href="customers/' . $data->id . '" class="btn btn-dark btn-sm"><i class="fas fa-eye"></i></a>&nbsp;<button title="Delete" type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
                    })->rawColumns(['action'])->make(true);
            }
        } catch (\Exception $ex) {
            return redirect('/')->with('error', $ex->getMessage());
        }
        return view('admin.customers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       try{
           $content=Customers::find($id);
           $customerOrders = Order::where('customer_id', $id)->with('orderItems', 'customer', 'orderItems.product')->get();
//           $customerOrders = Order::where('customer_id', $id)->with('orderItems', 'customer', 'orderItems.product', 'country', 'state')->get();
//            dd($customerOrders);
            return view('admin.customers.show',compact(['content','customerOrders']));
       }
       catch(\Exception $ex){
           return redirect ('admin/customers')->with('error',$ex->getMessage());
       }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $content=Customers::find($id);
        if(!empty($content) ){
            $content->delete();
            echo 1;
        }else{echo 2;}
    }
}
