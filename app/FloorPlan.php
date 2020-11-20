<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FloorPlan extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'tracking_id',
        'living_1',
        'living_2',
        'dining',
        'kitchen_with_nook',
        'kitchen_without_nook',
        'scullery/WIP',
        'bathroom_1',
        'WC',
        'bed_1',
        'bed_2',
        'bed_3',
        'guest_with_ensuite',
        'entry',
        'garage',
        'laundry',
        'ensuite',
        'WIR',
        'storage_1',
        'storage_2',
        'stairs_1',
        'study_nook',
        'study_room',
        'study/Office_nook',
        'gameroom',
        'hallway_1',
        'hallway_2',
        'utility',
        'fire_place',

        'bathroom_2',
        'bathroom_3',
        'bathroom_4',
        'bathroom_5',
        'WC_2',
        'deck_1',
        'deck_2',
        'bedroom_4',
        'bedroom_5',
        'WIR_2',
        'WIR_3',
        'WIR_4',
        'stairs_2',
        'stairs_3',
        'living_3',
        'kitchen_2',
        'hallway_3',
        'hallway_4',
        'hallway_5',
        'ensuite_2',
        'storage_3',
        'storage_4',
        'pool',
        'spa',
        'courtyard',

        'floor_level',
        'number_of_levels',
        'area',
        'length',
        'width',

        'bedroom_per_level',
        'living_per_level',
        'bathroom_per_level',
        'carport_per_level',

        'bedroom_per_building',
        'living_per_building',
        'bathroom_per_building',
        'carport_per_building',

        'shape',
        'remarks',
        'house_name',
        'brand',
    ];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    public function houseImage(){
    	return $this->hasMany(HouseImage::class);
    }

    public function floorPlanImage(){
    	return $this->hasMany(FloorPlanImage::class);
    }

    public function file(){
    	return $this->hasMany(File::class);
    }
}
