<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company;
use App\Models\JobApplication;
use App\Models\SavedJob;

class JobListing extends Model
{
    use HasFactory;

    protected $fillable = ['company_id', 'judul', 'jenis_pekerjaan', 'salary_min', 'salary_max', 'deskripsi', 'tanggung_jawab', 'persyaratan', 'keterampilan', 'jumlah_pelamar', 'status', 'expires_at'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function savedJobs()
    {
        return $this->hasMany(SavedJob::class);
    }
}
