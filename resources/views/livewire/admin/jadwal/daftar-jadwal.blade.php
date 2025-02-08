<div>
    <!-- Welcome Section -->
    <div
        class="p-6"
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
                <div class="relative flex flex-col items-center justify-between gap-6 p-6 text-center sm:flex-row sm:p-12 sm:text-left">
                    <!-- Left Content -->
                    <div>
                        <div class="space-y-2">
                            <h2
                                class="animate__animated animate__fadeInLeft bg-gradient-to-r from-violet-600 via-indigo-600 to-blue-600 bg-clip-text text-4xl font-black tracking-tight text-transparent sm:text-7xl"
                            >
                                Jadwal Belajar 📚
                            </h2>
                            <p
                                class="animate__animated animate__fadeInUp animate__delay-1s text-base font-light tracking-wider text-gray-600 sm:text-lg"
                            >
                                Kelola jadwal pembelajaran dengan mudah
                            </p>
                        </div>
                    </div>

                    <!-- Right Content - Action Buttons -->
                    <div class="animate__animated animate__fadeInRight">
                        <x-mary-button
                            icon="o-plus"
                            label="Tambah Jadwal"
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
                <div class="p-4 sm:p-6 md:p-10">
                    <div class="flex w-full flex-col gap-4 sm:flex-row">
                        <x-mary-input
                            placeholder="Cari jadwal..."
                            wire:model.live.debounce="search"
                            clearable
                            icon="o-magnifying-glass"
                            class="w-full border-slate-300 bg-gradient-to-br from-slate-100/80 to-slate-200/80 text-gray-700 placeholder-gray-500 shadow-lg backdrop-blur-lg transition-shadow duration-300 hover:shadow-xl sm:w-auto"
                        />

                        <div class="flex flex-col gap-4 sm:flex-row">
                            <x-mary-select
                                wire:model.live="perPage"
                                :options="[
                                    ['label' => '10 Data', 'value' => 10],
                                    ['label' => '25 Data', 'value' => 25],
                                    ['label' => '50 Data', 'value' => 50],
                                ]"
                                option-label="label"
                                option-value="value"
                                class="w-full border-slate-300 bg-gradient-to-br from-slate-100/80 to-slate-200/80 text-gray-700 shadow-lg backdrop-blur-lg transition-shadow duration-300 hover:shadow-xl sm:w-auto"
                            />

                            <x-mary-datetime
                                wire:model.live="filterDate"
                                placeholder="Filter Tanggal"
                                class="w-full border-slate-300 bg-gradient-to-br from-slate-100/80 to-slate-200/80 text-gray-700 shadow-lg backdrop-blur-lg transition-shadow duration-300 hover:shadow-xl sm:w-auto"
                            />

                            <x-mary-button
                                wire:click="exportJadwalByDate"
                                wire:loading.attr="disabled"
                                icon="o-document-arrow-down"
                                label="Export PDF"
                                class="w-full transform border border-white/20 bg-gradient-to-br from-violet-500/40 to-indigo-500/40 text-white shadow-lg backdrop-blur-lg transition-transform duration-300 hover:scale-105 hover:from-violet-500/50 hover:to-indigo-500/50 sm:w-auto"
                            />
                        </div>
                    </div>
                </div>
            </x-mary-card>
        </div>

        <!-- Jadwal Cards Grid -->
        <div
            class="grid grid-cols-1 gap-4 sm:gap-8 md:grid-cols-2 xl:grid-cols-3"
            x-show="showAnimation"
            x-transition:enter="transition duration-1000 ease-out"
            x-transition:enter-start="translate-y-12 transform opacity-0"
            x-transition:enter-end="translate-y-0 transform opacity-100"
        >
            @forelse ($jadwals as $jadwal)
                <div
                    class="animate__animated animate__fadeInUp transform overflow-hidden transition-all duration-500 hover:scale-105"
                    style="animation-delay: {{ $loop->iteration * 150 }}ms"
                >
                    <x-mary-card
                        shadow
                        class="rounded-3xl border-none bg-gradient-to-br from-gray-100 to-slate-200 backdrop-blur-lg transition-shadow duration-300 hover:shadow-2xl"
                    >
                        <div class="p-4 sm:p-8">
                            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                                <x-mary-badge
                                    :label="ucfirst($jadwal->status)"
                                    :class="$jadwal->status === 'aktif' ? 'bg-emerald-100 border-emerald-200 text-emerald-700' : 'bg-red-100 border-red-200 text-red-700'"
                                    class="w-fit rounded-full border px-4 py-1.5 text-sm font-medium backdrop-blur-lg transition-colors duration-300 hover:bg-opacity-75"
                                />
                                <span class="text-sm font-medium text-gray-600">
                                    {{ \Carbon\Carbon::parse($jadwal->tanggal_mulai)->format("d M Y") }}
                                </span>
                            </div>

                            <h3
                                class="mb-4 transform bg-gradient-to-r from-violet-600 to-indigo-600 bg-clip-text text-2xl font-black text-transparent transition-transform duration-300 hover:scale-105"
                            >
                                {{ $jadwal->nama_jadwal }}
                            </h3>

                            <div class="space-y-3 text-gray-600">
                                <div class="flex items-center gap-2">
                                    <x-mary-icon
                                        name="o-academic-cap"
                                        class="h-5 w-5"
                                    />
                                    <p class="text-lg">
                                        {{ $jadwal->mataPelajaran->nama_pelajaran }}
                                    </p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <x-mary-icon
                                        name="o-clock"
                                        class="h-5 w-5"
                                    />
                                    <p>
                                        {{ $jadwal->hari }},
                                        {{ $jadwal->jam_mulai }} -
                                        {{ $jadwal->jam_selesai }}
                                    </p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <x-mary-icon
                                        name="o-building-office"
                                        class="h-5 w-5"
                                    />
                                    <p>
                                        {{ $jadwal->kelasBimbel->nama_kelas }}
                                    </p>
                                </div>
                                @if ($jadwal->keterangan)
                                    <div class="flex items-center gap-2">
                                        <x-mary-icon
                                            name="o-information-circle"
                                            class="h-5 w-5"
                                        />
                                        <p>{{ $jadwal->keterangan }}</p>
                                    </div>
                                @endif
                            </div>

                            <div class="mt-8 flex gap-3">
                                <x-mary-button
                                    wire:click="edit({{ $jadwal->id }})"
                                    icon="o-pencil"
                                    label="Edit"
                                    class="flex-1 transform border border-white/20 bg-gradient-to-br from-blue-500/40 to-cyan-500/40 text-white backdrop-blur-lg transition-transform duration-300 hover:scale-105 hover:from-blue-500/50 hover:to-cyan-500/50"
                                />
                                <x-mary-button
                                    wire:click="confirmDelete({{ $jadwal->id }})"
                                    wire:confirm="Yakin ingin menghapus jadwal ini?"
                                    icon="o-trash"
                                    label="Hapus"
                                    class="flex-1 transform border border-white/20 bg-gradient-to-br from-red-500/40 to-pink-500/40 text-white backdrop-blur-lg transition-transform duration-300 hover:scale-105 hover:from-red-500/50 hover:to-pink-500/50"
                                />
                            </div>
                        </div>
                    </x-mary-card>
                </div>
            @empty
                <div class="animate__animated animate__fadeIn col-span-full">
                    <x-mary-card
                        shadow
                        class="rounded-3xl border-none bg-gradient-to-br from-gray-100 to-slate-200 p-16 text-center backdrop-blur-lg transition-shadow duration-300 hover:shadow-2xl"
                    >
                        <div
                            class="animate__animated animate__bounce animate__infinite mb-6 text-8xl"
                        >
                            📅
                        </div>
                        <h3
                            class="mb-4 bg-gradient-to-r from-violet-600 to-indigo-600 bg-clip-text text-3xl font-black text-transparent"
                        >
                            Belum Ada Jadwal
                        </h3>
                        <p class="text-lg font-light text-gray-600">
                            Mulai buat jadwal pertama Anda sekarang!
                        </p>
                    </x-mary-card>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Include your existing modals here -->
    <x-ts-modal
        wire="modalCreate"
        title="Tambah Jadwal Baru"
        size="4xl"
        persistent
    >
        <!-- Your existing create modal content -->
    </x-ts-modal>

    <x-ts-modal wire="modalEdit" title="Edit Jadwal" size="4xl" persistent>
        <!-- Your existing edit modal content -->
    </x-ts-modal>

    <x-ts-modal wire="modalDelete" title="Hapus Jadwal" size="md" persistent>
        <!-- Your existing delete modal content -->
    </x-ts-modal>

    <x-ts-modal wire="modalPreview" center size="4xl">
        <!-- Your existing preview modal content -->
    </x-ts-modal>
</div>
