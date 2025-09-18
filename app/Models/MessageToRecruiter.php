<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MessageToRecruiter extends Model
{
    use HasUuids;

    protected $fillable = ["report_id", "type", "message"];

    public function Report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }
}
