<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Boards;
use App\Models\Customers;
use App\Models\GiftLogs;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function login(){
        if (Auth::check()){
            if (Auth::user()->role == 'admin'){
                return redirect()->route('dashboard');
            } else{
                return redirect()->route('home');
            }
        }

        return view('admin.auth.login');
    }

    public function dashboard()
    {
        $data['orders'] = Order::where([
            ['status', 1],
            ['order_status', 'paid'],
        ])->count();
        $data['products'] = Product::where('status', 1)->count();
        $data['customers'] = Customers::count();
        $data['latestOrders'] = Order::with('customer')->orderBy('created_at', 'desc')->take(7)->get();
        $data['latestReviews'] = ProductReview::with('product', 'customer')->orderBy('created_at', 'desc')->take(7)->get();
        $data['users'] = User::count();
        $data['boards'] = Boards::count();
        $data['gifts'] = GiftLogs::where('status', '!=', 'accepted')->count();

        return view('admin.dashboard', compact('data'));
    }

}
