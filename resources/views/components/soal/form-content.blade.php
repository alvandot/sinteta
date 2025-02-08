@props([
    "formState",
    "kategoris",
    "gambarSoal",
    "formMode",
])

<div class="space-y-6">
    <!-- Jenis Soal -->
    <div>
        <x-ts-label for="jenis_soal" value="Jenis Soal" required />
        <x-ts-select.styled
            wire:model.live="formState.jenis_soal"
            id="jenis_soal"
            name="jenis_soal"
            :options="[
                ['label' => 'Pilihan Ganda', 'value' => 'pilihan_ganda', 'description' => 'Soal dengan satu jawaban benar'],
                ['label' => 'Multiple Choice', 'value' => 'multiple_choice', 'description' => 'Soal dengan beberapa jawaban benar'],
                ['label' => 'Essay', 'value' => 'essay', 'description' => 'Soal dengan jawaban berupa teks bebas'],
            ]"
            select="label:label|value:value"
            class="mt-1 w-full"
            placeholder="Pilih jenis soal"
        />
        @error("formState.jenis_soal")
            <x-ts-error>{{ $message }}</x-ts-error>
        @enderror
    </div>

    <!-- Kategori -->
    <div>
        <x-ts-label for="kategori_id" value="Kategori" required />
        <x-ts-select.styled
            wire:model="formState.kategori_id"
            id="kategori_id"
            name="kategori_id"
            :options="$kategoris->map(fn($kategori) => [
                'label' => $kategori->nama,
                'value' => $kategori->id,
                'description' => 'Kategori soal ' . $kategori->nama
            ])->toArray()"
            select="label:label|value:value"
            class="mt-1 w-full"
            placeholder="Pilih kategori soal"
        />
        @error("formState.kategori_id")
            <x-ts-error>{{ $message }}</x-ts-error>
        @enderror
    </div>

    <!-- Bobot -->
    <div>
        <x-ts-label for="bobot" value="Bobot Soal" required />
        <x-ts-number
            wire:model="formState.bobot"
            id="bobot"
            name="bobot"
            min="1"
            max="100"
            class="mt-1 w-full"
            placeholder="Masukkan bobot soal"
        />
        @error("formState.bobot")
            <x-ts-error>{{ $message }}</x-ts-error>
        @enderror
    </div>

    <!-- Pertanyaan -->
    <div>
        <x-ts-label for="pertanyaan" value="Pertanyaan" required />
        <div class="mt-1">
            <x-ts-textarea
                wire:model="formState.pertanyaan"
                id="pertanyaan"
                name="pertanyaan"
                class="w-full"
                rows="4"
                placeholder="Masukkan pertanyaan"
            />
        </div>
        @error("formState.pertanyaan")
            <x-ts-error>{{ $message }}</x-ts-error>
        @enderror
    </div>

    <!-- Gambar Soal -->
    <div>
        <x-ts-label for="gambar" value="Gambar Soal (Opsional)" />
        <div class="mt-1 flex items-center space-x-4">
            @if ($gambarSoal || ($formMode === "edit" && $formState["gambar"]))
                <div class="relative h-32 w-32 overflow-hidden rounded-lg">
                    <img
                        src="{{ $gambarSoal ? $gambarSoal->temporaryUrl() : Storage::url($formState["gambar"]) }}"
                        alt="Preview gambar soal"
                        class="h-full w-full object-cover"
                    />
                    <button
                        type="button"
                        id="hapus_gambar"
                        name="hapus_gambar"
                        wire:click="hapusGambar"
                        class="absolute right-1 top-1 rounded-full bg-red-100 p-1 text-red-600 hover:bg-red-200"
                    >
                        <x-ts-icon name="x-mark" class="h-4 w-4" />
                    </button>
                </div>
            @else
                <x-ts-upload
                    wire:model="gambarSoal"
                    id="gambar"
                    name="gambar"
                    accept="image/*"
                    class="w-full"
                />
            @endif
        </div>
        @error("gambarSoal")
            <x-ts-error>{{ $message }}</x-ts-error>
        @enderror
    </div>

    <!-- Opsi Jawaban untuk Pilihan Ganda dan Multiple Choice -->
    @if (in_array($formState["jenis_soal"], ["pilihan_ganda", "multiple_choice"]))
        <div>
            <div class="mb-4 flex items-center justify-between">
                <x-ts-label for="opsi_jawaban" value="Opsi Jawaban" required />
                <x-ts-button
                    type="button"
                    id="tambah_opsi"
                    name="tambah_opsi"
                    wire:click="tambahOpsi"
                    class="bg-gradient-to-r from-violet-600 to-indigo-600 text-white hover:from-violet-700 hover:to-indigo-700"
                    icon="plus"
                    size="sm"
                >
                    Tambah Opsi
                </x-ts-button>
            </div>

            <div class="space-y-4">
                @foreach ($formState["opsi"] as $index => $opsi)
                    <div
                        class="relative rounded-lg border border-gray-200 bg-white p-4 shadow-sm"
                    >
                        <div class="mb-4 grid grid-cols-12 gap-4">
                            <!-- Label -->
                            <div class="col-span-2">
                                <x-ts-label
                                    for="opsi_{{ $index }}_label"
                                    value="Label"
                                    required
                                />
                                <x-ts-input
                                    wire:model="formState.opsi.{{ $index }}.label"
                                    id="opsi_{{ $index }}_label"
                                    name="opsi[{{ $index }}][label]"
                                    class="mt-1"
                                    maxlength="1"
                                    placeholder="A, B, C, ..."
                                />
                                @error("formState.opsi.{$index}.label")
                                    <x-ts-error>{{ $message }}</x-ts-error>
                                @enderror
                            </div>

                            <!-- Teks -->
                            <div class="col-span-10">
                                <x-ts-label
                                    for="opsi_{{ $index }}_teks"
                                    value="Teks"
                                    required
                                />
                                <x-ts-textarea
                                    wire:model="formState.opsi.{{ $index }}.teks"
                                    id="opsi_{{ $index }}_teks"
                                    name="opsi[{{ $index }}][teks]"
                                    class="mt-1"
                                    rows="2"
                                    placeholder="Masukkan teks opsi jawaban"
                                />
                                @error("formState.opsi.{$index}.teks")
                                    <x-ts-error>{{ $message }}</x-ts-error>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <!-- Is Jawaban -->
                            <div class="flex items-center space-x-2">
                                <x-ts-checkbox
                                    wire:model="formState.opsi.{{ $index }}.is_jawaban"
                                    id="opsi_{{ $index }}_is_jawaban"
                                    name="opsi[{{ $index }}][is_jawaban]"
                                    :disabled="$formState['jenis_soal'] === 'pilihan_ganda' && $this->getJumlahJawaban() > 0 && !$formState['opsi'][$index]['is_jawaban']"
                                />
                                <x-ts-label
                                    for="opsi_{{ $index }}_is_jawaban"
                                    value="Jawaban Benar"
                                />
                            </div>

                            <!-- Delete Button -->
                            <x-ts-button
                                type="button"
                                id="hapus_opsi_{{ $index }}"
                                name="hapus_opsi_{{ $index }}"
                                wire:click="hapusOpsi({{ $index }})"
                                class="bg-gradient-to-r from-red-500 to-rose-500 text-white hover:from-red-600 hover:to-rose-600"
                                icon="trash"
                                size="sm"
                            >
                                Hapus
                            </x-ts-button>
                        </div>

                        @error("formState.opsi.{$index}.is_jawaban")
                            <x-ts-error>{{ $message }}</x-ts-error>
                        @enderror
                    </div>
                @endforeach
            </div>

            @error("formState.opsi")
                <x-ts-error>{{ $message }}</x-ts-error>
            @enderror
        </div>
    @endif

    <!-- Kunci Jawaban Essay -->
    @if ($formState["jenis_soal"] === "essay")
        <div>
            <x-ts-label for="kunci_jawaban" value="Kunci Jawaban" required />
            <div class="mt-1">
                <x-ts-textarea
                    wire:model="formState.kunci_jawaban"
                    id="kunci_jawaban"
                    name="kunci_jawaban"
                    class="w-full"
                    rows="4"
                    placeholder="Masukkan kunci jawaban"
                />
            </div>
            @error("formState.kunci_jawaban")
                <x-ts-error>{{ $message }}</x-ts-error>
            @enderror
        </div>
    @endif
</div>
