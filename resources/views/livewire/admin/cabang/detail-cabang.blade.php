<div>
    <div
        class="max-w-8xl container mx-auto px-4 py-6 sm:px-6 sm:py-8 lg:px-8 lg:py-12"
    >
        {{-- Header Informasi Cabang yang Modern --}}
        <div wire:loading.class="opacity-50 pointer-events-none">
            <x-mary-card
                class="mb-8 border-0 bg-white/90 shadow-[0_8px_30px_rgba(139,92,246,0.2)] backdrop-blur-2xl transition-all duration-500 hover:bg-white/95 hover:shadow-[0_8px_40px_rgba(139,92,246,0.3)]"
            >
                <div class="grid grid-cols-1 gap-6 lg:grid-cols-12">
                    {{-- Informasi Utama --}}
                    <div class="lg:col-span-12">
                        <div
                            class="relative flex flex-col items-start gap-6 rounded-2xl border border-violet-100/50 bg-gradient-to-br from-white/60 to-white/90 p-6 shadow-xl backdrop-blur-xl transition-all duration-500 hover:shadow-2xl sm:flex-row sm:items-center"
                        >
                            <div class="absolute -right-3 -top-3">
                                <div
                                    class="absolute inline-flex h-4 w-4 animate-ping rounded-full bg-violet-400 opacity-75"
                                ></div>
                                <div
                                    class="relative inline-flex h-4 w-4 rounded-full bg-violet-500"
                                ></div>
                            </div>

                            <div class="group relative">
                                <div
                                    class="absolute -inset-1 rounded-2xl bg-gradient-to-r from-violet-600 to-fuchsia-600 opacity-40 blur transition duration-500 group-hover:opacity-60"
                                ></div>
                                <div
                                    class="relative flex h-28 w-28 transform items-center justify-center rounded-2xl bg-gradient-to-br from-violet-500 via-fuchsia-500 to-pink-500 shadow-lg transition-all duration-500 group-hover:scale-105"
                                >
                                    <img
                                        src="{{ asset("images/logo.webp") }}"
                                        alt="Logo Mary"
                                        class="h-14 w-14 animate-bounce text-white"
                                    />
                                </div>
                            </div>

                            <div class="flex-grow space-y-3">
                                <div class="space-y-1">
                                    <h3
                                        class="bg-gradient-to-r from-violet-600 to-fuchsia-600 bg-clip-text text-3xl font-black text-transparent transition-all duration-300 hover:from-fuchsia-600 hover:to-pink-600"
                                    >
                                        {{ $cabang->nama }}
                                    </h3>
                                    <p class="italic text-gray-600">
                                        {{ $cabang->alamat }}
                                    </p>
                                </div>
                                <div class="flex flex-wrap items-center gap-3">
                                    <x-mary-badge
                                        icon="o-phone"
                                        class="bg-gradient-to-r from-violet-100 to-violet-200 px-4 py-2 text-violet-700 shadow-md transition-all duration-300 hover:shadow-lg"
                                    >
                                        {{ $cabang->telepon }}
                                    </x-mary-badge>
                                    <x-mary-badge
                                        icon="o-envelope"
                                        class="bg-gradient-to-r from-fuchsia-100 to-fuchsia-200 px-4 py-2 text-fuchsia-700 shadow-md transition-all duration-300 hover:shadow-lg"
                                    >
                                        {{ $cabang->email }}
                                    </x-mary-badge>
                                    <x-mary-badge
                                        icon="o-clock"
                                        class="bg-gradient-to-r from-pink-100 to-pink-200 px-4 py-2 text-pink-700 shadow-md transition-all duration-300 hover:shadow-lg"
                                    >
                                        {{ $cabang->jam_operasional }}
                                    </x-mary-badge>
                                </div>
                            </div>

                            <div class="flex gap-2">
                                <x-mary-button
                                    wire:click="$dispatch('edit-cabang', { id: {{ $cabang->id }} })"
                                    class="bg-gradient-to-r from-violet-600 to-fuchsia-600 text-white transition-all duration-300 hover:from-violet-700 hover:to-fuchsia-700"
                                >
                                    <div class="flex items-center gap-2">
                                        <x-mary-icon
                                            name="o-pencil-square"
                                            class="h-4 w-4"
                                        />
                                        Edit
                                    </div>
                                </x-mary-button>
                                <x-mary-button
                                    wire:click="$dispatch('delete-cabang', { id: {{ $cabang->id }} })"
                                    class="bg-gradient-to-r from-red-600 to-pink-600 text-white transition-all duration-300 hover:from-red-700 hover:to-pink-700"
                                >
                                    <div class="flex items-center gap-2">
                                        <x-mary-icon
                                            name="o-trash"
                                            class="h-4 w-4"
                                        />
                                        Hapus
                                    </div>
                                </x-mary-button>
                            </div>
                        </div>
                    </div>

                    {{-- Statistik Cards --}}
                    <div
                        class="grid grid-cols-1 gap-6 md:grid-cols-4 lg:col-span-12"
                    >
                        <div
                            class="group relative transform transition-all duration-500 hover:scale-105"
                        >
                            <div
                                class="absolute -inset-1 rounded-2xl bg-gradient-to-r from-violet-600 to-fuchsia-600 opacity-25 blur transition duration-1000 group-hover:opacity-75 group-hover:duration-200"
                            ></div>
                            <div
                                class="relative rounded-2xl bg-white/90 p-6 shadow-lg backdrop-blur-xl"
                            >
                                <div class="text-center">
                                    <div
                                        class="mb-2 text-sm font-medium text-gray-600"
                                    >
                                        Status Cabang
                                    </div>
                                    <x-mary-badge
                                        value="{{ $cabang->status }}"
                                        :color="$cabang->status === 'aktif' ? 'success' : 'error'"
                                        class="px-4 py-1 text-base"
                                    />
                                </div>
                            </div>
                        </div>

                        <div
                            class="group relative transform transition-all duration-500 hover:scale-105"
                        >
                            <div
                                class="absolute -inset-1 rounded-2xl bg-gradient-to-r from-violet-600 to-fuchsia-600 opacity-25 blur transition duration-1000 group-hover:opacity-75 group-hover:duration-200"
                            ></div>
                            <div
                                class="relative rounded-2xl bg-white/90 p-6 shadow-lg backdrop-blur-xl"
                            >
                                <div class="text-center">
                                    <div
                                        class="mb-2 text-sm font-medium text-gray-600"
                                    >
                                        Jam Operasional
                                    </div>
                                    <p
                                        class="text-lg font-semibold text-gray-800"
                                    >
                                        08:00 - 17:00
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div
                            class="group relative transform transition-all duration-500 hover:scale-105"
                        >
                            <div
                                class="absolute -inset-1 rounded-2xl bg-gradient-to-r from-violet-600 to-fuchsia-600 opacity-25 blur transition duration-1000 group-hover:opacity-75 group-hover:duration-200"
                            ></div>
                            <div
                                class="relative rounded-2xl bg-white/90 p-6 shadow-lg backdrop-blur-xl"
                            >
                                <div class="text-center">
                                    <div
                                        class="mb-2 text-sm font-medium text-gray-600"
                                    >
                                        Total Tentor
                                    </div>
                                    <div
                                        class="flex items-center justify-center gap-2"
                                    >
                                        <x-mary-icon
                                            name="o-users"
                                            class="h-6 w-6 text-violet-600"
                                        />
                                        <p
                                            class="bg-gradient-to-r from-violet-600 to-fuchsia-600 bg-clip-text text-2xl font-bold text-transparent"
                                        >
                                            {{ count($cabang->tentor) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div
                            class="group relative transform transition-all duration-500 hover:scale-105"
                        >
                            <div
                                class="absolute -inset-1 rounded-2xl bg-gradient-to-r from-violet-600 to-fuchsia-600 opacity-25 blur transition duration-1000 group-hover:opacity-75 group-hover:duration-200"
                            ></div>
                            <div
                                class="relative rounded-2xl bg-white/90 p-6 shadow-lg backdrop-blur-xl"
                            >
                                <div class="text-center">
                                    <div
                                        class="mb-2 text-sm font-medium text-gray-600"
                                    >
                                        Total Siswa
                                    </div>
                                    <div
                                        class="flex items-center justify-center gap-2"
                                    >
                                        <x-mary-icon
                                            name="o-academic-cap"
                                            class="h-6 w-6 text-violet-600"
                                        />
                                        <p
                                            class="bg-gradient-to-r from-violet-600 to-fuchsia-600 bg-clip-text text-2xl font-bold text-transparent"
                                        >
                                            {{ count($cabang->siswas) }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </x-mary-card>
        </div>

        {{-- Tabs Content --}}
        <x-mary-tabs
            wire:model="selectedTab"
            class="rounded-xl bg-white/90 p-4 shadow-lg backdrop-blur-2xl"
        >
            <x-mary-tab name="tentor-tab" label="Daftar Tentor" icon="o-users">
                <div class="grid grid-cols-1 gap-6 p-4 md:grid-cols-3">
                    @foreach ($cabang->tentor as $tentor)
                        <div
                            class="group relative transform transition-all duration-500 hover:scale-[1.02]"
                        >
                            <div
                                class="absolute -inset-1 rounded-2xl bg-gradient-to-r from-violet-600 to-fuchsia-600 opacity-25 blur transition duration-1000 group-hover:opacity-75 group-hover:duration-200"
                            ></div>
                            <div
                                class="relative rounded-2xl bg-white/90 p-6 shadow-lg backdrop-blur-xl"
                            >
                                <div class="flex flex-col gap-4">
                                    <div class="flex items-center gap-4">
                                        <x-mary-avatar
                                            src="{{ $tentor->foto ?? '' }}"
                                            class="h-16 w-16 ring-2 ring-violet-500/20"
                                        />
                                        <div>
                                            <h3
                                                class="bg-gradient-to-r from-violet-600 to-fuchsia-600 bg-clip-text text-lg font-semibold text-transparent"
                                            >
                                                {{ $tentor->user->name }}
                                            </h3>
                                            <p class="text-sm text-gray-500">
                                                {{ $tentor->user->email }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="space-y-3 text-sm">
                                        <div class="flex items-center gap-2">
                                            <x-mary-icon
                                                name="o-phone"
                                                class="h-4 w-4 text-violet-600"
                                            />
                                            <span class="text-gray-600">
                                                {{ $tentor->no_telepon }}
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <x-mary-icon
                                                name="o-map-pin"
                                                class="h-4 w-4 text-violet-600"
                                            />
                                            <span class="text-gray-600">
                                                {{ $tentor->alamat }}
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <x-mary-icon
                                                name="o-circle-stack"
                                                class="h-4 w-4 text-violet-600"
                                            />
                                            <x-mary-badge
                                                value="{{ $tentor->status }}"
                                                :color="$tentor->status === 'aktif' ? 'success' : 'error'"
                                                class="px-3"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-mary-tab>

            <x-mary-tab
                name="siswa-tab"
                label="Daftar Siswa"
                icon="o-academic-cap"
            >
                <div class="grid grid-cols-1 gap-6 p-4 md:grid-cols-3">
                    @foreach ($cabang->siswas as $siswa)
                        <div
                            class="group relative transform transition-all duration-500 hover:scale-[1.02]"
                        >
                            <div
                                class="absolute -inset-1 rounded-2xl bg-gradient-to-r from-violet-600 to-fuchsia-600 opacity-25 blur transition duration-1000 group-hover:opacity-75 group-hover:duration-200"
                            ></div>
                            <div
                                class="relative rounded-2xl bg-white/90 p-6 shadow-lg backdrop-blur-xl"
                            >
                                <div class="flex flex-col gap-4">
                                    <div class="flex items-center gap-4">
                                        <x-mary-avatar
                                            src="{{ $siswa->foto ?? '' }}"
                                            class="h-16 w-16 ring-2 ring-violet-500/20"
                                        />
                                        <div>
                                            <h3
                                                class="bg-gradient-to-r from-violet-600 to-fuchsia-600 bg-clip-text text-lg font-semibold text-transparent"
                                            >
                                                {{ $siswa->nama_lengkap }}
                                            </h3>
                                            <p class="text-sm text-gray-500">
                                                {{ $siswa->email }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="space-y-3 text-sm">
                                        <div class="flex items-center gap-2">
                                            <x-mary-icon
                                                name="o-phone"
                                                class="h-4 w-4 text-violet-600"
                                            />
                                            <span class="text-gray-600">
                                                {{ $siswa->no_telepon }}
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <x-mary-icon
                                                name="o-map-pin"
                                                class="h-4 w-4 text-violet-600"
                                            />
                                            <span class="text-gray-600">
                                                {{ $siswa->alamat }}
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <x-mary-icon
                                                name="o-circle-stack"
                                                class="h-4 w-4 text-violet-600"
                                            />
                                            <x-mary-badge
                                                value="{{ $siswa->status }}"
                                                :color="$siswa->status === 'aktif' ? 'success' : 'error'"
                                                class="px-3"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-mary-tab>
        </x-mary-tabs>
    </div>
</div>
