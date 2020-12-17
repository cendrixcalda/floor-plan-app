<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    protected $fillable = [
        'username',
        'password',
        'plain_password',
        'user_type',
        'adss_content_manager_access',
        'floor_plan_access',
        'floor_plan_edit_privilege',
    ];

    protected $hidden = [
        'password', 'created_at', 'updated_at', 'deleted_at'
    ];
}
