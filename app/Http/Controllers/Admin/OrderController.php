<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class OrderController extends Controller
{
    public function index()
    {

        try {
            if (request()->ajax()) {
                return datatables()->of(Order::with('customer')->where([
                    ['status', 1],
                    ['order_status', "paid"],
                ])->orderBy('id', 'desc')->get())
                    ->addIndexColumn()
                    /*->addColumn('order_no', function ($data) {
                        return $data->order_no ?? '';
                    })*/ ->addColumn('customer', function ($data) {
                        // if ($data->customer_id == null) {
                        return $data->customer_name;
                        // } else {
                        //     dd($data);
                        //     return $data->customer->first_name . ' ' . $data->customer->last_name;
                        // }
                    })->addColumn('total_amount', function ($data) {
                        return '$' . ($data->total_amount) ?? '';
                    })->addColumn('order_date', function ($data) {
                        return date('d-M-Y', strtotime($data->created_at)) ?? '';
                    })->addColumn('status', function ($data) {
                        if ($data->order_status == 'pending') {
                            return '<span class="badge badge-secondary">Pending</span>';
                        } elseif ($data->order_status == 'cancelled') {
                            return '<span class="badge badge-danger">Cancelled</span>';
                        } elseif ($data->order_status == 'completed') {
                            return '<span class="badge badge-success">Completed</span>';
                        } elseif ($data->order_status == 'shipped') {
                            return '<span class="badge badge-info">Shipped</span>';
                        }
                    })
                    ->addColumn('action', function ($data) {
                        return '<a title="View" href="order/' . $data->id . '" class="btn btn-dark btn-sm">
                                <i class="fas fa-eye"></i>
                                </a>&nbsp;<button title="Delete" type="button" name="delete" id="' . $data->id . '" class="delete btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i></button>';
                    })->rawColumns(['order_no', 'customer', 'status', 'total_amount', 'order_date', 'action'])->make(true);
            }
        } catch (\Exception $ex) {
            return redirect('/')->with('error', 'SomeThing Went Wrong baby');
        }
        return view('admin.order.index');
    }

    public function show($id)
    {
        $order = Order::where([
            ['id', $id],
            ['order_status', "paid"],
        ])->with('orderItems')->firstOrFail();

        return view('admin.order.show', compact(['order']));
    }

    public function changeOrderStatus(Request $request, $id)
    {
        $order = Order::where('id', $id);

        if ($order->count() > 0) {
            $order->update(['order_status' => $request->val]);
            return 1;
        } else {
            return 0;
        }
    }

    public function orderdelete($id)
    {
        $order = Order::where('id', $id);

        if ($order->count() > 0) {
            $order->update(['status' => 0]);
            return 1;
        } else {
            return 0;
        }
    }

    public function destroy($id)
    {
        $content = Order::find($id);
        $content->delete(); //
        $orderItems = OrderItem::where('order_id', $id)->delete();
        echo 1;
    }

    public function pdfDownload($file_name)
    {
        try {
            if (File::exists(public_path('uploads/orders/' . $file_name))) {
                $file_path = public_path('uploads/orders/' . $file_name);
                $pdf = PDF::loadView('image-pdf', compact('file_path'))->setPaper([0, 0, 288, 288]);
                return $pdf->download($file_name . '.pdf');
            } else {
                return abort(404);
            }
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', $e->getMessage());
        }
    }
}
