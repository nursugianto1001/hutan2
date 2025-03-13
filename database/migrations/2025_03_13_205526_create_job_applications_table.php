<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('job_listing_id')->constrained('job_listings')->onDelete('cascade');
            $table->string('surat_lamaran');
            $table->string('cv');
            $table->enum('status', ['pending', 'interview_scheduled', 'accepted', 'rejected', 'backup_candidate'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
