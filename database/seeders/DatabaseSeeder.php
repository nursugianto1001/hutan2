<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([RolesSeeder::class]);

        // Ambil role_id berdasarkan nama
        $adminRoleId = DB::table('roles')->where('name', 'admin')->value('id');
        $companyRoleId = DB::table('roles')->where('name', 'company')->value('id');
        $alumniRoleId = DB::table('roles')->where('name', 'alumni')->value('id');

        // Buat Admin
        User::factory()->create([
            'name' => 'Admin UNTAN',
            'email' => 'adminuntan@gmail.com',
            'password' => bcrypt('password123'),
            'role_id' => $adminRoleId,
            'nip' => '1987654321', // Hanya untuk admin
            'nim' => null,
            'email_verified_at' => now(),
        ]);

        // Buat akun Perusahaan
        $companyUser = User::factory()->create([
            'name' => 'PT Nusantara Tech',
            'email' => 'nusantaratech@gmail.com',
            'password' => bcrypt('company123'),
            'role_id' => $companyRoleId,
            'nip' => null,
            'nim' => null,
            'email_verified_at' => now(),
        ]);

        // Buat data perusahaan terkait
        DB::table('companies')->insert([
            'user_id' => $companyUser->id,
            'company_name' => 'PT Nusantara Tech',
            'contact_person' => 'Budi Santoso',
            'phone' => '08123456789',
            'address' => 'Jl. Merdeka No. 10, Jakarta',
            'website' => 'https://nusantaratech.com',
            'industry' => 'Teknologi Informasi',
            'status' => 'verified',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Buat akun Alumni
        User::factory()->create([
            'name' => 'Alumni UNTAN',
            'email' => 'alumniuntan@gmail.com',
            'password' => bcrypt('alumni123'),
            'role_id' => $alumniRoleId,
            'nip' => null,
            'nim' => 'A001', // Hanya untuk alumni
            'email_verified_at' => now(),
        ]);
    }
}
