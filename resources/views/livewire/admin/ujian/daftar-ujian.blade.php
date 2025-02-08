<div>
    <x-mary-modal wire:model="showPreview" title="Preview Ujian">
        @if ($selectedUjian)
            <div class="space-y-6">
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
                            <x-mary-icon
                                name="o-academic-cap"
                                class="h-14 w-14 animate-bounce text-white"
                            />
                        </div>
                    </div>

                    <div class="flex-grow space-y-3">
                        <div class="space-y-1">
                            <h3
                                class="bg-gradient-to-r from-violet-600 to-fuchsia-600 bg-clip-text text-3xl font-black text-transparent transition-all duration-300 hover:from-fuchsia-600 hover:to-pink-600"
                            >
                                {{ $selectedUjian->nama }}
                            </h3>
                            <p class="italic text-gray-600">
                                {{ $selectedUjian->deskripsi }}
                            </p>
                        </div>
                        <div class="flex flex-wrap items-center gap-3">
                            <x-mary-badge
                                icon="o-calendar"
                                class="bg-gradient-to-r from-violet-100 to-violet-200 px-4 py-2 text-violet-700 shadow-md transition-all duration-300 hover:shadow-lg"
                            >
                                {{ $selectedUjian->waktu_mulai->format("d M Y") }}
                            </x-mary-badge>
                            <x-mary-badge
                                icon="o-clock"
                                class="bg-gradient-to-r from-fuchsia-100 to-fuchsia-200 px-4 py-2 text-fuchsia-700 shadow-md transition-all duration-300 hover:shadow-lg"
                            >
                                {{ $selectedUjian->waktu_mulai->format("H:i") }}
                                WIB
                            </x-mary-badge>
                            <x-mary-badge
                                icon="o-clock"
                                class="bg-gradient-to-r from-pink-100 to-pink-200 px-4 py-2 text-pink-700 shadow-md transition-all duration-300 hover:shadow-lg"
                            >
                                {{ $selectedUjian->durasi }} Menit
                            </x-mary-badge>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <x-mary-card
                        class="bg-white/90 shadow-lg backdrop-blur-xl transition-all duration-300 hover:shadow-xl"
                    >
                        <div class="p-4">
                            <h4 class="mb-4 text-lg font-semibold">
                                Informasi Ujian
                            </h4>
                            <div class="space-y-3">
                                <div class="flex items-center gap-3">
                                    <x-mary-icon
                                        name="o-academic-cap"
                                        class="h-5 w-5 text-violet-500"
                                    />
                                    <span class="text-gray-600">
                                        {{ $selectedUjian->daftarUjianSiswa->first()->mataPelajaran->nama ?? "Tidak ada mata pelajaran" }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <x-mary-icon
                                        name="o-user"
                                        class="h-5 w-5 text-violet-500"
                                    />
                                    <span class="text-gray-600">
                                        {{ $selectedUjian->daftarUjianSiswa->first()->tentor->user->name ?? "Tidak ada tentor" }}
                                    </span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <x-mary-icon
                                        name="o-users"
                                        class="h-5 w-5 text-violet-500"
                                    />
                                    <span class="text-gray-600">
                                        {{ $selectedUjian->daftarUjianSiswa->count() }}
                                        Peserta
                                    </span>
                                </div>
                                <div class="flex items-center gap-3">
                                    <x-mary-icon
                                        name="o-document-text"
                                        class="h-5 w-5 text-violet-500"
                                    />
                                    <span class="text-gray-600">
                                        {{ count($selectedUjian->paketSoal->soals) }}
                                        Soal
                                    </span>
                                </div>
                            </div>
                        </div>
                    </x-mary-card>

                    <x-mary-card
                        class="bg-white/90 shadow-lg backdrop-blur-xl transition-all duration-300 hover:shadow-xl"
                    >
                        <div class="p-4">
                            <h4 class="mb-4 text-lg font-semibold">
                                Status Ujian
                            </h4>
                            <div class="space-y-3">
                                <div class="flex items-center gap-3">
                                    <x-mary-badge
                                        :color="$selectedUjian->status === 'published' ? 'success' : ($selectedUjian->status === 'draft' ? 'warning' : 'gray')"
                                        class="px-4 py-2"
                                    >
                                        {{ ucfirst($selectedUjian->status) }}
                                    </x-mary-badge>
                                </div>
                            </div>
                        </div>
                    </x-mary-card>
                </div>

                @if ($selectedUjian->paketSoal && $selectedUjian->paketSoal->soals->isNotEmpty())
                    <x-mary-card
                        class="bg-white/90 shadow-lg backdrop-blur-xl transition-all duration-300 hover:shadow-xl"
                    >
                        <div class="p-4">
                            <h4 class="mb-4 text-lg font-semibold">
                                Daftar Soal
                            </h4>
                            <div class="max-h-60 space-y-4 overflow-y-auto">
                                @foreach ($selectedUjian->paketSoal->soals as $index => $soal)
                                    <div
                                        class="rounded-lg border border-violet-100/50 bg-gradient-to-r from-violet-50 to-fuchsia-50 p-4"
                                    >
                                        <div
                                            class="mb-2 flex items-start gap-2"
                                        >
                                            <x-mary-badge
                                                class="bg-gradient-to-r from-violet-500 to-fuchsia-500 text-white"
                                            >
                                                Soal {{ $index + 1 }}
                                            </x-mary-badge>
                                            @if ($soal->jenis_soal)
                                                <x-mary-badge
                                                    class="bg-gradient-to-r from-pink-500 to-rose-500 text-white"
                                                >
                                                    {{ ucfirst($soal->jenis_soal) }}
                                                </x-mary-badge>
                                            @endif
                                        </div>
                                        <p class="text-gray-700">
                                            {{ $soal->pertanyaan }}
                                        </p>

                                        @if ($soal->jenis_soal === "pilihan_ganda" || $soal->jenis_soal === "multiple_choice")
                                            <div class="mt-3 space-y-2">
                                                @foreach (($soal->jenis_soal === "pilihan_ganda" ? $soal->opsiJawabanPG : $soal->opsiJawabanMultipleChoice)->sortBy("urutan") as $opsi)
                                                    <div
                                                        class="{{ $opsi->is_jawaban ? "bg-green-50 text-green-700" : "bg-white/50 text-gray-600" }} flex items-center gap-2 rounded-lg p-2"
                                                    >
                                                        <span
                                                            class="font-medium"
                                                        >
                                                            {{ $opsi->label }}.
                                                        </span>
                                                        <span>
                                                            {{ $opsi->teks }}
                                                        </span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @elseif ($soal->jenis_soal === "essay")
                                            <div
                                                class="mt-3 rounded-lg bg-green-50 p-3"
                                            >
                                                <p
                                                    class="text-sm font-medium text-green-800"
                                                >
                                                    Kunci Jawaban:
                                                </p>
                                                <p class="mt-1 text-green-700">
                                                    {{ $soal->kunci_essay }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </x-mary-card>
                @endif
            </div>

            <x-slot:footer>
                <div class="flex justify-end gap-2">
                    <x-mary-button
                        wire:click="$set('showPreview', false)"
                        class="bg-white text-gray-700 hover:bg-gray-50"
                    >
                        Tutup
                    </x-mary-button>
                    <x-mary-button
                        href="{{ route('admin.ujian.show', $selectedUjian) }}"
                        class="bg-gradient-to-r from-violet-500 to-fuchsia-500 text-white hover:from-violet-600 hover:to-fuchsia-600"
                    >
                        Lihat Detail
                    </x-mary-button>
                </div>
            </x-slot>
        @endif
    </x-mary-modal>

    <!-- Welcome Section -->
    <div
        x-data="{
            showAnimation: false,
            showWelcomeMessage: true,
            hoveredCard: null,
            filterOpen: false,
        }"
        x-init="setTimeout(() => (showAnimation = true), 500)"
    >
        <!-- Welcome Message -->
        <div
            x-show="showWelcomeMessage"
            x-transition:enter="transition duration-300 ease-out"
            x-transition:enter-start="-translate-y-4 transform opacity-0"
            x-transition:enter-end="translate-y-0 transform opacity-100"
            x-transition:leave="transition duration-200 ease-in"
            x-transition:leave-start="translate-y-0 transform opacity-100"
            x-transition:leave-end="-translate-y-4 transform opacity-0"
            class="fixed right-4 top-4 z-50 rounded-xl bg-gradient-to-r from-violet-500/90 to-fuchsia-500/90 p-4 text-white shadow-xl backdrop-blur-lg"
        >
            <div class="flex items-center gap-3">
                <span class="text-2xl">👋</span>
                <div>
                    <h3 class="font-bold">
                        Selamat Datang di Manajemen Ujian!
                    </h3>
                    <p class="text-sm opacity-90">
                        Kelola ujian dengan lebih efektif
                    </p>
                </div>
                <button
                    @click="showWelcomeMessage = false"
                    class="ml-4 rounded-lg p-1 transition-colors hover:bg-white/20"
                >
                    <x-mary-icon name="o-x-mark" class="h-5 w-5" />
                </button>
            </div>
        </div>

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
                class="overflow-hidden rounded-3xl border-none bg-gradient-to-br from-gray-100 to-slate-200 backdrop-blur-lg transition-all duration-300 hover:scale-[1.01] hover:shadow-lg"
            >
                <!-- Dynamic Background Decorations -->
                <div
                    class="absolute right-0 top-0 -mr-48 -mt-48 h-[500px] w-[500px] animate-[pulse_4s_ease-in-out_infinite] rounded-full bg-violet-500/20 blur-[100px]"
                ></div>
                <div
                    class="absolute bottom-0 left-0 -mb-48 -ml-48 h-[500px] w-[500px] animate-[pulse_5s_ease-in-out_infinite] rounded-full bg-fuchsia-500/20 blur-[100px]"
                ></div>
                <div
                    class="absolute left-1/2 top-1/2 h-[300px] w-[300px] -translate-x-1/2 -translate-y-1/2 animate-[pulse_3s_ease-in-out_infinite] rounded-full bg-pink-500/20 blur-[80px]"
                ></div>
                <div
                    class="absolute inset-0 bg-gradient-to-br from-violet-500/5 to-fuchsia-500/5 mix-blend-overlay"
                ></div>

                <!-- Card Content -->
                <div class="relative flex items-center justify-between p-4">
                    <!-- Left Content -->
                    <div>
                        <div class="space-y-4">
                            <div class="flex items-center space-x-4">
                                <h2
                                    class="cursor-default bg-gradient-to-r from-violet-600 via-fuchsia-600 to-pink-600 bg-clip-text text-8xl font-black tracking-tight text-transparent transition-all duration-300 hover:scale-105"
                                >
                                    Ujian
                                </h2>
                                <span class="animate-bounce text-7xl">📝</span>
                            </div>
                            <p
                                class="text-xl font-light tracking-wider text-gray-600 transition-all duration-300 hover:text-gray-800"
                            >
                                Kelola dan monitor ujian dengan mudah dan
                                efisien
                            </p>
                            <div class="flex gap-3">
                                <span
                                    class="cursor-default rounded-full bg-violet-100 px-4 py-2 text-sm font-medium text-violet-700 transition-all duration-300 hover:scale-105 hover:bg-violet-200"
                                >
                                    Terjadwal
                                </span>
                                <span
                                    class="cursor-default rounded-full bg-fuchsia-100 px-4 py-2 text-sm font-medium text-fuchsia-700 transition-all duration-300 hover:scale-105 hover:bg-fuchsia-200"
                                >
                                    Terorganisir
                                </span>
                                <span
                                    class="cursor-default rounded-full bg-pink-100 px-4 py-2 text-sm font-medium text-pink-700 transition-all duration-300 hover:scale-105 hover:bg-pink-200"
                                >
                                    Terintegrasi
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Right Content - Action Buttons -->
                    <div class="flex flex-col space-y-6">
                        <x-mary-button
                            icon="o-plus"
                            label="Buat Ujian"
                            wire:navigate
                            href="{{ route('admin.ujian.create') }}"
                            class="bg-gradient-to-br from-violet-500 to-fuchsia-500 text-white shadow-lg transition-all duration-300 hover:scale-105 hover:from-violet-600 hover:to-fuchsia-600"
                        />
                    </div>
                </div>
            </x-mary-card>
        </div>
    </div>
    <div
        class="max-w-8xl container mx-auto px-4 py-6 sm:px-6 sm:py-8 lg:px-8 lg:py-12"
    >
        <div class="mb-8">
            <div
                class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between"
            >
                <div class="flex flex-wrap items-center gap-3">
                    <!-- Search with animation -->
                    <div class="group relative">
                        <x-mary-input
                            icon="o-magnifying-glass"
                            wire:model.live.debounce.300ms="search"
                            placeholder="Cari ujian..."
                            class="min-w-[300px] transition-all duration-300 focus:ring-2 focus:ring-violet-500/50 group-hover:shadow-lg"
                        />
                        <div
                            class="absolute inset-0 -z-10 rounded-lg bg-gradient-to-r from-violet-500/10 to-fuchsia-500/10 opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                        ></div>
                    </div>

                    <!-- Per Page Dropdown with custom styling -->
                    <div class="group relative">
                        <x-mary-select
                            wire:model.live="perPage"
                            class="border-violet-200 bg-gradient-to-r from-violet-50 to-fuchsia-50 transition-all duration-300 group-hover:shadow-lg"
                        >
                            <option value="5">5 per halaman</option>
                            <option value="10">10 per halaman</option>
                            <option value="25">25 per halaman</option>
                            <option value="50">50 per halaman</option>
                        </x-mary-select>
                        <div
                            class="absolute inset-0 -z-10 rounded-lg bg-gradient-to-r from-violet-500/5 to-fuchsia-500/5"
                        ></div>
                    </div>

                    <!-- Export Button with Dropdown -->
                    <div class="group relative">
                        <x-mary-button
                            wire:click="toggleExportFilter"
                            class="bg-gradient-to-r from-red-500 to-pink-500 text-white transition-all duration-300 hover:from-red-600 hover:to-pink-600 group-hover:shadow-lg"
                        >
                            <div class="flex items-center gap-2">
                                <x-mary-icon
                                    name="o-document-arrow-down"
                                    class="h-5 w-5"
                                />
                                <span>Export PDF</span>
                            </div>
                        </x-mary-button>

                        @if ($showExportFilter)
                            <div
                                class="absolute right-0 z-50 mt-2 w-[400px] transform rounded-xl border border-gray-100 bg-white p-6 shadow-2xl transition-all duration-300 ease-out"
                            >
                                <div class="space-y-4">
                                    <div
                                        class="flex items-center justify-between"
                                    >
                                        <h3
                                            class="bg-gradient-to-r from-violet-600 to-fuchsia-600 bg-clip-text text-lg font-semibold text-transparent"
                                        >
                                            Periode Export
                                        </h3>
                                        <button
                                            wire:click="toggleExportFilter"
                                            class="text-gray-400 hover:text-gray-600"
                                        >
                                            <x-mary-icon
                                                name="o-x-mark"
                                                class="h-5 w-5"
                                            />
                                        </button>
                                    </div>

                                    <div class="space-y-4">
                                        <div class="space-y-2">
                                            <label
                                                class="block text-sm font-medium text-gray-700"
                                            >
                                                Tanggal Mulai
                                            </label>
                                            <x-mary-input
                                                type="date"
                                                wire:model="tanggalMulai"
                                                class="w-full bg-gray-50 focus:ring-2 focus:ring-violet-500/50"
                                            />
                                            @error("tanggalMulai")
                                                <span
                                                    class="text-xs text-red-500"
                                                >
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="space-y-2">
                                            <label
                                                class="block text-sm font-medium text-gray-700"
                                            >
                                                Tanggal Akhir
                                            </label>
                                            <x-mary-input
                                                type="date"
                                                wire:model="tanggalAkhir"
                                                class="w-full bg-gray-50 focus:ring-2 focus:ring-violet-500/50"
                                            />
                                            @error("tanggalAkhir")
                                                <span
                                                    class="text-xs text-red-500"
                                                >
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="flex justify-end gap-2 pt-4">
                                        <x-mary-button
                                            wire:click="toggleExportFilter"
                                            class="bg-gray-100 text-gray-700 hover:bg-gray-200"
                                        >
                                            Batal
                                        </x-mary-button>
                                        <x-mary-button
                                            wire:click="exportPDF"
                                            wire:loading.attr="disabled"
                                            class="bg-gradient-to-r from-violet-500 to-fuchsia-500 text-white hover:from-violet-600 hover:to-fuchsia-600"
                                        >
                                            <div
                                                class="flex items-center gap-2"
                                            >
                                                <span
                                                    wire:loading.remove
                                                    wire:target="exportPDF"
                                                >
                                                    Export
                                                </span>
                                                <span
                                                    wire:loading
                                                    wire:target="exportPDF"
                                                >
                                                    <svg
                                                        class="h-5 w-5 animate-spin text-white"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                    >
                                                        <circle
                                                            class="opacity-25"
                                                            cx="12"
                                                            cy="12"
                                                            r="10"
                                                            stroke="currentColor"
                                                            stroke-width="4"
                                                        ></circle>
                                                        <path
                                                            class="opacity-75"
                                                            fill="currentColor"
                                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                                        ></path>
                                                    </svg>
                                                </span>
                                                <span
                                                    wire:loading
                                                    wire:target="exportPDF"
                                                >
                                                    Memproses...
                                                </span>
                                            </div>
                                        </x-mary-button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <x-mary-button
                        href="{{ route('admin.ujian.create') }}"
                        class="transform bg-gradient-to-r from-violet-500 to-fuchsia-500 text-white transition-all duration-300 hover:scale-105 hover:from-violet-600 hover:to-fuchsia-600 hover:shadow-lg"
                    >
                        <div class="flex items-center gap-2">
                            <x-mary-icon name="o-plus" class="h-5 w-5" />
                            <span>Tambah Ujian</span>
                        </div>
                    </x-mary-button>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($ujians as $ujian)
                <x-mary-card
                    class="border-0 bg-white/90 shadow-lg backdrop-blur-xl transition-all duration-300 hover:shadow-xl"
                >
                    <div class="p-6">
                        <div class="mb-4 flex items-start justify-between">
                            <div>
                                <h3
                                    class="bg-gradient-to-r from-violet-600 to-fuchsia-600 bg-clip-text text-xl font-bold text-transparent"
                                >
                                    {{ $ujian->nama }}
                                </h3>
                                <p class="mt-1 text-gray-600">
                                    {{ Str::limit($ujian->deskripsi, 100) }}
                                </p>
                            </div>
                            <x-mary-badge
                                :color="$ujian->status === 'published' ? 'success' : ($ujian->status === 'draft' ? 'warning' : 'gray')"
                            >
                                {{ ucfirst($ujian->status) }}
                            </x-mary-badge>
                        </div>

                        <div class="space-y-3">
                            @if ($ujian->daftarUjianSiswa->isNotEmpty())
                                <div class="flex items-center gap-3">
                                    <x-mary-icon
                                        name="o-academic-cap"
                                        class="h-5 w-5 text-violet-500"
                                    />
                                    <span class="text-gray-600">
                                        {{ $ujian->daftarUjianSiswa->first()->mataPelajaran->nama_pelajaran ?? "Tidak ada mata pelajaran" }}
                                    </span>
                                </div>

                                <div class="flex items-center gap-3">
                                    <x-mary-icon
                                        name="o-user"
                                        class="h-5 w-5 text-violet-500"
                                    />
                                    <span class="text-gray-600">
                                        {{ $ujian->daftarUjianSiswa->first()->tentor->user->name ?? "Tidak ada tentor" }}
                                    </span>
                                </div>
                            @endif

                            <div class="flex items-center gap-3">
                                <x-mary-icon
                                    name="o-calendar"
                                    class="h-5 w-5 text-violet-500"
                                />
                                <span class="text-gray-600">
                                    {{ $ujian->waktu_mulai->format("d M Y H:i") }}
                                </span>
                            </div>

                            <div class="flex items-center gap-3">
                                <x-mary-icon
                                    name="o-clock"
                                    class="h-5 w-5 text-violet-500"
                                />
                                <span class="text-gray-600">
                                    Durasi: {{ $ujian->durasi }} Menit
                                </span>
                            </div>

                            @if ($ujian->paketSoal)
                                <div class="flex items-center gap-3">
                                    <x-mary-icon
                                        name="o-document-text"
                                        class="h-5 w-5 text-violet-500"
                                    />
                                    <span class="text-gray-600">
                                        {{ $ujian->paketSoal->soals_count ?? 0 }}
                                        Soal
                                    </span>
                                </div>
                            @endif

                            <div class="flex items-center gap-3">
                                <x-mary-icon
                                    name="o-users"
                                    class="h-5 w-5 text-violet-500"
                                />
                                <span class="text-gray-600">
                                    {{ $ujian->daftarUjianSiswa->count() }}
                                    Peserta
                                </span>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end gap-2">
                            <x-mary-button
                                wire:click="preview({{ $ujian->id }})"
                                class="btn-circle bg-violet-500 text-white hover:bg-violet-600"
                            >
                                <x-mary-icon name="o-eye" class="h-5 w-5" />
                            </x-mary-button>
                            <x-mary-button
                                href="#"
                                class="btn-circle bg-fuchsia-500 text-white hover:bg-fuchsia-600"
                            >
                                <x-mary-icon name="o-pencil" class="h-5 w-5" />
                            </x-mary-button>
                            <x-mary-button
                                wire:click="delete({{ $ujian->id }})"
                                wire:confirm="Apakah Anda yakin ingin menghapus ujian ini?"
                                class="btn-circle bg-red-500 text-white hover:bg-red-600"
                            >
                                <x-mary-icon name="o-trash" class="h-5 w-5" />
                            </x-mary-button>
                        </div>
                    </div>
                </x-mary-card>
            @empty
                <div class="col-span-full">
                    <div
                        class="flex flex-col items-center justify-center p-8 text-center"
                    >
                        <div class="mb-4 rounded-full bg-violet-100 p-3">
                            <x-mary-icon
                                name="o-document-text"
                                class="h-8 w-8 text-violet-500"
                            />
                        </div>
                        <h3 class="mb-1 text-lg font-medium text-gray-900">
                            Tidak ada ujian
                        </h3>
                        <p class="text-sm text-gray-500">
                            Belum ada ujian yang ditambahkan
                        </p>
                    </div>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $ujians->links() }}
        </div>
    </div>
</div>
