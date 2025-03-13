<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'company_name', 'contact_person', 'phone', 'address', 'website', 'industry', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobListings()
    {
        return $this->hasMany(JobListing::class);
    }

    public function verification()
    {
        return $this->hasOne(CompanyVerification::class);
    }
}
