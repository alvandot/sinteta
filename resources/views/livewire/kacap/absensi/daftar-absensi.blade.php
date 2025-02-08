<div class="p-4">
    <!-- Header -->
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Absensi</h1>
        <div class="flex space-x-2">
            <x-mary-button icon="o-document-arrow-down" wire:click="showExportDialog" secondary label="Export PDF" />
            <x-mary-button icon="o-plus" wire:click="create" primary label="Tambah Absensi" />
        </div>
    </div>

    <!-- Filter dan Pencarian -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
        <div class="relative">
            <input type="text" wire:model.live="search" placeholder="Cari siswa atau tentor..." class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 pl-10 text-sm text-gray-700 placeholder-gray-400 focus:border-violet-500 focus:outline-none focus:ring-2 focus:ring-violet-200">
            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                </svg>
            </div>
        </div>

        <input type="date" wire:model.live="filterTanggal" placeholder="Filter tanggal" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 focus:border-violet-500 focus:outline-none focus:ring-2 focus:ring-violet-200">

        <select wire:model.live="filterStatus" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-700 focus:border-violet-500 focus:outline-none focus:ring-2 focus:ring-violet-200">
            <option value="">Semua Status</option>
            <option value="hadir">Hadir</option>
            <option value="izin">Izin</option>
            <option value="sakit">Sakit</option>
            <option value="alpha">Alpha</option>
        </select>

        <select wire:model.live="filterMapel" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-700 focus:border-violet-500 focus:outline-none focus:ring-2 focus:ring-violet-200">
            <option value="">Semua Mapel</option>
            @foreach($mataPelajaranList as $mapel)
                <option value="{{ $mapel->id }}">{{ $mapel->nama_pelajaran }}</option>
            @endforeach
        </select>
    </div>

    <!-- Tabel Absensi -->
    <div class="overflow-hidden rounded-2xl border-2 border-violet-100 bg-white/90 shadow-xl">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-violet-200">
                <thead class="bg-gradient-to-r from-violet-50 to-indigo-50">
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-violet-700">Tanggal</th>
                        <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-violet-700">Siswa</th>
                        <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-violet-700">Tentor</th>
                        <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-violet-700">Mata Pelajaran</th>
                        <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-violet-700">Status</th>
                        <th scope="col" class="px-6 py-4 text-left text-sm font-semibold text-violet-700">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-violet-100 bg-white">
                    @forelse($absensiList as $absensi)
                        <tr class="transition hover:bg-violet-50">
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-700">
                                {{ $absensi->tanggal->format('d/m/Y') }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900">
                                {{ $absensi->siswa->nama_lengkap }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-700">
                                {{ $absensi->tentor->name }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-700">
                                {{ $absensi->mataPelajaran->nama_pelajaran }}
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm">
                                <span class="inline-flex items-center rounded-full px-3 py-0.5 text-sm font-medium
                                    {{ match($absensi->status) {
                                        'hadir' => 'bg-green-100 text-green-800',
                                        'izin' => 'bg-yellow-100 text-yellow-800',
                                        'sakit' => 'bg-blue-100 text-blue-800',
                                        'alpha' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-800'
                                    } }}">
                                    {{ ucfirst($absensi->status) }}
                                </span>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-700">
                                <div class="flex space-x-2">
                                    <button wire:click="edit({{ $absensi->id }})"
                                        class="inline-flex items-center rounded-lg bg-violet-100 p-2 text-violet-700 transition-colors hover:bg-violet-200">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>
                                    <button wire:click="delete({{ $absensi->id }})"
                                        class="inline-flex items-center rounded-lg bg-red-100 p-2 text-red-700 transition-colors hover:bg-red-200">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-sm text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="h-12 w-12 text-violet-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <span class="mt-2 font-medium">Tidak ada data absensi</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $absensiList->links() }}
    </div>

    <!-- Modal Form -->
    <x-mary-modal wire:model="isModalOpen" title="{{ $absensi_id ? 'Edit Absensi' : 'Tambah Absensi' }}">
        <div class="grid grid-cols-1 gap-4">
            <x-mary-select
                wire:model="jadwal_belajar_id"
                label="Jadwal Belajar"
                required
            >
                <option value="">Pilih Jadwal</option>
                @foreach($jadwalBelajarList ?? [] as $jadwal)
                    <option value="{{ $jadwal->id }}">
                        {{ $jadwal->hari }} - {{ $jadwal->jam_mulai }}
                    </option>
                @endforeach
            </x-mary-select>

            <x-mary-select
                wire:model="siswa_id"
                label="Siswa"
                required
            >
                <option value="">Pilih Siswa</option>
                @foreach($siswaList ?? [] as $siswa)
                    <option value="{{ $siswa->id }}">{{ $siswa->nama_lengkap }}</option>
                @endforeach
            </x-mary-select>

            <x-mary-select
                wire:model="tentor_id"
                label="Tentor"
                required
            >
                <option value="">Pilih Tentor</option>
                @foreach($tentorList ?? [] as $tentor)
                    <option value="{{ $tentor->id }}">{{ $tentor->name }}</option>
                @endforeach
            </x-mary-select>

            <x-mary-select
                wire:model="mata_pelajaran_id"
                label="Mata Pelajaran"
                required
            >
                <option value="">Pilih Mata Pelajaran</option>
                @foreach($mataPelajaranList as $mapel)
                    <option value="{{ $mapel->id }}">{{ $mapel->nama_pelajaran }}</option>
                @endforeach
            </x-mary-select>

            <x-mary-select
                wire:model="status"
                label="Status"
                required
            >
                <option value="">Pilih Status</option>
                <option value="hadir">Hadir</option>
                <option value="izin">Izin</option>
                <option value="sakit">Sakit</option>
                <option value="alpha">Alpha</option>
            </x-mary-select>

            <x-mary-textarea
                wire:model="keterangan"
                label="Keterangan"
                placeholder="Masukkan keterangan jika ada..."
            />

            <x-mary-textarea
                wire:model="catatan_pembelajaran"
                label="Catatan Pembelajaran"
                placeholder="Masukkan catatan pembelajaran..."
            />

            <x-mary-input
                type="date"
                wire:model="tanggal"
                label="Tanggal"
                required
            />
        </div>

        <x-slot:footer>
            <div class="flex justify-end gap-x-4">
                <x-mary-button wire:click="$toggle('isModalOpen')" secondary>
                    Batal
                </x-mary-button>
                <x-mary-button wire:click="save" primary>
                    {{ $absensi_id ? 'Update' : 'Simpan' }}
                </x-mary-button>
            </div>
        </x-slot:footer>
    </x-mary-modal>

    <!-- Modal Export -->
    <x-mary-modal wire:model="showExportModal" title="Export PDF Absensi" class="backdrop-blur">
        <div class="grid grid-cols-1 gap-4">
            <div class="grid grid-cols-2 gap-4">
                <x-mary-input
                    type="date"
                    wire:model="tanggalMulai"
                    label="Tanggal Mulai"
                    required
                />

                <x-mary-input
                    type="date"
                    wire:model="tanggalSelesai"
                    label="Tanggal Selesai"
                    required
                />
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">Filter Status</label>
                    <select wire:model="exportStatus" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-700 focus:border-violet-500 focus:outline-none focus:ring-2 focus:ring-violet-200">
                        <option value="">Semua Status</option>
                        <option value="hadir">Hadir</option>
                        <option value="izin">Izin</option>
                        <option value="sakit">Sakit</option>
                        <option value="alpha">Alpha</option>
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">Filter Mata Pelajaran</label>
                    <select wire:model="exportMapel" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-700 focus:border-violet-500 focus:outline-none focus:ring-2 focus:ring-violet-200">
                        <option value="">Semua Mapel</option>
                        @foreach($mataPelajaranList as $mapel)
                            <option value="{{ $mapel->id }}">{{ $mapel->nama_pelajaran }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">Filter Siswa</label>
                    <select wire:model="exportSiswa" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-700 focus:border-violet-500 focus:outline-none focus:ring-2 focus:ring-violet-200">
                        <option value="">Semua Siswa</option>
                        @foreach($siswaList as $siswa)
                            <option value="{{ $siswa->id }}">{{ $siswa->nama_lengkap }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">Filter Tentor</label>
                    <select wire:model="exportTentor" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-700 focus:border-violet-500 focus:outline-none focus:ring-2 focus:ring-violet-200">
                        <option value="">Semua Tentor</option>
                        @foreach($tentorList as $tentor)
                            <option value="{{ $tentor->id }}">{{ $tentor->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">Urutkan Berdasarkan</label>
                    <select wire:model="sortBy" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-700 focus:border-violet-500 focus:outline-none focus:ring-2 focus:ring-violet-200">
                        <option value="tanggal">Tanggal</option>
                        <option value="status">Status</option>
                        <option value="created_at">Waktu Dibuat</option>
                    </select>
                </div>

                <div>
                    <label class="mb-2 block text-sm font-medium text-gray-700">Urutan</label>
                    <select wire:model="sortDirection" class="w-full rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm text-gray-700 focus:border-violet-500 focus:outline-none focus:ring-2 focus:ring-violet-200">
                        <option value="desc">Terbaru</option>
                        <option value="asc">Terlama</option>
                    </select>
                </div>
            </div>

            <x-mary-input
                type="number"
                wire:model="perPage"
                label="Jumlah Data Per Halaman"
                min="1"
                max="1000"
                required
            />
        </div>

            <div class="flex justify-end gap-x-4">
                <x-mary-button wire:click="$toggle('showExportModal')" secondary>
                    Batal
                </x-mary-button>
                <x-mary-button wire:click="exportPDF" primary>
                    Export PDF
                </x-mary-button>
            </div>
    </x-mary-modal>
</div>
