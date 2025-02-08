<?php

namespace App\Livewire\Kacap;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.kacapLayout')]
class Dashboard extends Component
{
    public $headers;
    public $rows;

    public function mount()
    {
        $this->headers = [
            ['index' => 'aktivitas', 'label' => 'Aktivitas'],
            ['index' => 'tanggal', 'label' => 'Tanggal'],
            ['index' => 'status', 'label' => 'Status', 'unescaped' => true]
        ];

        $this->rows = [
            [
                'aktivitas' => 'Ujian Matematika Kelas X',
                'tanggal' => '2024-01-20',
                'status' => '<x-ts-badge color="green">Selesai</x-ts-badge>'
            ],
            [
                'aktivitas' => 'Ujian Bahasa Indonesia Kelas XI',
                'tanggal' => '2024-01-19',
                'status' => '<x-ts-badge color="yellow">Berlangsung</x-ts-badge>'
            ]
        ];
    }

    public function render()
    {
        return view('livewire.kacap.dashboard');
    }
}
