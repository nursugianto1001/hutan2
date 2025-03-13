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
        $alumniUser = User::factory()->create([
            'name' => 'Alumni UNTAN',
            'email' => 'alumniuntan@gmail.com',
            'password' => bcrypt('alumni123'),
            'role_id' => $alumniRoleId,
            'nip' => null,
            'nim' => 'A001', // Hanya untuk alumni
            'email_verified_at' => now(),
        ]);

        // Buat data dummy untuk lowongan pekerjaan
        $company = DB::table('companies')->first(); // Ambil perusahaan pertama yang ada

        if ($company) { // Pastikan perusahaan ada sebelum insert job_listings
            DB::table('job_listings')->insert([
                'company_id' => $company->id, // ✅ Ambil ID perusahaan yang valid
                'judul' => 'Software Engineer',
                'deskripsi' => 'Membutuhkan Software Engineer dengan pengalaman minimal 2 tahun.',
                'jenis_pekerjaan' => 'Full-time',
                'salary_min' => 10000000,
                'salary_max' => 15000000,
                'tanggung_jawab' => 'Mengembangkan aplikasi web dengan Laravel',
                'persyaratan' => 'Pengalaman 2 tahun di bidang IT',
                'keterampilan' => 'Laravel, PHP, MySQL',
                'jumlah_pelamar' => 0,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Buat data dummy untuk aplikasi lamaran kerja
        DB::table('job_applications')->insert([
            [
                'user_id' => $alumniUser->id,
                'job_listing_id' => 1,
                'surat_lamaran' => 'surat_lamaran.pdf',
                'cv' => 'cv_alumni.pdf',
                'status' => 'pending',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Buat data dummy untuk jadwal wawancara
        DB::table('interview_schedules')->insert([
            [
                'user_id' => $alumniUser->id,
                'job_listing_id' => 1,
                'tanggal_wawancara' => now()->addDays(5),
                'status' => 'scheduled',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);

        // Buat data dummy untuk notifikasi
        DB::table('notifications')->insert([
            [
                'user_id' => $alumniUser->id,
                'isi' => 'Lamaran Anda sedang diproses.',
                'is_read' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
