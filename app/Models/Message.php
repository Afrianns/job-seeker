<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    use HasUuids;

    protected $fillable = ["message", "job_id", "user_id"];

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
