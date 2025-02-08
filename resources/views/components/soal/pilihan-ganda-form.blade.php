@props([
    "soal",
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
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
                />
            </svg>
        </span>
        Pilihan Jawaban
    </h3>

    <div
        class="rounded-2xl border border-gray-100 bg-white/50 p-6 backdrop-blur-sm transition-all duration-300 hover:shadow-lg"
    >
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            @foreach (["a", "b", "c", "d"] as $pilihan)
                <div class="group relative">
                    <div
                        class="absolute -left-6 top-1/2 flex h-8 w-8 -translate-y-1/2 items-center justify-center rounded-full bg-violet-100 font-semibold uppercase text-violet-600"
                    >
                        {{ $pilihan }}
                    </div>
                    <x-mary-input
                        label="Pilihan {{ strtoupper($pilihan) }}"
                        wire:model="soal.pilihan_{{ $pilihan }}"
                        placeholder="Masukkan pilihan {{ strtoupper($pilihan) }}"
                        class="pl-8 transition-all duration-300 focus:ring-2 focus:ring-violet-500/50 group-hover:shadow-md"
                    />
                </div>
            @endforeach
        </div>

        <div class="mt-6 grid grid-cols-1 gap-6 md:grid-cols-2">
            <div class="group">
                <x-mary-select
                    label="Jawaban Benar"
                    wire:model="soal.jawaban_benar"
                    :options="[
                        ['name' => 'Pilihan A', 'value' => 'a'],
                        ['name' => 'Pilihan B', 'value' => 'b'],
                        ['name' => 'Pilihan C', 'value' => 'c'],
                        ['name' => 'Pilihan D', 'value' => 'd'],
                    ]"
                    class="transition-all duration-300 focus:ring-2 focus:ring-violet-500/50 group-hover:shadow-md"
                    placeholder="Pilih jawaban yang benar"
                />
            </div>

            <div class="group">
                <x-mary-textarea
                    label="Penjelasan Jawaban"
                    wire:model="soal.penjelasan"
                    placeholder="Berikan penjelasan untuk jawaban yang benar..."
                    rows="3"
                    class="transition-all duration-300 focus:ring-2 focus:ring-violet-500/50 group-hover:shadow-md"
                />
            </div>
        </div>
    </div>
</div>
