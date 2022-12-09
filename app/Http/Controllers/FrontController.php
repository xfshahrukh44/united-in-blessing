<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\PHPCustomMail;
use Illuminate\Support\Facades\Storage;

class FrontController extends Controller
{
    use PHPCustomMail;

    public function howItWorks(){
        return view('how-it-work');
    }

    public function guidelines(){
        return view('guideline');
    }

    public function faq(){
        return view('faq');
    }

    public function privacy_statement(){
        return view('privacy-statement');
    }

    public function contact(){
        return view('contact');
    }

    public function gifting_forms(){
        return view('gifting-form');
    }

    public function sendGiftingForm(Request $request){
        try {
            $user = User::where('username', $request->username)->first();
            if (!$user){
                return back()->with('error', 'No user exists with this username');
            }

            $filename = 'gifting-form-statement-and-non-solicitation.pdf';
            $file = public_path('assets/pdf/') . $filename;

            $html = 'New Gift form received please check the attachment';

            $this->customMailerWithAttachment('no-reply@uib.com', $user->email, 'Gift Form Received', $html, $file);

            return back()->with('success', 'Email sent successfully');
        } catch (\Exception $exception){
            return back()->with('error', $exception->getMessage());
        }
    }
}
