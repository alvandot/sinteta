<?php

namespace App\Livewire\Kacap\Siswa;

use App\Models\Akademik\KelasBimbel;
use Livewire\Component;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Layout;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Symfony\Component\Finder\SplFileInfo;
use TallStackUi\Traits\Interactions;

#[Layout('components.layouts.kacapLayout')]
class Pendaftaran extends Component
{
    use WithFileUploads, Interactions;

    /** @var \Illuminate\Support\Collection */
    public $kelas;

    /** @var array|UploadedFile|null */
    public $foto;

    /** @var array */
    public $form = [
        'nama' => '',
        'kelas_bimbel_id' => '',
        'jenis_kelamin' => '',
        'tanggal_lahir' => '',
        'alamat' => '',
        'asal_sekolah' => '',
        'jurusan' => '',
        'nama_wali' => '',
        'no_telepon_wali' => '',
    ];

    protected const STORAGE_PATH = 'storage/images/Pendaftaran_Siswa';
    protected const STORAGE_URL_PATH = 'images/Pendaftaran_Siswa/';

    public function mount(): void
    {
        $this->loadKelasBimbel();
        $this->loadExistingPhotos();
    }

    private function loadKelasBimbel(): void
    {
        $this->kelas = KelasBimbel::with('cabang')->get();
    }

    private function loadExistingPhotos(): void
    {
        $this->foto = $this->getFilesFromDirectory();
    }

    private function getFilesFromDirectory(): array
    {
        return collect(File::allFiles(public_path(self::STORAGE_PATH)))
            ->map(fn (SplFileInfo $file) => $this->mapFileInfo($file))
            ->toArray();
    }

    private function mapFileInfo(SplFileInfo $file): array
    {
        return [
            'name' => $file->getFilename(),
            'extension' => $file->getExtension(),
            'size' => $file->getSize(),
            'path' => $file->getRealPath(),
            'url' => Storage::url(self::STORAGE_URL_PATH . $file->getFilename()),
        ];
    }

    public function deleting(array $content): void
    {
        if (!$this->foto) {
            return;
        }

        $this->handleFileDeletion($content);
    }

    private function handleFileDeletion(array $content): void
    {
        $files = Arr::wrap($this->foto);
        $fileToDelete = $this->findFileToDelete($files, $content['temporary_name']);

        if ($fileToDelete) {
            $this->deleteFile($fileToDelete);
        }

        $this->updateRemainingFiles($content['temporary_name']);
    }

    private function findFileToDelete(array $files, string $temporaryName): ?UploadedFile
    {
        return collect($files)
            ->filter(fn (UploadedFile $item) => $item->getFilename() === $temporaryName)
            ->first();
    }

    private function deleteFile(UploadedFile $file): void
    {
        rescue(fn () => $file->delete(), report: false);
    }

    private function updateRemainingFiles(string $temporaryName): void
    {
        $remainingFiles = collect($this->foto)
            ->filter(fn (UploadedFile $item) => $item->getFilename() !== $temporaryName);

        $this->foto = is_array($this->foto)
            ? $remainingFiles->toArray()
            : $remainingFiles->first();
    }

    public function render()
    {
        return view('livewire.kacap.siswa.pendaftaran');
    }
}
