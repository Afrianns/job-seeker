<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyVerification extends Model
{
    use HasUuids;
    use HasFactory;

    protected $fillable = ["name","size","type","document_path","company_id", "status"];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
