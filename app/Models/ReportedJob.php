<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportedJob extends Model
{
    use HasUuids;

    protected $fillable = ["user_id", "job_listing_id", "message"];   

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function Job(): BelongsTo
    {
        return $this->belongsTo(JobListing::class, "job_listing_id");
    }
}
