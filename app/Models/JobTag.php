<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobTag extends Model
{
    protected $fillable = ["tag_id", "job_listing_id"];
}
