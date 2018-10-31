<?php

namespace App\Http\Controllers;

use App\Service;
use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('driver','truck')
        ->orderBy('id', 'desc')
        ->get();

        return view('service.services',['services'=>$services]);
    }


    public function show(Service $service)
    {
        $service = Service::with('driver','truck')
        ->find($service->id);

        return view('service.show',['service'=>$service]);
    }


    public function store(Request $request)
    {
        $service = new Service;
        $service->truck_id = $request->truck_id;
        $service->driver_id = $request->driver_id;
        $service->product = $request->product;
        $service->description = $request->description;
        $service->mileage = $request->mileage;
        $service->total = $request->total;
        $service->shop = $request->shop;
        $service->shop_phone = $request->shop_phone;
        $service->voucher_number = $request->voucher_number;
        if($request->file('image')!=NULL){
            $image = time().'.'. $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('img/service'), $image);
            $service->image = $image;
        }
        $service->save();

        Transaction::log(Route::getCurrentRoute()->getName(),'',$service);

        return redirect()->back();
    }

    public function update(Request $request)
    {
        $service = Service::find($request->id);
        $service->truck_id = $request->truck_id;
        $service->driver_id = $request->driver_id;
        $service->product = $request->product;
        $service->description = $request->description;
        $service->mileage = $request->mileage;
        $service->total = $request->total;
        $service->shop = $request->shop;
        $service->shop_phone = $request->shop_phone;
        $service->voucher_number = $request->voucher_number;
        if($request->file('image')!=NULL){
            $image = time().'.'. $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('img/service'), $image);
            $service->image = $image;
        }
        $service->save();

        Transaction::log(Route::getCurrentRoute()->getName(),Service::find($request->id),$service);

        return redirect()->back();
    }

    public function destroy(Request $request,Service $service)
    {
        Service::destroy($service->id);
        Transaction::log(Route::getCurrentRoute()->getName(),$service,false);
        return redirect()->back()->with('status', 'Record is Destroid!');
    }
}
