<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new

    class extends Migration {

    /**
     * Run the migrations.
     *
     * Membuat tabel untuk menyimpan soal-soal ujian dengan berbagai tipe
     * dan opsi jawabannya.
     */
    public function up(): void
    {

        Schema::create(
            'soals',

            function (Blueprint $table) {
                $table->id();
                $table->foreignId('paket_soal_id')
                    ->constrained('paket_soals')
                    ->cascadeOnDelete()
                    ->comment('Referensi ke paket soal')
                ;

                $table->unsignedSmallInteger('nomor_urut')
                    ->comment('Urutan soal dalam paket')
                ;

                $table->enum('jenis_soal', [
                    'pilihan_ganda',    // Single choice
                    'multiple_choice',  // Multiple choice
                    'essay'            // Essay/uraian
                ])
                    ->default('pilihan_ganda')
                    ->index()
                    ->comment('Tipe soal: pilihan_ganda/multiple_choice/essay')
                ;

                $table->text('pertanyaan')
                    ->comment('Isi pertanyaan soal')
                ;

                $table->string('kunci_pg', 10)
                    ->nullable()
                    ->comment('Kunci jawaban untuk soal pilihan ganda (single choice)')
                ;

                $table->text('kunci_multiple_choice')
                    ->nullable()
                    ->comment('Kunci jawaban untuk soal essay')
                ;
                $table->text('kunci_essay')
                    ->nullable()
                    ->comment('Kunci jawaban untuk soal essay')
                ;

                $table->string('gambar')
                    ->nullable()
                    ->comment('Path gambar pendukung soal jika ada')
                ;

                $table->unsignedTinyInteger('bobot')
                    ->default(1)
                    ->index()
                    ->comment('Bobot nilai soal')
                ;

                $table->json('metadata')
                    ->nullable()
                    ->comment('Data tambahan soal dalam format JSON (timer, petunjuk khusus, dll)')
                ;

                // Audit trail
                $table->foreignId('created_by')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete()
                    ->comment('User pembuat soal')
                ;

                $table->foreignId('updated_by')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete()
                    ->comment('User terakhir mengubah soal')
                ;

                $table->timestamps();
                $table->softDeletes()
                    ->index()
                ;

                // Indexes untuk optimasi query
                $table->index('nomor_urut');
                $table->unique(['paket_soal_id', 'nomor_urut'], 'unique_soal_urutan');
                $table->index(['created_at', 'updated_at']);
            }
        );

        Schema::create(
            'soal_opsi',

            function (Blueprint $table) {
                $table->id();
                $table->foreignId('soal_id')
                    ->constrained('soals')
                    ->cascadeOnDelete()
                    ->comment('Referensi ke soal')
                ;

                $table->char('label', 1)
                    ->comment('Label opsi (A/B/C/D/E)')
                    ->check('label in (\'A\',\'B\',\'C\',\'D\',\'E\')')
                ;

                $table->enum('jenis_soal', [
                    'pilihan_ganda',
                    'multiple_choice',
                    'essay',
                ])
                    ->default('pilihan_ganda')
                    ->index()
                    ->comment('Tipe soal untuk validasi')
                ;

                $table->text('teks')
                    ->comment('Isi opsi jawaban')
                ;

                $table->boolean('is_jawaban')
                    ->default(FALSE)
                    ->index()
                    ->comment('Penanda opsi ini adalah jawaban benar')
                ;

                $table->unsignedTinyInteger('urutan')
                    ->comment('Urutan tampilan opsi')
                ;

                // Audit trail
                $table->foreignId('created_by')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete()
                    ->comment('User pembuat opsi')
                ;

                $table->foreignId('updated_by')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete()
                    ->comment('User terakhir mengubah opsi')
                ;

                $table->timestamps();
                $table->softDeletes()
                    ->index()
                ;

                // Indexes
                $table->index(['soal_id', 'urutan']);
                $table->unique(['soal_id', 'label'], 'soal_opsi_unique');
                $table->index(['created_at', 'updated_at', 'deleted_at']);
            }
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soal_opsi');
        Schema::dropIfExists('soals');
    }

};
