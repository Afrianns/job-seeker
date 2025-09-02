<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasUuids, SoftDeletes;

    protected $fillable = ["message", "job_id", "user_id", "sender_id", "receiver_id", "message_id", "application_id", "is_edited"];

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
