<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Tag extends Model
{
    use HasUuids;
    
    protected $fillable = ["name", "total_used", "company_id"];


    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
