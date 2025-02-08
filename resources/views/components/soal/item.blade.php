@props([
    "soal",
    "index",
])

<div {{ $attributes->merge(["class" => "group relative"]) }}>
    <x-mary-card
        shadow="xl"
        class="relative rounded-xl border-none bg-white/80 backdrop-blur-sm transition-all duration-300 hover:scale-[1.02] hover:shadow-xl"
    >
        <div class="p-4">
            <!-- Header -->
            <div class="mb-4 flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <span
                        class="flex h-8 w-8 items-center justify-center rounded-full bg-violet-100 text-sm font-semibold text-violet-700"
                    >
                        {{ $index + 1 }}
                    </span>
                    <div class="flex items-center space-x-2">
                        @if ($soal->kategori)
                            <x-mary-badge
                                color="violet"
                                class="animate__animated animate__fadeIn"
                            >
                                {{ $soal->kategori->nama }}
                            </x-mary-badge>
                        @endif

                        <x-mary-badge
                            :color="$soal->jenis_soal === 'pilihan_ganda' ? 'blue' : ($soal->jenis_soal === 'multiple_choice' ? 'purple' : 'emerald')"
                            class="animate__animated animate__fadeIn"
                        >
                            {{ str($soal->jenis_soal)->title() }}
                        </x-mary-badge>
                    </div>
                </div>
                <div class="flex items-center space-x-2">
                    <x-mary-badge
                        color="amber"
                        class="animate__animated animate__fadeIn"
                    >
                        {{ $soal->bobot }} Poin
                    </x-mary-badge>
                </div>
            </div>

            <!-- Content -->
            <div class="mb-4 space-y-4">
                <!-- Pertanyaan -->
                <div class="prose prose-violet max-w-none">
                    {!! $soal->pertanyaan !!}
                </div>

                <!-- Gambar Soal -->
                @if ($soal->gambar)
                    <div class="mt-4 overflow-hidden rounded-lg">
                        <img
                            src="{{ Storage::url($soal->gambar) }}"
                            alt="Gambar Soal"
                            class="w-full object-cover transition-transform duration-300 hover:scale-105"
                        />
                    </div>
                @endif

                <!-- Opsi Jawaban -->
                @if ($soal->jenis_soal !== "essay")
                    <div class="mt-4 space-y-2">
                        @if ($soal->opsi && $soal->opsi->count() > 0)
                            @foreach ($soal->opsi as $opsi)
                                <div
                                    class="flex items-center space-x-3 rounded-lg border border-gray-200 bg-gray-50 p-3 transition-all duration-300 hover:border-violet-200 hover:bg-violet-50"
                                >
                                    <span
                                        class="{{ $opsi->is_jawaban ? "bg-green-100 text-green-700" : "bg-gray-100 text-gray-700" }} flex h-6 w-6 items-center justify-center rounded-full text-sm font-semibold"
                                    >
                                        {{ $opsi->label }}
                                    </span>
                                    <span class="text-gray-700">
                                        {{ $opsi->teks }}
                                    </span>
                                </div>
                            @endforeach
                        @else
                            <div
                                class="rounded-lg border border-gray-200 bg-gray-50 p-3"
                            >
                                <p class="text-gray-500">
                                    Belum ada opsi jawaban
                                </p>
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Kunci Jawaban Essay -->
                @if ($soal->jenis_soal === "essay")
                    <div
                        class="mt-4 rounded-lg border border-gray-200 bg-gray-50 p-4"
                    >
                        <div class="mb-2 font-semibold text-gray-700">
                            Kunci Jawaban:
                        </div>
                        <div
                            class="prose prose-violet max-w-none text-gray-600"
                        >
                            {!! $soal->kunci_jawaban !!}
                        </div>
                    </div>
                @endif
            </div>

            <!-- Footer -->
            <div
                class="flex items-center justify-between text-sm text-gray-500"
            >
                <div class="flex items-center space-x-4">
                    <span class="flex items-center space-x-1">
                        <x-mary-icon name="o-clock" class="h-4 w-4" />
                        <span>{{ $soal->created_at->diffForHumans() }}</span>
                    </span>
                    <span class="flex items-center space-x-1">
                        <x-mary-icon name="o-user" class="h-4 w-4" />
                        <span>{{ $soal->creator?->name }}</span>
                    </span>
                </div>
            </div>

            <!-- Action Buttons -->
            <div
                class="absolute right-3 top-3 flex space-x-2 opacity-0 transition-opacity duration-300 group-hover:opacity-100"
            >
                <x-mary-button
                    wire:click="editSoal({{ $soal->id }})"
                    class="bg-gradient-to-r from-amber-500 to-orange-500 text-white hover:from-amber-600 hover:to-orange-600"
                    icon="o-pencil"
                    size="sm"
                />
                <x-mary-button
                    wire:click="$dispatch('openDeleteModal', { soalId: {{ $soal->id }} })"
                    class="bg-gradient-to-r from-red-500 to-rose-500 text-white hover:from-red-600 hover:to-rose-600"
                    icon="o-trash"
                    size="sm"
                />
            </div>
        </div>
    </x-mary-card>
</div>
