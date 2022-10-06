<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingService;
use Illuminate\Http\Request;

class ShippingServiceController extends Controller
{
    public function index(Request $request){
        if ($request->method() == 'POST'){
            if ($request->has('ups') && !empty($request->get('ups'))){
                $upsData = $request->get('ups');
                if (isset($upsData['status']) == false){
                    $request->get('ups')['status'] = 0;
                    $upsData['status'] = 0;
                }
                foreach ($upsData as $key => $value){
                    $upsShipping = ShippingService::updateOrCreate(
                        ['service_name' => 'UPS', 'name' => $key],
                        ['value' => $value ?? '']
                    );
                }
            }
            if ($request->has('usps') && !empty($request->get('usps'))){
                $uspsData = $request->get('usps');
                if (isset($uspsData['status']) == false){
                    $request->get('usps')['status'] = 0;
                    $uspsData['status'] = 0;
                }
                foreach ($uspsData as $key => $value){
                    $uspsShipping = ShippingService::updateOrCreate(
                        ['service_name' => 'USPS', 'name' => $key],
                        ['value' => $value ?? '']
                    );
                }
            }
            return redirect()->back();
        }


        $ShippingServices = ShippingService::get();
        $content = array();
        foreach ($ShippingServices as $key => $item){
            $content[$item->service_name][$item->name] = $item->value;
        }
        //dd($content);
        return view('admin.shippingServices.edit', compact('content'));
    }
}
