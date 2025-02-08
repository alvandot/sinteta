@php
    use App\Models\DaftarUjianSiswa;
@endphp

<div
    class="min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50"
>
    <!-- Floating Clock Widget -->
    <div class="fixed bottom-6 right-6 z-50">
        <div
            class="group relative overflow-hidden rounded-2xl bg-white/95 px-5 py-3 shadow-lg backdrop-blur-sm transition-all duration-300 hover:shadow-xl"
        >
            <div class="flex items-center gap-4">
                <div
                    class="rounded-xl bg-indigo-500 p-2.5 shadow transition-colors duration-300 group-hover:bg-indigo-600"
                >
                    <x-mary-icon name="o-clock" class="h-6 w-6 text-white" />
                </div>
                <div x-data="clock()" x-init="startClock()">
                    <p class="text-sm font-medium text-gray-600">Waktu</p>
                    <h3
                        x-text="time"
                        class="text-2xl font-bold text-indigo-600"
                    ></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-6 py-8">
        <!-- Widgets -->
        <div class="mb-8 flex flex-wrap justify-center gap-6">
            <!-- Widget Total Ujian -->
            <div
                class="group relative overflow-hidden rounded-2xl border-4 border-purple-400/30 bg-white/90 px-8 py-6 shadow-2xl backdrop-blur-sm transition-all duration-500 hover:scale-105 hover:border-pink-400/50"
            >
                <div
                    class="absolute -right-16 -top-16 h-32 w-32 rounded-full bg-gradient-to-br from-purple-400/20 to-pink-400/20 transition-all duration-700 group-hover:scale-[2]"
                ></div>
                <div class="flex items-center gap-4">
                    <div
                        class="rounded-xl bg-gradient-to-br from-purple-400 to-pink-500 p-4 shadow-lg transition-transform duration-500 group-hover:scale-110"
                    >
                        <x-mary-icon
                            name="o-document-text"
                            class="h-10 w-10 animate-pulse text-white"
                        />
                    </div>
                    <div>
                        <p class="text-lg font-medium text-purple-600/80">
                            Total Ujian
                        </p>
                        <h3
                            class="bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-4xl font-black text-transparent"
                        >
                            {{ $ujians->total() }}
                        </h3>
                    </div>
                </div>
            </div>

            <!-- Widget Status -->
            <div
                class="group relative overflow-hidden rounded-2xl border-4 border-emerald-400/30 bg-white/90 px-8 py-6 shadow-2xl backdrop-blur-sm transition-all duration-500 hover:scale-105 hover:border-teal-400/50"
            >
                <div
                    class="absolute -right-16 -top-16 h-32 w-32 rounded-full bg-gradient-to-br from-emerald-400/20 to-teal-400/20 transition-all duration-700 group-hover:scale-[2]"
                ></div>
                <div class="flex items-center gap-4">
                    <div
                        class="rounded-xl bg-gradient-to-br from-emerald-400 to-teal-500 p-4 shadow-lg transition-transform duration-500 group-hover:scale-110"
                    >
                        <x-mary-icon
                            name="o-check-circle"
                            class="h-10 w-10 animate-pulse text-white"
                        />
                    </div>
                    <div>
                        <p class="text-lg font-medium text-emerald-600/80">
                            Ujian Aktif
                        </p>
                        <h3
                            class="bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-4xl font-black text-transparent"
                        >
                            {{ $activeUjianCount }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Header Section -->
        <div
            class="relative mb-12 overflow-hidden rounded-3xl bg-gradient-to-r from-purple-600 via-pink-600 to-orange-500 p-[2px]"
        >
            <div
                class="relative rounded-[1.4rem] bg-white/95 px-8 py-12 text-center backdrop-blur-md"
            >
                <div
                    class="absolute inset-0 bg-gradient-to-r from-purple-100/50 via-pink-100/50 to-orange-100/50"
                ></div>
                <h1
                    class="animate-gradient-x font-comic relative bg-gradient-to-r from-purple-600 via-pink-600 to-orange-500 bg-[length:200%_auto] bg-clip-text text-6xl font-black tracking-tight text-transparent"
                >
                    🎯 Ujian Terkini 🎯
                </h1>
                <p class="relative mt-4 text-2xl font-medium text-gray-600/90">
                    Siap untuk tantangan baru? Mari kita tunjukkan kemampuan
                    terbaikmu! 🚀
                </p>
            </div>
        </div>

        <!-- Search & Filter Bar -->
        <div class="relative mb-8">
            <div
                class="absolute inset-0 -z-10 bg-gradient-to-r from-purple-100 via-pink-100 to-orange-100 blur-3xl"
            ></div>
            <div
                class="relative flex flex-wrap items-center gap-4 rounded-2xl border-2 border-purple-200/50 bg-white/80 p-4 backdrop-blur-sm"
            >
                <div class="flex-1">
                    <x-mary-input
                        wire:model.live="search"
                        icon="o-magnifying-glass"
                        placeholder="Cari ujianmu di sini..."
                        class="w-full rounded-xl border-2 border-purple-200/70 bg-white/90 px-6 py-4 text-lg font-medium shadow-sm transition-all duration-300 focus:border-purple-400 focus:ring-4 focus:ring-purple-200/50"
                    />
                </div>
            </div>
        </div>

        <!-- Ujian Cards -->
        <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($ujians as $ujian)
                <div
                    class="group relative transform overflow-hidden rounded-3xl border-2 border-purple-200/50 bg-white/90 shadow-2xl backdrop-blur-sm transition-all duration-500 hover:-translate-y-2 hover:border-pink-300/70"
                >
                    <div
                        class="absolute inset-0 bg-gradient-to-br from-purple-50/80 to-pink-50/80 opacity-0 transition-opacity duration-500 group-hover:opacity-100"
                    ></div>
                    <div class="relative p-6">
                        <!-- Header -->
                        <div class="mb-6 flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div
                                    class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-purple-500 to-pink-500 shadow-xl transition-transform duration-500 group-hover:scale-110"
                                >
                                    <x-mary-icon
                                        name="o-academic-cap"
                                        class="h-8 w-8 animate-bounce text-white"
                                    />
                                </div>
                                <div>
                                    <h3
                                        class="line-clamp-2 text-xl font-bold text-gray-800"
                                    >
                                        {{ $ujian->ujian->nama }}
                                    </h3>
                                    <x-mary-badge
                                        :color="$ujian->ujian->status === 'aktif' ? 'success' : 'error'"
                                        class="animate-pulse text-sm font-semibold"
                                    >
                                        {{ ucfirst($ujian->ujian->status) }}
                                    </x-mary-badge>
                                </div>
                            </div>
                        </div>

                        <!-- Info Cards -->
                        <div class="space-y-4">
                            <div
                                class="flex items-center gap-4 rounded-xl bg-gradient-to-r from-blue-50/80 to-indigo-50/80 p-4 shadow-md transition-transform duration-300 hover:scale-[1.02]"
                            >
                                <div
                                    class="rounded-lg bg-gradient-to-br from-blue-500 to-indigo-500 p-3 shadow-lg"
                                >
                                    <x-mary-icon
                                        name="o-book-open"
                                        class="h-6 w-6 text-white"
                                    />
                                </div>
                                <div>
                                    <p
                                        class="text-sm font-medium text-blue-600/80"
                                    >
                                        Mata Pelajaran
                                    </p>
                                    <p class="text-lg font-bold text-gray-800">
                                        {{ $ujian->mataPelajaran->nama_pelajaran }}
                                    </p>
                                </div>
                            </div>

                            <div
                                class="flex items-center gap-4 rounded-xl bg-gradient-to-r from-pink-50/80 to-rose-50/80 p-4 shadow-md transition-transform duration-300 hover:scale-[1.02]"
                            >
                                <div
                                    class="rounded-lg bg-gradient-to-br from-pink-500 to-rose-500 p-3 shadow-lg"
                                >
                                    <x-mary-icon
                                        name="o-clock"
                                        class="h-6 w-6 text-white"
                                    />
                                </div>
                                <div>
                                    <p
                                        class="text-sm font-medium text-pink-600/80"
                                    >
                                        Durasi
                                    </p>
                                    <p class="text-lg font-bold text-gray-800">
                                        {{ $ujian->ujian->durasi }} Menit
                                    </p>
                                </div>
                            </div>

                            <!-- Waktu Mulai -->
                            <div
                                class="flex items-center gap-4 rounded-xl bg-gradient-to-r from-green-50/80 to-emerald-50/80 p-4 shadow-md transition-transform duration-300 hover:scale-[1.02]"
                            >
                                <div
                                    class="rounded-lg bg-gradient-to-br from-green-500 to-emerald-500 p-3 shadow-lg"
                                >
                                    <x-mary-icon
                                        name="o-play"
                                        class="h-6 w-6 text-white"
                                    />
                                </div>
                                <div>
                                    <p
                                        class="text-sm font-medium text-green-600/80"
                                    >
                                        Waktu Mulai
                                    </p>
                                    <p class="text-lg font-bold text-gray-800">
                                        {{ $ujian->ujian->waktu_mulai->format("d M Y, H:i") }}
                                    </p>
                                </div>
                            </div>

                            <!-- Waktu Selesai -->
                            <div
                                class="flex items-center gap-4 rounded-xl bg-gradient-to-r from-red-50/80 to-orange-50/80 p-4 shadow-md transition-transform duration-300 hover:scale-[1.02]"
                            >
                                <div
                                    class="rounded-lg bg-gradient-to-br from-red-500 to-orange-500 p-3 shadow-lg"
                                >
                                    <x-mary-icon
                                        name="o-stop"
                                        class="h-6 w-6 text-white"
                                    />
                                </div>
                                <div>
                                    <p
                                        class="text-sm font-medium text-red-600/80"
                                    >
                                        Waktu Selesai
                                    </p>
                                    <p class="text-lg font-bold text-gray-800">
                                        {{ $ujian->ujian->waktu_selesai->format("d M Y, H:i") }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- Action Button -->
                        <div class="mt-6 flex justify-end">
                            @if ($ujian->status === "selesai")
                                <x-mary-button
                                    disabled
                                    icon="o-check"
                                    class="bg-gray-400/80 px-6 py-3 text-base font-bold backdrop-blur-sm"
                                >
                                    Selesai
                                </x-mary-button>
                            @elseif ($ujian->status === "sedang_mengerjakan")
                                <x-mary-button
                                    wire:click="mulaiUjian({{ $ujian->ujian_id }})"
                                    icon="o-arrow-path"
                                    class="animate-gradient-x bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-500 bg-[length:200%_auto] px-6 py-3 text-base font-bold text-white shadow-xl transition-all duration-300 hover:scale-105 hover:shadow-indigo-200/50"
                                >
                                    Lanjutkan Ujian
                                </x-mary-button>
                            @elseif ($ujian->status === "belum_mulai")
                                <x-mary-button
                                    wire:click="mulaiUjian({{ $ujian->ujian_id }})"
                                    icon="o-clock"
                                    class="bg-yellow-400/80 px-6 py-3 text-base font-bold text-white backdrop-blur-sm"
                                >
                                    Belum Dimulai
                                </x-mary-button>
                            @else
                                @php
                                    $now = now();
                                    $waktuMulai = \Carbon\Carbon::parse($ujian->ujian->waktu_mulai);
                                    $waktuSelesai = \Carbon\Carbon::parse($ujian->ujian->waktu_selesai);
                                @endphp

                                @if ($now->lt($waktuMulai))
                                    <x-mary-button
                                        disabled
                                        icon="o-clock"
                                        class="bg-yellow-400/80 px-6 py-3 text-base font-bold text-white backdrop-blur-sm"
                                    >
                                        Belum Dimulai
                                    </x-mary-button>
                                @elseif ($now->gt($waktuSelesai))
                                    <x-mary-button
                                        disabled
                                        icon="o-x-mark"
                                        class="bg-red-400/80 px-6 py-3 text-base font-bold text-white backdrop-blur-sm"
                                    >
                                        Waktu Habis
                                    </x-mary-button>
                                @else
                                    <x-mary-button
                                        wire:click="mulaiUjian({{ $ujian->ujian->id }})"
                                        icon="o-rocket-launch"
                                        class="animate-gradient-x bg-gradient-to-r from-purple-600 via-pink-600 to-orange-500 bg-[length:200%_auto] px-6 py-3 text-base font-bold text-white shadow-xl transition-all duration-300 hover:scale-105 hover:shadow-pink-200/50"
                                    >
                                        Mulai Sekarang!
                                    </x-mary-button>
                                @endif
                            @endif
                        </div>

                        <!-- Decorative Elements -->
                        <div
                            class="absolute -right-3 -top-3 h-8 w-8 animate-bounce rounded-full bg-gradient-to-br from-purple-400 to-pink-400 shadow-lg"
                        ></div>
                        <div
                            class="absolute -bottom-3 -left-3 h-8 w-8 animate-bounce rounded-full bg-gradient-to-br from-pink-400 to-orange-400 shadow-lg delay-150"
                        ></div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div
                        class="overflow-hidden rounded-3xl border-2 border-purple-200/50 bg-white/90 p-12 text-center shadow-2xl backdrop-blur-sm"
                    >
                        <div class="flex flex-col items-center justify-center">
                            <div
                                class="mb-8 flex h-32 w-32 animate-bounce items-center justify-center rounded-full bg-gradient-to-br from-purple-100 to-pink-100 shadow-xl"
                            >
                                <x-mary-icon
                                    name="o-face-smile"
                                    class="h-20 w-20 text-purple-500"
                                />
                            </div>
                            <h3
                                class="mb-4 bg-gradient-to-r from-purple-600 via-pink-600 to-orange-500 bg-clip-text text-3xl font-black text-transparent"
                            >
                                Belum Ada Ujian Saat Ini 📚
                            </h3>
                            <p class="text-xl font-medium text-gray-600/90">
                                Tetap semangat! Ujian akan segera tersedia
                                untukmu! ✨
                            </p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            <div class="rounded-xl bg-white/90 p-4 shadow-lg backdrop-blur-sm">
                {{ $ujians->links() }}
            </div>
        </div>
    </div>

    @push("scripts")
        <script>
            function clock() {
                return {
                    time: '',
                    startClock() {
                        setInterval(() => {
                            this.time = new Date().toLocaleTimeString('id-ID', {
                                hour: '2-digit',
                                minute: '2-digit',
                                second: '2-digit',
                                hour12: false,
                            });
                        }, 1000);
                    },
                };
            }
        </script>
    @endpush
</div>
