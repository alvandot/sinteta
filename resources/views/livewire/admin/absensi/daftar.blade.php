<div>
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Daftar Absensi</h2>
        <div class="flex gap-2">
            <x-mary-input wire:model.live.debounce.300ms="search" placeholder="Cari siswa atau kelas..." />
            <x-mary-button wire:click="exportPDF" icon="o-document-arrow-down">
                Export PDF
            </x-mary-button>
        </div>
    </div>

    <div class="mb-4 p-4 border rounded-lg bg-blue-50 border-blue-200">
        <div class="flex items-center text-blue-800">
            <x-mary-icon name="o-information-circle" class="w-5 h-5 mr-2"/>
            <span>Pilih rentang tanggal untuk mengexport data (maksimal 31 hari)</span>
        </div>
    </div>

    <div class="grid grid-cols-4 gap-4 mb-4">
        <div>
            <x-mary-input type="date" wire:model.live="start_date" placeholder="Tanggal Mulai" />
        </div>
        <div>
            <x-mary-input type="date" wire:model.live="end_date" placeholder="Tanggal Akhir" />
        </div>
        <div>
            <x-mary-select wire:model.live="status">
                <option value="">Semua Status</option>
                <option value="hadir">Hadir</option>
                <option value="izin">Izin</option>
                <option value="sakit">Sakit</option>
                <option value="alpha">Alpha</option>
            </x-mary-select>
        </div>
    </div>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 sticky top-0">
                <tr>
                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sortBy('created_at')">
                        <div class="flex items-center">
                            Tanggal
                            @if($sortField === 'created_at')
                                <span class="ml-1">
                                    @if($sortDirection === 'asc')
                                        &#x25B2;
                                    @else
                                        &#x25BC;
                                    @endif
                                </span>
                            @endif
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">Nama Siswa</th>
                    <th scope="col" class="px-6 py-3">Kelas</th>
                    <th scope="col" class="px-6 py-3 cursor-pointer" wire:click="sortBy('status')">
                        <div class="flex items-center">
                            Status
                            @if($sortField === 'status')
                                <span class="ml-1">
                                    @if($sortDirection === 'asc')
                                        &#x25B2;
                                    @else
                                        &#x25BC;
                                    @endif
                                </span>
                            @endif
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($absensi as $item)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $item->created_at->format('d M Y H:i') }}</td>
                        <td class="px-6 py-4">{{ $item->siswa->nama_lengkap }}</td>
                        <td class="px-6 py-4">{{ $item->siswa->kelasBimbel->nama_kelas }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full
                                {{ $item->status === 'hadir' ? 'bg-green-500 text-white' :
                                   ($item->status === 'izin' ? 'bg-yellow-100 text-yellow-800' :
                                   ($item->status === 'sakit' ? 'bg-orange-100 text-orange-800' :
                                   'bg-red-100 text-red-800')) }}">
                                {{ ucfirst($item->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">{{ $item->keterangan }}</td>
                    </tr>
                @empty
                    <tr class="bg-white border-b">
                        <td colspan="6" class="px-6 py-4 text-center">Tidak ada data absensi</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $absensi->links() }}
    </div>
</div>
