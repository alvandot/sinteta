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
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('jenis_kelamin');
            $table->date('tanggal_lahir');
            $table->text('alamat');
            $table->string('no_telepon');
            $table->string('asal_sekolah');
            $table->string('kelas');
            $table->string('jurusan')->nullable();
            $table->string('nama_wali');
            $table->string('no_telepon_wali');
            $table->string('foto')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->date('tanggal_bergabung');
            $table->date('tanggal_berakhir')->nullable();
            $table->text('catatan')->nullable();
            $table->foreignId('kelas_bimbel_id')->constrained('kelas_bimbels')->cascadeOnDelete();
            $table->foreignId('cabang_id')->constrained()->cascadeOnDelete();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
