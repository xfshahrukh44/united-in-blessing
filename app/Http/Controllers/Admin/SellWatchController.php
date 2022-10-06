<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SellWatch;

class SellWatchController extends Controller
{
    public function index()
    {
        try {
            if (request()->ajax()) {
                return datatables()->of(SellWatch::where('status',1)->get())
                    // ->addIndexColumn()    
                    // ->addColumn('category_id', function ($data) {
                    //     return $data->category->name ?? '';
                    // })
                    // ->addColumn('product_current_price', function ($data) {
                    //     return $data->product_current_price ?? '';
                    // })
                    // ->addColumn('status', function ($data) {
                    //     if ($data->status == 0) {
                    //         return '<label class="switch"><input type="checkbox"  data-id="' . $data->id . '" data-val="1"  id="status-switch"><span class="slider round"></span></label>';
                    //     } else {
                    //         return '<label class="switch"><input type="checkbox" checked data-id="' . $data->id . '" data-val="0"  id="status-switch"><span class="slider round"></span></label>';
                    //     }
                    // })
                    ->addColumn('action', function ($data) {
                        return '<a title="View" href="sellwatch/show/' . $data->id . '" class="btn btn-dark btn-sm"><i class="fas fa-eye"></i></a>&nbsp;';
                    })->rawColumns(['status', 'action'])->make(true);
            }
        } catch (\Exception $ex) {
            return redirect('/')->with('error', 'SomeThing Went Wrong baby');
        }
        return view('admin.sellwatch.index');
    }

    public function show($id){
        $data = SellWatch::where('id',$id)->firstOrFail();
        // dd($data);
        return view('admin.sellwatch.show',compact('data'));
    }

}
