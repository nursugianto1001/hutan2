<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Roles;
use App\Models\Company;
use App\Models\JobApplication;
use App\Models\SavedJob;
use App\Models\InterviewSchedule;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role_id', 'nim', 'nip'];

    protected $hidden = ['password', 'remember_token'];

    public function role()
    {
        return $this->belongsTo(Roles::class);
    }

    public function company()
    {
        return $this->hasOne(Company::class);
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function savedJobs()
    {
        return $this->hasMany(SavedJob::class);
    }

    public function interviewSchedules()
    {
        return $this->hasMany(InterviewSchedule::class);
    }
}
