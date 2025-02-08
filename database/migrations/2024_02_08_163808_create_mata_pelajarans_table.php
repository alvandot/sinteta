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
        Schema::create('mata_pelajarans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pelajaran');
            $table->string('kode_pelajaran')->unique();
            $table->text('deskripsi')->nullable();
            $table->enum('kategori', ['IPA', 'IPS', 'BAHASA'])->default('IPA');
            $table->enum('tingkat_kelas', ['X', 'XI', 'XII'])->default('X');
            $table->enum('level_kesulitan', ['mudah', 'sedang', 'sulit'])->default('sedang');
            $table->integer('kkm')->default(70);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mata_pelajarans');
    }
};
