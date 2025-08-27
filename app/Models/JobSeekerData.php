<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobSeekerData extends Model
{
    public $fillable = ["name","size","type","cv_path","user_id", "status"];

    use HasUuids;

    public function jobSeeker(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
