<?php

namespace App\Http\Controllers;

use App\Service;
use App\Truck;
use App\Transaction;
use Illuminate\Http\Request;

use App\Http\Controllers\TruckController;
use Illuminate\Support\Facades\Route;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('driver','truck')
        ->get();

        return view('service.services',[ 'services' => $services, 'trucks' => $services->pluck('truck')->flatten()->unique(), 'start' => time()]);
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
        if ($request->created_at!='') {
            $service->created_at = $request->created_at;
        }
        if($request->file('image')!=NULL){
            $image = time().'.'. $request->file('image')->getClientOriginalExtension();
            $request->file('image')->move(public_path('img/service'), $image);
            $service->image = $image;
        }
        $service->save();
        try{
            App(TruckController::newMileage($service->truck_id, $service->mileage));
        }catch( \Exception $e){
            return redirect()->back()->with('warning', 'Service saved but milage did not updated due to '.$e->getMessage());
        }
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
        if ($request->created_at!='') {
            $service->created_at = $request->created_at;
        }
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
