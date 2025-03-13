<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Roles extends Model
{
    protected $table = 'roles';
    protected $fillable = ['name'];

    public $timestamps = false;

    /**
     * Relationship: Users
     */
    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }
}
