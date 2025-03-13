<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable()->comment('Waktu email diverifikasi');
            $table->string('password');
            $table->foreignId('role_id')->constrained('roles')->onDelete('cascade');
            $table->integer('withdraw_count')->default(0)->comment('Jumlah lamaran yang ditarik alumni'); // 🚀 HAPUS `after role_id`
            $table->string('nim')->unique()->nullable(); // Hanya untuk alumni
            $table->string('nip')->unique()->nullable(); // Hanya untuk admin
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
