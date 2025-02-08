<div
    x-data="{
        showSuccessMessage: false,
        showForm: true,
        formStep: 1,
        maxSteps: 3,
        nextStep() {
            if (this.formStep < this.maxSteps) this.formStep++
        },
        prevStep() {
            if (this.formStep > 1) this.formStep--
        },
    }"
    class="min-h-screen"
>
    {{-- Header Card dengan Animasi --}}
    <div
        x-show="showForm"
        x-transition:enter="transition duration-300 ease-out"
        x-transition:enter-start="-translate-y-4 transform opacity-0"
        x-transition:enter-end="translate-y-0 transform opacity-100"
    >
        <x-mary-card
            class="mb-6 border-0 bg-gradient-to-br from-indigo-50 via-white to-indigo-50 shadow-xl"
        >
            <div class="px-2 sm:flex sm:items-center sm:justify-between">
                <div class="relative">
                    <div
                        class="absolute -left-1 top-0 h-16 w-1 animate-pulse rounded-full bg-indigo-500"
                    ></div>
                    <h1
                        class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-3xl font-bold text-transparent"
                    >
                        Buat Jadwal Baru
                    </h1>
                    <p class="mt-2 text-sm font-medium text-gray-600">
                        <span class="inline-flex items-center">
                            <x-mary-icon
                                name="o-calendar"
                                class="mr-1 inline-block h-4 w-4 animate-bounce"
                            />
                            Tambahkan jadwal pembelajaran baru
                        </span>
                    </p>
                </div>
                <div class="mt-4 flex space-x-3 sm:mt-0">
                    <x-mary-button
                        wire:navigate
                        href="{{ route('admin.jadwal.index') }}"
                        class="transform bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg transition-all duration-200 hover:scale-105 hover:from-indigo-700 hover:to-purple-700 hover:shadow-indigo-200"
                        icon="o-arrow-left"
                    >
                        Kembali ke Daftar
                    </x-mary-button>
                </div>
            </div>
        </x-mary-card>
    </div>

    {{-- Progress Steps --}}
    <div class="mb-8 flex justify-center">
        <div class="relative">
            <div class="flex items-center space-x-12">
                <template x-for="in 3 step" :key="step">
                    <div class="flex flex-col items-center">
                        <div
                            :class="{
                                'bg-indigo-600': formStep >= step,
                                'bg-gray-300': formStep < step
                            }"
                            class="flex h-8 w-8 items-center justify-center rounded-full font-bold text-white transition-all duration-300"
                            x-text="step"
                        ></div>
                        <span
                            class="mt-2 text-xs font-medium"
                            x-text="
                                step === 1
                                    ? 'Informasi Waktu'
                                    : step === 2
                                      ? 'Informasi Pembelajaran'
                                      : 'Keterangan'
                            "
                        ></span>
                    </div>
                </template>
            </div>
            <div class="absolute top-4 -z-10 h-0.5 w-full bg-gray-300">
                <div
                    class="h-full bg-indigo-600 transition-all duration-300"
                    :style="'width: ' + (((formStep - 1) / (maxSteps - 1)) * 100) + '%'"
                ></div>
            </div>
        </div>
    </div>

    {{-- Form Card dengan Step Navigation --}}
    <x-mary-card
        class="overflow-hidden border-0 bg-gradient-to-br from-white via-indigo-50/30 to-white shadow-xl"
    >
        <x-mary-form wire:submit="simpan" class="space-y-8">
            {{-- Step 1: Informasi Waktu --}}
            <div
                x-show="formStep === 1"
                x-transition:enter="transition duration-300 ease-out"
                x-transition:enter-start="translate-x-4 transform opacity-0"
                x-transition:enter-end="translate-x-0 transform opacity-100"
            >
                <div class="space-y-6">
                    <div class="flex items-center space-x-3">
                        <div class="h-8 w-1 rounded-full bg-indigo-500"></div>
                        <h2
                            class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-xl font-bold text-transparent"
                        >
                            Informasi Waktu
                        </h2>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-3">
                        <x-mary-datepicker
                            label="Tanggal"
                            wire:model="tanggal_mulai"
                            icon="o-calendar"
                            type="date"
                            disabled
                            :min="now()->format('Y-m-d')"
                            required
                            class="transform shadow-sm transition-transform duration-300 hover:scale-105"
                            hint="Pilih tanggal pelaksanaan"
                        />

                        @php
                            $config = [
                                "enableTime" => true,
                                "noCalendar" => true,
                                "dateFormat" => "H:i",
                                "time_24hr" => true,
                                "minTime" => "10:00",
                                "maxTime" => "21:00",
                            ];
                        @endphp

                        <x-mary-datepicker
                            label="Jam Mulai"
                            wire:model="jam_mulai"
                            icon="o-clock"
                            :config="$config"
                            required
                            class="transform shadow-sm transition-transform duration-300 hover:scale-105"
                            hint="Waktu dimulainya pembelajaran"
                        />

                        <x-mary-datepicker
                            label="Jam Selesai"
                            wire:model="jam_selesai"
                            icon="o-clock"
                            :config="$config"
                            required
                            class="transform shadow-sm transition-transform duration-300 hover:scale-105"
                            hint="Waktu berakhir pembelajaran"
                        />
                    </div>
                </div>
            </div>

            {{-- Step 2: Informasi Pembelajaran --}}
            <div
                x-show="formStep === 2"
                x-transition:enter="transition duration-300 ease-out"
                x-transition:enter-start="translate-x-4 transform opacity-0"
                x-transition:enter-end="translate-x-0 transform opacity-100"
            >
                <div class="space-y-6">
                    <div class="flex items-center space-x-3">
                        <div class="h-8 w-1 rounded-full bg-pink-500"></div>
                        <h2
                            class="bg-gradient-to-r from-pink-600 to-rose-600 bg-clip-text text-xl font-bold text-transparent"
                        >
                            Informasi Pembelajaran
                        </h2>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-3">
                        <x-mary-select
                            label="Kelas"
                            wire:model="kelas_bimbel_id"
                            :options="$daftarKelas"
                            option-label="nama_kelas"
                            option-value="id"
                            placeholder="Pilih Kelas"
                            required
                            icon="o-academic-cap"
                            class="transform shadow-sm transition-transform duration-300 hover:scale-105"
                            hint="Kelas yang akan mengikuti pembelajaran"
                        />

                        <x-mary-select
                            label="Mata Pelajaran"
                            wire:model.live="mata_pelajaran_id"
                            :options="$daftarMapel"
                            option-label="nama_pelajaran"
                            option-value="id"
                            placeholder="Pilih Mata Pelajaran"
                            required
                            icon="o-book-open"
                            class="transform shadow-sm transition-transform duration-300 hover:scale-105"
                            hint="Mata pelajaran yang akan diajarkan"
                        />

                        <x-mary-select
                            label="Tentor"
                            wire:model.live="tentor_id"
                            :options="$daftarGuru"
                            option-label="user.name"
                            option-value="id"
                            placeholder="Pilih Tentor"
                            required
                            icon="o-user"
                            class="transform shadow-sm transition-transform duration-300 hover:scale-105"
                            hint="Tentor yang akan mengajar"
                        />

                        <x-mary-select
                            label="Ruangan"
                            wire:model="ruangan_id"
                            :options="$daftarRuangan"
                            option-label="nama"
                            option-value="id"
                            placeholder="Pilih Ruangan"
                            required
                            icon="o-home"
                            class="transform shadow-sm transition-transform duration-300 hover:scale-105"
                            hint="Ruangan tempat pembelajaran"
                        />
                    </div>
                </div>
            </div>

            {{-- Step 3: Keterangan --}}
            <div
                x-show="formStep === 3"
                x-transition:enter="transition duration-300 ease-out"
                x-transition:enter-start="translate-x-4 transform opacity-0"
                x-transition:enter-end="translate-x-0 transform opacity-100"
            >
                <div class="space-y-6">
                    <div class="flex items-center space-x-3">
                        <div class="h-8 w-1 rounded-full bg-violet-500"></div>
                        <h2
                            class="bg-gradient-to-r from-violet-600 to-indigo-600 bg-clip-text text-xl font-bold text-transparent"
                        >
                            Keterangan Tambahan
                        </h2>
                    </div>

                    <x-mary-textarea
                        label="Keterangan"
                        wire:model="keterangan"
                        placeholder="Masukkan keterangan tambahan (opsional)"
                        rows="3"
                        class="transform shadow-sm transition-transform duration-300 hover:scale-105"
                        hint="Informasi tambahan mengenai jadwal pembelajaran"
                    />
                </div>
            </div>

            {{-- Navigation Buttons --}}
            <div class="mt-8 flex justify-between">
                <x-mary-button
                    x-show="formStep > 1"
                    @click="prevStep()"
                    class="transform border border-white/20 bg-gradient-to-br from-gray-500/40 via-gray-600/40 to-gray-700/40 font-medium text-white shadow-lg backdrop-blur-xl transition-all duration-300 hover:scale-105 hover:from-gray-500/60 hover:via-gray-600/60 hover:to-gray-700/60"
                    icon="o-arrow-left"
                >
                    Sebelumnya
                </x-mary-button>

                <div class="flex gap-4">
                    <x-mary-button
                        x-show="formStep < maxSteps"
                        @click="nextStep()"
                        class="transform border border-white/20 bg-gradient-to-br from-indigo-500/40 via-purple-500/40 to-violet-500/40 font-medium text-white shadow-lg backdrop-blur-xl transition-all duration-300 hover:scale-105 hover:from-indigo-500/60 hover:via-purple-500/60 hover:to-violet-500/60"
                        icon="o-arrow-right"
                    >
                        Selanjutnya
                    </x-mary-button>

                    <x-mary-button
                        x-show="formStep === maxSteps"
                        type="submit"
                        class="transform border border-white/20 bg-gradient-to-br from-emerald-500/40 via-teal-500/40 to-green-500/40 font-medium text-white shadow-lg backdrop-blur-xl transition-all duration-300 hover:scale-105 hover:from-emerald-500/60 hover:via-teal-500/60 hover:to-green-500/60"
                        icon="o-check"
                    >
                        Simpan Jadwal
                    </x-mary-button>
                </div>
            </div>
        </x-mary-form>
    </x-mary-card>

    {{-- Daftar Jadwal Besok --}}
    <div class="mt-8">
        <x-mary-card
            shadow
            class="rounded-3xl border-none bg-gradient-to-br from-gray-100 to-slate-200 backdrop-blur-lg duration-300 hover:scale-[1.01]"
        >
            <div class="mb-6 flex items-center space-x-3">
                <div class="h-8 w-1 rounded-full bg-emerald-500"></div>
                <h2
                    class="bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-xl font-bold text-transparent"
                >
                    Jadwal Untuk Besok
                    ({{ Carbon\Carbon::tomorrow()->locale("id")->isoFormat("dddd, D MMMM Y") }})
                </h2>
            </div>

            @if ($jadwalBesok->isEmpty())
                <div class="py-8 text-center">
                    <div class="mb-4 text-6xl">📅</div>
                    <p class="text-gray-500">Belum ada jadwal untuk besok</p>
                </div>
            @else
                <div
                    class="grid grid-cols-1 gap-4 md:grid-cols-2 lg:grid-cols-3"
                >
                    @foreach ($jadwalBesok as $jadwal)
                        <x-mary-card
                            shadow
                            class="group relative rounded-2xl border-none bg-gradient-to-br from-white/90 via-slate-50/90 to-slate-100/90 backdrop-blur-xl duration-300 hover:scale-[1.02] hover:shadow-xl hover:shadow-violet-200/40"
                        >
                            <div
                                class="absolute -inset-0.5 rounded-2xl bg-gradient-to-br from-violet-500/20 to-indigo-500/20 opacity-0 blur transition duration-300 group-hover:opacity-100"
                            ></div>
                            <div class="relative p-5">
                                <div
                                    class="mb-4 flex items-center justify-between"
                                >
                                    <div class="flex items-center space-x-2">
                                        <x-mary-icon
                                            name="o-clock"
                                            class="h-5 w-5 text-violet-500"
                                        />
                                        <x-mary-badge
                                            value="{{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}"
                                            class="border-violet-200 bg-violet-100/80 font-medium text-violet-700"
                                        />
                                    </div>
                                </div>

                                <h3
                                    class="mb-2 bg-gradient-to-br from-violet-700 to-indigo-700 bg-clip-text text-lg font-bold text-transparent"
                                >
                                    {{ $jadwal->nama_jadwal }}
                                </h3>

                                <h4
                                    class="mb-3 bg-gradient-to-br from-violet-700 to-indigo-700 bg-clip-text text-base font-medium text-transparent"
                                >
                                    {{ $jadwal->mataPelajaran->nama_pelajaran }}
                                </h4>

                                <div class="space-y-3">
                                    <div
                                        class="flex items-center space-x-3 rounded-lg border border-violet-100/50 bg-violet-50/50 p-2"
                                    >
                                        <x-mary-icon
                                            name="o-academic-cap"
                                            class="h-5 w-5 text-violet-600"
                                        />
                                        <span
                                            class="font-medium text-violet-700"
                                        >
                                            {{ $jadwal->kelasBimbel->nama_kelas }}
                                        </span>
                                    </div>

                                    <div
                                        class="flex items-center space-x-3 rounded-lg border border-indigo-100/50 bg-indigo-50/50 p-2"
                                    >
                                        <x-mary-icon
                                            name="o-user"
                                            class="h-5 w-5 text-indigo-600"
                                        />
                                        <span
                                            class="font-medium text-indigo-700"
                                        >
                                            {{ $jadwal->tentor->user->name }}
                                        </span>
                                    </div>

                                    @if ($jadwal->keterangan)
                                        <div
                                            class="flex items-center space-x-3 rounded-lg border border-emerald-100/50 bg-emerald-50/50 p-2"
                                        >
                                            <x-mary-icon
                                                name="o-information-circle"
                                                class="h-5 w-5 text-emerald-600"
                                            />
                                            <span
                                                class="font-medium text-emerald-700"
                                            >
                                                {{ $jadwal->keterangan }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </x-mary-card>
                    @endforeach
                </div>
            @endif
        </x-mary-card>
    </div>

    {{-- Success Message Modal --}}
    <div
        x-show="showSuccessMessage"
        x-transition:enter="transition duration-300 ease-out"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
    >
        <div
            class="scale-90 transform rounded-lg bg-white p-8 shadow-xl transition-all duration-300 hover:scale-100"
        >
            <div class="text-center">
                <div
                    class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-green-100"
                >
                    <svg
                        class="h-6 w-6 text-green-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M5 13l4 4L19 7"
                        ></path>
                    </svg>
                </div>
                <h3 class="mt-4 text-lg font-medium text-gray-900">
                    Jadwal Berhasil Disimpan!
                </h3>
                <div class="mt-6">
                    <x-mary-button
                        wire:navigate
                        href="{{ route('admin.jadwal.index') }}"
                        class="bg-gradient-to-r from-green-600 to-teal-600 text-white"
                    >
                        Kembali ke Daftar Jadwal
                    </x-mary-button>
                </div>
            </div>
        </div>
    </div>
</div>
