<?php

namespace App\Livewire\Admin\Soal;

use App\Models\Soal\PaketSoal;
use Illuminate\View\View;
use Livewire\Component;
use App\Models\Soal\Soal;
use Mary\Traits\Toast;
use Livewire\WithFileUploads;
use App\Models\Soal\SoalOpsi;

/**
 * Class BuatSoal
 * Komponen Livewire untuk membuat dan mengelola soal ujian
 *
 * Class ini menangani:
 * - Pembuatan paket soal baru
 * - Penambahan soal pilihan ganda dan essay
 * - Upload dan preview gambar soal
 * - Validasi input soal
 * - Penyimpanan soal ke database
 */
class BuatSoal extends Component
{
    use Toast;
    use WithFileUploads;

    /**
     * Konstanta untuk opsi pilihan ganda (A,B,C,D,E)
     * Digunakan sebagai pilihan jawaban standar untuk soal pilihan ganda
     */
    protected const PILIHAN_GANDA_OPTIONS = ['A', 'B', 'C', 'D', 'E'];

    /**
     * Konfigurasi untuk upload gambar
     * Mengatur batasan dan panduan untuk gambar yang diupload:
     * - Aspect ratio 16:9
     * - Ukuran minimum 100x100 pixel
     * - Ukuran maksimum 1000x1000 pixel
     * - Menampilkan panduan visual saat upload
     */
    public $configImg = [
        'viewMode' => 2, // Menggunakan mode 2 untuk tampilan yang lebih baik
        'autoCropArea' => 0.8, // Area crop otomatis yang lebih optimal
        'responsive' => true,
        'restore' => false,
        'guides' => true,
        'center' => true,
        'highlight' => true,
        'background' => true, // Menambahkan background untuk kontras yang lebih baik
        'cropBoxMovable' => true,
        'cropBoxResizable' => true,
        'toggleDragModeOnDblclick' => true,
        'minContainerWidth' => 300, // Lebar minimum container
        'minContainerHeight' => 200, // Tinggi minimum container
        'minCropBoxWidth' => 100, // Lebar minimum crop box
        'minCropBoxHeight' => 100, // Tinggi minimum crop box
        'rotatable' => true, // Memungkinkan rotasi gambar
        'scalable' => true, // Memungkinkan scaling gambar
        'zoomable' => true, // Memungkinkan zoom gambar
        'zoomOnTouch' => true, // Zoom dengan touch gesture
        'zoomOnWheel' => true, // Zoom dengan mouse wheel
        'wheelZoomRatio' => 0.1, // Rasio zoom yang lebih halus
    ];

    /**
     * Data form untuk membuat paket soal
     * Menyimpan informasi dasar paket soal seperti:
     * - Nama dan deskripsi paket
     * - Mata pelajaran dan kategori
     * - Tingkat kelas dan tahun ajaran
     * - Jumlah soal pilihan ganda dan essay
     */
    public $formData = [
        'nama' => '',
        'deskripsi' => '',
        'mata_pelajaran_id' => '',
        'kategori_id' => '',
        'tingkat' => '',
        'tahun' => '',
        'jumlah_soal_pilgan' => 1,
        'jumlah_soal_essay' => 0,
    ];

    /**
     * ID paket soal yang sedang dibuat
     * Digunakan untuk referensi saat menyimpan soal
     */
    public $paket_soal_id;

    /**
     * Array untuk menyimpan soal pilihan ganda
     * Setiap elemen berisi detail soal seperti pertanyaan, pilihan jawaban, dan kunci
     */
    public $soal_pilgan = [];

    /**
     * Array untuk menyimpan soal essay
     * Setiap elemen berisi pertanyaan dan kunci jawaban essay
     */
    public $soal_essay = [];

    /**
     * Array untuk menyimpan preview gambar
     * Menyimpan URL temporary untuk preview gambar yang diupload
     */
    public $gambarPreview = [];

    /**
     * Kategori soal yang tersedia
     * Mendefinisikan jenis-jenis soal yang dapat dibuat
     */
    public $kategories = [
        ['id' => 1, 'nama' => 'Pilihan Ganda'],
        ['id' => 2, 'nama' => 'Essay']
    ];

    /**
     * Daftar mata pelajaran yang tersedia
     * Diisi saat inisialisasi komponen
     */
    public $mataPelajarans;

    /**
     * Daftar tingkat kelas yang tersedia
     * Diisi saat inisialisasi komponen
     */
    public $tingkats;

    /**
     * Mendapatkan semua rules validasi
     * Menggabungkan rules untuk form utama, soal pilgan, dan soal essay
     *
     * @return array Rules validasi lengkap
     */
    protected function rules()
    {
        return array_merge(
            $this->getFormRules(),
            $this->getSoalPilganRules(),
            $this->getSoalEssayRules()
        );
    }

    /**
     * Rules validasi untuk form utama
     * Memastikan input dasar paket soal valid
     *
     * @return array Rules untuk form utama
     */
    protected function getFormRules()
    {
        return [
            'formData.mata_pelajaran_id' => 'required',
            'formData.tahun' => 'required|numeric',
            'formData.jumlah_soal_pilgan' => 'required|numeric|min:0|max:50',
            'formData.jumlah_soal_essay' => 'required|numeric|min:0|max:20'
        ];
    }

    /**
     * Rules validasi untuk soal pilihan ganda
     * Memvalidasi setiap soal pilihan ganda yang dibuat
     *
     * @return array Rules untuk soal pilihan ganda
     */
    protected function getSoalPilganRules()
    {
        $rules = [];
        $baseRules = [
            'pertanyaan' => 'required',
            'kunci_jawaban' => 'required',
            'gambar' => 'nullable|image|max:2048'
        ];

        foreach(self::PILIHAN_GANDA_OPTIONS as $option) {
            $baseRules["pilihan_" . strtolower($option)] = 'required';
        }

        for($i = 1; $i <= $this->formData['jumlah_soal_pilgan']; $i++) {
            foreach($baseRules as $field => $rule) {
                $rules["soal_pilgan.$i.$field"] = $rule;
            }
        }

        return $rules;
    }

    /**
     * Rules validasi untuk soal essay
     * Memvalidasi setiap soal essay yang dibuat
     *
     * @return array Rules untuk soal essay
     */
    protected function getSoalEssayRules()
    {
        $rules = [];
        $baseRules = [
            'pertanyaan' => 'required',
            'kunci_jawaban' => 'required',
            'gambar' => 'nullable|image|max:2048'
        ];

        for($i = 1; $i <= $this->formData['jumlah_soal_essay']; $i++) {
            foreach($baseRules as $field => $rule) {
                $rules["soal_essay.$i.$field"] = $rule;
            }
        }

        return $rules;
    }

    /**
     * Inisialisasi awal saat komponen dimuat
     * Memanggil method untuk inisialisasi data form
     */
    public function mount()
    {
        $this->initializeFormData();
    }

    /**
     * Inisialisasi data form
     * Mengatur nilai default untuk form dan mengisi data referensi
     */
    protected function initializeFormData()
    {
        $this->formData['tahun'] = date('Y');
        $this->paket_soal_id = PaketSoal::count();
        $this->formData['jumlah_soal_pilgan'] = 1;
        $this->formData['jumlah_soal_essay'] = 0;
        $this->tingkats = [
            ['key' => '7', 'value' => 'Kelas 7'],
            ['key' => '8', 'value' => 'Kelas 8'],
            ['key' => '9', 'value' => 'Kelas 9'],
            ['key' => '10', 'value' => 'Kelas 10'],
            ['key' => '11', 'value' => 'Kelas 11'],
            ['key' => '12', 'value' => 'Kelas 12']
        ];
        $this->mataPelajarans = [
            ['id' => 1, 'nama' => 'Matematika'],
            ['id' => 2, 'nama' => 'Bahasa Indonesia'],
            ['id' => 3, 'nama' => 'Bahasa Inggris'],
            ['id' => 4, 'nama' => 'IPA'],
            ['id' => 5, 'nama' => 'IPS'],
            ['id' => 6, 'nama' => 'Matematika Wajib'],
            ['id' => 7, 'nama' => 'Bahasa Indonesia Wajib'],
            ['id' => 8, 'nama' => 'Bahasa Inggris Wajib'],
            ['id' => 9, 'nama' => 'Matematika Peminatan'],
            ['id' => 10, 'nama' => 'Bahasa Indonesia Peminatan'],
            ['id' => 11, 'nama' => 'Bahasa Inggris Peminatan'],
            ['id' => 12, 'nama' => 'Fisika Peminatan'],
            ['id' => 13, 'nama' => 'Kimia Peminatan'],
            ['id' => 14, 'nama' => 'Biologi Peminatan'],
            ['id' => 15, 'nama' => 'Ekonomi Peminatan'],
            ['id' => 16, 'nama' => 'Sosiologi Peminatan'],
            ['id' => 17, 'nama' => 'Geografi Peminatan'],
            ['id' => 18, 'nama' => 'Seni Budaya Peminatan'],
            ['id' => 19, 'nama' => 'Teknologi Informasi dan Komunikasi Peminatan'],
        ];
    }

    /**
     * Handler saat jumlah soal pilgan diupdate
     * Menginisialisasi array gambar untuk soal pilihan ganda
     */
    public function updatedFormDataJumlahSoalPilgan()
    {
        $this->initializeSoalGambar('pilgan');
    }

    /**
     * Handler saat jumlah soal essay diupdate
     * Menginisialisasi array gambar untuk soal essay
     */
    public function updatedFormDataJumlahSoalEssay()
    {
        $this->initializeSoalGambar('essay');
    }

    /**
     * Inisialisasi gambar soal
     * Menyiapkan array untuk menyimpan gambar soal
     *
     * @param string $type Tipe soal ('pilgan' atau 'essay')
     */
    protected function initializeSoalGambar($type = 'pilgan')
    {
        $soalArray = $type === 'pilgan' ? 'soal_pilgan' : 'soal_essay';
        $jumlahSoal = $type === 'pilgan' ?
            $this->formData['jumlah_soal_pilgan'] :
            $this->formData['jumlah_soal_essay'];

        for($i = 1; $i <= $jumlahSoal; $i++) {
            $this->$soalArray[$i]['gambar'] = null;
        }
    }

    /**
     * Handler saat soal pilgan diupdate
     * Menangani perubahan pada soal pilihan ganda
     *
     * @param mixed $value Nilai baru
     * @param string $key Key yang diupdate
     */
    public function updatedSoalPilgan($value, $key)
    {
        $this->handleGambarUpdate($value, $key, 'pilgan');
    }

    /**
     * Handler saat soal essay diupdate
     * Menangani perubahan pada soal essay
     *
     * @param mixed $value Nilai baru
     * @param string $key Key yang diupdate
     */
    public function updatedSoalEssay($value, $key)
    {
        $this->handleGambarUpdate($value, $key, 'essay');
    }

    /**
     * Handler untuk update gambar
     * Memproses upload gambar dan membuat preview
     *
     * @param mixed $value Nilai gambar
     * @param string $key Key gambar
     * @param string $type Tipe soal
     */
    protected function handleGambarUpdate($value, $key, $type)
    {
        if (str_contains($key, 'gambar') && $value) {
            $index = explode('.', $key)[1];
            $this->gambarPreview["{$type}_{$index}"] = $value->temporaryUrl();
        }
    }

    /**
     * Menyimpan soal ke database
     * Memvalidasi input dan menyimpan paket soal beserta detailnya
     */
    public function simpanSoal()
    {
        $this->validate();
        $paketSoal = $this->createPaketSoal();
        $this->createSoalDetails($paketSoal->id);
        $this->showSuccessMessage();
    }

    /**
     * Menampilkan pesan sukses
     * Menampilkan notifikasi dan redirect setelah penyimpanan berhasil
     */
    protected function showSuccessMessage()
    {
        $this->success(
            'Soal berhasil disimpan!',
            redirectTo: route('admin.soal.index'),
            css: 'alert-success animate-pulse bg-gradient-to-r from-green-500 via-green-400 to-green-500 text-white font-bold shadow-lg'
        );
    }

    /**
     * Membuat paket soal baru
     * Menyimpan data paket soal ke database
     *
     * @return PaketSoal Instance paket soal yang baru dibuat
     */
    protected function createPaketSoal()
    {
        return PaketSoal::create([
            'nama' => $this->generateNamaPaket(),
            'deskripsi' => $this->generateDeskripsi(),
            'mata_pelajaran_id' => $this->formData['mata_pelajaran_id'],
            'tingkat' => $this->formData['tingkat'],
            'tahun' => $this->formData['tahun']
        ]);
    }

    /**
     * Generate nama paket soal
     * Membuat nama paket soal otomatis jika tidak diisi
     *
     * @return string Nama paket soal
     */
    protected function generateNamaPaket()
    {
        return $this->formData['nama'] ?? sprintf(
            'Soal %s %s',
            $this->mataPelajarans[$this->formData['mata_pelajaran_id']-1]['nama'],
            $this->tingkats[$this->formData['tingkat']]
        );
    }

    /**
     * Generate deskripsi paket soal
     * Membuat deskripsi paket soal otomatis jika tidak diisi
     *
     * @return string Deskripsi paket soal
     */
    protected function generateDeskripsi()
    {
        return $this->formData['deskripsi'] ?? sprintf(
            'Soal latihan untuk %s semester 1',
            $this->tingkats[$this->formData['tingkat']]
        );
    }

    /**
     * Membuat detail soal
     * Menyimpan soal pilihan ganda dan essay ke database
     *
     * @param int $paketSoalId ID paket soal
     */
    protected function createSoalDetails($paketSoalId)
    {
        // Create pilihan ganda questions
        foreach($this->soal_pilgan as $detail) {
            $this->createSingleSoal($paketSoalId, $detail, 'pilihan_ganda');
        }

        // Create essay questions
        foreach($this->soal_essay as $detail) {
            $this->createSingleSoal($paketSoalId, $detail, 'essay');
        }
    }

    /**
     * Membuat satu soal
     * Menyimpan detail satu soal ke database
     *
     * @param int $paketSoalId ID paket soal
     * @param array $detail Detail soal
     * @param string $jenisSoal Jenis soal ('pilihan_ganda' atau 'essay')
     */
    protected function createSingleSoal($paketSoalId, $detail, $jenisSoal)
    {
        // Hitung nomor urut terakhir untuk paket soal ini
        $lastNomorUrut = Soal::where('paket_soal_id', $paketSoalId)
            ->where('jenis_soal', $jenisSoal)
            ->max('nomor_urut') ?? 0;

        // Hitung total soal dalam paket
        $totalSoal = $this->formData['jumlah_soal_pilgan'] + $this->formData['jumlah_soal_essay'];

        // Hitung bobot per soal (100 dibagi total soal)
        $bobot = 100 / $totalSoal;

        $soalData = [
            'paket_soal_id' => $paketSoalId,
            'pertanyaan' => $detail['pertanyaan'],
            'jenis_soal' => $jenisSoal,
            'gambar' => $this->processGambar($detail, $paketSoalId),
            'nomor_urut' => $lastNomorUrut + 1,
            'bobot' => $bobot, // Tambahkan bobot soal
            'created_by' => auth()->id()
        ];

        // Buat soal terlebih dahulu
        $soal = Soal::create($soalData);

        if ($jenisSoal === 'pilihan_ganda') {
            // Simpan opsi pilihan ganda ke tabel soal_opsi
            foreach (self::PILIHAN_GANDA_OPTIONS as $index => $label) {
                SoalOpsi::create([
                    'soal_id' => $soal->id,
                    'label' => $label,
                    'jenis_soal' => 'pilihan_ganda',
                    'teks' => $detail['pilihan_' . strtolower($label)],
                    'is_jawaban' => $detail['kunci_jawaban'] === $label,
                    'urutan' => $index + 1,
                    'created_by' => auth()->id()
                ]);

                if ($detail['kunci_jawaban'] === $label) {
                    $soal->update(['kunci_pg' => $label]);
                }
            }
        } else {
            $soal->update(['kunci_jawaban' => $detail['kunci_jawaban']]);
        }
    }

    /**
     * Memproses upload gambar
     * Menyimpan gambar ke storage dan mengembalikan path
     *
     * @param array $detail Detail soal
     * @param int $paketSoalId ID paket soal
     * @return string|null Path gambar atau null jika tidak ada gambar
     */
    protected function processGambar($detail, $paketSoalId)
    {
        return isset($detail['gambar']) && $detail['gambar']
            ? $detail['gambar']->store('paket_soal/' . $paketSoalId, 'public')
            : null;
    }

    /**
     * Format opsi jawaban pilihan ganda
     * Mengubah format opsi jawaban menjadi array
     *
     * @param array $detail Detail soal
     * @return array Array opsi jawaban
     */
    protected function formatOpsiJawaban($detail)
    {
        // Method ini tidak lagi diperlukan karena opsi jawaban disimpan di tabel soal_opsi
        return [];
    }

    /**
     * Render view
     * Menampilkan halaman pembuatan soal
     *
     * @return View View untuk membuat soal
     */
    public function render(): View
    {
        return view('livewire.admin.soal.buat-soal');
    }
}
