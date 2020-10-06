<?php

namespace App\Http\Controllers;

use App\FixingDetail;
use App\FixingType;
use App\Manufacturer;
use App\ManufacturerModel;
use App\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\FixingMailInfoToClient;
use App\Mail\FixingMailInfoToManager;

class FixingController extends Controller
{
    public function fixing() {
        return view('pages.fixing.fixing');
    }

    public function fixingType($type) {
        $fixingType = FixingType::where('code', $type)->first();
        return view('pages.fixing.fixing-inner', compact('fixingType'));
    }

    public function fixingBrand($type, $brand) {
        $manufacturer = Manufacturer::where('code', $brand)->first();
        return view('pages.fixing.fixing-inner-brand', compact('manufacturer'));
    }

    public function fixingBrandModel($type, $brand, $modelName) {
        $model = ManufacturerModel::where('code', $modelName)->first();
        return view('pages.fixing.model', compact('model'));
    }

    public function fixingModelDetail($type, $brand, $modelName, $detailName) {
        $model = ManufacturerModel::where('code', $modelName)->first();
        return view('pages.fixing.model', compact('model'));
    }

    public function fixingDetailOrder(Request $request, $type, $brand, $model) {
        $details = FixingDetail::find(explode(',', $request->id));
        return view('pages.fixing.details', compact('details'));
    }

    public function fixingDetailOrderRequest(Request $request)
    {

        $details = json_decode($request->details);
        foreach($details as $detail) {
            $detailObject = FixingDetail::find($detail->id);
            $detail->name = $detailObject->manufacturerModel->name . ' ' . $detailObject->name;
        }
        $request_details = $request;
        $request_details['clientOrder'] = $details;
        Mail::to('dierkholm@gmail.com')->send(new FixingMailInfoToManager($request_details));
        Mail::to('dierkholm@gmail.com')->send(new FixingMailInfoToClient($request_details));

        return $request_details;
    }

    public function fixingService($type, $serviceCode)
    {
        $service = Service::where('code', $serviceCode)->first();
        return view('pages.fixing.service-inner', compact('service'));
    }

}
