<div class="py-12">
    <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="overflow-hidden bg-white p-6 shadow-xl sm:rounded-lg">
            <div class="mb-8 text-center">
                <h1 class="text-3xl font-bold text-gray-900">Hasil Ujian</h1>
                <p class="text-gray-600">{{ $daftarUjian->ujian->nama }}</p>
            </div>

            <div class="mb-8 grid grid-cols-1 gap-6 md:grid-cols-2">
                <div
                    class="rounded-xl bg-gradient-to-br from-violet-50 to-violet-100 p-6"
                >
                    <h2 class="mb-4 text-lg font-semibold text-violet-900">
                        Informasi Ujian
                    </h2>
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-violet-700">Nama Siswa</span>
                            <span class="font-medium">
                                {{ $daftarUjian->siswa->nama_lengkap }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-violet-700">Tanggal Ujian</span>
                            <span class="font-medium">
                                {{ $daftarUjian->created_at->format("d F Y") }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-violet-700">Waktu Mulai</span>
                            <span class="font-medium">
                                {{ $daftarUjian->created_at->format("H:i") }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-violet-700">Waktu Selesai</span>
                            <span class="font-medium">
                                {{ $daftarUjian->waktu_selesai->format("H:i") }}
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-violet-700">Durasi</span>
                            <span class="font-medium">
                                {{ $daftarUjian->ujian->durasi }} Menit
                            </span>
                        </div>
                    </div>
                </div>

                <div
                    class="rounded-xl bg-gradient-to-br from-fuchsia-50 to-fuchsia-100 p-6"
                >
                    <h2 class="mb-4 text-lg font-semibold text-fuchsia-900">
                        Nilai Akhir
                    </h2>
                    <div class="text-center">
                        <div class="mb-2 text-6xl font-bold text-fuchsia-600">
                            {{ $daftarUjian->nilai }}
                        </div>
                        <p class="text-fuchsia-700">dari 100</p>
                    </div>
                </div>
            </div>

            <div class="flex justify-center gap-4">
                <x-mary-button
                    tag="a"
                    href="{{ route('siswa.dashboard') }}"
                    class="bg-gradient-to-r from-violet-600 to-fuchsia-600 text-white"
                >
                    <div class="flex items-center gap-2">
                        <x-mary-icon name="o-arrow-left" class="h-5 w-5" />
                        Kembali ke Daftar Ujian
                    </div>
                </x-mary-button>

                <form
                    action="{{ route("siswa.export-hasil-ujian", $daftarUjian->id) }}"
                    method="POST"
                >
                    @csrf
                    <x-mary-button
                        type="submit"
                        class="bg-gradient-to-r from-emerald-600 to-teal-600 text-white"
                    >
                        <div class="flex items-center gap-2">
                            <x-mary-icon
                                name="o-document-arrow-down"
                                class="h-5 w-5"
                            />
                            Download Hasil Ujian
                        </div>
                    </x-mary-button>
                </form>
            </div>
        </div>
    </div>
</div>
