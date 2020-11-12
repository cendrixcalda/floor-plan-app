<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HouseImage extends Model
{
    use SoftDeletes;

    protected $fillable = ['title'];
}
