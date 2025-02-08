<div class="min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50">
    <!-- Floating Clock Widget -->
    <div class="fixed bottom-6 right-6 z-50">
        <div class="group relative overflow-hidden rounded-2xl bg-white/95 px-5 py-3 shadow-lg backdrop-blur-sm transition-all duration-300 hover:shadow-xl">
            <div class="flex items-center gap-4">
                <div class="rounded-xl bg-indigo-500 p-2.5 shadow transition-colors duration-300 group-hover:bg-indigo-600">
                    <x-mary-icon name="o-clock" class="h-6 w-6 text-white" />
                </div>
                <div x-data="clock()" x-init="startClock()">
                    <p class="text-sm font-medium text-gray-600">Waktu</p>
                    <h3 x-text="time" class="text-2xl font-bold text-indigo-600"></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-6 py-8">
        <!-- Header Section -->
        <div class="relative mb-12 overflow-hidden rounded-3xl">
            <!-- Animated background gradient -->
            <div class="absolute inset-0 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 animate-gradient-xy"></div>

            <!-- Glowing border effect -->
            <div class="absolute inset-0 bg-gradient-to-r from-indigo-400 via-purple-400 to-pink-400 opacity-75 blur-xl"></div>

            <!-- Main content -->
            <div class="relative rounded-[1.4rem] bg-white/95 px-8 py-16 text-center backdrop-blur-xl transform transition-all duration-500 hover:scale-[1.02]">
                <!-- Floating shapes -->
                <div class="absolute top-0 left-0 w-24 h-24 bg-purple-400/20 rounded-full blur-2xl animate-pulse"></div>
                <div class="absolute bottom-0 right-0 w-32 h-32 bg-pink-400/20 rounded-full blur-2xl animate-pulse delay-700"></div>

                <!-- Sparkles effect -->
                <div class="absolute inset-0 overflow-hidden">
                    <div class="absolute w-2 h-2 bg-white rounded-full animate-ping" style="top: 20%; left: 30%"></div>
                    <div class="absolute w-2 h-2 bg-white rounded-full animate-ping delay-300" style="top: 60%; left: 70%"></div>
                    <div class="absolute w-2 h-2 bg-white rounded-full animate-ping delay-700" style="top: 80%; left: 40%"></div>
                </div>

                <h1 class="relative font-comic text-7xl font-black tracking-tight mb-6">
                    <span class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent animate-gradient-x">
                        ✨ Riwayat Hasil Ujian ✨
                    </span>
                </h1>

                <p class="relative text-2xl font-medium">
                    <span class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 bg-clip-text text-transparent">
                        Lihat perjalanan belajarmu dan terus tingkatkan prestasimu!
                    </span>
                    <span class="inline-block animate-bounce">🚀</span>
                </p>

                <!-- Decorative line -->
                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 w-32 h-1 rounded-full bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>
            </div>
            </div>

        <!-- Search & Filter Bar -->
        <div class="relative mb-8">
            <div class="absolute inset-0 -z-10 bg-gradient-to-r from-purple-100 via-pink-100 to-orange-100 blur-3xl"></div>
            <div class="relative flex flex-wrap items-center gap-4 rounded-2xl border-2 border-purple-200/50 bg-white/80 p-4 backdrop-blur-sm">
                <div class="flex-1">
                    <x-mary-input
                        wire:model.live.debounce.500ms="search"
                        icon="o-magnifying-glass"
                        placeholder="Cari riwayat ujianmu di sini..."
                        class="w-full rounded-xl border-2 border-purple-200/70 bg-white/90 px-6 py-4 text-lg font-medium shadow-sm transition-all duration-300 focus:border-purple-400 focus:ring-4 focus:ring-purple-200/50"
                    />
                </div>
            </div>
        </div>

        <!-- Hasil Ujian Cards -->
        <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                        @forelse ($hasilUjians as $hasil)
                <div class="group relative transform overflow-hidden rounded-3xl border-2 border-purple-200/50 bg-white/90 shadow-2xl backdrop-blur-sm transition-all duration-500 hover:-translate-y-2 hover:border-pink-300/70">
                    <div class="absolute inset-0 bg-gradient-to-br from-purple-50/80 to-pink-50/80 opacity-0 transition-opacity duration-500 group-hover:opacity-100"></div>
                    <div class="relative p-6">
                        <!-- Header -->
                        <div class="mb-6 flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-gradient-to-br from-purple-500 to-pink-500 shadow-xl transition-transform duration-500 group-hover:scale-110">
                                    <x-mary-icon name="o-document-text" class="h-8 w-8 text-white animate-bounce" />
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800 line-clamp-2">
                                        {{ $hasil->daftarUjianSiswa?->ujian?->nama ?? 'Tidak tersedia' }}
                                    </h3>
                                    <p class="text-sm text-gray-600">
                                        {{ $hasil->created_at->format('d M Y H:i') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Info Cards -->
                        <div class="space-y-4">
                            <!-- Mata Pelajaran -->
                            <div class="flex items-center gap-4 rounded-xl bg-gradient-to-r from-blue-50/80 to-indigo-50/80 p-4 shadow-md transition-transform duration-300 hover:scale-[1.02]">
                                <div class="rounded-lg bg-gradient-to-br from-blue-500 to-indigo-500 p-3 shadow-lg">
                                    <x-mary-icon name="o-book-open" class="h-6 w-6 text-white" />
                                    </div>
                                <div>
                                    <p class="text-sm font-medium text-blue-600/80">Mata Pelajaran</p>
                                    <p class="text-lg font-bold text-gray-800">
                                        {{ $hasil->daftarUjianSiswa?->mataPelajaran?->nama_pelajaran ?? 'Tidak tersedia' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Nilai -->
                            <div class="flex items-center gap-4 rounded-xl bg-gradient-to-r from-emerald-50/80 to-teal-50/80 p-4 shadow-md transition-transform duration-300 hover:scale-[1.02]">
                                <div class="rounded-lg bg-gradient-to-br from-emerald-500 to-teal-500 p-3 shadow-lg">
                                    <x-mary-icon name="o-trophy" class="h-6 w-6 text-white" />
                                    </div>
                                <div>
                                    <p class="text-sm font-medium text-emerald-600/80">Nilai Akhir</p>
                                    <p class="text-lg font-bold {{ $hasil->nilai_akhir >= 70 ? 'text-emerald-600' : 'text-rose-600' }}">
                                        {{ number_format($hasil->nilai_akhir ?? 0, 1) }}
                                    </p>
                                </div>
                            </div>

                            <!-- Durasi -->
                            <div class="flex items-center gap-4 rounded-xl bg-gradient-to-r from-pink-50/80 to-rose-50/80 p-4 shadow-md transition-transform duration-300 hover:scale-[1.02]">
                                <div class="rounded-lg bg-gradient-to-br from-pink-500 to-rose-500 p-3 shadow-lg">
                                    <x-mary-icon name="o-clock" class="h-6 w-6 text-white" />
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-pink-600/80">Durasi Pengerjaan</p>
                                    <p class="text-lg font-bold text-gray-800">
                                        {{ $hasil->getDurasiFormatted() }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="mt-6 flex justify-end">
                            <x-mary-button
                                wire:click="showDetail({{ $hasil->ujian_id }})"
                                icon="o-eye"
                                class="animate-gradient-x bg-gradient-to-r from-purple-600 via-pink-600 to-orange-500 bg-[length:200%_auto] px-6 py-3 text-base font-bold text-white shadow-xl transition-all duration-300 hover:scale-105 hover:shadow-pink-200/50"
                            >
                                Lihat Detail
                            </x-mary-button>
                        </div>

                        <!-- Decorative Elements -->
                        <div class="absolute -right-3 -top-3 h-8 w-8 animate-bounce rounded-full bg-gradient-to-br from-purple-400 to-pink-400 shadow-lg"></div>
                        <div class="absolute -bottom-3 -left-3 h-8 w-8 animate-bounce rounded-full bg-gradient-to-br from-pink-400 to-orange-400 shadow-lg delay-150"></div>
                                    </div>
                                    </div>
                        @empty
                <div class="col-span-full">
                    <div class="overflow-hidden rounded-3xl border-2 border-purple-200/50 bg-white/90 p-12 text-center shadow-2xl backdrop-blur-sm">
                        <div class="flex flex-col items-center justify-center">
                            <div class="mb-8 flex h-32 w-32 animate-bounce items-center justify-center rounded-full bg-gradient-to-br from-purple-100 to-pink-100 shadow-xl">
                                <x-mary-icon name="o-face-smile" class="h-20 w-20 text-purple-500" />
                            </div>
                            <h3 class="mb-4 bg-gradient-to-r from-purple-600 via-pink-600 to-orange-500 bg-clip-text text-3xl font-black text-transparent">
                                Belum Ada Riwayat Ujian 📚
                            </h3>
                            <p class="text-xl font-medium text-gray-600/90">
                                Yuk mulai ujianmu dan catat prestasi pertamamu! ✨
                            </p>
                        </div>
                    </div>
                </div>
                        @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $hasilUjians->links() }}
        </div>
    </div>

    <!-- Detail Modal -->
    <x-mary-modal wire:model="showDetailModal" box-class="max-w-7xl" blur="lg">
        <div class="relative">
            <!-- Header dengan efek gradient -->
            <div class="mb-8 rounded-xl bg-gradient-to-r from-purple-600 via-pink-600 to-orange-500 p-1">
                <div class="rounded-lg bg-white p-4">
                    <h2 class="animate-gradient-x bg-gradient-to-r from-purple-600 via-pink-600 to-orange-500 bg-[length:200%_auto] bg-clip-text text-3xl font-black text-transparent">
                        ✨ Detail Hasil Ujian ✨
                    </h2>
                </div>
            </div>

        @if($selectedHasil)
        <div class="space-y-8">
            <!-- Informasi Umum dengan Card Design yang Lebih Menarik -->
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                <div class="group transform rounded-2xl bg-gradient-to-br from-purple-50 to-pink-50 p-1 transition-all duration-300 hover:scale-[1.02] hover:shadow-xl">
                    <div class="h-full rounded-xl bg-white/90 p-6 backdrop-blur-sm">
                        <h3 class="mb-6 flex items-center gap-3 text-xl font-bold text-purple-800">
                            <x-mary-icon name="o-academic-cap" class="h-7 w-7 animate-bounce text-purple-600" />
                            Informasi Ujian
                        </h3>
                        <div class="space-y-4">
                            <div class="flex items-center gap-3 rounded-lg bg-purple-50 p-3 transition-all duration-300 hover:bg-purple-100">
                                <x-mary-icon name="o-document-text" class="h-5 w-5 text-purple-600" />
                                <span class="text-gray-600">Nama Ujian:</span>
                                <span class="font-medium text-gray-800">{{ $selectedHasil->daftarUjianSiswa?->ujian?->nama ?? 'Tidak tersedia' }}</span>
                            </div>
                            <div class="flex items-center gap-3 rounded-lg bg-pink-50 p-3 transition-all duration-300 hover:bg-pink-100">
                                <x-mary-icon name="o-book-open" class="h-5 w-5 text-pink-600" />
                                <span class="text-gray-600">Mata Pelajaran:</span>
                                <span class="font-medium text-gray-800">{{ $selectedHasil->daftarUjianSiswa?->mataPelajaran?->nama_pelajaran ?? 'Tidak tersedia' }}</span>
                            </div>
                            <div class="flex items-center gap-3 rounded-lg bg-orange-50 p-3 transition-all duration-300 hover:bg-orange-100">
                                <x-mary-icon name="o-calendar" class="h-5 w-5 text-orange-600" />
                                <span class="text-gray-600">Tanggal:</span>
                                <span class="font-medium text-gray-800">{{ $selectedHasil->created_at->format('d M Y') }}</span>
                            </div>
                            <div class="flex items-center gap-3 rounded-lg bg-purple-50 p-3 transition-all duration-300 hover:bg-purple-100">
                                <x-mary-icon name="o-clock" class="h-5 w-5 text-purple-600" />
                                <span class="text-gray-600">Waktu:</span>
                                <span class="font-medium text-gray-800">{{ optional($selectedHasil->waktu_mulai)->format('H:i') ?? '-' }} - {{ optional($selectedHasil->waktu_selesai)->format('H:i') ?? '-' }}</span>
                            </div>
                            <div class="flex items-center gap-3 rounded-lg bg-pink-50 p-3 transition-all duration-300 hover:bg-pink-100">
                                <x-mary-icon name="o-clock" class="h-5 w-5 text-pink-600" />
                                <span class="text-gray-600">Durasi:</span>
                                <span class="font-medium text-gray-800">{{ $selectedHasil->getDurasiFormatted() }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="group transform rounded-2xl bg-gradient-to-br from-emerald-50 to-teal-50 p-1 transition-all duration-300 hover:scale-[1.02] hover:shadow-xl">
                    <div class="h-full rounded-xl bg-white/90 p-6 backdrop-blur-sm">
                        <h3 class="mb-6 flex items-center gap-3 text-xl font-bold text-emerald-800">
                            <x-mary-icon name="o-trophy" class="h-7 w-7 animate-bounce text-emerald-600" />
                            Hasil Pencapaian
                        </h3>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between rounded-lg bg-emerald-50 p-4 transition-all duration-300 hover:bg-emerald-100">
                                <div class="flex items-center gap-3">
                                    <x-mary-icon name="o-trophy" class="h-8 w-8 text-emerald-600" />
                                    <span class="text-lg text-gray-600">Nilai Akhir:</span>
                                </div>
                                <span class="text-2xl font-black {{ $selectedHasil->nilai_akhir >= 70 ? 'animate-pulse text-emerald-600' : 'text-rose-600' }}">
                                    {{ number_format($selectedHasil->nilai_akhir, 1) }}
                                </span>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <div class="rounded-lg bg-teal-50 p-4 text-center transition-all duration-300 hover:bg-teal-100">
                                    <div class="mb-2 text-sm text-gray-600">Benar</div>
                                    <div class="text-xl font-bold text-emerald-600">{{ $selectedHasil->total_jawaban_benar }}</div>
                                </div>
                                <div class="rounded-lg bg-rose-50 p-4 text-center transition-all duration-300 hover:bg-rose-100">
                                    <div class="mb-2 text-sm text-gray-600">Salah</div>
                                    <div class="text-xl font-bold text-rose-600">{{ $selectedHasil->total_jawaban_salah }}</div>
                                </div>
                                <div class="rounded-lg bg-gray-50 p-4 text-center transition-all duration-300 hover:bg-gray-100">
                                    <div class="mb-2 text-sm text-gray-600">Kosong</div>
                                    <div class="text-xl font-bold text-gray-600">{{ $selectedHasil->total_tidak_dijawab }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Jawaban -->
            @if($selectedHasil && !empty($selectedHasil->detail_jawaban))
            <div class="transform rounded-2xl bg-gradient-to-br from-violet-50 to-purple-50 p-1 transition-all duration-300 hover:scale-[1.02] hover:shadow-xl">
                <div class="rounded-xl bg-white/90 p-6 backdrop-blur-sm">
                    <h3 class="mb-6 flex items-center gap-3 text-xl font-bold text-violet-800">
                        <x-mary-icon name="o-list-bullet" class="h-7 w-7 animate-bounce text-violet-600" />
                        Detail Jawaban
                    </h3>
                    <div class="space-y-6">
                        @forelse($selectedHasil->detail_jawaban as $jawaban)
                            <div class="group transform overflow-hidden rounded-xl bg-gradient-to-br from-violet-50 to-purple-50 p-0.5 transition-all duration-300 hover:scale-[1.02] hover:shadow-lg">
                                <div class="h-full rounded-lg bg-white p-4">
                                    <!-- Header Soal -->
                                    <div class="mb-4 flex items-center justify-between">
                                        <span class="flex items-center gap-2 font-bold text-violet-800">
                                            <x-mary-icon name="o-queue-list" class="h-5 w-5 text-violet-600" />
                                            Soal {{ $jawaban['nomor_soal'] ?? '-' }}
                                        </span>
                                        <div class="flex items-center gap-2">
                                            <span class="rounded-full {{ ($jawaban['is_correct'] ?? false) ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }} px-3 py-1 text-sm font-medium">
                                                {{ ($jawaban['is_correct'] ?? false) ? 'Benar' : 'Salah' }}
                                            </span>
                                            <span class="rounded-full bg-blue-100 text-blue-700 px-3 py-1 text-sm font-medium">
                                                Bobot: {{ $jawaban['bobot'] ?? '0' }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Pertanyaan -->
                                    <div class="mb-4 rounded-lg bg-violet-50 p-4">
                                        <p class="font-medium text-violet-900">{{ $jawaban['pertanyaan'] ?? 'Pertanyaan tidak tersedia' }}</p>
                                    </div>

                                    <!-- Pilihan Jawaban -->
                                    @if(!empty($jawaban['pilihan']) && is_array($jawaban['pilihan']))
                                        <div class="mb-4 grid gap-3">
                                            @foreach($jawaban['pilihan'] as $key => $pilihan)
                                                <div class="flex items-center gap-3 rounded-lg p-3 transition-all duration-300
                                                    {{ $key === ($jawaban['jawaban_benar'] ?? '') ? 'bg-emerald-50' :
                                                       ($key === ($jawaban['jawaban_siswa'] ?? '') ?
                                                            ($jawaban['is_correct'] ? 'bg-emerald-50' : 'bg-rose-50') :
                                                            'bg-gray-50') }}">
                                                    <!-- Indikator Pilihan -->
                                                    <div class="flex h-8 w-8 items-center justify-center rounded-full
                                                        {{ $key === ($jawaban['jawaban_benar'] ?? '') ? 'bg-emerald-200 text-emerald-800' :
                                                           ($key === ($jawaban['jawaban_siswa'] ?? '') ?
                                                                ($jawaban['is_correct'] ? 'bg-emerald-200 text-emerald-800' : 'bg-rose-200 text-rose-800') :
                                                                'bg-gray-200 text-gray-800') }}
                                                        font-medium">
                                                        {{ strtoupper($key) }}
                                                    </div>

                                                    <!-- Teks Pilihan -->
                                                    <span class="flex-1 {{ $key === ($jawaban['jawaban_benar'] ?? '') ? 'text-emerald-900' :
                                                                   ($key === ($jawaban['jawaban_siswa'] ?? '') ?
                                                                        ($jawaban['is_correct'] ? 'text-emerald-900' : 'text-rose-900') :
                                                                        'text-gray-900') }}">
                                                        {{ $pilihan }}
                                                    </span>

                                                    <!-- Indikator Status -->
                                                    @if($key === ($jawaban['jawaban_benar'] ?? ''))
                                                        <x-mary-icon name="o-check-circle" class="h-6 w-6 text-emerald-600" />
                                                    @elseif($key === ($jawaban['jawaban_siswa'] ?? '') && !($jawaban['is_correct'] ?? false))
                                                        <x-mary-icon name="o-x-circle" class="h-6 w-6 text-rose-600" />
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>

                                        <!-- Status Jawaban -->
                                        <div class="mt-3 flex items-center gap-3 rounded-lg bg-gray-50 p-3">
                                            <span class="font-medium text-gray-700">Jawaban Anda:</span>
                                            <span class="font-bold {{ ($jawaban['is_correct'] ?? false) ? 'text-emerald-600' : 'text-rose-600' }}">
                                                {{ strtoupper($jawaban['jawaban_siswa'] ?? 'Tidak Dijawab') }}
                                            </span>
                                            <span class="font-medium text-gray-700">|</span>
                                            <span class="font-medium text-gray-700">Jawaban Benar:</span>
                                            <span class="font-bold text-emerald-600">
                                                {{ strtoupper($jawaban['jawaban_benar'] ?? '-') }}
                                            </span>
                                        </div>
                                    @endif

                                    <!-- Pembahasan -->
                                    @if(!empty($jawaban['pembahasan']))
                                        <div class="mt-4 rounded-lg bg-blue-50 p-4">
                                            <p class="mb-2 font-medium text-blue-800">Pembahasan:</p>
                                            <p class="text-blue-700">{{ $jawaban['pembahasan'] }}</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-8">
                                <p class="text-gray-500">Tidak ada detail jawaban yang tersedia</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
            @else
            <div class="transform rounded-2xl bg-gradient-to-br from-violet-50 to-purple-50 p-1 transition-all duration-300 hover:scale-[1.02] hover:shadow-xl">
                <div class="rounded-xl bg-white/90 p-6 backdrop-blur-sm">
                    <div class="flex flex-col items-center justify-center py-12 text-center">
                        <div class="relative mb-6">
                            <div class="absolute -inset-4 rounded-full bg-violet-100 animate-pulse"></div>
                            <div class="relative">
                                <x-mary-icon name="o-document-magnifying-glass" class="h-20 w-20 text-violet-500 animate-bounce" />
                            </div>
                        </div>

                        <h3 class="mb-4 text-2xl font-bold bg-gradient-to-r from-violet-600 to-purple-600 bg-clip-text text-transparent">
                            Detail Jawaban Belum Tersedia
                        </h3>

                        <div class="max-w-md space-y-3">
                            <p class="text-gray-600">
                                Mohon maaf, detail jawaban untuk ujian ini belum dapat ditampilkan saat ini.
                            </p>
                            <p class="text-sm text-violet-600">
                                Silahkan download hasil ujian untuk melihat detail jawaban.
                            </p>

                            <div class="mt-6 flex justify-center">
                                <x-mary-button
                                    wire:click="downloadHasilUjian({{ $selectedHasil->ujian_id }})"
                                    class="group relative transform overflow-hidden rounded-xl bg-gradient-to-r from-violet-600 via-purple-600 to-pink-600 px-8 py-4 text-white transition-all duration-500 hover:scale-105 hover:shadow-lg"
                                >
                                    <div class="absolute inset-0 bg-white opacity-0 transition-opacity duration-300 group-hover:opacity-10"></div>
                                    <div class="flex items-center gap-3">
                                        <x-mary-icon name="o-arrow-down-tray" class="h-5 w-5 animate-bounce" />
                                        <span class="font-semibold">Download Hasil Ujian</span>
                                    </div>
                                </x-mary-button>
                            </div>

                            <p class="mt-4 text-sm text-gray-500">
                                File akan diunduh dalam format PDF yang berisi detail lengkap hasil ujian Anda.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        @endif

        <x-slot:actions>
            <div class="flex justify-end gap-4">
                <x-mary-button
                    label="Tutup"
                    wire:click="closeDetail"
                    class="bg-gradient-to-r from-gray-500 to-gray-600 text-white transition-all duration-300 hover:scale-105 hover:from-gray-600 hover:to-gray-700"
                    icon="o-x-mark"
                />
            </div>
        </x-slot:actions>
    </x-mary-modal>
</div>

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
                    hour12: false
                });
            }, 1000);
        }
    }
}
</script>
