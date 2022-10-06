<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customers;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductReview;

class AdminController extends Controller
{
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

        return view('admin.dashboard', compact('data'));
    }

}
