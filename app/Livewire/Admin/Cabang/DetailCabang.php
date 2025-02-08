<?php

declare(strict_types=1);

namespace App\Livewire\Admin\Cabang;

use App\Models\Cabang;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app')]
class DetailCabang extends Component
{
    public Cabang $cabang;
    public $selectedTab = 'tentor-tab';

    public function mount(Cabang $cabang)
    {
        $this->cabang = $cabang->with(['tentor', 'siswas'])->first();
    }

    public function render()
    {
        $this->cabang->load(['tentor', 'siswas']);
        return view('livewire.admin.cabang.detail-cabang');
    }
}
