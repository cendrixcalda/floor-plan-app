<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FloorPlan extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'tracking_id',
        'living_one',
        'living_two',
        'dining',
        'kitchen_with_nook',
        'kitchen_without_nook',
        'scullery/WIP',
        'bathroom_one',
        'WC',
        'bed_one',
        'bed_two',
        'bed_three',
        'entry',
        'garage',
        'laundry',
        'ensuite',
        'WIR',
        'storage_one',
        'storage_two',
        'stairs_one',
        'study_nook',
        'study/Office',
        'gameroom',
        'hallway_one',
        'hallway_two',
        'utility',
        'bathroom_two',
        'bathroom_three',
        'bathroom_four',
        'bathroom_five',
        'WC_two',
        'deck',
        'bedroom_four',
        'bedroom_five',
        'WIR_two',
        'stairs_two',
        'stairs_three',
        'living_three',
        'kitchen_two',
        'hallway_three',
        'hallway_four',
        'hallway_five',
        'storage_three',
        'ensuite_two',
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
    ];

    protected $hidden = ['created_at', 'updated_at', "deleted_at"];

    public function houseImage(){
    	return $this->hasMany(HouseImage::class);
    }

    public function floorPlanImage(){
    	return $this->hasMany(FloorPlanImage::class);
    }

    public function autocadFile(){
    	return $this->hasMany(AutocadFile::class);
    }
}
