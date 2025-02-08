<div
    class="min-h-screen overflow-y-auto bg-[url('/images/pattern.svg')] bg-gradient-to-br from-violet-50 via-fuchsia-50 to-pink-50 bg-fixed bg-blend-soft-light"
    x-data="{
        showSavedIndicator: false,
        timer: @js($sisa_waktu),
        timerDisplay: '',
        flaggedSoal: @entangle("flaggedSoal"),
        jawaban: @entangle("jawaban"),
        currentSoal: @entangle("currentSoal"),

        formatTime(seconds) {
            const hours = Math.floor(seconds / 3600)
            const minutes = Math.floor((seconds % 3600) / 60)
            const secs = seconds % 60
            return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}:${String(secs).padStart(2, '0')}`
        },

        initTimer() {
            this.timerDisplay = this.formatTime(this.timer)
            const interval = setInterval(() => {
                if (this.timer > 0) {
                    this.timer--
                    this.timerDisplay = this.formatTime(this.timer)

                    if (this.timer < 300) {
                        this.$refs.timerContainer.classList.add(
                            'animate-pulse',
                            'text-red-600',
                        )
                    }
                } else {
                    clearInterval(interval)
                    $wire.selesaiUjian()
                }
            }, 1000)
        },

        showAutoSaveIndicator() {
            this.showSavedIndicator = true
            setTimeout(() => {
                this.showSavedIndicator = false
            }, 2000)
        },

        isSoalTerjawab(index) {
            if (! this.jawaban || typeof this.jawaban !== 'object') return false

            const jawaban = this.jawaban[index]
            if (! jawaban) return false

            if (typeof jawaban === 'string') {
                return jawaban.trim().length > 0
            }

            if (typeof jawaban === 'object') {
                return Object.values(jawaban).some((v) => v === true)
            }

            return false
        },

        isSoalFlagged(index) {
            if (! this.flaggedSoal || typeof this.flaggedSoal !== 'object')
                return false
            return Boolean(this.flaggedSoal[index])
        },

        getSoalClass(index) {
            if (index === this.currentSoal) {
                return 'bg-violet-600 text-white shadow-lg scale-110'
            }
            return this.isSoalTerjawab(index)
                ? 'bg-emerald-500 text-white'
                : 'bg-white/50 hover:bg-white text-gray-700'
        },
    }"
    x-init="initTimer()"
>
    {{-- Auto-save Indicator --}}
    <div
        x-show="showSavedIndicator"
        x-transition:enter="transition duration-300 ease-out"
        x-transition:enter-start="translate-y-2 transform opacity-0"
        x-transition:enter-end="translate-y-0 transform opacity-100"
        x-transition:leave="transition duration-200 ease-in"
        x-transition:leave-start="translate-y-0 transform opacity-100"
        x-transition:leave-end="translate-y-2 transform opacity-0"
        class="fixed bottom-4 left-4 z-50"
    >
        <div class="rounded-xl bg-emerald-500 px-4 py-2 text-white shadow-lg">
            <div class="flex items-center gap-2">
                <x-mary-icon
                    name="s-check-circle"
                    class="h-5 w-5 animate-pulse"
                />
                <span>Jawaban tersimpan</span>
            </div>
        </div>
    </div>

    {{-- Timer Display --}}
    <div class="fixed right-4 top-4 z-50">
        <div
            x-ref="timerContainer"
            class="transform rounded-2xl border border-violet-100/50 bg-white/80 px-6 py-3 shadow-lg backdrop-blur-xl transition-all duration-300 hover:scale-105"
        >
            <div class="flex items-center gap-3">
                <x-mary-icon name="o-clock" class="h-6 w-6 text-violet-600" />
                <span
                    x-text="timerDisplay"
                    class="bg-gradient-to-r from-violet-600 to-fuchsia-600 bg-clip-text text-lg font-black text-transparent"
                ></span>
            </div>
        </div>
    </div>

    {{-- Modal Peringatan Multiple Choice dengan desain yang lebih modern --}}
    <x-mary-modal
        blur
        wire:model="showWarningModal"
        class="!overflow-y-visible"
    >
        <div class="space-y-6">
            <div class="flex items-center gap-4">
                <div
                    class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-amber-100 to-amber-200"
                >
                    <x-mary-icon
                        name="o-exclamation-triangle"
                        class="h-8 w-8 animate-pulse text-amber-600"
                    />
                </div>
                <div>
                    <h3
                        class="bg-gradient-to-r from-amber-600 to-red-600 bg-clip-text text-xl font-black text-transparent"
                    >
                        Peringatan!
                    </h3>
                    <p class="text-gray-600">
                        Anda baru memilih 1 jawaban pada soal ini
                    </p>
                </div>
            </div>

            <div
                class="rounded-2xl border border-amber-200/50 bg-gradient-to-br from-amber-50 to-amber-100/50 p-6 backdrop-blur-xl"
            >
                <p class="mb-3 font-bold text-amber-800">
                    Untuk soal multiple choice:
                </p>
                <ul class="space-y-2 text-amber-700">
                    <li class="flex items-center gap-3">
                        <div
                            class="flex h-6 w-6 items-center justify-center rounded-full bg-amber-200/50"
                        >
                            <x-mary-icon name="s-check" class="h-4 w-4" />
                        </div>
                        <span>Sebaiknya pilih minimal 2 jawaban</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div
                            class="flex h-6 w-6 items-center justify-center rounded-full bg-amber-200/50"
                        >
                            <x-mary-icon name="s-check" class="h-4 w-4" />
                        </div>
                        <span>
                            Semua jawaban yang dipilih akan dihitung dalam
                            penilaian
                        </span>
                    </li>
                    <li class="flex items-center gap-3">
                        <div
                            class="flex h-6 w-6 items-center justify-center rounded-full bg-amber-200/50"
                        >
                            <x-mary-icon name="s-check" class="h-4 w-4" />
                        </div>
                        <span>
                            Pastikan Anda memilih semua jawaban yang benar
                        </span>
                    </li>
                </ul>
            </div>
        </div>

        <x-slot:footer>
            <div class="flex justify-end gap-3">
                <x-mary-button
                    wire:click="$set('showWarningModal', false)"
                    class="rounded-xl border border-gray-200 bg-white px-6 py-2.5 font-semibold text-gray-700 shadow-sm transition-all duration-300 hover:bg-gray-50 hover:shadow"
                >
                    Lanjutkan Memilih
                </x-mary-button>
                <x-mary-button
                    wire:click="$set('currentSoal', {{ $targetSoal }})"
                    class="rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 px-6 py-2.5 font-semibold text-white shadow-lg transition-all duration-300 hover:from-amber-600 hover:to-amber-700 hover:shadow-xl"
                >
                    Tetap Pindah Soal
                </x-mary-button>
            </div>
        </x-slot>
    </x-mary-modal>

    <div
        class="max-w-8xl container mx-auto px-4 py-6 sm:px-6 sm:py-8 lg:px-8 lg:py-12"
    >
        {{-- Header Informasi Ujian yang Modern --}}
        <div>
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
                                        {{ $ujian->nama }}
                                    </h3>
                                    <p class="italic text-gray-600">
                                        {{ $ujian->deskripsi }}
                                    </p>
                                </div>
                                <div class="flex flex-wrap items-center gap-3">
                                    <x-mary-badge
                                        icon="o-calendar"
                                        class="bg-gradient-to-r from-violet-100 to-violet-200 px-4 py-2 text-violet-700 shadow-md transition-all duration-300 hover:shadow-lg"
                                    >
                                        {{ now()->format("d M Y") }}
                                    </x-mary-badge>
                                    <x-mary-badge
                                        icon="o-clock"
                                        class="bg-gradient-to-r from-fuchsia-100 to-fuchsia-200 px-4 py-2 text-fuchsia-700 shadow-md transition-all duration-300 hover:shadow-lg"
                                    >
                                        {{ now()->format("H:i") }} WIB
                                    </x-mary-badge>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Statistik Ujian --}}
                    <div class="lg:col-span-12">
                        <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                            {{-- Durasi --}}
                            <div
                                class="group relative transform transition-all duration-500 hover:scale-105"
                            >
                                <div
                                    class="absolute -inset-1 rounded-2xl bg-gradient-to-r from-violet-600 to-violet-600 opacity-25 blur transition duration-1000 group-hover:opacity-75 group-hover:duration-200"
                                ></div>
                                <div
                                    class="relative rounded-2xl border border-violet-100/50 bg-white/90 p-6 shadow-lg transition-all duration-300 hover:shadow-xl"
                                >
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-violet-100 to-violet-200"
                                        >
                                            <x-mary-icon
                                                name="o-clock"
                                                class="h-7 w-7 text-violet-600"
                                            />
                                        </div>
                                        <div>
                                            <p
                                                class="text-sm font-medium text-gray-500"
                                            >
                                                Durasi Ujian
                                            </p>
                                            <p
                                                class="bg-gradient-to-r from-violet-600 to-fuchsia-600 bg-clip-text text-2xl font-black text-transparent"
                                            >
                                                {{ $ujian->durasi }} Menit
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Total Soal --}}
                            <div
                                class="group relative transform transition-all duration-500 hover:scale-105"
                            >
                                <div
                                    class="absolute -inset-1 rounded-2xl bg-gradient-to-r from-fuchsia-600 to-fuchsia-600 opacity-25 blur transition duration-1000 group-hover:opacity-75 group-hover:duration-200"
                                ></div>
                                <div
                                    class="relative rounded-2xl border border-fuchsia-100/50 bg-white/90 p-6 shadow-lg transition-all duration-300 hover:shadow-xl"
                                >
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-fuchsia-100 to-fuchsia-200"
                                        >
                                            <x-mary-icon
                                                name="o-document-text"
                                                class="h-7 w-7 text-fuchsia-600"
                                            />
                                        </div>
                                        <div>
                                            <p
                                                class="text-sm font-medium text-gray-500"
                                            >
                                                Total Soal
                                            </p>
                                            <p
                                                class="bg-gradient-to-r from-fuchsia-600 to-pink-600 bg-clip-text text-2xl font-black text-transparent"
                                            >
                                                {{ $total_soal }} Soal
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Terjawab --}}
                            <div
                                class="group relative transform transition-all duration-500 hover:scale-105"
                            >
                                <div
                                    class="absolute -inset-1 rounded-2xl bg-gradient-to-r from-emerald-600 to-emerald-600 opacity-25 blur transition duration-1000 group-hover:opacity-75 group-hover:duration-200"
                                ></div>
                                <div
                                    class="relative rounded-2xl border border-emerald-100/50 bg-white/90 p-6 shadow-lg transition-all duration-300 hover:shadow-xl"
                                >
                                    <div class="flex items-center gap-4">
                                        <div
                                            class="flex h-14 w-14 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-100 to-emerald-200"
                                        >
                                            <x-mary-icon
                                                name="o-check"
                                                class="h-7 w-7 text-emerald-600"
                                            />
                                        </div>
                                        <div>
                                            <p
                                                class="text-sm font-medium text-gray-500"
                                            >
                                                Terjawab
                                            </p>
                                            <p
                                                class="bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-2xl font-black text-transparent"
                                            >
                                                {{
                                                    count(
                                                        array_filter($jawaban, function ($j) {
                                                            if (is_array($j)) {
                                                                return ! empty(array_filter($j));
                                                            }
                                                            return ! is_null($j) && $j !== "";
                                                        }),
                                                    )
                                                }}
                                                Soal
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </x-mary-card>
        </div>

        <div class="mb-8">
            <div
                class="relative rounded-2xl border border-violet-100/50 bg-white/80 p-8 shadow-lg backdrop-blur-xl transition-all duration-300 hover:shadow-xl"
            >
                <div class="mb-4 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-violet-100 to-violet-200"
                        >
                            <x-mary-icon
                                name="o-chart-bar"
                                class="h-6 w-6 text-violet-600"
                            />
                        </div>
                        <h3
                            class="bg-gradient-to-r from-violet-600 to-fuchsia-600 bg-clip-text text-xl font-black text-transparent"
                        >
                            Progress Pengerjaan
                        </h3>
                    </div>
                    <x-mary-badge
                        icon="o-check-circle"
                        class="bg-gradient-to-r from-emerald-100 to-emerald-200 px-4 py-2 text-emerald-700 shadow-md transition-all duration-300 hover:shadow-lg"
                    >
                        {{
                            count(
                                array_filter($jawaban, function ($j) {
                                    if (is_array($j)) {
                                        return ! empty(array_filter($j));
                                    }
                                    return ! is_null($j) && $j !== "";
                                }),
                            )
                        }}
                        dari {{ $total_soal }} Soal
                    </x-mary-badge>
                </div>

                <div class="relative">
                    @php
                        $jawaban_terjawab = array_filter($jawaban, function ($j) {
                            if (is_array($j)) {
                                return ! empty(array_filter($j));
                            }
                            return ! is_null($j) && $j !== "";
                        });
                        $progress = $total_soal > 0 ? round((count($jawaban_terjawab) / $total_soal) * 100) : 0;
                    @endphp

                    <div class="relative">
                        <x-mary-progress
                            :value="$progress"
                            :max="100"
                            class="h-6 rounded-xl bg-gradient-to-r from-violet-100 via-fuchsia-100 to-pink-100"
                        >
                            <div
                                class="absolute inset-0 overflow-hidden rounded-xl"
                            >
                                <div
                                    class="absolute inset-0 animate-pulse bg-gradient-to-r from-violet-500 via-fuchsia-500 to-pink-500 opacity-20"
                                ></div>
                            </div>

                            <div
                                class="absolute inset-0 flex items-center justify-center"
                            >
                                <span class="text-sm font-bold text-gray-800">
                                    {{ $progress }}% Selesai
                                </span>
                            </div>
                        </x-mary-progress>

                        <div
                            class="mt-3 flex justify-between text-sm font-medium"
                        >
                            <span class="text-violet-600">Progress</span>
                            <span class="text-fuchsia-600">
                                {{ $progress }}%
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Grid Layout untuk Konten dengan Lazy Loading --}}
        <div class="relative grid grid-cols-1 gap-6 lg:grid-cols-12 lg:gap-8">
            {{-- Konten Soal (Kiri) --}}
            <div class="order-2 lg:order-1 lg:col-span-9">
                <div>
                    @if ($soal)
                        <x-mary-card
                            class="border-0 bg-white/90 shadow-[0_8px_30px_rgba(139,92,246,0.2)] backdrop-blur-2xl transition-all duration-500 hover:bg-white/95 hover:shadow-[0_8px_40px_rgba(139,92,246,0.3)]"
                        >
                            {{-- Nomor Soal --}}
                            <div class="mb-8">
                                <div
                                    class="flex flex-col items-start justify-between gap-4 sm:flex-row sm:items-center"
                                >
                                    <div
                                        class="group relative transform transition-all duration-500 hover:scale-105"
                                    >
                                        <div
                                            class="absolute -inset-1 rounded-2xl bg-gradient-to-r from-violet-600 via-fuchsia-600 to-pink-600 opacity-25 blur transition duration-1000 group-hover:opacity-75 group-hover:duration-200"
                                        ></div>
                                        <div
                                            class="relative flex items-center gap-4 rounded-2xl border border-violet-100/50 bg-white/90 px-6 py-3 shadow-lg backdrop-blur-xl"
                                        >
                                            <span
                                                class="bg-gradient-to-r from-violet-600 to-fuchsia-600 bg-clip-text text-3xl font-black text-transparent"
                                            >
                                                #{{ $currentSoal + 1 }}
                                            </span>
                                            <div
                                                class="h-8 w-px bg-gradient-to-b from-violet-200 to-fuchsia-200"
                                            ></div>
                                            <span
                                                class="text-base font-medium text-gray-600"
                                            >
                                                dari {{ $total_soal }} Soal
                                            </span>
                                        </div>
                                    </div>

                                    {{-- Jenis Soal & Bobot Badge --}}
                                    <div
                                        class="flex flex-wrap items-center gap-4"
                                    >
                                        {{-- Jenis Soal Badge --}}
                                        <div
                                            class="group relative transform transition-all duration-500 hover:scale-105"
                                        >
                                            <div
                                                class="absolute -inset-1 rounded-2xl bg-gradient-to-r from-violet-500/20 to-violet-500/30 opacity-25 blur transition duration-1000 group-hover:opacity-75 group-hover:duration-200"
                                            ></div>
                                            @php
                                                $jenisIcon = match ($soal->jenis_soal) {
                                                    "pilihan_ganda" => "o-list-bullet",
                                                    "essay" => "o-pencil",
                                                    "multiple_choice" => "o-squares-plus",
                                                    default => "o-document-text",
                                                };

                                                $jenisLabel = match ($soal->jenis_soal) {
                                                    "pilihan_ganda" => "Pilihan Ganda",
                                                    "essay" => "Essay",
                                                    "multiple_choice" => "Multiple Choice",
                                                    default => "Soal",
                                                };

                                                $jenisBg = match ($soal->jenis_soal) {
                                                    "pilihan_ganda" => "border-violet-200 from-violet-50 to-violet-100/50 text-violet-700",
                                                    "essay" => "border-emerald-200 from-emerald-50 to-emerald-100/50 text-emerald-700",
                                                    "multiple_choice" => "border-blue-200 from-blue-50 to-blue-100/50 text-blue-700",
                                                    default => "border-gray-200 from-gray-50 to-gray-100/50 text-gray-700",
                                                };
                                            @endphp

                                            <div
                                                class="{{ $jenisBg }} relative flex items-center gap-2 rounded-xl bg-gradient-to-r px-4 py-2 shadow-sm"
                                            >
                                                <x-mary-icon
                                                    :name="$jenisIcon"
                                                    class="h-5 w-5"
                                                />
                                                <span class="font-medium">
                                                    {{ $jenisLabel }}
                                                </span>
                                                @if ($soal->jenis_soal === "multiple_choice")
                                                    <span
                                                        class="rounded-lg bg-blue-100 px-2 py-0.5 text-xs text-blue-700"
                                                    >
                                                        Min. 2 Jawaban
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- Bobot Badge --}}
                                        <div
                                            class="group relative transform transition-all duration-500 hover:scale-105"
                                        >
                                            <div
                                                class="absolute -inset-1 rounded-2xl bg-gradient-to-r from-fuchsia-500/20 to-fuchsia-500/30 opacity-25 blur transition duration-1000 group-hover:opacity-75 group-hover:duration-200"
                                            ></div>
                                            <div
                                                class="relative flex items-center gap-2 rounded-xl border border-fuchsia-200 bg-gradient-to-r from-fuchsia-50 to-fuchsia-100/50 px-4 py-2 text-fuchsia-700 shadow-sm"
                                            >
                                                <x-mary-icon
                                                    name="o-star"
                                                    class="h-5 w-5"
                                                />
                                                <span class="font-medium">
                                                    Bobot:
                                                    {{ $soal->bobot ?? 1 }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Pertanyaan dengan Label Kategori/Materi --}}
                            <x-mary-card
                                class="mb-8 border border-violet-100/50 bg-gradient-to-br from-gray-50/90 to-white/90 backdrop-blur-xl transition-all duration-300 hover:shadow-lg"
                            >
                                <div class="mb-6 flex flex-wrap gap-3">
                                    {{-- Badge Jenis Soal dengan Animasi Hover --}}
                                    @if ($soal->kategori || $soal->materi)
                                        @if ($soal->kategori)
                                            <div
                                                class="group relative transform transition-all duration-500 hover:scale-105"
                                            >
                                                <div
                                                    class="absolute -inset-1 rounded-xl bg-gradient-to-r from-emerald-400 to-emerald-600 opacity-25 blur transition duration-1000 group-hover:opacity-75 group-hover:duration-200"
                                                ></div>
                                                <x-mary-badge
                                                    icon="o-tag"
                                                    class="relative border border-emerald-200 bg-white px-4 py-2 text-emerald-700 shadow-md transition-all duration-300 hover:bg-emerald-50 hover:shadow-lg"
                                                >
                                                    {{ $soal->kategori }}
                                                </x-mary-badge>
                                            </div>
                                        @endif

                                        @if ($soal->materi)
                                            <div
                                                class="group relative transform transition-all duration-500 hover:scale-105"
                                            >
                                                <div
                                                    class="absolute -inset-1 rounded-xl bg-gradient-to-r from-sky-400 to-sky-600 opacity-25 blur transition duration-1000 group-hover:opacity-75 group-hover:duration-200"
                                                ></div>
                                                <x-mary-badge
                                                    icon="o-book-open"
                                                    class="relative border border-sky-200 bg-white px-4 py-2 text-sky-700 shadow-md transition-all duration-300 hover:bg-sky-50 hover:shadow-lg"
                                                    value="{{ $soal->materi }}"
                                                />
                                            </div>
                                        @endif
                                    @endif
                                </div>
                                <div class="prose max-w-none">
                                    <div
                                        class="text-xl font-medium leading-relaxed text-gray-900"
                                    >
                                        <span
                                            class="bg-gradient-to-r from-violet-600 to-fuchsia-600 bg-clip-text text-2xl font-black text-transparent"
                                        >
                                            {{ $currentSoal + 1 }}.
                                        </span>
                                        <span class="leading-relaxed">
                                            {!! $soal->pertanyaan !!}
                                        </span>
                                    </div>
                                </div>
                            </x-mary-card>

                            {{-- Pilihan Jawaban --}}
                            <div class="space-y-4">
                                @if ($soal->jenis_soal === "pilihan_ganda")
                                    @foreach ($soal->opsiJawabanPG as $index => $opsi)
                                        <div
                                            wire:key="pg-{{ $currentSoal }}-{{ $index }}"
                                            class="group relative transform transition-all duration-300 hover:scale-[1.02]"
                                        >
                                            <div
                                                class="absolute -inset-1 rounded-xl bg-gradient-to-r from-violet-400 to-fuchsia-600 opacity-0 blur transition duration-500 group-hover:opacity-20"
                                            ></div>
                                            <input
                                                type="radio"
                                                wire:model.live="jawaban.{{ $currentSoal }}"
                                                value="{{ $opsi->label }}"
                                                id="radio_{{ $currentSoal }}_{{ $opsi->label }}"
                                                class="peer sr-only"
                                            />
                                            <label
                                                for="radio_{{ $currentSoal }}_{{ $opsi->label }}"
                                                class="relative flex w-full cursor-pointer items-center gap-4 rounded-xl border border-violet-100/50 bg-white/90 p-6 shadow-sm backdrop-blur-sm transition-all duration-300 hover:border-violet-300 hover:bg-violet-50/90 hover:shadow-lg hover:shadow-violet-100/50 peer-checked:border-violet-500 peer-checked:bg-violet-50/90"
                                            >
                                                <div
                                                    class="flex h-7 w-7 items-center justify-center rounded-lg border-2 border-violet-200 bg-white/50 transition-colors duration-300 group-hover:border-violet-400 peer-checked:border-violet-500"
                                                >
                                                    <div
                                                        class="hidden h-3 w-3 scale-0 transform rounded-md bg-gradient-to-r from-violet-500 to-fuchsia-500 transition-transform duration-300 peer-checked:block peer-checked:scale-100"
                                                    ></div>
                                                </div>
                                                <div class="flex-1">
                                                    <div
                                                        class="flex items-center gap-4"
                                                    >
                                                        <span
                                                            class="bg-gradient-to-r from-violet-600 to-fuchsia-600 bg-clip-text text-xl font-black text-transparent"
                                                        >
                                                            {{ chr(65 + $index) }}
                                                        </span>
                                                        <div
                                                            class="prose max-w-none text-lg text-gray-700"
                                                        >
                                                            {!! $opsi->teks !!}
                                                        </div>
                                                    </div>
                                                </div>
                                            </label>
                                        </div>
                                    @endforeach
                                @elseif ($soal->jenis_soal === "multiple_choice")
                                    <div
                                        class="rounded-2xl border border-violet-100/50 bg-white/80 p-6 shadow-lg backdrop-blur-xl"
                                    >
                                        <div class="space-y-4">
                                            @foreach ($soal->opsiJawabanMultipleChoice as $index => $opsi)
                                                <div
                                                    wire:key="mc-{{ $currentSoal }}-{{ $index }}"
                                                    class="group relative transform transition-all duration-300 hover:scale-[1.02]"
                                                >
                                                    <div
                                                        class="absolute -inset-1 rounded-xl bg-gradient-to-r from-violet-400 to-fuchsia-600 opacity-0 blur transition duration-500 group-hover:opacity-20"
                                                    ></div>
                                                    <input
                                                        type="checkbox"
                                                        wire:change="updateJawabanMC({{ $currentSoal }}, '{{ chr(65 + $index) }}', $event.target.checked)"
                                                        @checked(in_array(chr(65 + $index), $jawaban[$currentSoal] ?? []))
                                                        id="checkbox_{{ $currentSoal }}_{{ $opsi->label }}"
                                                        class="peer sr-only"
                                                    />
                                                    <label
                                                        for="checkbox_{{ $currentSoal }}_{{ $opsi->label }}"
                                                        class="relative flex w-full cursor-pointer items-center gap-4 rounded-xl border border-violet-100/50 bg-white/90 p-6 shadow-sm transition-all duration-300 hover:border-violet-300 hover:bg-violet-50/90 hover:shadow-lg hover:shadow-violet-100/50 peer-checked:border-violet-500 peer-checked:bg-violet-50/90"
                                                    >
                                                        <div
                                                            class="flex h-7 w-7 items-center justify-center rounded-lg border-2 border-violet-200 bg-white/50 transition-colors duration-300 group-hover:border-violet-400 peer-checked:border-violet-500"
                                                        >
                                                            <svg
                                                                class="hidden h-4 w-4 text-violet-600 peer-checked:block"
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                viewBox="0 0 20 20"
                                                                fill="currentColor"
                                                            >
                                                                <path
                                                                    fill-rule="evenodd"
                                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                                    clip-rule="evenodd"
                                                                />
                                                            </svg>
                                                        </div>
                                                        <div class="flex-1">
                                                            <div
                                                                class="flex items-center gap-4"
                                                            >
                                                                <span
                                                                    class="bg-gradient-to-r from-violet-600 to-fuchsia-600 bg-clip-text text-xl font-black text-transparent"
                                                                >
                                                                    {{ chr(65 + $index) }}
                                                                </span>
                                                                <div
                                                                    class="prose max-w-none text-lg text-gray-700"
                                                                >
                                                                    {!! $opsi->teks !!}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @elseif ($soal->jenis_soal === "essay")
                                    <div
                                        class="group relative transform transition-all duration-300 hover:scale-[1.01]"
                                    >
                                        <div
                                            class="absolute -inset-1 rounded-2xl bg-gradient-to-r from-violet-400 to-fuchsia-600 opacity-0 blur transition duration-500 group-hover:opacity-20"
                                        ></div>
                                        <div
                                            class="relative rounded-2xl border border-violet-100/50 bg-white/90 p-8 shadow-lg backdrop-blur-xl"
                                        >
                                            <textarea
                                                wire:model.live="jawaban.{{ $currentSoal }}"
                                                wire:change="updateJawabanEssay({{ $currentSoal }}, $event.target.value)"
                                                rows="8"
                                                placeholder="Tuliskan jawaban Anda secara lengkap dan jelas..."
                                                class="w-full resize-none rounded-xl border-violet-200 bg-white/80 text-lg text-gray-700 placeholder-gray-400 transition-all duration-300 hover:bg-white focus:border-violet-500 focus:ring-violet-500/20"
                                            ></textarea>

                                            <div
                                                class="mt-6 flex items-center justify-between"
                                            >
                                                <div
                                                    class="flex items-center gap-3"
                                                >
                                                    @if (isset($jawaban[$currentSoal]))
                                                        <div
                                                            class="flex items-center gap-2 rounded-xl bg-gradient-to-r from-emerald-50 to-teal-50 px-4 py-2 text-emerald-700 shadow-sm"
                                                        >
                                                            <x-mary-icon
                                                                name="s-check-circle"
                                                                class="h-5 w-5 animate-pulse text-emerald-500"
                                                            />
                                                            <span
                                                                class="text-sm font-semibold"
                                                            >
                                                                Tersimpan
                                                                Otomatis
                                                            </span>
                                                        </div>
                                                    @endif
                                                </div>

                                                <div
                                                    class="{{
                                                        strlen($jawaban[$currentSoal] ?? "") < 100
                                                            ? "bg-gradient-to-r from-red-50 to-pink-50 text-red-700"
                                                            : "bg-gradient-to-r from-emerald-50 to-teal-50 text-emerald-700"
                                                    }} flex items-center gap-2 rounded-xl px-4 py-2 shadow-sm"
                                                >
                                                    <x-mary-icon
                                                        name="o-document-text"
                                                        class="h-5 w-5 {{
                                                        strlen($jawaban[$currentSoal] ?? '') < 100
                                                            ? 'text-red-500'
                                                            : 'text-emerald-500'
                                                    }}"
                                                    />
                                                    <span
                                                        class="text-sm font-semibold"
                                                    >
                                                        {{ strlen($jawaban[$currentSoal] ?? "") }}
                                                        Karakter
                                                    </span>
                                                    @if (strlen($jawaban[$currentSoal] ?? "") < 100)
                                                        <span
                                                            class="text-xs text-red-500"
                                                        >
                                                            (Min. 100)
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                {{-- Indikator Tersimpan Otomatis untuk Pilihan Ganda --}}
                                @if ($soal->jenis_soal === "pilihan_ganda" && isset($jawaban[$currentSoal]))
                                    <div class="mt-4 flex justify-end">
                                        <div
                                            class="flex items-center gap-2 rounded-xl bg-gradient-to-r from-emerald-50 to-teal-50 px-4 py-2 text-emerald-700 shadow-sm"
                                        >
                                            <x-mary-icon
                                                name="s-check-circle"
                                                class="h-5 w-5 animate-pulse text-emerald-500"
                                            />
                                            <span class="text-sm font-semibold">
                                                Tersimpan Otomatis
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </x-mary-card>
                    @endif
                </div>
            </div>

            {{-- Navigasi Soal (Kanan) dengan Lazy Loading --}}
            <div class="order-1 lg:order-2 lg:col-span-3">
                <div class="lg:sticky lg:top-4">
                    <x-mary-card
                        class="border-0 bg-gradient-to-br from-white/80 to-white/50 shadow-[0_8px_30px_rgba(139,92,246,0.15)] backdrop-blur-xl transition-all duration-500 hover:shadow-[0_8px_40px_rgba(139,92,246,0.25)]"
                    >
                        <div
                            class="mb-4 flex items-center justify-between sm:mb-6"
                        >
                            <div>
                                <h3
                                    class="bg-gradient-to-r from-violet-600 to-fuchsia-600 bg-clip-text text-lg font-black text-transparent"
                                >
                                    Navigasi Soal
                                </h3>
                                <p class="text-sm text-gray-600">
                                    Klik nomor untuk berpindah soal
                                </p>
                            </div>

                            {{-- Tombol Flag Soal --}}
                            <x-mary-button
                                wire:click="toggleFlag({{ $currentSoal }})"
                                class="transform bg-white text-amber-600 transition-all duration-300 hover:scale-105 hover:bg-amber-50"
                            >
                                <div class="flex items-center gap-2">
                                    <x-mary-icon
                                        name="{{ isset($flaggedSoal[$currentSoal]) && $flaggedSoal[$currentSoal] ? 's-flag' : 'o-flag' }}"
                                        class="h-5 w-5"
                                    />
                                    <span class="hidden sm:inline">
                                        {{ isset($flaggedSoal[$currentSoal]) && $flaggedSoal[$currentSoal] ? "Hapus Tanda" : "Tandai Soal" }}
                                    </span>
                                </div>
                            </x-mary-button>
                        </div>

                        {{-- Navigasi Soal dengan Blade Loop --}}
                        <div
                            class="grid grid-cols-6 gap-2 sm:grid-cols-4 sm:gap-3 lg:grid-cols-3 xl:grid-cols-4"
                        >
                            <template
                                x-for="index in {{ $total_soal }}"
                                :key="index - 1"
                            >
                                <div class="relative">
                                    <button
                                        @click="$wire.setCurrentSoal(index - 1)"
                                        :class="getSoalClass(index - 1)"
                                        class="flex h-10 w-full transform items-center justify-center rounded-xl font-semibold transition-all duration-300 hover:scale-105"
                                    >
                                        <span x-text="index"></span>
                                        <template
                                            x-if="isSoalTerjawab(index - 1)"
                                        >
                                            <x-mary-icon
                                                name="s-check-circle"
                                                class="absolute -bottom-1 -right-1 h-4 w-4 animate-pulse text-white"
                                            />
                                        </template>
                                    </button>
                                    <template
                                        x-if="isSoalFlagged(index - 1)"
                                    >
                                        <div class="absolute -right-2 -top-2">
                                            <x-mary-icon
                                                name="s-flag"
                                                class="h-5 w-5 animate-pulse text-amber-500"
                                            />
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>

                        <div
                            class="mt-4 rounded-xl bg-gradient-to-br from-violet-50/80 to-violet-100/50 p-3 backdrop-blur-sm sm:mt-6 sm:p-4"
                        >
                            <div class="flex flex-col gap-3">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="h-4 w-4 rounded-full bg-violet-600"
                                    ></div>
                                    <span class="text-sm text-gray-700">
                                        Soal Aktif
                                    </span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div
                                        class="h-4 w-4 rounded-full bg-emerald-500"
                                    ></div>
                                    <span class="text-sm text-gray-700">
                                        Terjawab
                                    </span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div
                                        class="h-4 w-4 rounded-full border border-gray-200 bg-white/50"
                                    ></div>
                                    <span class="text-sm text-gray-700">
                                        Belum Dijawab
                                    </span>
                                </div>
                                {{-- Tambah indikator soal yang ditandai --}}
                                <div class="flex items-center gap-2">
                                    <div
                                        class="flex h-4 w-4 items-center justify-center"
                                    >
                                        <x-mary-icon
                                            name="s-flag"
                                            class="h-4 w-4 text-amber-500"
                                        />
                                    </div>
                                    <span class="text-sm text-gray-700">
                                        Soal Ditandai
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Selesai Ujian --}}
                        <div class="mt-4 sm:mt-6">
                            <x-mary-button
                                wire:click="$set('showKonfirmasiModal', true)"
                                class="w-full transform rounded-xl bg-gradient-to-r from-violet-600 to-fuchsia-600 py-3 font-semibold text-white shadow-lg transition-all duration-300 hover:scale-105 hover:from-violet-700 hover:to-fuchsia-700 hover:shadow-xl"
                            >
                                <div
                                    class="flex items-center justify-center gap-2"
                                >
                                    <x-mary-icon
                                        name="o-check-circle"
                                        class="h-5 w-5"
                                    />
                                    <span>Selesai Ujian</span>
                                </div>
                            </x-mary-button>
                        </div>
                    </x-mary-card>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Konfirmasi Selesai Ujian --}}
    <x-mary-modal blur wire:model="showKonfirmasiModal">
        <div class="space-y-4">
            <div class="flex items-center gap-3 text-amber-600">
                <div
                    class="flex h-12 w-12 items-center justify-center rounded-full bg-gradient-to-br from-amber-100 to-amber-200"
                >
                    <x-mary-icon
                        name="o-exclamation-triangle"
                        class="h-6 w-6 animate-pulse"
                    />
                </div>
                <div>
                    <h3 class="text-lg font-bold">Konfirmasi Selesai Ujian</h3>
                    <p class="text-sm">
                        Apakah Anda yakin ingin menyelesaikan ujian?
                    </p>
                </div>
            </div>

            <div
                class="rounded-xl bg-gradient-to-br from-amber-50 to-amber-100/50 p-4 backdrop-blur-sm"
            >
                <p class="font-medium text-amber-700">Perhatian:</p>
                <ul class="mt-2 space-y-1 text-sm text-amber-600">
                    <li class="flex items-center gap-2">
                        <x-mary-icon name="s-chevron-right" class="h-4 w-4" />
                        Pastikan semua jawaban sudah terisi dengan benar
                    </li>
                    <li class="flex items-center gap-2">
                        <x-mary-icon name="s-chevron-right" class="h-4 w-4" />
                        Anda tidak dapat mengubah jawaban setelah ujian selesai
                    </li>
                    <li class="flex items-center gap-2">
                        <x-mary-icon name="s-chevron-right" class="h-4 w-4" />
                        Nilai akan langsung dihitung dan diekspor ke PDF
                    </li>
                </ul>
            </div>

            <div class="mt-4 rounded-xl bg-violet-50 p-4 text-violet-700">
                <p class="font-medium">Pilih tindakan Anda:</p>
                <ul class="mt-2 space-y-1 text-sm">
                    <li class="flex items-center gap-2">
                        <x-mary-icon name="s-arrow-left" class="h-4 w-4" />
                        Klik "Kembali ke Ujian" untuk melanjutkan mengerjakan
                    </li>
                    <li class="flex items-center gap-2">
                        <x-mary-icon name="s-check" class="h-4 w-4" />
                        Klik "Selesai Ujian" untuk mengakhiri dan melihat nilai
                    </li>
                </ul>
            </div>
        </div>

        <x-slot:actions>
            <div class="flex justify-end gap-3">
                <x-mary-button
                    wire:click="$set('showKonfirmasiModal', false)"
                    class="bg-white transition-all duration-300 hover:bg-gray-50"
                >
                    <div class="flex items-center gap-2">
                        <x-mary-icon name="o-arrow-left" class="h-4 w-4" />
                        Kembali ke Ujian
                    </div>
                </x-mary-button>
                <x-mary-button
                    wire:click="selesaiUjian"
                    class="bg-gradient-to-r from-violet-600 to-fuchsia-600 text-white transition-all duration-300 hover:from-violet-700 hover:to-fuchsia-700"
                >
                    <div class="flex items-center gap-2">
                        <x-mary-icon name="o-check" class="h-4 w-4" />
                        Selesai Ujian
                    </div>
                </x-mary-button>
            </div>
        </x-slot>
    </x-mary-modal>

    {{-- Loading States dengan Livewire --}}
    <div
        wire:loading
        wire:target="setCurrentSoal, previousSoal, nextSoal, selesaiUjian"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/20 backdrop-blur-sm"
    >
        <div class="rounded-xl bg-white p-6 shadow-xl">
            <div class="flex items-center gap-3">
                <div
                    class="h-8 w-8 animate-spin rounded-full border-4 border-violet-600 border-t-transparent"
                ></div>
                <span class="text-lg font-semibold text-violet-700">
                    Memuat...
                </span>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('livewire:initialized', () => {
            Livewire.on('resetRadioState', () => {
                document
                    .querySelectorAll('input[type="radio"]')
                    .forEach((radio) => {
                        radio.checked = false;
                    });
            });

            // Handle auto-save indicator
            Livewire.on('jawaban-updated', () => {
                Alpine.store('ujian').showAutoSaveIndicator();
            });

            // Tambahkan smooth scroll ke soal aktif
            Livewire.on('soalChanged', () => {
                const activeQuestion =
                    document.querySelector('.active-question');
                if (activeQuestion) {
                    activeQuestion.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start',
                    });
                }
            });

            // Handle download dan redirect
            Livewire.on('downloadAndRedirect', (data) => {
                const downloadUrl = data[0].downloadUrl;
                const redirectUrl = data[0].redirectUrl;

                // Coba buka PDF di tab baru dan simpan referensinya
                const pdfWindow = window.open(downloadUrl, '_blank');

                // Periksa apakah window berhasil dibuka
                if (pdfWindow === null || typeof pdfWindow === 'undefined') {
                    // Jika popup diblokir, tampilkan pesan dan link manual
                    Swal.fire({
                        title: 'Popup Diblokir',
                        html: `
                            Browser Anda memblokir popup. Silakan:<br>
                            1. <a href="${downloadUrl}" target="_blank" class="text-violet-600 hover:text-violet-700 font-semibold">Klik di sini untuk membuka PDF</a><br>
                            2. Setelah PDF terbuka, klik OK untuk melanjutkan
                        `,
                        icon: 'warning',
                        confirmButtonText: 'OK',
                        allowOutsideClick: false,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = redirectUrl;
                        }
                    });
                } else {
                    // Jika window berhasil dibuka
                    Swal.fire({
                        title: 'PDF Hasil Ujian',
                        text: 'PDF hasil ujian sedang dibuka di tab baru. Klik OK setelah PDF terbuka.',
                        icon: 'success',
                        confirmButtonText: 'OK',
                        allowOutsideClick: false,
                        showCancelButton: true,
                        cancelButtonText: 'Buka PDF Lagi',
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = redirectUrl;
                        } else if (
                            result.dismiss === Swal.DismissReason.cancel
                        ) {
                            // Buka PDF lagi jika user klik "Buka PDF Lagi"
                            window.open(downloadUrl, '_blank');
                        }
                    });
                }
            });
        });
    </script>

    {{-- Tambahkan div untuk iframe di bagian bawah view --}}
    <div id="download-container" class="hidden"></div>
</div>
