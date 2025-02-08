<?php

namespace Database\Factories\Akademik;

use App\Models\Akademik\Ujian;
use App\Models\Soal\PaketSoal;
use App\Models\Akademik\KelasBimbel;
use Illuminate\Database\Eloquent\Factories\Factory;

class UjianFactory extends Factory
    {

    protected $model = Ujian::class;

    /**
     * Status yang tersedia untuk ujian
     */
    private const AVAILABLE_STATUSES = [ 'aktif' ];

    /**
     * Tipe ujian yang tersedia
     */
    private const AVAILABLE_TYPES = [
        'ulangan_harian',
        'ujian_tengah_semester',
        'ujian_akhir_semester',
        'remedial',
        'try_out',
    ];

    /**
     * Mode ujian yang tersedia
     */
    private const AVAILABLE_MODES = [ 'offline', 'online' ];

    public function definition () : array
        {

        $startDate = $this->faker->dateTimeBetween ( 'now', '+1 month' );
        $endDate   = $this->faker->dateTimeBetween ( $startDate, '+2 months' );

        return [
            'paket_soal_id'   => \App\Models\Soal\PaketSoal::factory (),
            'kelas_bimbel_id' => \App\Models\Akademik\KelasBimbel::factory (),
            'judul'           => $this->generateTitle (),
            'deskripsi'       => $this->generateDescription (),
            'instruksi'       => $this->generateInstructions (),
            'tipe_ujian'      => $this->faker->randomElement ( self::AVAILABLE_TYPES ),
            'mode_ujian'      => $this->faker->randomElement ( self::AVAILABLE_MODES ),
            'tanggal_mulai'   => $startDate,
            'tanggal_selesai' => $endDate,
            'durasi'          => $this->faker->numberBetween ( 30, 180 ),
            'jumlah_soal'     => $this->faker->numberBetween ( 10, 50 ),
            'bobot_per_soal'  => $this->faker->numberBetween ( 1, 5 ),
            'nilai_minimum'   => $this->faker->numberBetween ( 65, 80 ),
            'acak_soal'       => $this->faker->boolean,
            'tampilkan_hasil' => $this->faker->boolean,
            'status'          => 'draft',
            'created_at'      => now (),
            'updated_at'      => now (),
        ];
        }

    /**
     * Menghasilkan judul yang valid
     */
    protected function generateTitle () : string
        {

        $types = [
            'Ulangan Harian',
            'Ujian Tengah Semester',
            'Ujian Akhir Semester',
            'Remedial',
            'Try Out',
        ];

        $subjects = [
            'Matematika',
            'Fisika',
            'Kimia',
            'Biologi',
            'Bahasa Indonesia',
            'Bahasa Inggris',
        ];

        $chapters = [
            'Bab 1',
            'Bab 2',
            'Bab 3',
            'Semester 1',
            'Semester 2',
        ];

        return $this->faker->randomElement ( $types ) . ' ' .
            $this->faker->randomElement ( $subjects ) . ' ' .
            $this->faker->randomElement ( $chapters );
        }

    /**
     * Menghasilkan deskripsi yang valid
     */
    protected function generateDescription () : string
        {

        $descriptionParts = [
            'Ujian ini mencakup materi:',
            '- ' . $this->faker->sentence (),
            '- ' . $this->faker->sentence (),
            '- ' . $this->faker->sentence (),
            'Tujuan pembelajaran:',
            '1. ' . $this->faker->sentence (),
            '2. ' . $this->faker->sentence ()
        ];

        return implode ( "\n", $descriptionParts );
        }

    /**
     * Menghasilkan instruksi yang valid
     */
    protected function generateInstructions () : string
        {

        $instructionParts = [
            'Petunjuk Pengerjaan:',
            '1. Baca soal dengan teliti',
            '2. Waktu pengerjaan ' . $this->faker->numberBetween ( 30, 180 ) . ' menit',
            '3. Kerjakan soal dari yang termudah',
            '4. Periksa kembali jawaban sebelum submit',
            'Catatan:',
            '- ' . $this->faker->sentence (),
            '- ' . $this->faker->sentence ()
        ];

        return implode ( "\n", $instructionParts );
        }

    /**
     * State untuk ujian dengan status tertentu
     */
    public function withStatus ( string $status ) : static
        {

        if ( ! in_array ( $status, self::AVAILABLE_STATUSES ) )
            {
            throw new \InvalidArgumentException( "Status '$status' tidak valid" );
            }

        return $this->state ( [ 'status' => $status ] );
        }

    /**
     * State untuk ujian dengan tipe tertentu
     */
    public function withType ( string $type ) : static
        {

        if ( ! in_array ( $type, self::AVAILABLE_TYPES ) )
            {
            throw new \InvalidArgumentException( "Tipe ujian '$type' tidak valid" );
            }

        return $this->state ( [ 'tipe_ujian' => $type ] );
        }

    /**
     * State untuk ujian dengan mode tertentu
     */
    public function withMode ( string $mode ) : static
        {

        if ( ! in_array ( $mode, self::AVAILABLE_MODES ) )
            {
            throw new \InvalidArgumentException( "Mode ujian '$mode' tidak valid" );
            }

        return $this->state ( [ 'mode_ujian' => $mode ] );
        }

    /**
     * State untuk ujian dengan paket soal tertentu
     */
    public function forPaketSoal ( \App\Models\Soal\PaketSoal $paketSoal ) : static
        {

        return $this->state ( [ 'paket_soal_id' => $paketSoal->id ] );
        }

    /**
     * State untuk ujian dengan kelas bimbel tertentu
     */
    public function forKelasBimbel ( \App\Models\Akademik\KelasBimbel $kelasBimbel ) : static
        {

        return $this->state ( [ 'kelas_bimbel_id' => $kelasBimbel->id ] );
        }

    /**
     * State untuk ujian dengan durasi tertentu
     */
    public function withDuration ( int $minutes ) : static
        {

        if ( $minutes < 15 || $minutes > 180 )
            {
            throw new \InvalidArgumentException( "Durasi harus antara 15 dan 180 menit" );
            }

        return $this->state ( [ 'durasi' => $minutes ] );
        }

    /**
     * State untuk ujian dengan jumlah soal tertentu
     */
    public function withQuestionCount ( int $count ) : static
        {

        if ( $count < 5 || $count > 100 )
            {
            throw new \InvalidArgumentException( "Jumlah soal harus antara 5 dan 100" );
            }

        return $this->state ( [ 'jumlah_soal' => $count ] );
        }

    /**
     * State untuk ujian dengan bobot per soal tertentu
     */
    public function withQuestionWeight ( int $weight ) : static
        {

        if ( $weight < 1 || $weight > 10 )
            {
            throw new \InvalidArgumentException( "Bobot per soal harus antara 1 dan 10" );
            }

        return $this->state ( [ 'bobot_per_soal' => $weight ] );
        }

    /**
     * State untuk ujian dengan nilai minimum tertentu
     */
    public function withMinimumScore ( int $score ) : static
        {

        if ( $score < 0 || $score > 100 )
            {
            throw new \InvalidArgumentException( "Nilai minimum harus antara 0 dan 100" );
            }

        return $this->state ( [ 'nilai_minimum' => $score ] );
        }

    /**
     * State untuk ujian dengan pengacakan soal
     */
    public function withRandomQuestions ( bool $random = TRUE ) : static
        {

        return $this->state ( [ 'acak_soal' => $random ] );
        }

    /**
     * State untuk ujian dengan tampilan hasil
     */
    public function withResultDisplay ( bool $display = TRUE ) : static
        {

        return $this->state ( [ 'tampilkan_hasil' => $display ] );
        }

    /**
     * State untuk ujian dengan tanggal mulai dan selesai tertentu
     */
    public function withDateRange ( \DateTime $startDate, \DateTime $endDate ) : static
        {

        if ( $startDate >= $endDate )
            {
            throw new \InvalidArgumentException( "Tanggal mulai harus lebih awal dari tanggal selesai" );
            }

        return $this->state ( [
            'tanggal_mulai'   => $startDate,
            'tanggal_selesai' => $endDate,
        ] )
        ;
        }

    }
