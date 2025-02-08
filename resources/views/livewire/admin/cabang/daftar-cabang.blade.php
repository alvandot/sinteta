<div
    x-data="{ showAnimation: false }"
    x-init="setTimeout(() => (showAnimation = true), 500)"
>
    <!-- Header Card -->
    <div
        class="mb-10"
        x-show="showAnimation"
        x-transition:enter="transition duration-1000 ease-out"
        x-transition:enter-start="-translate-y-12 transform opacity-0"
        x-transition:enter-end="translate-y-0 transform opacity-100"
    >
        <x-mary-card
            shadow
            class="transform overflow-hidden rounded-3xl border-none bg-gradient-to-br from-gray-100 to-slate-200 backdrop-blur-lg transition-all duration-500 hover:scale-[1.02] hover:shadow-2xl"
        >
            <!-- Background Decorations -->
            <div
                class="absolute right-0 top-0 -mr-48 -mt-48 h-[500px] w-[500px] animate-pulse rounded-full bg-violet-500/20 blur-[100px]"
            ></div>
            <div
                class="absolute bottom-0 left-0 -mb-48 -ml-48 h-[500px] w-[500px] animate-pulse rounded-full bg-indigo-500/20 blur-[100px]"
            ></div>

            <!-- Card Content -->
            <div class="relative flex items-center justify-between p-12">
                <!-- Left Content -->
                <div>
                    <div class="space-y-2">
                        <h2
                            class="animate__animated animate__fadeInLeft bg-gradient-to-r from-violet-600 via-indigo-600 to-blue-600 bg-clip-text text-7xl font-black tracking-tight text-transparent"
                        >
                            Daftar Cabang 🏢
                        </h2>
                        <p
                            class="animate__animated animate__fadeInUp animate__delay-1s text-lg font-light tracking-wider text-gray-600"
                        >
                            Kelola data cabang perusahaan dengan mudah
                        </p>
                    </div>
                </div>

                <!-- Right Content - Action Buttons -->
                <div
                    class="animate__animated animate__fadeInRight flex flex-col space-y-6"
                >
                    <x-mary-button
                        icon="o-plus"
                        label="Tambah Cabang"
                        wire:click="create"
                        class="animate-bounce border border-white/20 bg-gradient-to-br from-violet-500/40 to-indigo-500/40 shadow-2xl backdrop-blur-sm transition-all duration-500 hover:scale-110 hover:from-violet-500/50 hover:to-indigo-500/50"
                    />
                </div>
            </div>
        </x-mary-card>
    </div>

    <!-- Control Panel -->
    <div
        x-show="showAnimation"
        x-transition:enter="transition duration-1000 ease-out"
        x-transition:enter-start="translate-y-12 transform opacity-0"
        x-transition:enter-end="translate-y-0 transform opacity-100"
    >
        <x-mary-card
            shadow
            class="mb-10 rounded-3xl border-none bg-gradient-to-br from-gray-100 to-slate-200 backdrop-blur-lg duration-300 hover:scale-[1.01]"
        >
            <div class="flex items-center justify-between p-10">
                <div class="flex w-full gap-4">
                    <x-mary-input
                        placeholder="Cari cabang..."
                        wire:model.live.debounce="search"
                        clearable
                        icon="o-magnifying-glass"
                        class="border-slate-300 bg-gradient-to-br from-slate-100/80 to-slate-200/80 text-gray-700 placeholder-gray-500 shadow-lg backdrop-blur-lg transition-shadow duration-300 hover:shadow-xl"
                    />
                </div>
            </div>
        </x-mary-card>
    </div>

    <!-- Cabang Cards Grid -->
    <div
        class="grid grid-cols-1 gap-8 md:grid-cols-2 xl:grid-cols-3"
        x-show="showAnimation"
        x-transition:enter="transition duration-1000 ease-out"
        x-transition:enter-start="translate-y-12 transform opacity-0"
        x-transition:enter-end="translate-y-0 transform opacity-100"
    >
        @forelse ($cabangs as $cabang)
            <div
                wire:click="showDetail({{ $cabang->id }})"
                class="animate__animated animate__fadeInUp group transform cursor-pointer overflow-hidden transition-all duration-500 hover:scale-105"
                style="animation-delay: {{ $loop->iteration * 150 }}ms"
            >
                <x-mary-card
                    shadow
                    class="relative rounded-3xl border-none bg-gradient-to-br from-gray-100 to-slate-200 backdrop-blur-lg transition-all duration-500 hover:shadow-2xl"
                >
                    <!-- Decorative Elements -->
                    <div
                        class="absolute -right-20 -top-20 h-40 w-40 rounded-full bg-violet-400/20 blur-2xl transition-all duration-500 group-hover:bg-indigo-400/30"
                    ></div>
                    <div
                        class="absolute -bottom-20 -left-20 h-40 w-40 rounded-full bg-blue-400/20 blur-2xl transition-all duration-500 group-hover:bg-cyan-400/30"
                    ></div>

                    <div class="relative p-8">
                        <!-- Header with Icon -->
                        <div class="mb-6 flex items-center gap-4">
                            <div
                                class="rounded-2xl bg-gradient-to-br from-violet-500/10 to-indigo-500/10 p-3 transition-all duration-300 group-hover:from-violet-500/20 group-hover:to-indigo-500/20"
                            >
                                <x-mary-icon
                                    name="o-building-office-2"
                                    class="h-8 w-8 text-violet-600 transition-colors duration-300 group-hover:text-indigo-600"
                                />
                            </div>
                            <h3
                                class="bg-gradient-to-r from-violet-600 to-indigo-600 bg-clip-text text-2xl font-black text-transparent transition-all duration-300 group-hover:from-indigo-600 group-hover:to-blue-600"
                            >
                                {{ $cabang->nama }}
                            </h3>
                        </div>

                        <!-- Info Cards -->
                        <div class="space-y-4">
                            <div
                                class="rounded-xl bg-white/50 p-4 backdrop-blur-sm transition-all duration-300 group-hover:bg-white/70"
                            >
                                <div class="flex items-center gap-3">
                                    <x-mary-icon
                                        name="o-map-pin"
                                        class="h-5 w-5 text-violet-500"
                                    />
                                    <p class="text-gray-700">
                                        {{ $cabang->alamat }}
                                    </p>
                                </div>
                            </div>

                            <div
                                class="rounded-xl bg-white/50 p-4 backdrop-blur-sm transition-all duration-300 group-hover:bg-white/70"
                            >
                                <div class="flex items-center gap-3">
                                    <x-mary-icon
                                        name="o-phone"
                                        class="h-5 w-5 text-indigo-500"
                                    />
                                    <p class="text-gray-700">
                                        {{ $cabang->kontak }}
                                    </p>
                                </div>
                            </div>

                            <div
                                class="rounded-xl bg-white/50 p-4 backdrop-blur-sm transition-all duration-300 group-hover:bg-white/70"
                            >
                                <div class="flex items-center gap-3">
                                    <x-mary-icon
                                        name="o-envelope"
                                        class="h-5 w-5 text-blue-500"
                                    />
                                    <p class="text-gray-700">
                                        {{ $cabang->email }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-mary-card>
            </div>
        @empty
            <div class="animate__animated animate__fadeIn col-span-full">
                <x-mary-card
                    shadow
                    class="relative cursor-pointer rounded-3xl border-none bg-gradient-to-br from-gray-100 to-slate-200 p-16 text-center backdrop-blur-lg hover:cursor-pointer"
                >
                    <!-- Decorative Background -->
                    <div
                        class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAwIiBoZWlnaHQ9IjIwMCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZGVmcz48cGF0dGVybiBpZD0iZ3JpZCIgd2lkdGg9IjQwIiBoZWlnaHQ9IjQwIiBwYXR0ZXJuVW5pdHM9InVzZXJTcGFjZU9uVXNlIj48cGF0aCBkPSJNIDQwIDAgTCAwIDAgMCA0MCIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjZTJlOGYwIiBzdHJva2Utd2lkdGg9IjEiLz48L3BhdHRlcm4+PC9kZWZzPjxyZWN0IHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiIGZpbGw9InVybCgjZ3JpZCkiLz48L3N2Zz4=')] opacity-30"
                    ></div>

                    <div class="relative">
                        <div
                            class="animate__animated animate__bounce animate__infinite animate__slow mb-6 text-8xl"
                        >
                            <span
                                class="relative inline-block transform cursor-default transition-transform duration-300 hover:scale-110"
                            >
                                🏢
                            </span>
                        </div>
                        <h3
                            class="mb-4 transform bg-gradient-to-r from-violet-600 via-indigo-600 to-blue-600 bg-clip-text text-3xl font-black text-transparent transition-transform duration-300 hover:scale-105"
                        >
                            Belum Ada Cabang
                        </h3>
                        <p
                            class="text-lg font-light text-gray-600 transition-colors duration-300 hover:text-gray-800"
                        >
                            Mulai buat cabang pertama Anda sekarang!
                        </p>
                    </div>
                </x-mary-card>
            </div>
        @endforelse
    </div>

    <!-- Modals -->
    <x-mary-modal wire:model="showModal">
        <x-slot name="title">
            {{ $editMode ? "Edit Cabang" : "Tambah Cabang Baru" }}
        </x-slot>

        <div class="space-y-4">
            <div>
                <x-mary-input
                    wire:model="nama_cabang"
                    label="Nama Cabang"
                    placeholder="Masukkan nama cabang"
                />
                @error("nama_cabang")
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-mary-textarea
                    wire:model="alamat"
                    label="Alamat"
                    placeholder="Masukkan alamat cabang"
                />
                @error("alamat")
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-mary-input
                    wire:model="kontak"
                    label="Kontak"
                    placeholder="Masukkan nomor kontak"
                />
                @error("kontak")
                    <span class="text-sm text-red-500">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-mary-button
                    wire:click="$toggle('showModal')"
                    variant="secondary"
                >
                    Batal
                </x-mary-button>
                <x-mary-button wire:click="save">
                    {{ $editMode ? "Simpan Perubahan" : "Simpan" }}
                </x-mary-button>
            </div>
        </x-slot>
    </x-mary-modal>

    <x-mary-modal wire:model="showDeleteModal">
        <x-slot name="title">Konfirmasi Hapus</x-slot>

        <div class="space-y-4">
            <p>
                Apakah Anda yakin ingin menghapus cabang ini? Tindakan ini tidak
                dapat dibatalkan.
            </p>
        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-mary-button
                    wire:click="$toggle('showDeleteModal')"
                    variant="secondary"
                >
                    Batal
                </x-mary-button>
                <x-mary-button wire:click="delete" negative>
                    Hapus
                </x-mary-button>
            </div>
        </x-slot>
    </x-mary-modal>

    <!-- Modal Detail Cabang -->
    <x-mary-modal wire:model="showDetailModal" class="max-w-3xl">
        <x-slot name="title">
            <div class="flex items-center gap-3">
                <div
                    class="rounded-xl bg-gradient-to-br from-violet-500/10 to-indigo-500/10 p-2"
                >
                    <x-mary-icon
                        name="o-building-office-2"
                        class="h-6 w-6 text-violet-600"
                    />
                </div>
                <span>Detail Cabang</span>
            </div>
        </x-slot>

        @if ($selectedCabang)
            <div class="space-y-6 p-4">
                <!-- Info Section -->
                <div class="space-y-4">
                    <div class="rounded-xl bg-gray-50 p-4">
                        <div class="flex items-center gap-3">
                            <x-mary-icon
                                name="o-building-office"
                                class="h-5 w-5 text-violet-500"
                            />
                            <div>
                                <p class="text-sm text-gray-500">Nama Cabang</p>
                                <p class="text-lg font-semibold text-gray-700">
                                    {{ $selectedCabang->nama }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-xl bg-gray-50 p-4">
                        <div class="flex items-center gap-3">
                            <x-mary-icon
                                name="o-map-pin"
                                class="h-5 w-5 text-indigo-500"
                            />
                            <div>
                                <p class="text-sm text-gray-500">Alamat</p>
                                <p class="text-lg font-semibold text-gray-700">
                                    {{ $selectedCabang->alamat }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-xl bg-gray-50 p-4">
                        <div class="flex items-center gap-3">
                            <x-mary-icon
                                name="o-phone"
                                class="h-5 w-5 text-blue-500"
                            />
                            <div>
                                <p class="text-sm text-gray-500">Kontak</p>
                                <p class="text-lg font-semibold text-gray-700">
                                    {{ $selectedCabang->kontak }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-xl bg-gray-50 p-4">
                        <div class="flex items-center gap-3">
                            <x-mary-icon
                                name="o-envelope"
                                class="h-5 w-5 text-cyan-500"
                            />
                            <div>
                                <p class="text-sm text-gray-500">Email</p>
                                <p class="text-lg font-semibold text-gray-700">
                                    {{ $selectedCabang->email }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex justify-end gap-3 pt-4">
                    <x-mary-button
                        wire:click="edit({{ $selectedCabang->id }})"
                        icon="o-pencil"
                    >
                        Edit
                    </x-mary-button>
                    <x-mary-button
                        wire:click="confirmDelete({{ $selectedCabang->id }})"
                        negative
                        icon="o-trash"
                    >
                        Hapus
                    </x-mary-button>
                </div>
            </div>
        @endif

        <x-slot name="footer">
            <div class="flex justify-end">
                <x-mary-button
                    wire:click="$toggle('showDetailModal')"
                    variant="secondary"
                >
                    Tutup
                </x-mary-button>
            </div>
        </x-slot>
    </x-mary-modal>
</div>
