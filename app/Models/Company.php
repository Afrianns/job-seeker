<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Company extends Model
{
    use HasUuids;
    use HasFactory;
    
    protected $fillable = ["name", "email","description","is_approved","verification_document"];

    
    public function Jobs(): HasMany
    {
        return $this->hasMany(JobListing::class);
    }

    public function link(): HasOne
    {
        return $this->hasOne(CompanyLink::class);
    }

    public function verification(): HasOne
    {
        return $this->hasOne(CompanyVerification::class);
    }

    public function recruiter(): HasOne
    {
        return $this->hasOne(Company::class);
    }
}
