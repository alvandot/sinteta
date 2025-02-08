<div>
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
            class="fixed right-4 top-4 z-50 rounded-xl bg-gradient-to-r from-indigo-500/90 to-violet-500/90 p-4 text-white shadow-xl backdrop-blur-lg"
        >
            <div class="flex items-center gap-3">
                <span class="text-2xl">👋</span>
                <div>
                    <h3 class="font-bold">Selamat Datang di Bank Soal!</h3>
                    <p class="text-sm opacity-90">
                        Kelola soal-soal Anda dengan lebih mudah
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
                    class="absolute bottom-0 left-0 -mb-48 -ml-48 h-[500px] w-[500px] animate-[pulse_5s_ease-in-out_infinite] rounded-full bg-indigo-500/20 blur-[100px]"
                ></div>
                <div
                    class="absolute left-1/2 top-1/2 h-[300px] w-[300px] -translate-x-1/2 -translate-y-1/2 animate-[pulse_3s_ease-in-out_infinite] rounded-full bg-blue-500/20 blur-[80px]"
                ></div>
                <div
                    class="absolute inset-0 bg-gradient-to-br from-violet-500/5 to-indigo-500/5 mix-blend-overlay"
                ></div>

                <!-- Card Content -->
                <div class="relative flex items-center justify-between p-4">
                    <!-- Left Content -->
                    <div>
                        <div class="space-y-4">
                            <div class="flex items-center space-x-4">
                                <h2
                                    class="cursor-default bg-gradient-to-r from-violet-600 via-indigo-600 to-blue-600 bg-clip-text text-8xl font-black tracking-tight text-transparent transition-all duration-300 hover:scale-105"
                                >
                                    Bank Soal
                                </h2>
                                <span class="animate-bounce text-7xl">📚</span>
                            </div>
                            <p
                                class="text-xl font-light tracking-wider text-gray-600 transition-all duration-300 hover:text-gray-800"
                            >
                                Kelola dan organisir semua soal dengan mudah dan
                                efisien
                            </p>
                            <div class="flex gap-3">
                                <span
                                    class="cursor-default rounded-full bg-violet-100 px-4 py-2 text-sm font-medium text-violet-700 transition-all duration-300 hover:scale-105 hover:bg-violet-200"
                                >
                                    Terstruktur
                                </span>
                                <span
                                    class="cursor-default rounded-full bg-indigo-100 px-4 py-2 text-sm font-medium text-indigo-700 transition-all duration-300 hover:scale-105 hover:bg-indigo-200"
                                >
                                    Sistematis
                                </span>
                                <span
                                    class="cursor-default rounded-full bg-blue-100 px-4 py-2 text-sm font-medium text-blue-700 transition-all duration-300 hover:scale-105 hover:bg-blue-200"
                                >
                                    Efektif
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Right Content - Action Buttons -->
                    <div class="flex flex-col space-y-6">
                        <x-mary-button
                            icon="o-plus"
                            label="Tambah Soal"
                            wire:navigate
                            href="{{ route('admin.soal.create') }}"
                            class="bg-gradient-to-br from-violet-500 to-indigo-500 text-white shadow-lg transition-all duration-300 hover:scale-105 hover:from-violet-600 hover:to-indigo-600"
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
                class="mb-10 rounded-3xl border-none bg-gradient-to-br from-gray-100 to-slate-200 backdrop-blur-lg transition-all duration-300 hover:shadow-xl"
            >
                <div
                    class="absolute inset-0 bg-gradient-to-br from-violet-500/5 to-indigo-500/5 mix-blend-overlay"
                ></div>
                <div
                    class="relative z-10 flex items-center justify-between p-10"
                >
                    <div class="flex w-full flex-wrap gap-4">
                        <div class="group min-w-[200px] flex-1">
                            <x-mary-input
                                placeholder="Cari soal..."
                                wire:model.live.debounce="search"
                                clearable
                                icon="o-magnifying-glass"
                                class="border-slate-300 bg-gradient-to-br from-slate-100/80 to-slate-200/80 text-gray-700 placeholder-gray-500 shadow-lg backdrop-blur-lg transition-all duration-300 group-hover:scale-[1.02] group-hover:shadow-xl"
                            />
                        </div>
                        <div class="group min-w-[200px] flex-1">
                            <x-mary-select
                                wire:model.live="mata_pelajaran_id"
                                :options="$mataPelajarans"
                                option-label="nama_pelajaran"
                                option-value="id"
                                placeholder="Filter Mata Pelajaran"
                                class="border-slate-300 bg-gradient-to-br from-slate-100/80 to-slate-200/80 text-gray-700 shadow-lg backdrop-blur-lg transition-all duration-300 group-hover:scale-[1.02] group-hover:shadow-xl"
                            />
                        </div>
                        <div class="group min-w-[200px] flex-1">
                            <x-mary-select
                                wire:model.live="tahun"
                                :options="$this->tahunOptions"
                                option-label="label"
                                option-value="value"
                                placeholder="Filter Tahun"
                                class="border-slate-300 bg-gradient-to-br from-slate-100/80 to-slate-200/80 text-gray-700 shadow-lg backdrop-blur-lg transition-all duration-300 group-hover:scale-[1.02] group-hover:shadow-xl"
                            />
                        </div>
                    </div>
                </div>
            </x-mary-card>
        </div>

        <!-- Soal Cards Grid -->
        <div
            class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-3"
            x-show="showAnimation"
            x-transition:enter="transition duration-1000 ease-out"
            x-transition:enter-start="translate-y-12 transform opacity-0"
            x-transition:enter-end="translate-y-0 transform opacity-100"
        >
            @forelse ($paketSoals as $paket)
                <div
                    class="relative overflow-hidden rounded-2xl border border-indigo-200 bg-white/90 p-8 shadow-lg backdrop-blur-sm transition-all duration-300 hover:scale-[1.02] hover:shadow-xl"
                    x-on:mouseenter="hoveredCard = {{ $paket->id }}"
                    x-on:mouseleave="hoveredCard = null"
                >
                    <!-- Header -->
                    <div class="mb-6 flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div
                                class="rounded-xl bg-gradient-to-br from-indigo-400 to-violet-500 p-4 shadow-lg transition-transform duration-300"
                                :class="{ 'scale-110': hoveredCard === {{ $paket->id }} }"
                            >
                                <x-mary-icon
                                    name="o-book-open"
                                    class="h-8 w-8 text-white"
                                />
                            </div>
                            <div>
                                <p
                                    class="text-lg font-medium text-indigo-600/80"
                                >
                                    {{ $paket->mataPelajaran->nama_pelajaran }}
                                </p>
                                <h3
                                    class="bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-2xl font-black text-transparent"
                                >
                                    {{ $paket->nama }}
                                </h3>
                            </div>
                        </div>
                        <x-mary-button
                            wire:click="exportPDF({{ $paket->id }})"
                            class="bg-gradient-to-r from-red-500 to-pink-500 text-white transition-all duration-300 hover:scale-105"
                        >
                            <x-mary-icon
                                name="o-document-arrow-down"
                                class="mr-2 h-5 w-5"
                            />
                            Export PDF
                        </x-mary-button>
                    </div>

                    <!-- Info Cards -->
                    <div class="mb-6 space-y-4">
                        <!-- Tahun & Tingkat -->
                        <div
                            class="flex items-center gap-4 rounded-xl bg-gradient-to-r from-indigo-50/80 to-violet-50/80 p-4 shadow-md transition-all duration-300 hover:scale-[1.01] hover:shadow-lg"
                        >
                            <div
                                class="rounded-lg bg-gradient-to-br from-indigo-500 to-violet-500 p-3 shadow-lg"
                            >
                                <x-mary-icon
                                    name="o-calendar"
                                    class="h-6 w-6 text-white"
                                />
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">
                                    Tahun
                                </p>
                                <p class="text-lg font-bold text-indigo-600">
                                    {{ $paket->tahun }}
                                </p>
                            </div>
                            <div class="ml-auto">
                                <span
                                    class="rounded-full bg-indigo-100 px-3 py-1 text-sm font-medium text-indigo-600 transition-colors hover:bg-indigo-200"
                                >
                                    Kelas {{ $paket->tingkat }}
                                </span>
                            </div>
                        </div>

                        <!-- Jumlah Soal -->
                        <div
                            class="flex items-center gap-4 rounded-xl bg-gradient-to-r from-violet-50/80 to-purple-50/80 p-4 shadow-md transition-all duration-300 hover:scale-[1.01] hover:shadow-lg"
                        >
                            <div
                                class="rounded-lg bg-gradient-to-br from-violet-500 to-purple-500 p-3 shadow-lg"
                            >
                                <x-mary-icon
                                    name="o-document-text"
                                    class="h-6 w-6 text-white"
                                />
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-600">
                                    Jumlah Soal
                                </p>
                                <p class="text-lg font-bold text-violet-600">
                                    {{ $paket->soals->count() }} Soal
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-between gap-4">
                        <x-mary-button
                            wire:navigate
                            href="{{ route('admin.soal.edit', $paket->id) }}"
                            class="flex-1 bg-gradient-to-r from-indigo-500 to-violet-500 text-white transition-all duration-300 hover:scale-105"
                        >
                            <x-mary-icon name="o-pencil" class="mr-2 h-5 w-5" />
                            Edit
                        </x-mary-button>

                        <x-mary-button
                            wire:click="previewSoal({{ $paket->id }})"
                            class="flex-1 bg-gradient-to-r from-violet-500 to-purple-500 text-white transition-all duration-300 hover:scale-105"
                        >
                            <x-mary-icon name="o-eye" class="mr-2 h-5 w-5" />
                            Preview
                        </x-mary-button>

                        <x-mary-button
                            wire:click="deletePaketSoal({{ $paket->id }})"
                            wire:confirm="Yakin ingin menghapus paket soal ini?"
                            class="flex-1 bg-gradient-to-r from-red-500 to-pink-500 text-white transition-all duration-300 hover:scale-105"
                        >
                            <x-mary-icon name="o-trash" class="mr-2 h-5 w-5" />
                            Hapus
                        </x-mary-button>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div
                        class="overflow-hidden rounded-3xl border border-indigo-200 bg-white/90 p-12 text-center shadow-lg backdrop-blur-sm transition-all duration-300 hover:shadow-xl"
                    >
                        <div class="flex flex-col items-center justify-center">
                            <div
                                class="mb-8 flex h-32 w-32 animate-bounce items-center justify-center rounded-full bg-gradient-to-br from-indigo-100 to-violet-100 shadow-lg"
                            >
                                <x-mary-icon
                                    name="o-face-smile"
                                    class="h-20 w-20 text-indigo-500"
                                />
                            </div>
                            <h3
                                class="mb-4 bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-500 bg-clip-text text-3xl font-black text-transparent"
                            >
                                Belum Ada Soal Saat Ini 📚
                            </h3>
                            <p class="text-xl font-medium text-gray-600/90">
                                Mulai buat soal pertama Anda sekarang! ✨
                            </p>
                            <x-mary-button
                                wire:navigate
                                href="{{ route('admin.soal.create') }}"
                                class="mt-8 bg-gradient-to-r from-indigo-500 to-violet-500 text-white transition-all duration-300 hover:scale-110"
                            >
                                <x-mary-icon
                                    name="o-plus"
                                    class="mr-2 h-5 w-5"
                                />
                                Buat Soal Pertama
                            </x-mary-button>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <!-- Modal Preview Soal -->
    <x-mary-modal wire:model="showPreviewModal" box-class="max-w-4xl" blur="lg">
        <div class="relative">
            <!-- Decorative Elements -->
            <div
                class="absolute -right-24 -top-24 h-48 w-48 animate-pulse rounded-full bg-violet-400/20 blur-3xl"
            ></div>
            <div
                class="absolute -bottom-24 -left-24 h-48 w-48 animate-pulse rounded-full bg-indigo-400/20 blur-3xl"
            ></div>

            <h2
                class="flex items-center gap-3 bg-gradient-to-r from-violet-600 via-fuchsia-600 to-indigo-600 bg-clip-text text-3xl font-black tracking-tight text-transparent"
            >
                <span class="animate-bounce">🎯</span>
                Preview Soal
                <span class="animate-bounce">✨</span>
            </h2>

            <div class="relative space-y-6">
                @if ($selectedPaket)
                    <div class="mb-8">
                        <div class="mb-4 flex items-center gap-3">
                            <span class="animate-bounce text-4xl">📚</span>
                            <h3
                                class="bg-gradient-to-r from-violet-600 via-fuchsia-600 to-indigo-600 bg-clip-text text-3xl font-black tracking-tight text-transparent"
                            >
                                {{ $selectedPaket->nama }}
                            </h3>
                        </div>
                        <p
                            class="pl-16 text-lg font-light tracking-wide text-gray-600"
                        >
                            {{ $selectedPaket->deskripsi }}
                        </p>
                        <div
                            class="mt-4 h-1 w-32 rounded-full bg-gradient-to-r from-violet-500 to-indigo-500"
                        ></div>
                    </div>

                    @forelse ($selectedPaket->soals as $index => $soal)
                        <div
                            class="rounded-2xl border border-white/20 bg-white/80 p-6 shadow-lg backdrop-blur-sm transition-all duration-300 hover:scale-[1.01] hover:shadow-xl"
                        >
                            <!-- Header dengan Nomor Soal dan Jenis -->
                            <div class="mb-6 flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <span
                                        class="rounded-full border border-violet-200/50 bg-gradient-to-r from-violet-100/80 to-fuchsia-100/80 px-4 py-2 text-sm font-bold text-violet-700 shadow-inner"
                                    >
                                        Soal {{ $soal->nomor_urut }}
                                    </span>
                                    <span class="animate-bounce">
                                        @switch($soal->jenis_soal)
                                            @case("pilihan_ganda")
                                                🎯

                                                @break
                                            @case("multiple_choice")
                                                🎪

                                                @break
                                            @default
                                                📝
                                        @endswitch
                                    </span>
                                </div>
                                <span
                                    class="rounded-full border border-indigo-200/50 bg-gradient-to-r from-indigo-100/80 to-blue-100/80 px-4 py-2 text-sm font-bold text-indigo-700 shadow-inner"
                                >
                                    {{ ucfirst(str_replace("_", " ", $soal->jenis_soal)) }}
                                </span>
                            </div>

                            <div class="prose max-w-none">
                                <!-- Pertanyaan -->
                                <div
                                    class="mb-6 rounded-xl border border-gray-100/50 bg-gradient-to-br from-gray-50/90 to-slate-50/90 p-6 shadow-inner transition-all duration-300 hover:shadow-lg"
                                >
                                    {!! $soal->pertanyaan !!}
                                </div>

                                <!-- Gambar -->
                                @if ($soal->hasGambar())
                                    <div
                                        class="group relative mb-6 overflow-hidden rounded-xl"
                                    >
                                        <img
                                            src="{{ asset("storage/" . $soal->gambar) }}"
                                            alt="Gambar Soal"
                                            class="h-auto w-full rounded-xl shadow-md transition-all duration-300 group-hover:scale-105"
                                            @click="$dispatch('open-modal', { image: '{{ asset("storage/" . $soal->gambar) }}' })"
                                        />
                                    </div>
                                @endif

                                <!-- Opsi Jawaban -->
                                @if ($soal->isPilihanGanda())
                                    <div class="space-y-4">
                                        <div
                                            class="mb-4 rounded-xl border border-green-200/50 bg-gradient-to-r from-green-50/90 to-emerald-50/90 p-4 shadow-inner transition-all duration-300 hover:shadow-lg"
                                        >
                                            <h4
                                                class="mb-2 flex items-center gap-2 font-bold text-green-700"
                                            >
                                                <span
                                                    class="animate-bounce text-lg"
                                                >
                                                    🎯
                                                </span>
                                                Kunci Jawaban:
                                                @if ($soal->kunci_pg)
                                                    <span
                                                        class="ml-2 inline-flex items-center justify-center rounded-full bg-green-100 px-3 py-1 text-sm font-bold text-green-700"
                                                    >
                                                        {{ $soal->kunci_pg }}
                                                    </span>
                                                @else
                                                    <span class="text-red-500">
                                                        Belum diatur
                                                    </span>
                                                @endif
                                            </h4>
                                        </div>
                                        @foreach ($soal->opsiJawabanPG as $opsi)
                                            <div
                                                class="{{ $opsi->urutan === $soal->kunci_pg ? "border border-green-200/50 bg-gradient-to-r from-green-50/90 to-emerald-50/90" : "border border-gray-200/50 bg-gradient-to-r from-gray-50/90 to-slate-50/90" }} flex items-center space-x-4 rounded-xl p-4 transition-all duration-300 hover:scale-[1.01]"
                                            >
                                                <span
                                                    class="{{ $opsi->urutan === $soal->kunci_pg ? "bg-gradient-to-br from-green-200 to-emerald-200 text-green-700" : "bg-gradient-to-br from-gray-200 to-slate-200 text-gray-700" }} flex h-10 w-10 items-center justify-center rounded-full font-bold shadow-inner"
                                                >
                                                    {{ $opsi->urutan }}
                                                </span>
                                                <p class="flex-1 font-medium">
                                                    {{ $opsi->teks }}
                                                </p>
                                                @if ($opsi->urutan === $soal->kunci_pg)
                                                    <span
                                                        class="animate-pulse text-green-600"
                                                    >
                                                        ✨
                                                    </span>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @elseif ($soal->isMultipleChoice())
                                    <div class="space-y-4">
                                        <div
                                            class="mb-4 rounded-xl border border-green-200/50 bg-gradient-to-r from-green-50/90 to-emerald-50/90 p-4 shadow-inner transition-all duration-300 hover:shadow-lg"
                                        >
                                            <h4
                                                class="mb-2 flex items-center gap-2 font-bold text-green-700"
                                            >
                                                <span
                                                    class="animate-bounce text-lg"
                                                >
                                                    🎪
                                                </span>
                                                Kunci Jawaban:
                                                @forelse ($soal->kunci_multiple_choice ?? [] as $kunci)
                                                    <span
                                                        class="ml-2 inline-flex items-center justify-center rounded-full bg-green-100 px-3 py-1 text-sm font-bold text-green-700"
                                                    >
                                                        {{ $kunci }}
                                                    </span>
                                                @empty
                                                    <span class="text-red-500">
                                                        Belum diatur
                                                    </span>
                                                @endforelse
                                            </h4>
                                        </div>
                                        @foreach ($soal->opsiJawabanMultipleChoice as $opsi)
                                            <div
                                                class="{{ in_array($opsi->urutan, $soal->kunci_multiple_choice ?? []) ? "border border-green-200/50 bg-gradient-to-r from-green-50/90 to-emerald-50/90" : "border border-gray-200/50 bg-gradient-to-r from-gray-50/90 to-slate-50/90" }} flex items-center space-x-4 rounded-xl p-4 transition-all duration-300 hover:scale-[1.01]"
                                            >
                                                <span
                                                    class="{{ in_array($opsi->urutan, $soal->kunci_multiple_choice ?? []) ? "bg-gradient-to-br from-green-200 to-emerald-200 text-green-700" : "bg-gradient-to-br from-gray-200 to-slate-200 text-gray-700" }} flex h-10 w-10 items-center justify-center rounded-full font-bold shadow-inner"
                                                >
                                                    {{ chr(64 + intval($opsi->urutan)) }}
                                                </span>
                                                <p class="flex-1 font-medium">
                                                    {{ $opsi->teks }}
                                                </p>
                                                @if (in_array($opsi->urutan, $soal->kunci_multiple_choice ?? []))
                                                    <span
                                                        class="animate-pulse text-green-600"
                                                    >
                                                        ✨
                                                    </span>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div
                                        class="mt-6 rounded-xl border border-green-200/50 bg-gradient-to-br from-green-50/90 to-emerald-50/90 p-6 shadow-inner backdrop-blur-sm transition-all duration-300 hover:shadow-lg"
                                    >
                                        <h4
                                            class="mb-3 flex items-center gap-2 font-bold text-green-700"
                                        >
                                            <span
                                                class="animate-bounce text-lg"
                                            >
                                                📝
                                            </span>
                                            Kunci Jawaban Essay
                                        </h4>
                                        <div class="prose prose-sm max-w-none">
                                            {!! nl2br(e($soal->kunci_essay)) !!}
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Footer dengan Bobot -->
                            <div class="mt-6 border-t border-gray-100/50 pt-4">
                                <p
                                    class="flex items-center gap-2 bg-gradient-to-r from-violet-600 via-fuchsia-600 to-indigo-600 bg-clip-text text-sm font-bold text-transparent"
                                >
                                    <span class="animate-pulse text-lg">
                                        ⭐
                                    </span>
                                    Bobot:
                                    {{ $soal->getBobotFormattedAttribute() }}
                                </p>
                            </div>
                        </div>
                    @empty
                        <div class="py-12 text-center">
                            <div class="mb-4 animate-bounce text-6xl">🎯</div>
                            <p class="text-lg text-gray-500">
                                Belum ada soal dalam paket ini.
                            </p>
                        </div>
                    @endforelse
                @endif
            </div>

            <x-slot:footer>
                <div class="flex justify-end gap-x-4">
                    <x-mary-button
                        icon="o-x-mark"
                        label="Tutup"
                        wire:click="closePreviewModal"
                        class="border border-white/20 bg-gradient-to-br from-slate-500/40 to-gray-500/40 shadow-lg transition-all duration-300 hover:scale-105"
                    />
                </div>
            </x-slot>
        </div>
    </x-mary-modal>
</div>
