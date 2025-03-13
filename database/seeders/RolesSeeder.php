<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    public function run(): void
    {
        $roles = ['admin', 'company', 'alumni'];

        foreach ($roles as $role) {
            DB::table('roles')->insertOrIgnore(['name' => $role, 'created_at' => now(), 'updated_at' => now()]);
        }
    }
}
