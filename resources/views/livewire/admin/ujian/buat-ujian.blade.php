<div>
    {{-- Header Card --}}
    <x-mary-card
        class="mb-6 border-0 bg-gradient-to-br from-indigo-50 via-white to-indigo-50 shadow-xl"
    >
        <div class="px-2 sm:flex sm:items-center sm:justify-between">
            <div class="relative">
                <div
                    class="absolute -left-1 top-0 h-16 w-1 rounded-full bg-indigo-500"
                ></div>
                <h1
                    class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-3xl font-bold text-transparent"
                >
                    Buat Ujian Baru
                </h1>
                <p class="mt-2 text-sm font-medium text-gray-600">
                    <span class="inline-block">
                        <x-mary-icon
                            name="o-pencil"
                            class="mr-1 inline-block h-4 w-4"
                        />
                        Tambahkan ujian baru untuk siswa
                    </span>
                </p>
            </div>
            <div class="mt-4 flex space-x-3 sm:mt-0">
                <x-mary-button
                    wire:click="$dispatch('showDaftarUjian')"
                    class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg transition-all duration-200 hover:from-indigo-700 hover:to-purple-700 hover:shadow-indigo-200"
                    icon="o-arrow-left"
                >
                    Kembali ke Daftar
                </x-mary-button>
            </div>
        </div>
    </x-mary-card>

    {{-- Form Card --}}
    <x-mary-card
        class="border-0 bg-gradient-to-br from-white via-indigo-50/30 to-white shadow-xl"
    >
        <x-mary-form wire:submit="save" class="space-y-8">
            {{-- Informasi Dasar --}}
            <div class="space-y-6">
                <div class="flex items-center space-x-3">
                    <div class="h-8 w-1 rounded-full bg-indigo-500"></div>
                    <h2
                        class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-xl font-bold text-transparent"
                    >
                        Informasi Dasar
                    </h2>
                </div>

                <div class="grid grid-cols-1 gap-6">
                    <x-mary-input
                        name="nama"
                        label="Nama Ujian"
                        wire:model="nama"
                        required
                        :error="$errors->first('nama')"
                        placeholder="Masukkan nama ujian"
                        icon="o-document-text"
                        class="shadow-sm"
                    />
                </div>

                <div class="grid gap-6 sm:grid-cols-2">
                    <x-mary-select
                        name="mata_pelajaran_id"
                        label="Mata Pelajaran"
                        wire:model.live="mata_pelajaran_id"
                        :options="$mata_pelajaran_options"
                        required
                        searchable
                        :error="$errors->first('mata_pelajaran_id')"
                        placeholder="Pilih mata pelajaran"
                        icon="o-book-open"
                        option-label="name"
                        option-value="id"
                        hint="Pilih mata pelajaran untuk melihat paket soal yang tersedia"
                        class="shadow-sm"
                    />

                    <x-mary-select
                        name="kelas_id"
                        label="Kelas"
                        wire:model="kelas_id"
                        :options="$kelas_options"
                        required
                        searchable
                        :error="$errors->first('kelas_id')"
                        placeholder="Pilih kelas"
                        icon="o-user-group"
                        option-label="name"
                        option-value="id"
                        class="shadow-sm"
                    />
                </div>

                <div class="grid gap-6 sm:grid-cols-2">
                    <x-mary-datetime
                        type="time"
                        name="waktu_mulai"
                        label="Waktu Mulai"
                        wire:model="waktu_mulai"
                        required
                        :error="$errors->first('waktu_mulai')"
                        icon="o-calendar"
                        class="shadow-sm"
                    />

                    <x-mary-datetime
                        type="time"
                        name="waktu_selesai"
                        label="Waktu Selesai"
                        wire:model="waktu_selesai"
                        required
                        :error="$errors->first('waktu_selesai')"
                        icon="o-calendar"
                        class="shadow-sm"
                    />
                </div>

                <div class="grid gap-6 sm:grid-cols-2">
                    <x-mary-input
                        type="number"
                        name="durasi"
                        label="Durasi (Menit)"
                        wire:model="durasi"
                        required
                        :error="$errors->first('durasi')"
                        placeholder="Masukkan durasi ujian"
                        icon="o-clock"
                        min="1"
                        hint="Durasi ujian dalam menit"
                        class="shadow-sm"
                    />

                    <x-mary-input
                        type="number"
                        name="kkm"
                        label="KKM"
                        wire:model="kkm"
                        required
                        :error="$errors->first('kkm')"
                        placeholder="Masukkan nilai KKM"
                        icon="o-chart-bar"
                        min="0"
                        max="100"
                        hint="Kriteria Ketuntasan Minimal (0-100)"
                        class="shadow-sm"
                    />
                </div>
            </div>

            {{-- Debug Info (Development Only) --}}
            @if (config("app.debug"))
                <div
                    class="mb-4 rounded-lg bg-gray-100 p-4 text-sm text-gray-700"
                >
                    <p>Debug Info:</p>
                    <ul class="list-inside list-disc">
                        <li>Mata Pelajaran ID: {{ $mata_pelajaran_id }}</li>
                        <li>
                            Jumlah Paket Soal: {{ count($paket_soal_options) }}
                        </li>
                    </ul>
                </div>
            @endif

            {{-- Pengaturan Soal --}}
            <div class="space-y-6">
                <div class="flex items-center space-x-3">
                    <div class="h-8 w-1 rounded-full bg-purple-500"></div>
                    <h2
                        class="bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-xl font-bold text-transparent"
                    >
                        Pengaturan Soal
                    </h2>
                </div>

                <div class="grid gap-6 sm:grid-cols-2">
                    <x-mary-select
                        name="paket_soal_id"
                        label="Paket Soal"
                        wire:model.live="paket_soal_id"
                        :options="$paket_soal_options"
                        required
                        searchable
                        :error="$errors->first('paket_soal_id')"
                        placeholder="Pilih paket soal"
                        icon="o-book-open"
                        option-label="name"
                        option-value="id"
                        hint="Pilih paket soal yang akan digunakan"
                        class="shadow-sm"
                    />

                    <x-mary-select
                        name="mode_pengacakan"
                        label="Mode Pengacakan"
                        wire:model="mode_pengacakan"
                        :options="[
                            ['id' => 'soal', 'name' => 'Acak Soal'],
                            ['id' => 'soal_dan_jawaban', 'name' => 'Acak Soal dan Jawaban'],
                            ['id' => 'tidak_acak', 'name' => 'Tidak Acak'],
                        ]"
                        required
                        :error="$errors->first('mode_pengacakan')"
                        placeholder="Pilih mode pengacakan"
                        icon="o-arrow-path"
                        option-label="name"
                        option-value="id"
                        class="shadow-sm"
                    />
                </div>
            </div>

            {{-- Pengaturan Tambahan --}}
            <div class="space-y-6">
                <div class="flex items-center space-x-3">
                    <div class="h-8 w-1 rounded-full bg-pink-500"></div>
                    <h2
                        class="bg-gradient-to-r from-pink-600 to-rose-600 bg-clip-text text-xl font-bold text-transparent"
                    >
                        Pengaturan Tambahan
                    </h2>
                </div>

                <div class="grid gap-6 sm:grid-cols-2">
                    <div
                        class="rounded-xl bg-gradient-to-br from-indigo-50 to-white p-4 shadow-sm"
                    >
                        <x-mary-toggle
                            name="tampilkan_hasil"
                            label="Tampilkan Hasil Setelah Selesai"
                            wire:model="tampilkan_hasil"
                            :error="$errors->first('tampilkan_hasil')"
                            hint="Siswa dapat melihat nilai setelah menyelesaikan ujian"
                        />
                    </div>

                    <div
                        class="rounded-xl bg-gradient-to-br from-purple-50 to-white p-4 shadow-sm"
                    >
                        <x-mary-toggle
                            name="tampilkan_pembahasan"
                            label="Tampilkan Pembahasan"
                            wire:model="tampilkan_pembahasan"
                            :error="$errors->first('tampilkan_pembahasan')"
                            hint="Siswa dapat melihat pembahasan setelah menyelesaikan ujian"
                        />
                    </div>
                </div>

                <div class="grid gap-6 sm:grid-cols-2">
                    <div
                        class="rounded-xl bg-gradient-to-br from-pink-50 to-white p-4 shadow-sm"
                    >
                        <x-mary-toggle
                            name="dapat_mengulang"
                            label="Dapat Mengulang Ujian"
                            wire:model="dapat_mengulang"
                            :error="$errors->first('dapat_mengulang')"
                            hint="Siswa dapat mengulang ujian jika nilai di bawah KKM"
                        />
                    </div>

                    <div
                        class="rounded-xl bg-gradient-to-br from-rose-50 to-white p-4 shadow-sm"
                    >
                        <x-mary-toggle
                            name="aktif"
                            label="Aktifkan Ujian"
                            wire:model="aktif"
                            :error="$errors->first('aktif')"
                            hint="Ujian dapat diakses oleh siswa"
                        />
                    </div>
                </div>
            </div>

            {{-- Form Actions --}}
            <div class="flex justify-end space-x-4 pt-4">
                <x-mary-button
                    wire:click="$dispatch('showDaftarUjian')"
                    class="border border-gray-300 bg-white text-gray-700 shadow-sm hover:bg-gray-50"
                >
                    Batal
                </x-mary-button>

                <x-mary-button
                    type="submit"
                    class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg transition-all duration-200 hover:from-indigo-700 hover:to-purple-700 hover:shadow-indigo-200"
                    icon="o-paper-airplane"
                    :loading="$loading"
                >
                    Simpan Ujian
                </x-mary-button>
            </div>
        </x-mary-form>
    </x-mary-card>

    {{-- Modal Detail Paket Soal --}}
    <x-mary-modal
        name="detail-paket-soal"
        title="Detail Paket Soal"
        wire:model="showDetailModal"
        box-class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-lg border border-gray-100 dark:border-gray-700 max-w-4xl w-full mx-auto transform transition-all duration-300 ease-in-out"
    >
        @if ($selected_paket_soal)
            <div class="space-y-6">
                {{-- Header Paket Soal dengan Styling yang Lebih Menarik --}}
                <div
                    class="rounded-xl border border-blue-100 bg-gradient-to-r from-blue-50 to-indigo-50 p-4"
                >
                    <h3 class="text-xl font-bold text-blue-800">
                        {{ $selected_paket_soal->nama }}
                    </h3>
                    <div class="mt-2 flex items-center text-indigo-600">
                        <x-mary-icon
                            name="o-academic-cap"
                            class="mr-2 h-5 w-5"
                        />
                        <p class="text-sm">
                            {{ $selected_paket_soal->mataPelajaran->nama_pelajaran }}
                        </p>
                    </div>
                </div>

                {{-- Statistik Paket Soal --}}
                <div class="grid grid-cols-3 gap-4">
                    <div
                        class="rounded-xl border border-emerald-100 bg-emerald-50 p-4"
                    >
                        <div class="flex items-center justify-between">
                            <span class="font-medium text-emerald-700">
                                Total Soal
                            </span>
                            <x-mary-icon
                                name="o-document-text"
                                class="h-5 w-5 text-emerald-500"
                            />
                        </div>
                        <p class="mt-2 text-2xl font-bold text-emerald-800">
                            {{ $selected_paket_soal->soals->count() }}
                        </p>
                    </div>
                    <div
                        class="rounded-xl border border-violet-100 bg-violet-50 p-4"
                    >
                        <div class="flex items-center justify-between">
                            <span class="font-medium text-violet-700">
                                Total Bobot
                            </span>
                            <x-mary-icon
                                name="o-scale"
                                class="h-5 w-5 text-violet-500"
                            />
                        </div>
                        <p class="mt-2 text-2xl font-bold text-violet-800">
                            {{ $selected_paket_soal->soals->sum("bobot") }}
                        </p>
                    </div>
                    <div
                        class="rounded-xl border border-amber-100 bg-amber-50 p-4"
                    >
                        <div class="flex items-center justify-between">
                            <span class="font-medium text-amber-700">
                                Jenis Soal
                            </span>
                            <x-mary-icon
                                name="o-puzzle-piece"
                                class="h-5 w-5 text-amber-500"
                            />
                        </div>
                        <p class="mt-2 text-2xl font-bold text-amber-800">
                            {{ $selected_paket_soal->soals->unique("jenis_soal")->count() }}
                        </p>
                    </div>
                </div>

                {{-- Daftar Soal dengan Styling yang Lebih Menarik --}}
                <div class="space-y-4">
                    <h4
                        class="flex items-center text-lg font-semibold text-gray-700"
                    >
                        <x-mary-icon
                            name="o-clipboard-document-list"
                            class="mr-2 h-5 w-5"
                        />
                        Daftar Soal
                    </h4>
                    <div class="max-h-[400px] space-y-4 overflow-y-auto pr-2">
                        @foreach ($selected_paket_soal->soals as $index => $soal)
                            <div
                                class="rounded-xl border border-gray-100 bg-white p-5 shadow-sm transition-shadow hover:shadow-md"
                            >
                                <div class="flex items-start justify-between">
                                    <div class="flex items-center space-x-3">
                                        <span
                                            class="rounded-full bg-blue-100 px-3 py-1 text-sm font-medium text-blue-800"
                                        >
                                            Soal {{ $index + 1 }}
                                        </span>
                                        <span
                                            class="rounded-full bg-purple-100 px-3 py-1 text-sm font-medium text-purple-800"
                                        >
                                            {{ ucfirst($soal->jenis_soal) }}
                                        </span>
                                    </div>
                                    <span
                                        class="rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-800"
                                    >
                                        Bobot: {{ $soal->bobot }}
                                    </span>
                                </div>

                                <div class="prose prose-sm mt-4 max-w-none">
                                    {!! $soal->pertanyaan !!}
                                </div>

                                {{-- Kunci Jawaban dengan Styling yang Lebih Menarik --}}
                                <div
                                    class="mt-4 border-t border-dashed border-gray-200 pt-4"
                                >
                                    <p
                                        class="flex items-center text-sm font-medium text-emerald-600"
                                    >
                                        <x-mary-icon
                                            name="o-key"
                                            class="mr-2 h-4 w-4"
                                        />
                                        Kunci Jawaban:
                                    </p>
                                    <div
                                        class="mt-2 rounded-lg bg-emerald-50 p-3"
                                    >
                                        @if ($soal->jenis_soal === "pilihan_ganda")
                                            @foreach ($soal->soalOpsiRelation as $opsi)
                                                @if ($opsi->is_jawaban)
                                                    <div
                                                        class="flex items-center space-x-2 text-emerald-700"
                                                    >
                                                        <x-mary-icon
                                                            name="o-check-circle"
                                                            class="h-4 w-4"
                                                        />
                                                        <span>
                                                            {{ $opsi->label }}.
                                                            {{ $opsi->teks }}
                                                        </span>
                                                    </div>
                                                @endif
                                            @endforeach
                                        @elseif ($soal->jenis_soal === "multiple_choice")
                                            <div class="space-y-2">
                                                @foreach ($soal->soalOpsiRelation as $opsi)
                                                    @if ($opsi->is_jawaban)
                                                        <div
                                                            class="flex items-center space-x-2 text-emerald-700"
                                                        >
                                                            <x-mary-icon
                                                                name="o-check-circle"
                                                                class="h-4 w-4"
                                                            />
                                                            <span>
                                                                {{ $opsi->label }}.
                                                                {{ $opsi->teks }}
                                                            </span>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @elseif ($soal->jenis_soal === "essay")
                                            <div class="text-emerald-700">
                                                {!! $soal->kunci_essay !!}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            <div
                class="flex flex-col items-center justify-center py-12 text-gray-500"
            >
                <x-mary-icon
                    name="o-document-magnifying-glass"
                    class="mb-4 h-16 w-16"
                />
                <p class="text-lg">Silakan pilih paket soal terlebih dahulu</p>
            </div>
        @endif

        <x-slot:footer>
            <div class="flex justify-end">
                <x-mary-button
                    wire:click="closeDetailModal"
                    secondary
                    icon="o-x-mark"
                >
                    Tutup
                </x-mary-button>
            </div>
        </x-slot>
    </x-mary-modal>
</div>
