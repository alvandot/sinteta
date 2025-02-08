<div>
    {{-- Loading States dengan Alpine.js --}}
    <div
        x-data="{ isLoading: false }"
        x-on:livewire:loading.window="isLoading = true"
        x-on:livewire:load.window="isLoading = false"
        x-on:livewire:navigating.window="isLoading = true"
        x-on:livewire:navigated.window="isLoading = false"
    >
        {{-- Loading Overlay --}}
        <div
            x-show="isLoading"
            x-transition:enter="transition duration-300 ease-out"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition duration-200 ease-in"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-50 flex items-center justify-center bg-black/20 backdrop-blur-sm"
        >
            <div
                class="transform animate-bounce rounded-xl bg-white p-6 shadow-xl"
            >
                <div class="flex items-center gap-3">
                    <div
                        class="h-8 w-8 animate-spin rounded-full border-4 border-violet-600 border-t-transparent"
                    ></div>
                    <span class="text-lg font-semibold text-violet-700">
                        Memproses...
                    </span>
                </div>
            </div>
        </div>

        <div class="p-6">
            <!-- Header -->
            <div class="mb-8">
                <x-mary-card
                    class="rounded-2xl border border-violet-100/50 bg-white/80 shadow-lg backdrop-blur-xl transition-all duration-300 hover:shadow-xl"
                >
                    <div class="p-8">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div
                                    class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-violet-100 to-violet-200"
                                >
                                    <x-mary-icon
                                        name="o-pencil-square"
                                        class="h-6 w-6 text-violet-600"
                                    />
                                </div>
                                <div>
                                    <h2
                                        class="bg-gradient-to-r from-violet-600 to-fuchsia-600 bg-clip-text text-2xl font-black text-transparent"
                                    >
                                        Buat Soal Baru
                                    </h2>
                                    <p class="text-gray-600">
                                        Tambahkan soal baru ke bank soal untuk
                                        digunakan dalam ujian
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-mary-card>
            </div>

            <!-- Form Section -->
            <x-mary-form wire:submit="simpanSoal" class="space-y-8">
                <!-- Informasi Dasar -->
                <div
                    class="rounded-2xl border border-violet-100/50 bg-white/80 p-6 shadow-lg backdrop-blur-xl"
                >
                    <div class="mb-4 flex items-center gap-3">
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-violet-100 to-violet-200"
                        >
                            <x-mary-icon
                                name="o-information-circle"
                                class="h-6 w-6 text-violet-600"
                            />
                        </div>
                        <h3
                            class="bg-gradient-to-r from-violet-600 to-fuchsia-600 bg-clip-text text-xl font-black text-transparent"
                        >
                            Informasi Dasar
                        </h3>
                    </div>

                    <div class="space-y-4">
                        <x-mary-input
                            label="Judul Soal"
                            wire:model="formData.nama"
                            placeholder="Contoh: Ujian Tengah Semester Matematika"
                            class="w-full"
                        />
                        <x-mary-textarea
                            label="Deskripsi"
                            wire:model="formData.deskripsi"
                            placeholder="Deskripsikan tujuan dan cakupan materi soal"
                            rows="4"
                            class="w-full"
                        />
                    </div>
                </div>

                <!-- Kategori & Klasifikasi -->
                <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                    <div
                        class="rounded-2xl border border-violet-100/50 bg-white/80 p-6 shadow-lg backdrop-blur-xl"
                    >
                        <div class="mb-4 flex items-center gap-3">
                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-violet-100 to-violet-200"
                            >
                                <x-mary-icon
                                    name="o-tag"
                                    class="h-6 w-6 text-violet-600"
                                />
                            </div>
                            <h3
                                class="bg-gradient-to-r from-violet-600 to-fuchsia-600 bg-clip-text text-xl font-black text-transparent"
                            >
                                Kategori & Klasifikasi
                            </h3>
                        </div>

                        <div class="space-y-4">
                            <x-mary-select
                                label="Mata Pelajaran"
                                wire:model="formData.mata_pelajaran_id"
                                :options="$mataPelajarans"
                                option-label="nama"
                                option-value="id"
                                placeholder="Pilih mata pelajaran"
                                class="w-full"
                            />
                            <x-mary-select
                                label="Tingkat"
                                wire:model="formData.tingkat"
                                :options="$tingkats"
                                option-value="key"
                                option-label="value"
                                placeholder="Pilih tingkat"
                                class="w-full"
                            />
                            <x-mary-input
                                type="number"
                                label="Tahun"
                                wire:model="formData.tahun"
                                placeholder="Masukkan tahun"
                                class="w-full"
                            />
                        </div>
                    </div>

                    <!-- Jumlah Soal -->
                    <div
                        class="rounded-2xl border border-violet-100/50 bg-white/80 p-6 shadow-lg backdrop-blur-xl"
                    >
                        <div class="mb-4 flex items-center gap-3">
                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-violet-100 to-violet-200"
                            >
                                <x-mary-icon
                                    name="o-calculator"
                                    class="h-6 w-6 text-violet-600"
                                />
                            </div>
                            <h3
                                class="bg-gradient-to-r from-violet-600 to-fuchsia-600 bg-clip-text text-xl font-black text-transparent"
                            >
                                Jumlah Soal
                            </h3>
                        </div>

                        <div class="space-y-4">
                            <x-mary-input
                                type="number"
                                label="Jumlah Soal Pilihan Ganda"
                                wire:model.live="formData.jumlah_soal_pilgan"
                                placeholder="1-50 soal"
                                min="1"
                                max="50"
                                class="w-full"
                                :readonly="!empty($soal_pilgan)"
                            />
                            <x-mary-input
                                type="number"
                                label="Jumlah Soal Essay"
                                wire:model.live="formData.jumlah_soal_essay"
                                placeholder="1-50 soal"
                                class="w-full"
                            />
                        </div>
                    </div>
                </div>

                <!-- Soal Pilihan Ganda -->
                @for ($i = 1; $i <= $formData['jumlah_soal_pilgan']; $i++)
                    <div
                        class="rounded-2xl border border-violet-100/50 bg-white/80 p-6 shadow-lg backdrop-blur-xl"
                    >
                        <div class="mb-4 flex items-center gap-3">
                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-violet-100 to-violet-200"
                            >
                                <x-mary-icon
                                    name="o-check-circle"
                                    class="h-6 w-6 text-violet-600"
                                />
                            </div>
                            <h3
                                class="bg-gradient-to-r from-violet-600 to-fuchsia-600 bg-clip-text text-xl font-black text-transparent"
                            >
                                Soal Pilihan Ganda #{{ $i }}
                            </h3>
                        </div>

                        <div class="space-y-6">
                            <x-mary-textarea
                                label="Pertanyaan"
                                wire:model="soal_pilgan.{{ $i }}.pertanyaan"
                                placeholder="Tuliskan pertanyaan dengan jelas dan spesifik"
                                rows="4"
                                class="w-full"
                            />
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                @foreach (["A", "B", "C", "D", "E"] as $option)
                                    <x-mary-textarea
                                        label="Pilihan {{ $option }}"
                                        wire:model.change="soal_pilgan.{{ $i }}.pilihan_{{ strtolower($option) }}"
                                        placeholder="Masukkan pilihan {{ $option }}"
                                        rows="3"
                                        class="w-full"
                                    />
                                @endforeach
                            </div>
                            <x-mary-select
                                label="Kunci Jawaban"
                                :options="collect(['A', 'B', 'C', 'D', 'E'])->map(fn($key) => ['key' => $key, 'value' => $soal_pilgan[$i]['pilihan_' . strtolower($key)] ?? null])->filter(fn($option) => !is_null($option['value']))->toArray()"
                                wire:model="soal_pilgan.{{ $i }}.kunci_jawaban"
                                option-value="key"
                                option-label="value"
                                placeholder="Pilih kunci jawaban"
                                class="w-full"
                            />
                            <x-mary-file
                                label="Gambar Soal"
                                wire:model="soal_pilgan.{{ $i }}.gambar"
                                accept="image/png, image/jpeg"
                                crop-after-change
                                :crop-config="$configImg"
                            >
                                <img
                                    src="{{ asset("storage/masukan_gambar.webp") }}"
                                    class="h-40 rounded-lg"
                                />
                            </x-mary-file>
                        </div>
                    </div>
                @endfor

                <!-- Soal Essay -->
                @for ($i = 1; $i <= $formData['jumlah_soal_essay']; $i++)
                    <div
                        class="rounded-2xl border border-violet-100/50 bg-white/80 p-6 shadow-lg backdrop-blur-xl"
                    >
                        <div class="mb-4 flex items-center gap-3">
                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-violet-100 to-violet-200"
                            >
                                <x-mary-icon
                                    name="o-pencil"
                                    class="h-6 w-6 text-violet-600"
                                />
                            </div>
                            <h3
                                class="bg-gradient-to-r from-violet-600 to-fuchsia-600 bg-clip-text text-xl font-black text-transparent"
                            >
                                Soal Essay #{{ $i }}
                            </h3>
                        </div>

                        <div class="space-y-6">
                            <x-mary-textarea
                                label="Pertanyaan"
                                wire:model="soal_essay.{{ $i }}.pertanyaan"
                                placeholder="Masukkan pertanyaan essay"
                                rows="4"
                                class="w-full"
                            />
                            <x-mary-textarea
                                label="Kunci Jawaban"
                                wire:model="soal_essay.{{ $i }}.kunci_jawaban"
                                placeholder="Masukkan kunci jawaban"
                                rows="6"
                                class="w-full"
                            />
                            <x-mary-file
                                label="Gambar Soal"
                                wire:model="soal_essay.{{ $i }}.gambar"
                                accept="image/png, image/jpeg"
                                crop-after-change
                                :crop-config="$configImg"
                            >
                                <img
                                    src="{{ asset("storage/masukan_gambar.webp") }}"
                                    class="h-40 rounded-lg"
                                />
                            </x-mary-file>
                        </div>
                    </div>
                @endfor

                <!-- Tombol Aksi -->
                <div class="flex justify-end gap-4">
                    <x-mary-button
                        link="daftar"
                        wire:navigate
                        type="reset"
                        class="bg-gradient-to-r from-red-600 to-pink-600 text-white transition-all duration-300 hover:from-red-700 hover:to-pink-700"
                    >
                        <div class="flex items-center gap-2">
                            <x-mary-icon name="o-x-mark" class="h-4 w-4" />
                            Batal
                        </div>
                    </x-mary-button>
                    <x-mary-button
                        type="submit"
                        class="bg-gradient-to-r from-violet-600 to-fuchsia-600 text-white transition-all duration-300 hover:from-violet-700 hover:to-fuchsia-700"
                    >
                        <div class="flex items-center gap-2">
                            <x-mary-icon name="o-check" class="h-4 w-4" />
                            Simpan Soal
                        </div>
                    </x-mary-button>
                </div>
            </x-mary-form>
        </div>
    </div>
</div>
