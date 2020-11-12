<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FloorPlanImage extends Model
{
    use SoftDeletes;

    protected $fillable = ['title'];
}
