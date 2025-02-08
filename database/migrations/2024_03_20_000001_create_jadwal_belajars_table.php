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
        Schema::create('jadwal_belajars', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jadwal');
            $table->foreignId('kelas_bimbel_id')->constrained()->cascadeOnDelete();
            $table->foreignId('mata_pelajaran_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tentor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ruangan_id')->constrained()->cascadeOnDelete();
            $table->date('tanggal_mulai');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->enum('status', ['selesai', 'berjalan', 'belum_mulai'])->default('belum_mulai');
            $table->string('keterangan')->nullable();
            $table->timestamps();

            // Unique constraint untuk mencegah jadwal bentrok
            $table->unique(['ruangan_id', 'tanggal_mulai', 'jam_mulai', 'jam_selesai'], 'jadwal_bentrok');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_belajars');
    }
};
