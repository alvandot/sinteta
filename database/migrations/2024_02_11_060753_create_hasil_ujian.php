<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hasil_ujians', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ujian_id')->constrained('ujians')->onDelete('cascade');
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('cascade');
            $table->foreignId('paket_soal_id')->constrained('paket_soals')->onDelete('cascade');

            // Informasi Jawaban
            $table->json('jawaban')->nullable()->comment('Menyimpan seluruh jawaban siswa dalam format JSON');
            $table->integer('total_jawaban_benar')->default(0);
            $table->integer('total_jawaban_salah')->default(0);
            $table->integer('total_tidak_dijawab')->default(0);

            // Penilaian
            $table->decimal('nilai_akhir', 5, 2)->nullable()->comment('Nilai akhir dalam skala 0-100');
            $table->json('detail_penilaian')->nullable()->comment('Detail penilaian per soal');

            // Status dan Waktu
            $table->enum('status', [
                'belum_mulai',
                'sedang_mengerjakan',
                'selesai',
                'tersubmit',
                'dinilai'
            ])->default('belum_mulai');

            $table->timestamp('waktu_mulai')->nullable();
            $table->timestamp('waktu_selesai')->nullable();
            $table->integer('durasi_pengerjaan')->nullable()->comment('Durasi pengerjaan dalam detik');

            // Metadata
            $table->json('metadata')->nullable()->comment('Informasi tambahan seperti device, browser, IP');
            $table->text('catatan_khusus')->nullable();

            // Timestamps
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index(['ujian_id', 'siswa_id']);
            $table->index('status');
            $table->index(['created_at', 'waktu_mulai']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_ujians');
    }
};
