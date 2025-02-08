<?php

namespace App\Livewire;

use App\Traits\WithLoading;
use App\Traits\WithNotification;
use Livewire\Component;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;

class Example extends Component
{
    use WithLoading;
    use WithNotification;
    use WithFileUploads;

    #[Rule('required|min:3')]
    public string $name = '';

    #[Rule('required|email')]
    public string $email = '';

    #[Rule('nullable|image|max:1024')] // 1MB Max
    public $photo = null;

    #[Rule('required')]
    public string $type = '';

    #[Rule('required|min:10')]
    public string $description = '';

    public bool $showModal = false;

    public function save(): void
    {
        $this->loading(function () {
            $validated = $this->validate();

            try {
                // Simpan data
                // ...

                $this->reset();
                $this->success('Data berhasil disimpan!');
            } catch (\Exception $e) {
                $this->error('Terjadi kesalahan: ' . $e->getMessage());
            }
        });
    }

    public function render()
    {
        return view('livewire.example', [
            'types' => [
                ['value' => 'type1', 'label' => 'Tipe 1'],
                ['value' => 'type2', 'label' => 'Tipe 2'],
                ['value' => 'type3', 'label' => 'Tipe 3'],
            ],
        ]);
    }
}
