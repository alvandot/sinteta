@props([
    "formData",
    "soalPilgan",
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
                #
            </span>
            <h3
                class="bg-gradient-to-r from-violet-600 to-indigo-600 bg-clip-text text-2xl font-black text-transparent"
            >
                Jumlah Soal
            </h3>
        </div>

        <div class="space-y-6">
            <div class="group">
                <x-mary-input
                    type="number"
                    label="Jumlah Soal Pilihan Ganda"
                    wire:model.live="formData.jumlah_soal_pilgan"
                    min="0"
                    max="50"
                    placeholder="Masukkan jumlah soal pilihan ganda (maks. 50)"
                    class="w-full transition-all duration-300 hover:shadow-lg focus:ring-2 focus:ring-violet-500/50"
                />
                <p class="mt-2 text-sm text-gray-500">
                    Jumlah soal pilihan ganda saat ini:
                    {{ count($soalPilgan) }}
                </p>
            </div>

            <div class="group">
                <x-mary-input
                    type="number"
                    label="Jumlah Soal Essay"
                    wire:model.live="formData.jumlah_soal_essay"
                    min="0"
                    max="20"
                    placeholder="Masukkan jumlah soal essay (maks. 20)"
                    class="w-full transition-all duration-300 hover:shadow-lg focus:ring-2 focus:ring-violet-500/50"
                />
                <p class="mt-2 text-sm text-gray-500">
                    Total soal:
                    {{ $formData["jumlah_soal_pilgan"] + $formData["jumlah_soal_essay"] }}
                </p>
            </div>
        </div>
    </div>
</x-mary-card>
