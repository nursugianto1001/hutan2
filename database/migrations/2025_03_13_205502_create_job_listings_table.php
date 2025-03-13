<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('job_listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade'); 
            $table->string('judul');
            $table->string('jenis_pekerjaan');
            $table->integer('salary_min')->nullable();
            $table->integer('salary_max')->nullable();
            $table->text('deskripsi');
            $table->text('tanggung_jawab');
            $table->text('persyaratan');
            $table->text('keterampilan');
            $table->integer('jumlah_pelamar')->default(0);
            $table->enum('status', ['active', 'inactive', 'pending', 'open'])->default('pending');
            $table->datetime('expires_at')->nullable()->comment('Tanggal kadaluarsa lowongan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_listings');
    }
};
