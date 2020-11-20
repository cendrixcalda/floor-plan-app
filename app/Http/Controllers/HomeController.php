<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\FloorPlan;
use App\HouseImage;
use App\FloorPlanImage;
use App\File;

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

        $betweenKeys = ['area', 'length', 'width'];

        $floorPlans = FloorPlan::when($search, function ($query) use ($search, $betweenKeys) {
            foreach ($search as $key => $value) {
                if(in_array($key, $betweenKeys)) $query->whereBetween($key, [$value[0], $value[1]]);
                else $query->where($key, 'like', $value . '%');
            }
        })
        ->with('houseImage')
        ->with('floorPlanImage')
        ->with('file')
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

                    if($request->hasfile('files')) {
                        foreach($request->file('files') as $fileKey => $fileFile) {
                            $name = time().'_'.$fileFile->getClientOriginalName();
                            $fileFile->move(public_path().'/files/', $name);
    
                            $file = new File;
                            $file->title = $name;
                            $file->floor_plan_id = $floorPlan->id;
                            $file->save();
                        }
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
    
            if($key == 'bed_1' || $key == 'bed_2' || $key == 'bed_3' || $key == 'bedroom_4' || $key == 'bedroom_5') {
                $floorPlan = FloorPlan::find($id);
                $bedroomPerLevel = 0.00;

                $bedroomPerLevel += $floorPlan->bed_1 ? 1.00 : 0.00;
                $bedroomPerLevel += $floorPlan->bed_2 ? 1.00 : 0.00;
                $bedroomPerLevel += $floorPlan->bed_3 ? 1.00 : 0.00;
                $bedroomPerLevel += $floorPlan->bedroom_4 ? 1.00 : 0.00;
                $bedroomPerLevel += $floorPlan->bedroom_5 ? 1.00 : 0.00;

                $floorPlan->update(['bedroom_per_level' => $bedroomPerLevel]);

            } elseif ($key == 'living_1' || $key == 'living_2' || $key == 'living_3') {
                $floorPlan = FloorPlan::find($id);
                $livingPerLevel = 0.00;

                $livingPerLevel += $floorPlan->living_1 ? 1.00 : 0.00;
                $livingPerLevel += $floorPlan->living_2 ? 1.00 : 0.00;
                $livingPerLevel += $floorPlan->living_3 ? 1.00 : 0.00;

                $floorPlan->update(['living_per_level' => $livingPerLevel]);

            } elseif ($key == 'bathroom_1' || $key == 'bathroom_2' || $key == 'bathroom_3' || $key == 'bathroom_4' || $key == 'bathroom_5' || $key == 'guest_with_ensuite' || $key == 'ensuite' || $key == 'ensuite_2' || $key == 'WC' || $key == 'WC_2') {
                $floorPlan = FloorPlan::find($id);
                $bathroomPerLevel = 0.00;

                $bathroomPerLevel += $floorPlan->bathroom_1 ? 1.00 : 0.00;
                $bathroomPerLevel += $floorPlan->bathroom_2 ? 1.00 : 0.00;
                $bathroomPerLevel += $floorPlan->bathroom_3 ? 1.00 : 0.00;
                $bathroomPerLevel += $floorPlan->bathroom_4 ? 1.00 : 0.00;
                $bathroomPerLevel += $floorPlan->bathroom_5 ? 1.00 : 0.00;

                $bathroomPerLevel += $floorPlan->guest_with_ensuite ? 1.00 : 0.00;
                $bathroomPerLevel += $floorPlan->ensuite ? 1.00 : 0.00;
                $bathroomPerLevel += $floorPlan->ensuite_2 ? 1.00 : 0.00;
        
                $bathroomPerLevel += $floorPlan->WC ? 0.50 : 0.00;
                $bathroomPerLevel += $floorPlan->WC_2 ? 0.50 : 0.00;

                $floorPlan->update(['bathroom_per_level' => $bathroomPerLevel]);

            }

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
            $files = File::where('floor_plan_id', $id)->delete();
            
            $notifMessage = "Floor plan was removed successfully.";
            $notifType = "success";
        } catch (Exception $ex) {
            $notifMessage = $ex->getMessage();
            $notifType = "error";
        }
        
        return ["notifMessage" => $notifMessage, "notifType" => $notifType];
    }
}
