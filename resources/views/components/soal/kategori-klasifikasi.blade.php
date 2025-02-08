@props([
    "soal",
    "kategoris",
])

<div class="space-y-6">
    <h3 class="flex items-center gap-2 text-lg font-semibold text-gray-700">
        <span
            class="flex h-8 w-8 items-center justify-center rounded-lg bg-violet-100 text-violet-600"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-5 w-5"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"
                />
            </svg>
        </span>
        Kategori & Klasifikasi
    </h3>

    <div
        class="rounded-2xl border border-gray-100 bg-white/50 p-6 backdrop-blur-sm transition-all duration-300 hover:shadow-lg"
    >
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <div class="group">
                <x-mary-select
                    label="Kategori"
                    wire:model="soal.kategori_id"
                    :options="$kategoris->map(fn($kat) => ['name' => $kat->nama, 'value' => $kat->id])->toArray()"
                    class="transition-all duration-300 focus:ring-2 focus:ring-violet-500/50 group-hover:shadow-md"
                    placeholder="Pilih kategori soal"
                />

                <p class="mt-2 text-sm text-gray-500">
                    Pilih kategori yang sesuai dengan materi soal
                </p>
            </div>

            <div class="group">
                <x-mary-select
                    label="Tingkat Kesulitan"
                    wire:model="soal.level"
                    :options="[
                        ['name' => 'Mudah', 'value' => 'mudah'],
                        ['name' => 'Sedang', 'value' => 'sedang'],
                        ['name' => 'Sulit', 'value' => 'sulit'],
                    ]"
                    class="transition-all duration-300 focus:ring-2 focus:ring-violet-500/50 group-hover:shadow-md"
                    placeholder="Pilih tingkat kesulitan"
                />

                <p class="mt-2 text-sm text-gray-500">
                    Tentukan tingkat kesulitan soal
                </p>
            </div>
        </div>
    </div>
</div>
