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
        Schema::create('kelas_bimbels', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelas');
            $table->foreignId('cabang_id')->constrained('cabangs')->cascadeOnDelete();
            $table->text('deskripsi')->nullable();
            $table->enum('tingkat_kelas', ['X', 'XI', 'XII'])->default('X');
            $table->enum('jurusan', ['IPA', 'IPS', 'BAHASA'])->default('IPA');
            $table->enum('program_bimbel', ['Reguler', 'Intensif', 'Private'])->default('Reguler');
            $table->integer('kapasitas')->default(30);
            $table->decimal('biaya_pendaftaran', 10, 2)->default(0);
            $table->decimal('biaya_bulanan', 10, 2)->default(0);
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->enum('status', ['active', 'inactive', 'full'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas_bimbels');
    }
};
