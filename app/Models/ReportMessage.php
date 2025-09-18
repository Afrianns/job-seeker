<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportMessage extends Model
{
    use HasUuids;

    protected $fillable = ["user_id", "report_id", "message"];   

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function Report(): BelongsTo
    {
        return $this->belongsTo(Report::class);
    }
}
