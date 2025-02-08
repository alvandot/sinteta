@props([
    "index",
    "soal",
    "configImg",
])

<x-mary-card
    shadow
    class="relative overflow-hidden rounded-3xl border-none bg-gradient-to-br from-gray-100 to-slate-200 backdrop-blur-lg duration-500 hover:scale-[1.02]"
>
    <!-- Background Decorations -->
    <div
        class="absolute right-0 top-0 -mr-24 -mt-24 h-[300px] w-[300px] animate-pulse rounded-full bg-violet-500/10 blur-[50px]"
    ></div>
    <div
        class="absolute bottom-0 left-0 -mb-24 -ml-24 h-[300px] w-[300px] animate-pulse rounded-full bg-indigo-500/10 blur-[50px]"
    ></div>

    <div class="relative p-8">
        <div class="mb-8 flex items-center gap-3">
            <span
                class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-violet-500 to-indigo-500 text-lg font-bold text-white shadow-lg"
            >
                {{ $index }}
            </span>
            <h3
                class="bg-gradient-to-r from-violet-600 to-indigo-600 bg-clip-text text-2xl font-black text-transparent"
            >
                Soal Essay
            </h3>
        </div>

        <div class="space-y-6">
            <div class="group">
                <x-mary-textarea
                    label="Pertanyaan"
                    wire:model="soal_essay.{{ $index }}.pertanyaan"
                    placeholder="Tuliskan pertanyaan essay dengan jelas dan spesifik"
                    rows="4"
                    class="w-full transition-all duration-300 hover:shadow-lg focus:ring-2 focus:ring-violet-500/50"
                />
            </div>

            <div class="group">
                <x-mary-textarea
                    label="Kunci Jawaban"
                    wire:model="soal_essay.{{ $index }}.kunci_jawaban"
                    placeholder="Tuliskan kunci jawaban yang diharapkan"
                    rows="6"
                    class="w-full transition-all duration-300 hover:shadow-lg focus:ring-2 focus:ring-violet-500/50"
                />
            </div>

            <div class="group">
                <x-mary-file
                    label="Gambar Soal"
                    wire:model="soal_essay.{{ $index }}.gambar"
                    accept="image/png, image/jpeg"
                    crop-after-change
                    :crop-config="$configImg"
                    class="transition-all duration-300 hover:shadow-lg"
                >
                    <div class="group relative overflow-hidden rounded-lg">
                        <img
                            src="{{ asset("storage/masukan_gambar.webp") }}"
                            class="h-40 w-full object-cover transition-transform duration-500 group-hover:scale-110"
                        />
                        <div
                            class="absolute inset-0 flex items-end justify-center bg-gradient-to-t from-black/50 to-transparent pb-4 opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                        >
                            <span class="text-sm font-medium text-white">
                                Klik untuk mengunggah gambar
                            </span>
                        </div>
                    </div>
                </x-mary-file>
            </div>
        </div>
    </div>
</x-mary-card>
