<div class="min-h-screen bg-gradient-to-br from-violet-50 to-pink-50">
    <div class="mx-auto max-w-7xl px-6 py-12">
        <!-- Header Section dengan Animasi -->
        <div
            class="relative mb-16 transform text-center transition-all duration-300 hover:scale-105"
        >
            <div class="absolute inset-0 -z-10">
                <div
                    class="animate-gradient-x absolute inset-0 bg-gradient-to-r from-violet-300 via-fuchsia-300 to-pink-300 opacity-40"
                ></div>
            </div>
            <h1
                class="font-comic bg-gradient-to-r from-violet-600 to-pink-600 bg-clip-text text-6xl font-black text-transparent"
            >
                👨‍🎓 Detail Siswa 👩‍🎓
            </h1>
            <p class="mt-4 text-2xl font-medium text-gray-700">
                Lihat dan kelola informasi detail siswa! 📚
            </p>
        </div>

        <!-- Profile Card dengan Efek Hover -->
        <div
            class="mb-12 rounded-[2.5rem] border-4 border-violet-400 bg-white p-10 shadow-2xl transition-all duration-300 hover:shadow-violet-200"
        >
            <div class="flex flex-col items-center gap-8 md:flex-row">
                <!-- Foto Profile dengan Animasi -->
                <div class="group relative">
                    @if ($siswa->foto)
                        <img
                            src="{{ Storage::url($siswa->foto) }}"
                            alt="{{ $siswa->nama_lengkap }}"
                            class="h-56 w-56 rounded-full object-cover ring-8 ring-violet-200 transition-transform duration-300 group-hover:scale-105"
                        />
                    @else
                        <div
                            class="flex h-56 w-56 items-center justify-center rounded-full bg-gradient-to-br from-violet-500 to-fuchsia-600 ring-8 ring-violet-200 transition-all duration-300 group-hover:from-fuchsia-500 group-hover:to-pink-600"
                        >
                            <span class="text-7xl font-bold text-white">
                                {{ substr($siswa->nama_lengkap, 0, 1) }}
                            </span>
                        </div>
                    @endif

                    <form wire:submit="updateFoto" class="mt-6">
                        <input
                            type="file"
                            wire:model="foto"
                            class="hidden"
                            id="foto"
                            accept="image/*"
                        />
                        <x-mary-button
                            tag="label"
                            for="foto"
                            class="w-full cursor-pointer justify-center rounded-full bg-gradient-to-r from-violet-500 to-fuchsia-500 px-8 py-4 transition-all duration-300 hover:from-fuchsia-500 hover:to-pink-500"
                        >
                            <x-mary-icon name="o-camera" class="h-6 w-6" />
                            <span class="text-lg">Ganti Foto</span>
                        </x-mary-button>
                    </form>
                </div>

                <!-- Info Utama dengan Animasi -->
                <div class="flex-1 space-y-8">
                    <div
                        class="transform transition-all duration-300 hover:scale-105"
                    >
                        @if ($isEditing)
                            <x-mary-input
                                wire:model.live="form.nama_lengkap"
                                class="text-xl font-bold text-gray-800"
                            />
                        @else
                            <h2
                                class="bg-gradient-to-r from-violet-600 to-fuchsia-600 bg-clip-text text-4xl font-bold text-transparent"
                            >
                                {{ $siswa->nama_lengkap }}
                            </h2>
                        @endif

                        @if ($isEditing)
                            <x-mary-input
                                wire:model.live="form.email"
                                class="text-xl font-bold text-gray-800"
                            />
                        @else
                            <p
                                class="mt-2 text-2xl font-medium text-fuchsia-600"
                            >
                                {{ $siswa->email }}
                            </p>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                        <!-- Status dengan Animasi -->
                        <div
                            class="transform rounded-2xl bg-gradient-to-br from-violet-50 to-violet-100 p-6 transition-all duration-300 hover:scale-105"
                        >
                            <div class="mb-3 flex items-center justify-between">
                                <p class="font-medium text-violet-700">
                                    Status
                                </p>
                                <div class="flex gap-3">
                                    <x-mary-button
                                        wire:click="updateStatus('aktif')"
                                        size="sm"
                                        class="bg-gradient-to-r from-green-400 to-green-600 hover:from-green-500 hover:to-green-700"
                                    >
                                        Aktif
                                    </x-mary-button>
                                    <x-mary-button
                                        wire:click="updateStatus('nonaktif')"
                                        size="sm"
                                        class="bg-gradient-to-r from-red-400 to-red-600 hover:from-red-500 hover:to-red-700"
                                    >
                                        Nonaktif
                                    </x-mary-button>
                                </div>
                            </div>
                            <p
                                class="text-xl font-bold capitalize text-gray-800"
                            >
                                {{ $siswa->status }}
                            </p>
                        </div>

                        <!-- Kelas Bimbel dengan Animasi -->
                        <div
                            class="transform rounded-2xl bg-gradient-to-br from-fuchsia-50 to-fuchsia-100 p-6 transition-all duration-300 hover:scale-105"
                        >
                            @if ($isEditing)
                                <x-mary-input
                                    wire:model.live="form.kelas_bimbel_id"
                                    class="text-xl font-bold text-gray-800"
                                />
                            @else
                                <p class="mb-3 font-medium text-fuchsia-700">
                                    Kelas Bimbel
                                </p>
                                <p class="text-xl font-bold text-gray-800">
                                    {{ $siswa->kelasBimbel->nama_kelas ?? "Belum ada kelas" }}
                                </p>
                            @endif
                        </div>

                        <!-- Cabang dengan Animasi -->
                        <div
                            class="transform rounded-2xl bg-gradient-to-br from-pink-50 to-pink-100 p-6 transition-all duration-300 hover:scale-105"
                        >
                            @if ($isEditing)
                                <x-mary-input
                                    wire:model.live="form.cabang_id"
                                    class="text-xl font-bold text-gray-800"
                                />
                            @else
                                <p class="mb-3 font-medium text-pink-700">
                                    Cabang
                                </p>
                                <p class="text-xl font-bold text-gray-800">
                                    {{ $siswa->cabang->nama ?? "Belum ada cabang" }}
                                </p>
                            @endif
                        </div>

                        <!-- Tanggal Bergabung dengan Animasi -->
                        <div
                            class="transform rounded-2xl bg-gradient-to-br from-violet-50 to-violet-100 p-6 transition-all duration-300 hover:scale-105"
                        >
                            <p class="mb-3 font-medium text-violet-700">
                                Tanggal Bergabung
                            </p>
                            <p class="text-xl font-bold text-gray-800">
                                {{ $siswa->created_at->format("d M Y") }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informasi Siswa dengan Animasi -->
        <div
            class="mt-16 rounded-[2.5rem] border-4 border-violet-400 bg-white p-10 shadow-2xl transition-all duration-300 hover:shadow-violet-200"
        >
            <h2
                class="mb-10 bg-gradient-to-r from-violet-600 to-fuchsia-600 bg-clip-text text-3xl font-bold text-transparent"
            >
                Informasi Lengkap Siswa
            </h2>

            <div class="grid grid-cols-1 gap-10 md:grid-cols-2">
                <!-- Data Pribadi dengan Animasi -->
                <div class="space-y-8">
                    <div class="flex items-center justify-between">
                        <h3 class="text-2xl font-bold text-violet-600">
                            Data Pribadi
                        </h3>
                        <x-mary-button
                            wire:click="toggleEdit"
                            class="transform rounded-full transition-all duration-300 hover:scale-105"
                            :class="$isEditing ? 'bg-gradient-to-r from-green-400 to-green-600' : 'bg-gradient-to-r from-violet-400 to-violet-600'"
                        >
                            <x-mary-icon
                                name="{{ $isEditing ? 'o-check' : 'o-pencil' }}"
                                class="h-6 w-6"
                            />
                            <span class="text-lg">
                                {{ $isEditing ? "Selesai" : "Edit" }}
                            </span>
                        </x-mary-button>
                    </div>

                    <!-- Data Fields dengan Animasi -->
                    <div
                        class="transform rounded-2xl bg-gradient-to-br from-violet-50 to-violet-100 p-6 transition-all duration-300 hover:scale-105"
                    >
                        <p class="mb-3 font-medium text-violet-700">
                            Nama Lengkap
                        </p>
                        @if ($isEditing)
                            <x-mary-input
                                wire:model.live="form.nama_lengkap"
                                wire:blur="updateField('nama_lengkap')"
                                class="text-xl font-bold text-gray-800"
                            />
                        @else
                            <p class="text-xl font-bold text-gray-800">
                                {{ $siswa->nama_lengkap }}
                            </p>
                        @endif
                    </div>

                    <!-- Remaining fields follow similar pattern... -->
                    <!-- ... -->
                </div>

                <!-- Data Akademik dengan Animasi -->
                <div class="space-y-8">
                    <h3 class="text-2xl font-bold text-fuchsia-600">
                        Data Akademik
                    </h3>

                    <div
                        class="transform rounded-2xl bg-gradient-to-br from-fuchsia-50 to-fuchsia-100 p-6 transition-all duration-300 hover:scale-105"
                    >
                        <p class="mb-3 font-medium text-fuchsia-700">
                            Asal Sekolah
                        </p>
                        @if ($isEditing)
                            <x-mary-input
                                wire:model.live="form.asal_sekolah"
                                wire:blur="updateField('asal_sekolah')"
                                class="text-xl font-bold text-gray-800"
                            />
                        @else
                            <p class="text-xl font-bold text-gray-800">
                                {{ $siswa->asal_sekolah ?? "-" }}
                            </p>
                        @endif
                    </div>

                    <!-- Remaining academic fields... -->
                    <!-- ... -->
                </div>
            </div>
        </div>

        <!-- Data Orang Tua dengan Animasi -->
        <div
            class="mt-10 rounded-[2.5rem] border-4 border-violet-400 bg-white p-10 shadow-2xl transition-all duration-300 hover:shadow-violet-200"
        >
            <div class="space-y-8">
                <h3 class="text-2xl font-bold text-pink-600">Data Wali</h3>

                <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                    <div
                        class="transform rounded-2xl bg-gradient-to-br from-violet-50 to-violet-100 p-6 transition-all duration-300 hover:scale-105"
                    >
                        <p class="mb-3 font-medium text-violet-700">
                            Nama Wali
                        </p>
                        <p class="text-xl font-bold text-gray-800">
                            {{ $siswa->nama_wali ?? "-" }}
                        </p>
                    </div>

                    <div
                        class="transform rounded-2xl bg-gradient-to-br from-pink-50 to-pink-100 p-6 transition-all duration-300 hover:scale-105"
                    >
                        <p class="mb-3 font-medium text-pink-700">
                            Nomor Telepon Wali
                        </p>
                        <p class="text-xl font-bold text-gray-800">
                            {{ $siswa->no_telepon_wali ?? "-" }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Alamat dengan Animasi -->
        <div
            class="mt-10 rounded-[2.5rem] border-4 border-fuchsia-400 bg-white p-10 shadow-2xl transition-all duration-300 hover:shadow-fuchsia-200"
        >
            <div class="space-y-8">
                <h3 class="text-2xl font-bold text-violet-600">Data Alamat</h3>

                <div
                    class="transform rounded-2xl bg-gradient-to-br from-violet-50 to-violet-100 p-6 transition-all duration-300 hover:scale-105"
                >
                    <p class="mb-3 font-medium text-violet-700">
                        Alamat Lengkap
                    </p>
                    <p class="text-xl font-bold text-gray-800">
                        {{ $siswa->alamat ?? "-" }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Action Buttons dengan Animasi -->
        <div class="mt-10 flex justify-end gap-6">
            <x-mary-button
                href="{{ route('admin.siswa.index') }}"
                class="transform rounded-full bg-gradient-to-r from-gray-400 to-gray-600 px-8 py-4 transition-all duration-300 hover:scale-105 hover:from-gray-500 hover:to-gray-700"
            >
                <x-mary-icon name="o-arrow-left" class="h-6 w-6" />
                <span class="text-lg">Kembali</span>
            </x-mary-button>

            <x-mary-button
                wire:click="delete"
                wire:confirm="Apakah Anda yakin ingin menghapus siswa ini?"
                class="transform rounded-full bg-gradient-to-r from-red-400 to-red-600 px-8 py-4 transition-all duration-300 hover:scale-105 hover:from-red-500 hover:to-red-700"
            >
                <x-mary-icon name="o-trash" class="h-6 w-6" />
                <span class="text-lg">Hapus Siswa</span>
            </x-mary-button>
        </div>
    </div>
</div>
