<?php /* Menambahkan Alpine.js state management dan interaktivitas */ ?>
<div x-data="{
    showSuccessAlert: false,
    showErrorAlert: false,
    showNoPreviousAlert: false,
    message: '',
    isSubmitting: false,
    showRiwayatModal: false,
    selectedSiswaId: null,
    confirmSubmit() {
        if (this.isSubmitting) return;

        this.isSubmitting = true;
        $wire.simpanAbsensi()
            .then(() => {
                this.showSuccessAlert = true;
                setTimeout(() => this.showSuccessAlert = false, 3000);
            })
            .catch(() => {
                this.showErrorAlert = true;
                setTimeout(() => this.showErrorAlert = false, 3000);
            })
            .finally(() => {
                this.isSubmitting = false;
            });
    }
}">
    <div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
        <!-- Alert Success -->
        <div x-show="showSuccessAlert"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform -translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform -translate-y-2"
             class="mb-4">
            <x-mary-alert type="success" message="Absensi berhasil disimpan!" />
        </div>

        <!-- Alert Error -->
        <div x-show="showErrorAlert"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform -translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform -translate-y-2"
             class="mb-4">
            <x-mary-alert type="error" message="Terjadi kesalahan saat menyimpan absensi!" />
        </div>

        <!-- Alert No Previous Meeting -->
        <div x-show="showNoPreviousAlert"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform -translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="opacity-100 transform translate-y-0"
             x-transition:leave-end="opacity-0 transform -translate-y-2"
             class="mb-4">
            <x-mary-alert type="warning" message="Tidak ada jadwal pertemuan sebelumnya untuk mata pelajaran ini!" />
        </div>

        <div class="sm:flex sm:justify-between sm:items-center mb-8">
            <div class="mb-4 sm:mb-0">
                <h1 class="text-2xl md:text-3xl font-bold text-slate-800">Absensi Kelas {{ $this->jadwalBelajar->kelasBimbel->nama }}</h1>
                <p class="text-sm text-slate-600 mt-1">
                    Mata Pelajaran: {{ $this->jadwalBelajar->mataPelajaran->nama_pelajaran }}
                </p>
            </div>
            <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end gap-2">
                <!-- Filter Status -->
                <x-ts-select.styled wire:model.live="filterStatus" :options="['hadir', 'izin', 'sakit', 'alpha', 'belum_diisi']" />

                <x-mary-input type="date"
                    wire:model.live="tanggal"
                    x-on:change="$wire.loadAbsensi()" />
            </div>
        </div>

        <!-- Statistik Kehadiran -->
        <div class="mb-8 grid grid-cols-1 md:grid-cols-5 gap-6">
            <x-mary-stat
                title="Hadir"
                value="{{$statistik['hadir']}}"
                color="emerald"
                icon="o-user-group"
                class="transform hover:scale-105 transition-transform duration-300 hover:shadow-lg rounded-xl bg-gradient-to-br from-emerald-50 to-emerald-100 border-2 border-emerald-200" />

            <x-mary-stat
                title="Izin"
                value="{{$statistik['izin']}}"
                color="blue"
                icon="o-clock"
                class="transform hover:scale-105 transition-transform duration-300 hover:shadow-lg rounded-xl bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-200" />

            <x-mary-stat
                title="Sakit"
                value="{{$statistik['sakit']}}"
                color="yellow"
                icon="o-face-frown"
                class="transform hover:scale-105 transition-transform duration-300 hover:shadow-lg rounded-xl bg-gradient-to-br from-yellow-50 to-yellow-100 border-2 border-yellow-200" />

            <x-mary-stat
                title="Alpha"
                value="{{$statistik['alpha']}}"
                color="red"
                icon="o-x-circle"
                class="transform hover:scale-105 transition-transform duration-300 hover:shadow-lg rounded-xl bg-gradient-to-br from-red-50 to-red-100 border-2 border-red-200" />

            <x-mary-stat
                title="Belum Diisi"
                value="{{$statistik['belum_diisi']}}"
                color="gray"
                icon="o-question-mark-circle"
                class="transform hover:scale-105 transition-transform duration-300 hover:shadow-lg rounded-xl bg-gradient-to-br from-gray-50 to-gray-100 border-2 border-gray-200" />
        </div>



        <!-- Bulk Actions -->
        <div class="mb-4 bg-white/50 backdrop-blur-sm border border-gray-200 rounded-lg p-4 shadow-sm"
             x-show="$wire.selectedSiswa.length > 0"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 transform -translate-y-2"
             x-transition:enter-end="opacity-100 transform translate-y-0">

            <div class="flex items-center gap-4 flex-wrap">
                <div class="flex items-center gap-2">
                    <span class="flex items-center gap-1 text-sm font-medium text-gray-700">
                        <x-mary-icon name="o-user-group" class="w-4 h-4"/>
                        {{ count($selectedSiswa) }} siswa dipilih
                    </span>
                </div>

                <div class="flex-1 flex items-center gap-2">
                    <select wire:model="bulkStatus" class="w-48 block appearance-none rounded-lg border border-gray-300 bg-white px-4 py-2 pr-8 text-sm font-medium text-gray-700 shadow-sm transition duration-150 ease-in-out hover:border-gray-400 focus:border-emerald-500 focus:outline-none focus:ring-2 focus:ring-emerald-500/20">
                        <option value="" class="text-gray-500">Pilih Status</option>
                        <option value="hadir" class="text-emerald-600">Hadir</option>
                        <option value="izin" class="text-blue-600">Izin</option>
                        <option value="sakit" class="text-yellow-600">Sakit</option>
                        <option value="alpha" class="text-red-600">Alpha</option>
                    </select>

                    <x-mary-button wire:click="applyBulkStatus" size="sm" icon="o-check" class="bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700">
                        Terapkan
                    </x-mary-button>

                    <x-mary-button wire:click="$set('selectedSiswa', [])" size="sm" icon="o-x-mark" color="red" class="hover:bg-red-600">
                        Batal
                    </x-mary-button>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <x-mary-card>
                <div class="overflow-x-auto">
                    <div class="grid grid-cols-1 gap-4">
                        <div class="bg-gradient-to-r from-emerald-50 to-teal-50 p-4 rounded-t-lg flex items-center gap-4">
                            <div class="w-4">
                                <x-mary-checkbox wire:model.live="selectAll" class="transition duration-300 ease-in-out hover:scale-110" />
                            </div>
                            <div class="flex-1">
                                <span class="text-xs font-bold text-emerald-700 uppercase tracking-wider flex items-center gap-2">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                    </svg>
                                    Nama Siswa
                                </span>
                            </div>
                            <div class="flex-1">
                                <span class="text-xs font-bold text-emerald-700 uppercase tracking-wider flex items-center gap-2">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Status
                                </span>
                            </div>
                            <div class="flex-1">
                                <span class="text-xs font-bold text-emerald-700 uppercase tracking-wider flex items-center gap-2">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                                    </svg>
                                    Keterangan
                                </span>
                            </div>
                            <div class="w-24">
                                <span class="text-xs font-bold text-emerald-700 uppercase tracking-wider flex items-center gap-2">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM12.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0zM18.75 12a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                                    </svg>
                                    Aksi
                                </span>
                            </div>
                        </div>

                        @forelse($this->filteredSiswa as $siswa)
                            <div class="bg-white p-4 rounded-lg shadow-sm hover:bg-gray-50 transition-colors duration-200" x-data="{ status: $wire.entangle('status.' + {{ $siswa->id }}), showKeterangan: false }">
                                <div class="flex items-center gap-4">
                                    <div class="w-4">
                                        <x-mary-checkbox wire:model.live="selectedSiswa" value="{{ $siswa->id }}" class="transition duration-300 ease-in-out hover:scale-110" />
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-3">
                                            <div class="h-8 w-8 rounded-full bg-gradient-to-br from-emerald-400 to-teal-400 flex items-center justify-center text-white font-bold">
                                                {{ substr($siswa->nama_lengkap, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-medium text-gray-900">{{ $siswa->nama_lengkap }}</div>
                                                <div class="text-xs text-gray-500">Siswa</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <select
                                            x-model="status"
                                            x-on:change="showKeterangan = ['izin', 'sakit', 'alpha'].includes(status)"
                                            class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm transition duration-200"
                                        >
                                            <option value="">Pilih Status</option>
                                            <option value="hadir" class="text-emerald-600">Hadir</option>
                                            <option value="izin" class="text-blue-600">Izin</option>
                                            <option value="sakit" class="text-yellow-600">Sakit</option>
                                            <option value="alpha" class="text-red-600">Alpha</option>
                                        </select>
                                    </div>
                                    <div class="flex-1">
                                        <div x-show="showKeterangan"
                                             x-transition:enter="transition ease-out duration-300"
                                             x-transition:enter-start="opacity-0 transform scale-95"
                                             x-transition:enter-end="opacity-100 transform scale-100"
                                             x-transition:leave="transition ease-in duration-200"
                                             x-transition:leave-start="opacity-100 transform scale-100"
                                             x-transition:leave-end="opacity-0 transform scale-95">
                                            <textarea
                                                wire:model="keterangan.{{ $siswa->id }}"
                                                rows="1"
                                                class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm resize-none transition duration-200"
                                                placeholder="Keterangan (opsional)"
                                            >{{ $this->absensi[$siswa->id]->keterangan ?? '' }}</textarea>
                                        </div>
                                    </div>
                                    <div class="w-24">
                                        <x-mary-button
                                            size="xs"
                                            wire:click="loadRiwayatAbsensi({{ $siswa->id }})"
                                            @click="showRiwayatModal = true; selectedSiswaId = {{ $siswa->id }}"
                                            class="transition duration-300 ease-in-out hover:scale-105 hover:shadow-md"
                                            icon="o-clock"
                                        >
                                            Riwayat
                                        </x-mary-button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="bg-white p-8 rounded-lg text-center">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada siswa</h3>
                                    <p class="mt-1 text-sm text-gray-500">Belum ada siswa yang terdaftar di kelas ini</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </x-mary-card>
        </div>

        <!-- Modal Riwayat Absensi -->
        <x-mary-modal wire:model="showRiwayat" wire:close="closeRiwayatModal">
            <x-slot name="title">
                @if($selectedSiswaId)
                    Riwayat Absensi {{ $this->jadwalBelajar->kelasBimbel->siswa->firstWhere('id', $selectedSiswaId)?->nama_lengkap }}
                @else
                    Riwayat Absensi
                @endif
            </x-slot>

            <div class="space-y-4">
                @forelse($riwayatAbsensi as $riwayat)
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <div class="flex justify-between items-start">
                            <div>
                                <div class="font-medium">{{ Carbon\Carbon::parse($riwayat->tanggal)->isoFormat('dddd, D MMMM Y') }}</div>
                                <div class="text-sm text-gray-600">Status:
                                    <span @class([
                                        'font-medium',
                                        'text-emerald-600' => $riwayat->status === 'hadir',
                                        'text-blue-600' => $riwayat->status === 'izin',
                                        'text-yellow-600' => $riwayat->status === 'sakit',
                                        'text-red-600' => $riwayat->status === 'alpha',
                                    ])>
                                        {{ ucfirst($riwayat->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        @if($riwayat->keterangan)
                            <div class="mt-2 text-sm text-gray-600">
                                <span class="font-medium">Keterangan:</span> {{ $riwayat->keterangan }}
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="text-center text-gray-500 py-4">
                        Belum ada riwayat absensi
                    </div>
                @endforelse
            </div>

            <x-slot name="footer">
                <div class="flex justify-end">
                    <x-mary-button wire:click="closeRiwayatModal">
                        Tutup
                    </x-mary-button>
                </div>
            </x-slot>
        </x-mary-modal>

        <div class="mt-8 bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Catatan Pembelajaran</h2>
            <x-mary-textarea
                wire:model="catatan_pembelajaran"
                placeholder="Tuliskan materi yang diajarkan, progress pembelajaran, atau catatan penting lainnya..."
                rows="4"
                class="w-full"
            />
        </div>

        <!-- Card Jadwal Sebelumnya -->
        <div class="mt-8 bg-white rounded-lg shadow p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                <x-mary-icon name="o-clock" class="w-5 h-5 text-emerald-600" />
                Jadwal Sebelumnya
            </h2>

            <div class="space-y-6">
                @forelse($jadwalSebelumnya as $jadwal)
                    <div class="bg-gray-50 rounded-lg overflow-hidden">
                        <!-- Header Informasi -->
                        <div class="p-4 bg-gradient-to-r from-emerald-50 to-teal-50">
                            <div class="flex justify-between items-start">
                                <div class="space-y-1">
                                    <div class="font-medium text-gray-900">{{ $this->formatTanggal($jadwal->tanggal_mulai) }}</div>
                                    <div class="text-sm text-gray-600">
                                        <span class="font-medium">Mata Pelajaran:</span> {{ $jadwal->mataPelajaran->nama_pelajaran }}
                                    </div>
                                    <div class="text-sm text-gray-600">
                                        <span class="font-medium">Kelas:</span> {{ $jadwal->kelasBimbel->nama_kelas }}
                                    </div>
                                    <div class="text-sm text-gray-600">
                                        <span class="font-medium">Kode Jadwal:</span> {{ $jadwal->id }}
                                    </div>
                                </div>
                                <div class="flex gap-2 flex-wrap">
                                    <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium rounded-full bg-emerald-100 text-emerald-700">
                                        <x-mary-icon name="o-check-circle" class="w-3 h-3" />
                                        Hadir: {{ $jadwal->absensi->where('status', 'hadir')->count() }}
                                    </span>
                                    <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-700">
                                        <x-mary-icon name="o-clock" class="w-3 h-3" />
                                        Izin: {{ $jadwal->absensi->where('status', 'izin')->count() }}
                                    </span>
                                    <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-700">
                                        <x-mary-icon name="o-face-frown" class="w-3 h-3" />
                                        Sakit: {{ $jadwal->absensi->where('status', 'sakit')->count() }}
                                    </span>
                                    <span class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700">
                                        <x-mary-icon name="o-x-circle" class="w-3 h-3" />
                                        Alpha: {{ $jadwal->absensi->where('status', 'alpha')->count() }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Tabel Detail Absensi -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Nama Siswa
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Waktu
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Keterangan
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($jadwal->absensi as $absensi)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="h-8 w-8 rounded-full bg-gradient-to-br from-emerald-400 to-teal-400 flex items-center justify-center text-white font-bold">
                                                        {{ substr($absensi->siswa->nama_lengkap ?? '', 0, 1) }}
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="text-sm font-medium text-gray-900">
                                                            {{ $absensi->siswa->nama_lengkap }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span @class([
                                                    'px-2 py-1 text-xs font-medium rounded-full inline-flex items-center gap-1',
                                                    'bg-emerald-100 text-emerald-700' => $absensi->status === 'hadir',
                                                    'bg-blue-100 text-blue-700' => $absensi->status === 'izin',
                                                    'bg-yellow-100 text-yellow-700' => $absensi->status === 'sakit',
                                                    'bg-red-100 text-red-700' => $absensi->status === 'alpha',
                                                ])>
                                                    @switch($absensi->status)
                                                        @case('hadir')
                                                            <x-mary-icon name="o-check-circle" class="w-3 h-3" />
                                                            @break
                                                        @case('izin')
                                                            <x-mary-icon name="o-clock" class="w-3 h-3" />
                                                            @break
                                                        @case('sakit')
                                                            <x-mary-icon name="o-face-frown" class="w-3 h-3" />
                                                            @break
                                                        @case('alpha')
                                                            <x-mary-icon name="o-x-circle" class="w-3 h-3" />
                                                            @break
                                                    @endswitch
                                                    {{ ucfirst($absensi->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ \Carbon\Carbon::parse($absensi->created_at)->format('H:i') }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{ $absensi->keterangan ?: '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        @if($jadwal->catatan_pembelajaran)
                            <div class="p-4 border-t border-gray-200">
                                <h4 class="text-sm font-medium text-gray-900 mb-2">Catatan Pembelajaran:</h4>
                                <p class="text-sm text-gray-600">{{ $jadwal->catatan_pembelajaran }}</p>
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-8">
                        <div class="mx-auto h-12 w-12 text-gray-400">
                            <x-mary-icon name="o-clock" class="h-12 w-12" />
                        </div>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak Ada Jadwal Sebelumnya</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Belum ada jadwal sebelumnya untuk kelas dan mata pelajaran ini.
                        </p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-4">
            <x-mary-button
                icon="o-check"
                x-on:click="confirmSubmit()"
                x-bind:disabled="isSubmitting"
                x-bind:class="{ 'opacity-50 cursor-not-allowed': isSubmitting }">
                <span x-show="!isSubmitting">Simpan Absensi</span>
                <span x-show="isSubmitting">Menyimpan...</span>
            </x-mary-button>
        </div>
    </div>
</div>
