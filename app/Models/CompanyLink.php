<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyLink extends Model
{
    use HasUuids;

    protected $fillable = ["instagram_link","facebook_link","twitter_link","website_link", "company_id"];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
