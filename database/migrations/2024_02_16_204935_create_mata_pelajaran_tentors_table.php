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
        Schema::create('mata_pelajaran_tentors', function (Blueprint $table) {
            // Primary key
            $table->foreignId('mata_pelajaran_id')
                ->constrained('mata_pelajarans')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreignId('tentor_id')
                ->constrained('tentors')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            // Set composite primary key
            $table->primary(['mata_pelajaran_id', 'tentor_id']);


            // Optional: Add additional pivot table specific columns
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->text('catatan')->nullable();

            // Add indexes for better query performance
            $table->index(['mata_pelajaran_id', 'tentor_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mata_pelajaran_tentors');
    }
};
