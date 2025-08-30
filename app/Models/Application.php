<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Application extends Model
{
    use HasUuids;
    protected $fillable = ["name","size","type","status","rejected_reason", "cv_path", "user_id", "job_listing_id"];


    public function Job(): BelongsTo
    {
        return $this->belongsTo(JobListing::class, "job_listing_id");
    }

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
