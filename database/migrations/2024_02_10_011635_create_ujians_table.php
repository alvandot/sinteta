<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ujians', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->date('tanggal_ujian');
            $table->foreignId('kelas_id')->constrained('kelas_bimbels')->cascadeOnDelete();
            $table->time('waktu_mulai'); // Format waktu
            $table->time('waktu_selesai'); // Mengubah dari dateTime ke time
            $table->integer('durasi');
            $table->foreignId('paket_soal_id')->constrained('paket_soals')->cascadeOnDelete();
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajarans')->cascadeOnDelete();
            $table->enum('status', ['aktif', 'nonaktif', 'selesai'])->default('nonaktif');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ujians');
    }
};
