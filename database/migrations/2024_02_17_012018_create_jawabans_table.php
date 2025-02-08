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
        Schema::create('jawaban_pengguna', function (Blueprint $table) {
            // Primary key
            $table->id('id_jawaban');

            // Foreign keys with cascading delete/update
            $table->foreignId('id_tryout')
                ->constrained('ujians')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('id_pengguna')
                ->constrained('siswas')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            // Score details
            $table->decimal('skor', 5, 2)->default(0);
            $table->integer('jumlah_benar')->default(0);
            $table->integer('jumlah_salah')->default(0);
            $table->integer('waktu_pengerjaan')->comment('Duration in minutes');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_pengguna');
    }
};
