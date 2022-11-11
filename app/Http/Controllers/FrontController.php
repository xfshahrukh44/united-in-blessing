<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\PHPCustomMail;

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
                return back()->with('error', 'No user exist with this username');
            }

            $filename = 'gifting-form-statement-and-non-solicitation.pdf';
            $file = public_path('assets/pdf/') . $filename;

            $content = file_get_contents($file);
            $content = chunk_split(base64_encode($content));

            // a random hash will be necessary to send mixed content
            $separator = md5(time());

            // carriage return type (RFC)
            $eol = "\r\n";

            $html = 'New Gift form received please check the attachment';

            // attachment
            $html .= "Content-Type: application/octet-stream; name=\"" . $filename . "\"" . $eol;
            $html .= "Content-Transfer-Encoding: base64" . $eol;
            $html .= "Content-Disposition: attachment" . $eol;
            $html .= $content . $eol;
            $html .= "--" . $separator . "--";

            $this->customMail('no-reply@uib.com', $user->email, 'Gift Form Received', $html);

            return back()->with('success', 'Email sent successfully');
        } catch (\Exception $exception){
            return back()->with('error', $exception->getMessage());
        }
    }
}
