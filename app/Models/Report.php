<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Report extends Model
{
    use HasUuids;

    protected $fillable = ["job_listing_id", "is_resolved", "is_resolved_by_recruiter"];

    public function Job(): BelongsTo
    {
        return $this->belongsTo(JobListing::class, "job_listing_id");
    }

    public function reportMessage(): HasMany
    {
        return $this->hasMany(ReportMessage::class);
    }

    public function messageToRecruiter(): HasMany
    {
        return $this->hasMany(MessageToRecruiter::class);
    }
}
