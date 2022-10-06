<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsLetter;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\App\Jobs\SendEmailJob;
use App\Jobs\SendEmailJob as JobsSendEmailJob;
// use App\Newsletter_sent;
use App\Models\Newsletter_sent;
use Carbon\Carbon;

class NewsLetterController extends Controller
{
    public function index()
    {

        try {
            if (request()->ajax()) {
                return datatables()->of(NewsLetter::orderBy('created_at', 'desc')->get())
                     ->addIndexColumn()
                    ->addColumn('status', function ($data){
                        if($data->status == 0){
                            return '<label class="switch"><input type="checkbox"  data-id="'.$data->id.'" data-val="1"  id="status-switch"><span class="slider round"></span></label>';
                        }else{
                            return '<label class="switch"><input type="checkbox" checked data-id="'.$data->id.'" data-val="0"  id="status-switch"><span class="slider round"></span></label>';
                        }
                    })
                    ->addColumn('action', function ($data) {
                        return '<button title="Delete" type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>';
                    })->rawColumns(['status','action'])->make(true);
            }
        } catch (\Exception $ex) {
            return redirect('/')->with('error', $ex->getMessage());
        }
        return view('admin.newsletter.index');
    }

    public function edit(Request $request, $id){
        $subscription = NewsLetter::where('id',$id)->first();
        if(empty($subscription)){
           return 0;
        }
        $status = $subscription->status;
        if($status == 0){
            $status = 1;
        }else{
            $status = 0;
        }
        if($request->method() == 'POST'){
            $subscription->status = $status;
            $subscription->save();
        }
        return 1;
    }

    public function destroy($id)
    {
        $content = NewsLetter::find($id);
        $content->delete();
        echo 1;
    }

    // sendNewsLetter
    public function sendNewsLetter()
    {
        return view('admin.newsletter.sendnewsletter');
    }
    public function sendNewsLetterEmail(Request $req)
    {
        $this->validate($req, array(
            'subject' => 'required',
            'message' => 'required'
        ));
        $sub=NewsLetter::all();  
        foreach($sub as $subs){  
            $details['email'] = $subs->email;
            $details['subject'] = $req->input('subject');
            $details['content'] = $req->input('message');
            // dd( dispatch(new JobsSendEmailJob($details)));
            dispatch(new JobsSendEmailJob($details))
            ->delay(now()->addSeconds(10));

             Newsletter_sent::create([
                'news_letter_id' => $subs->id,
                'subject' => $req->input('subject'),
                'content' => $req->input('message'),
            ]);
        }
        return redirect(route('newsletter.index'))->with('success', 'Email Sent To All Subscribers Successfully..!!');
    } //end sendNewsLetterEmail
   

}
