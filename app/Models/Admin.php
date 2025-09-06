<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Admin extends Authenticatable
{
    protected $fillable = [
        'email',
        'password',
    ];

    use HasUuids;
    //
}
