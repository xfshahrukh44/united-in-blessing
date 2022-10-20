<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontController extends Controller
{
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
}
