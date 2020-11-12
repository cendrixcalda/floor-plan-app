<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\FloorPlan;
use App\HouseImage;
use App\FloorPlanImage;
use App\AutocadFile;

class HomeController extends Controller
{
    public function show(Request $request){
        return view('home');
    }

    public function getFloorPlanColumns(){
        $columns = Schema::getColumnListing('floor_plans');

        return json_encode($columns);
    }

    public function getFloorPlans(Request $request){

        $length = $request->input('length');
        $search = $request->input('search');
        $search = json_decode($search, true);

        $floorPlans = FloorPlan::when($search, function ($query) use ($search) {
            foreach ($search as $key => $value) {
                $query->where($key, 'like', $value . '%');
            }
        })
        ->with('houseImage')
        ->with('floorPlanImage')
        ->paginate($length);

        return ['data' => $floorPlans, 'length' => $length, 'requestCounter' => $request->input('requestCounter')];
    }

    public function postFloorPlan(Request $request){
        $data = $request->post();

        if (!isset($data['details']['tracking_id'])){ 
            $notifMessage = "Tracking id is required.";
            $notifType = "warning";
            
            return ["notifMessage" => $notifMessage, "notifType" => $notifType];
        } elseif (!(count($data['details']) - 1)){ 
            $notifMessage = "No details provided for this floor plan.";
            $notifType = "warning";

            return ["notifMessage" => $notifMessage, "notifType" => $notifType];
        } else {
            if(!$request->hasfile('house_images')) {
                $notifMessage = "No house image uploaded for this floor plan.";
                $notifType = "warning";

                return ["notifMessage" => $notifMessage, "notifType" => $notifType];
            } elseif(!$request->hasfile('floor_plan_images')) {
                $notifMessage = "No floor plan image uploaded for this floor plan.";
                $notifType = "warning";

                return ["notifMessage" => $notifMessage, "notifType" => $notifType];
            } else {
                foreach ($data['details'] as $detailsKey => $details) {
                    $data['details'][$detailsKey] = json_decode(trim($details));
                }

                try {
                    //Insert floor plan details here to get id reference
                    $floorPlan = FloorPlan::create($data['details']);

                    foreach($request->file('house_images') as $houseImageKey => $houseImageFile) {
                        $name = time().'_'.$houseImageFile->getClientOriginalName();
                        $houseImageFile->move(public_path().'/images/house_images', $name);

                        $houseImage = new HouseImage;
                        $houseImage->title = $name;
                        $houseImage->floor_plan_id = $floorPlan->id;
                        $houseImage->save();
                    }

                    foreach($request->file('floor_plan_images') as $floorPlanImageKey => $floorPlanImageFile) {
                        $name = time().'_'.$floorPlanImageFile->getClientOriginalName();
                        $floorPlanImageFile->move(public_path().'/images/floor_plan_images', $name);

                        $floorPlanImage = new FloorPlanImage;
                        $floorPlanImage->title = $name;
                        $floorPlanImage->floor_plan_id = $floorPlan->id;
                        $floorPlanImage->save();
                    }

                    $notifMessage = "New floor plan was added successfully.";
                    $notifType = "success";
                } catch (Exception $ex) {
                    $notifMessage = $ex->getMessage();
                    $notifType = "error";
                }
                
                return ["notifMessage" => $notifMessage, "notifType" => $notifType];
            }
        }
    }

    public function putFloorPlan(Request $request){
        $id = $request->post('id');
        $key = $request->post('key');
        $value = $request->post('value');

        try {
            $floorPlan = FloorPlan::findOrFail($id)->update([$key => $value]);
            $notifMessage = "Floor plan was updated successfully.";
            $notifType = "success";
        } catch (Exception $ex) {
            $notifMessage = $ex->getMessage();
            $notifType = "error";
        }
        
        return ["notifMessage" => $notifMessage, "notifType" => $notifType];
    }

    public function deleteFloorPlan(Request $request){
        $id = $request->post('id');

        try {
            $floorPlan = FloorPlan::findOrFail($id)->delete();
            $houseImages = HouseImage::where('floor_plan_id', $id)->delete();
            $floorPlanImages = FloorPlanImage::where('floor_plan_id', $id)->delete();
            
            $notifMessage = "Floor plan was removed successfully.";
            $notifType = "success";
        } catch (Exception $ex) {
            $notifMessage = $ex->getMessage();
            $notifType = "error";
        }
        
        return ["notifMessage" => $notifMessage, "notifType" => $notifType];
    }
}
