<div
    class="min-h-screen overflow-y-auto bg-[url('/images/pattern.svg')] bg-gradient-to-br from-violet-50 via-fuchsia-50 to-pink-50 bg-fixed bg-blend-soft-light"
>
    <div
        class="max-w-8xl container mx-auto px-4 py-6 sm:px-6 sm:py-8 lg:px-8 lg:py-12"
    >
        <x-mary-card
            class="border-0 bg-white/90 shadow-[0_8px_30px_rgba(139,92,246,0.2)] backdrop-blur-2xl transition-all duration-500 hover:bg-white/95 hover:shadow-[0_8px_40px_rgba(139,92,246,0.3)]"
        >
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

                <div class="flex-1">
                    <h1
                        class="bg-gradient-to-r from-violet-600 to-fuchsia-600 bg-clip-text text-2xl font-black text-transparent sm:text-3xl"
                    >
                        Edit Paket Soal
                    </h1>
                </div>
            </div>

            <div class="mt-8">
                <x-mary-form wire:submit="update" class="space-y-8">
                    <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                        <!-- Nama -->
                        <div
                            class="group relative transform transition-all duration-300 hover:-translate-y-1"
                        >
                            <div
                                class="absolute -inset-1 rounded-2xl bg-gradient-to-r from-violet-400 to-fuchsia-400 opacity-20 blur transition duration-300 group-hover:opacity-30"
                            ></div>
                            <div
                                class="relative rounded-2xl bg-white p-6 shadow-lg"
                            >
                                <label
                                    for="nama"
                                    class="mb-3 block text-base font-semibold text-gray-800"
                                >
                                    Nama Paket
                                </label>
                                <x-mary-input
                                    wire:model="nama"
                                    type="text"
                                    id="nama"
                                    name="nama"
                                    class="w-full rounded-xl border-violet-200 transition-all duration-300 focus:border-violet-500 focus:ring focus:ring-violet-200"
                                    placeholder="Masukkan nama paket soal"
                                />
                                @error("nama")
                                    <p
                                        class="mt-2 text-sm font-medium text-red-500"
                                    >
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Mata Pelajaran -->
                        <div
                            class="group relative transform transition-all duration-300 hover:-translate-y-1"
                        >
                            <div
                                class="absolute -inset-1 rounded-2xl bg-gradient-to-r from-violet-400 to-fuchsia-400 opacity-20 blur transition duration-300 group-hover:opacity-30"
                            ></div>
                            <div
                                class="relative rounded-2xl bg-white p-6 shadow-lg"
                            >
                                <label
                                    for="mata_pelajaran_id"
                                    class="mb-3 block text-base font-semibold text-gray-800"
                                >
                                    Mata Pelajaran
                                </label>
                                <x-mary-select
                                    wire:model="mata_pelajaran_id"
                                    id="mata_pelajaran_id"
                                    :options="$mataPelajarans"
                                    option-value="id"
                                    option-label="nama_pelajaran"
                                    placeholder="Pilih Mata Pelajaran"
                                    class="w-full rounded-xl transition-all duration-300"
                                />
                                @error("mata_pelajaran_id")
                                    <p
                                        class="mt-2 text-sm font-medium text-red-500"
                                    >
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Tingkat -->
                        <div
                            class="group relative transform transition-all duration-300 hover:-translate-y-1"
                        >
                            <div
                                class="absolute -inset-1 rounded-2xl bg-gradient-to-r from-violet-400 to-fuchsia-400 opacity-20 blur transition duration-300 group-hover:opacity-30"
                            ></div>
                            <div
                                class="relative rounded-2xl bg-white p-6 shadow-lg"
                            >
                                <label
                                    for="tingkat"
                                    class="mb-3 block text-base font-semibold text-gray-800"
                                >
                                    Tingkat
                                </label>
                                <x-mary-select
                                    wire:model="tingkat"
                                    :options="$tingkats"
                                    option-value="id"
                                    option-label="nama"
                                    id="tingkat"
                                    name="tingkat"
                                    class="w-full rounded-xl transition-all duration-300"
                                />
                                @error("tingkat")
                                    <p
                                        class="mt-2 text-sm font-medium text-red-500"
                                    >
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Tahun -->
                        <div
                            class="group relative transform transition-all duration-300 hover:-translate-y-1"
                        >
                            <div
                                class="absolute -inset-1 rounded-2xl bg-gradient-to-r from-violet-400 to-fuchsia-400 opacity-20 blur transition duration-300 group-hover:opacity-30"
                            ></div>
                            <div
                                class="relative rounded-2xl bg-white p-6 shadow-lg"
                            >
                                <label
                                    for="tahun"
                                    class="mb-3 block text-base font-semibold text-gray-800"
                                >
                                    Tahun
                                </label>
                                <x-mary-input
                                    wire:model="tahun"
                                    type="text"
                                    id="tahun"
                                    name="tahun"
                                    class="w-full rounded-xl border-violet-200 transition-all duration-300 focus:border-violet-500 focus:ring focus:ring-violet-200"
                                    placeholder="Masukkan tahun"
                                />
                                @error("tahun")
                                    <p
                                        class="mt-2 text-sm font-medium text-red-500"
                                    >
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div
                            class="group relative transform transition-all duration-300 hover:-translate-y-1 md:col-span-2"
                        >
                            <div
                                class="absolute -inset-1 rounded-2xl bg-gradient-to-r from-violet-400 to-fuchsia-400 opacity-20 blur transition duration-300 group-hover:opacity-30"
                            ></div>
                            <div
                                class="relative rounded-2xl bg-white p-6 shadow-lg"
                            >
                                <label
                                    for="deskripsi"
                                    class="mb-3 block text-base font-semibold text-gray-800"
                                >
                                    Deskripsi
                                </label>
                                <x-mary-textarea
                                    wire:model="deskripsi"
                                    id="deskripsi"
                                    name="deskripsi"
                                    rows="4"
                                    class="w-full rounded-xl border-violet-200 transition-all duration-300 focus:border-violet-500 focus:ring focus:ring-violet-200"
                                    placeholder="Masukkan deskripsi paket soal"
                                />
                                @error("deskripsi")
                                    <p
                                        class="mt-2 text-sm font-medium text-red-500"
                                    >
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-4 pt-4">
                        <x-mary-button
                            href="{{ route('admin.soal.index') }}"
                            class="rounded-xl border border-gray-200 bg-white px-8 py-3 font-semibold text-gray-700 shadow-sm transition-all duration-300 hover:bg-gray-50 hover:shadow-md"
                        >
                            <x-mary-icon name="o-x-mark" class="mr-2 h-5 w-5" />
                            Batal
                        </x-mary-button>
                        <x-mary-button
                            type="submit"
                            class="rounded-xl bg-gradient-to-r from-violet-600 to-fuchsia-600 px-8 py-3 font-semibold text-white shadow-lg transition-all duration-300 hover:from-violet-700 hover:to-fuchsia-700 hover:shadow-xl"
                        >
                            <x-mary-icon name="o-check" class="mr-2 h-5 w-5" />
                            Simpan Perubahan
                        </x-mary-button>
                    </div>
                </x-mary-form>

                <x-mary-card class="mt-8">
                    <h3
                        class="mb-6 bg-gradient-to-r from-violet-600 to-fuchsia-600 bg-clip-text text-xl font-bold text-transparent"
                    >
                        Daftar Soal
                    </h3>
                    <x-mary-card class="space-y-4">
                        @forelse ($soals as $index => $soal)
                            <div
                                class="rounded-2xl border-2 border-violet-200/50 bg-white/90 p-6 shadow-xl backdrop-blur-xl transition-all duration-300 hover:-translate-y-1 hover:shadow-2xl"
                            >
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-6">
                                        <div
                                            class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-violet-500 to-fuchsia-500 text-xl font-bold text-white shadow-lg"
                                        >
                                            {{ $index + 1 }}
                                        </div>
                                        <div>
                                            <p
                                                class="mb-1 text-lg font-bold text-gray-800"
                                            >
                                                {{ $soal->pertanyaan }}
                                            </p>
                                            <span
                                                class="rounded-full bg-violet-100 px-4 py-1 text-sm font-medium text-violet-700"
                                            >
                                                {{ ucfirst($soal->jenis_soal) }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-4">
                                        <x-mary-button
                                            wire:click="hapusSoal({{ $soal->id }})"
                                            class="rounded-xl bg-gradient-to-r from-red-500 to-pink-500 font-medium text-white shadow-lg transition-all duration-300 hover:from-red-600 hover:to-pink-600 hover:shadow-xl"
                                        >
                                            <x-mary-icon
                                                name="o-trash"
                                                class="mr-2 h-5 w-5"
                                            />
                                            Hapus
                                        </x-mary-button>
                                    </div>
                                </div>

                                <div class="mt-6">
                                    <div
                                        class="rounded-2xl border border-violet-100/50 bg-gradient-to-br from-violet-50 to-fuchsia-50 p-6"
                                    >
                                        <h4
                                            class="mb-4 text-lg font-bold text-violet-800"
                                        >
                                            Opsi Jawaban
                                        </h4>
                                        <div class="space-y-3">
                                            @foreach ($soal->soalOpsi as $opsi)
                                                <div
                                                    class="group flex items-center gap-4"
                                                >
                                                    <x-mary-checkbox
                                                        wire:model.live="opsiJawaban.{{ $soal->id }}.{{ $opsi->id }}"
                                                        :checked="$opsi->is_jawaban"
                                                        :disabled="$soal->jenis_soal == 'pilihan_ganda' && $opsi->is_jawaban"
                                                        class="h-5 w-5 rounded-lg text-emerald-500 transition duration-300"
                                                    />
                                                    <div class="flex-1">
                                                        <x-mary-input
                                                            wire:model.live="opsiTeks.{{ $soal->id }}.{{ $opsi->id }}"
                                                            value="{{ $opsi->teks }}"
                                                            class="w-full rounded-xl border-violet-200 transition-all duration-300 focus:border-violet-500 focus:ring focus:ring-violet-200 group-hover:shadow-md"
                                                        />
                                                    </div>
                                                </div>
                                            @endforeach

                                            @if ($soal->jenis_soal == "essay")
                                                <div
                                                    class="mt-4 rounded-xl border border-violet-200/50 bg-violet-100/50 p-4"
                                                >
                                                    <span
                                                        class="mb-2 block text-sm font-bold text-violet-700"
                                                    >
                                                        Kunci Jawaban Essay:
                                                    </span>
                                                    <x-mary-textarea
                                                        wire:model.live="kunciEssay.{{ $soal->id }}"
                                                        value="{{ $soal->kunci_essay }}"
                                                        rows="3"
                                                        class="w-full rounded-xl border-violet-200 transition-all duration-300 focus:border-violet-500 focus:ring focus:ring-violet-200"
                                                    />
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div
                                class="rounded-2xl border-2 border-dashed border-violet-200 bg-gradient-to-br from-violet-50 to-fuchsia-50 p-12 text-center"
                            >
                                <x-mary-icon
                                    name="o-document-text"
                                    class="mx-auto mb-4 h-16 w-16 text-violet-400"
                                />
                                <p class="text-lg font-medium text-violet-700">
                                    Belum ada soal yang ditambahkan
                                </p>
                                <p class="mt-2 text-violet-500">
                                    Silakan tambahkan soal baru untuk memulai
                                </p>
                            </div>
                        @endforelse
                    </x-mary-card>
                </x-mary-card>
            </div>
        </x-mary-card>
    </div>
</div>
