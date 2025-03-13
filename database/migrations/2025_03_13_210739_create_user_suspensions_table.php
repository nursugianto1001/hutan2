<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('user_suspensions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('start_date')->useCurrent()->comment('Tanggal mulai blokir');
            $table->timestamp('end_date')->nullable()->comment('Tanggal berakhir blokir');
            $table->string('reason')->comment('Alasan blokir, misal: tidak hadir wawancara, menarik lamaran terlalu sering');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_suspensions');
    }
};
