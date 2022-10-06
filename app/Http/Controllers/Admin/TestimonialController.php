<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;

class TestimonialController extends Controller
{
    public function index(Request $request){
        try {
            if (request()->ajax()) {
                return datatables()->of(Testimonial::get())
                    ->addColumn('comment', function ($data) {
                        return $data->comment ?? "";
                    })
                    ->addColumn('status', function ($data) {
                        if($data->status == 0){
                            return '<label class="switch"><input type="checkbox"  data-id="'.$data->id.'" data-val="1"  id="status-switch"><span class="slider round"></span></label>';
                        }else{
                            return '<label class="switch"><input type="checkbox" checked data-id="'.$data->id.'" data-val="0"  id="status-switch"><span class="slider round"></span></label>';
                        }
                    })
                    ->addColumn('action', function ($data) {
                        return '<a title="Edit" href="testimonial/edit/' . $data->id . '" class="btn btn-dark btn-sm"><i class="fas fa-pencil-alt"></i></a>&nbsp;<button title="Delete" type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
                    })->rawColumns(['comment','status','action'])->make(true);
            }
        } catch (\Exception $ex) {
            return redirect('/')->with('error', $ex->getMessage());
        }
        return view('admin.testimonial.index');

    }


    public function create(Request $request){
        return view('admin.testimonial.create');
    }

    public function store(Request $request){
        // dd($request->all());    
        $faq = Testimonial::create([
            'name'          => $request->name,
            'designation'   => $request->designation,
            'comment'       => $request->comment,
            'status'        => 1,
        ]);

        return redirect(route('testimonial.index')); 
    }

    public function edit($id){
        $faq = Testimonial::where('id',$id)->first();
        return view('admin.testimonial.edit',compact('faq','id'));
    }

    public function update(Request $request, $id){
        // dd($request->all());   
        $faq = Testimonial::where('id',$id)->update([
            'name'          => $request->name,
            'designation'   => $request->designation,
            'comment'       => $request->comment,
            'status'        => 1,
        ]);
        return redirect(route('testimonial.index')); 
    }

    public function destroy($id){
        // die($id);
        $content=Testimonial::find($id);
        $content->delete();//
        echo 1;
    }

    public function changeBlogStatus(Request $request,$id)
    {

        $product = Testimonial::where('id',$id);

        if($product->count() > 0){
            $product->update(['status' => $request->val]);
            return 1;
        }
    }

}
