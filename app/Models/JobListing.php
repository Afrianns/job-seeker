<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class JobListing extends Model
{
    protected $fillable = ["title","description", "company_id"];

    use HasUuids;

    public function Tags(): BelongsToMany
    {
        return $this->BelongsToMany(Tag::class,"job_tags");
    }

    public function Company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function Application(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function Report(): HasOne
    {
        return $this->hasOne(Report::class);
    }

    public function MessageToRecruiter(): HasMany
    {
        return $this->hasMany(MessageToRecruiter::class);
    }
}
