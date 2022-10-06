<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailSetting;

class EmailSettingController extends Controller
{
    public function index(Request $request){

        try{
            if($request->method() == 'POST'){
                
                $content = EmailSetting::find(1);
                $content->mail_domain = $request->mail_domain;
                $content->mail_host = $request->mail_host;
                $content->ssl = $request->ssl;
                $content->username = $request->username;
                $content->password = $request->password;
                $content->mail_port = $request->mail_port;
                $content->from_address = $request->from_address;

               if($content->save()){
                   return redirect('/admin/emailsetting')->with('success','Email Settings Update Successfully');
               }
            }else {
                //echo "sada";
                $content = EmailSetting::findOrfail(1);
                //dd($content);
                //$shippingRates = ShippingRate::where('status',1)->get();

                return view('admin.emailsetting.edit', compact('content'));
            }
        }
        catch(\Exception $ex){
            //return redirect('admin/dashboard')->with('error',$ex->getMessage());

        }
    }


}
