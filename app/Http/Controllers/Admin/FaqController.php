<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;

class FaqController extends Controller
{

    public function index(Request $request){
        try {
            if (request()->ajax()) {
                return datatables()->of(Faq::get())
                    ->addColumn('description', function ($data) {
                        return $data->description ?? "";
                    })
                    // ->addColumn('status', function ($data) {
                    //     if($data->status == 1){
                    //         return '<span class="badge badge-success">Enabled</span>';
                    //     }else{
                    //         return '<span class="badge badge-warning">Disabled</span>';
                    //     }
                    // })
                    ->addColumn('action', function ($data) {
                        return '<a title="Edit" href="faq/edit/' . $data->id . '" class="btn btn-dark btn-sm"><i class="fas fa-pencil-alt"></i></a>&nbsp;<button title="Delete" type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
                    })->rawColumns(['description','status','action'])->make(true);
            }
        } catch (\Exception $ex) {
            return redirect('/')->with('error', $ex->getMessage());
        }
        return view('admin.faq.index');

    }


    public function create(Request $request){
        return view('admin.faq.create');
    }

    public function store(Request $request){
        //dd($request->all());    
        $faq = Faq::create([
            'title'         => $request->title,
            'description'   => $request->description,
            'status'   => 1,
        ]);

        return redirect(route('faq.index')); 
    }

    public function edit($id){
        $faq = Faq::where('id',$id)->first();
        return view('admin.faq.edit',compact('faq','id'));
    }

    public function update(Request $request, $id){
        $faq = Faq::where('id',$id)->update([
            'title'         => $request->title,
            'description'   => $request->description,
            'status'   => 1,
        ]);
        return redirect(route('faq.index')); 
    }

    public function destroy($id){
        $content=Faq::find($id);
        $content->delete();//
        echo 1;
    }

}
