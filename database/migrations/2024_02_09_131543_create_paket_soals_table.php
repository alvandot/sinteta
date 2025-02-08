<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaketSoalsTable extends Migration
{
    public function up()
    {
        Schema::create('paket_soals', function (Blueprint $table) {
            $table->id();
            $table->string('kode_paket')->unique();
            $table->string('tipe_soal');
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->foreignId('mata_pelajaran_id')->constrained('mata_pelajarans')->onDelete('cascade');
            $table->string('tingkat');
            $table->year('tahun');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('paket_soals');
    }
}
