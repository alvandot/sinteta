<div>
    {{-- Header Card --}}
    <x-mary-card class="mb-6">
        <div class="sm:flex sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Detail Ujian</h1>
                <p class="mt-2 text-sm text-gray-700">
                    Lihat detail informasi ujian
                </p>
            </div>
            <div class="mt-4 flex space-x-3 sm:mt-0">
                <x-mary-button
                    wire:click="$dispatch('showDaftarUjian')"
                    secondary
                    icon="o-arrow-left"
                >
                    Kembali
                </x-mary-button>

                <x-mary-button wire:click="edit" warning icon="o-pencil-square">
                    Edit
                </x-mary-button>
            </div>
        </div>
    </x-mary-card>

    {{-- Content --}}
    <div class="grid gap-6 lg:grid-cols-3">
        {{-- Main Content --}}
        <div class="space-y-6 lg:col-span-2">
            {{-- Informasi Dasar --}}
            <x-mary-card>
                <div class="space-y-6">
                    <h2 class="text-lg font-semibold text-gray-900">
                        Informasi Dasar
                    </h2>
                    <dl class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Nama Ujian
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $ujian->nama }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Jenis Ujian
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ ucfirst($ujian->jenis) }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Mata Pelajaran
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $ujian->mataPelajaran->nama_pelajaran }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Kelas
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $ujian->kelas->nama_kelas }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </x-mary-card>

            {{-- Waktu Pelaksanaan --}}
            <x-mary-card>
                <div class="space-y-6">
                    <h2 class="text-lg font-semibold text-gray-900">
                        Waktu Pelaksanaan
                    </h2>
                    <dl class="grid gap-4 sm:grid-cols-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Waktu Mulai
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $ujian->waktu_mulai->format("d/m/Y H:i") }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Waktu Selesai
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $ujian->waktu_selesai->format("d/m/Y H:i") }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Durasi
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $ujian->durasi }} Menit
                            </dd>
                        </div>
                    </dl>
                </div>
            </x-mary-card>

            {{-- Pengaturan Soal --}}
            <x-mary-card>
                <div class="space-y-6">
                    <h2 class="text-lg font-semibold text-gray-900">
                        Pengaturan Soal
                    </h2>
                    <dl class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Jumlah Soal
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $ujian->jumlah_soal }} Soal
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Mode Pengacakan
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ ucwords(str_replace("_", " ", $ujian->mode_pengacakan)) }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Soal Mudah
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $ujian->jumlah_mudah }} Soal
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Soal Sedang
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $ujian->jumlah_sedang }} Soal
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Soal Sulit
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $ujian->jumlah_sulit }} Soal
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                KKM
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $ujian->kkm }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </x-mary-card>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">
            {{-- Status Card --}}
            <x-mary-card>
                <div class="space-y-6">
                    <h2 class="text-lg font-semibold text-gray-900">
                        Status Ujian
                    </h2>
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Status
                            </dt>
                            <dd class="mt-1">
                                <span
                                    @class([
                                        "inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium",
                                        "bg-green-100 text-green-800" =>
                                            $ujian->aktif && $ujian->waktu_mulai->isFuture(),
                                        "bg-yellow-100 text-yellow-800" =>
                                            $ujian->aktif &&
                                            $ujian->waktu_mulai->isPast() &&
                                            $ujian->waktu_selesai->isFuture(),
                                        "bg-red-100 text-red-800" =>
                                            ! $ujian->aktif || $ujian->waktu_selesai->isPast(),
                                    ])
                                >
                                    @if ($ujian->aktif)
                                        @if ($ujian->waktu_mulai->isFuture())
                                            Akan Dimulai
                                        @elseif ($ujian->waktu_selesai->isPast())
                                            Selesai
                                        @else
                                                Sedang Berlangsung
                                        @endif
                                    @else
                                            Tidak Aktif
                                    @endif
                                </span>
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Pengaturan
                            </dt>
                            <dd class="mt-2 space-y-2">
                                <div class="flex items-center">
                                    <x-mary-icon
                                        name="{{ $ujian->tampilkan_hasil ? 'o-check' : 'o-x-mark' }}"
                                        class="h-5 w-5 {{ $ujian->tampilkan_hasil ? 'text-green-500' : 'text-red-500' }}"
                                    />
                                    <span class="ml-2 text-sm text-gray-900">
                                        Tampilkan Hasil Setelah Selesai
                                    </span>
                                </div>

                                <div class="flex items-center">
                                    <x-mary-icon
                                        name="{{ $ujian->tampilkan_pembahasan ? 'o-check' : 'o-x-mark' }}"
                                        class="h-5 w-5 {{ $ujian->tampilkan_pembahasan ? 'text-green-500' : 'text-red-500' }}"
                                    />
                                    <span class="ml-2 text-sm text-gray-900">
                                        Tampilkan Pembahasan
                                    </span>
                                </div>

                                <div class="flex items-center">
                                    <x-mary-icon
                                        name="{{ $ujian->dapat_mengulang ? 'o-check' : 'o-x-mark' }}"
                                        class="h-5 w-5 {{ $ujian->dapat_mengulang ? 'text-green-500' : 'text-red-500' }}"
                                    />
                                    <span class="ml-2 text-sm text-gray-900">
                                        Dapat Mengulang Ujian
                                    </span>
                                </div>
                            </dd>
                        </div>
                    </dl>
                </div>
            </x-mary-card>

            {{-- Statistik Card --}}
            <x-mary-card>
                <div class="space-y-6">
                    <h2 class="text-lg font-semibold text-gray-900">
                        Statistik
                    </h2>
                    <dl class="grid grid-cols-2 gap-4">
                        <div class="rounded-lg border border-gray-200 p-4">
                            <dt class="text-sm font-medium text-gray-500">
                                Total Peserta
                            </dt>
                            <dd
                                class="mt-1 text-2xl font-semibold text-gray-900"
                            >
                                {{ $ujian->total_peserta }}
                            </dd>
                        </div>

                        <div class="rounded-lg border border-gray-200 p-4">
                            <dt class="text-sm font-medium text-gray-500">
                                Sudah Mengerjakan
                            </dt>
                            <dd
                                class="mt-1 text-2xl font-semibold text-gray-900"
                            >
                                {{ $ujian->total_selesai }}
                            </dd>
                        </div>

                        <div class="rounded-lg border border-gray-200 p-4">
                            <dt class="text-sm font-medium text-gray-500">
                                Nilai Tertinggi
                            </dt>
                            <dd
                                class="mt-1 text-2xl font-semibold text-green-600"
                            >
                                {{ $ujian->nilai_tertinggi }}
                            </dd>
                        </div>

                        <div class="rounded-lg border border-gray-200 p-4">
                            <dt class="text-sm font-medium text-gray-500">
                                Nilai Terendah
                            </dt>
                            <dd
                                class="mt-1 text-2xl font-semibold text-red-600"
                            >
                                {{ $ujian->nilai_terendah }}
                            </dd>
                        </div>

                        <div class="rounded-lg border border-gray-200 p-4">
                            <dt class="text-sm font-medium text-gray-500">
                                Rata-rata Nilai
                            </dt>
                            <dd
                                class="mt-1 text-2xl font-semibold text-blue-600"
                            >
                                {{ $ujian->rata_rata_nilai }}
                            </dd>
                        </div>

                        <div class="rounded-lg border border-gray-200 p-4">
                            <dt class="text-sm font-medium text-gray-500">
                                Lulus KKM
                            </dt>
                            <dd
                                class="mt-1 text-2xl font-semibold text-indigo-600"
                            >
                                {{ $ujian->total_lulus_kkm }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </x-mary-card>

            {{-- Info Card --}}
            <x-mary-card>
                <div class="space-y-6">
                    <h2 class="text-lg font-semibold text-gray-900">
                        Informasi Tambahan
                    </h2>
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Dibuat Oleh
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $ujian->created_by->name }}
                            </dd>
                        </div>

                        <div>
                            <dt class="text-sm font-medium text-gray-500">
                                Dibuat Pada
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $ujian->created_at->format("d F Y H:i") }}
                            </dd>
                        </div>

                        @if ($ujian->updated_by)
                            <div>
                                <dt class="text-sm font-medium text-gray-500">
                                    Diperbarui Oleh
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $ujian->updated_by->name }}
                                </dd>
                            </div>

                            <div>
                                <dt class="text-sm font-medium text-gray-500">
                                    Diperbarui Pada
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $ujian->updated_at->format("d F Y H:i") }}
                                </dd>
                            </div>
                        @endif
                    </dl>
                </div>
            </x-mary-card>
        </div>
    </div>
</div>
