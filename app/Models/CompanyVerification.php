<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyVerification extends Model
{
    use HasFactory;

    protected $fillable = ['company_id', 'status', 'catatan'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
