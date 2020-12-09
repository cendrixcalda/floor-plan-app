<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'username',
        'password',
        'account_type',
        'adss_content_manager_access',
        'floor_plan_access',
        'floor_plan_edit_privilege',
    ];
}
