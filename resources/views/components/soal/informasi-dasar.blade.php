@props([
    "soal",
])

<div class="space-y-6">
    <div class="group">
        <h3
            class="mb-4 flex items-center gap-2 text-lg font-semibold text-gray-700"
        >
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
                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                </svg>
            </span>
            Informasi Dasar
        </h3>

        <div
            class="rounded-2xl border border-gray-100 bg-white/50 p-6 backdrop-blur-sm transition-all duration-300 hover:shadow-lg"
        >
            <x-mary-textarea
                label="Pertanyaan"
                wire:model="soal.pertanyaan"
                placeholder="Masukkan pertanyaan soal di sini..."
                rows="4"
                class="w-full transition-all duration-300 focus:ring-2 focus:ring-violet-500/50 group-hover:shadow-md"
            />
        </div>
    </div>
</div>
