@php
    use SimpleSoftwareIO\QrCode\Facades\QrCode;
@endphp

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Hasil Ujian</title>
        @livewireStyles
        @vite("resources/css/app.css", "resources/js/app.js")
    </head>

    <body class="min-h-screen bg-gradient-to-br from-violet-50 to-indigo-50">
        <!-- Watermark -->
        <div class="fixed inset-0 flex items-center justify-center">
            <div
                class="rotate-[-15deg] select-none text-9xl font-black text-gray-100/10"
            >
                SINTETA CBT
            </div>
        </div>

        <div class="container relative mx-auto max-w-5xl px-4 py-8">
            <!-- Header Card -->
            <x-mary-card class="mb-8" shadow="xl">
                <div class="grid grid-cols-3 items-center gap-4">
                    <!-- QR Code -->
                    <div class="flex justify-start">
                        <x-mary-card class="bg-white p-2">
                            {!! QrCode::format("svg")->size(80)->generate(url("/verify-hasil-ujian/" . $id_ujian)) !!}
                        </x-mary-card>
                    </div>

                    <!-- Logo -->
                    <div class="flex justify-center">
                        <img
                            src="{{ public_path("images/logo.webp") }}"
                            alt="Logo"
                            class="h-24 w-auto transform transition hover:scale-105"
                        />
                    </div>

                    <!-- Empty space for symmetry -->
                    <div></div>
                </div>

                <div class="mt-6 text-center">
                    <h1
                        class="bg-gradient-to-r from-violet-600 to-indigo-600 bg-clip-text text-4xl font-bold text-transparent"
                    >
                        SINTETA CBT
                    </h1>
                    <x-mary-card class="mt-3" color="violet">
                        <p class="text-sm">
                            Jl. Mardani Raya No.70 3, RT.11/RW.13, Cemp. Putih
                            Bar., Kec. Cemp. Putih,
                        </p>
                        <p class="text-sm">
                            Kota Jakarta Pusat, Daerah Khusus Ibukota Jakarta
                            10560
                        </p>
                        <p class="text-sm font-medium">
                            Email: Sinteta
                            @gmail.com
                            | Telp: +6281-3803-27556
                        </p>
                    </x-mary-card>
                </div>
            </x-mary-card>

            <!-- Title Card -->
            <x-mary-card
                class="mb-8 bg-gradient-to-r from-violet-500 to-indigo-600 text-white"
            >
                <div class="py-6 text-center">
                    <h2 class="text-3xl font-bold">Laporan Hasil Ujian</h2>
                    <p class="mt-2 text-lg opacity-90">{{ $nama_ujian }}</p>
                </div>
            </x-mary-card>

            <!-- Student Info -->
            <x-mary-card
                class="hover:shadow-3xl mb-8 border-none bg-gradient-to-br from-violet-50 to-indigo-50 shadow-2xl transition-all duration-500"
            >
                <div class="relative">
                    <!-- Decorative Elements -->
                    <div
                        class="absolute -right-4 -top-4 h-24 w-24 rounded-full bg-violet-500/10 blur-xl"
                    ></div>
                    <div
                        class="absolute -bottom-4 -left-4 h-24 w-24 rounded-full bg-indigo-500/10 blur-xl"
                    ></div>

                    <!-- Content Grid -->
                    <div
                        class="relative z-10 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3"
                    >
                        <x-mary-stat
                            label="Nama Siswa"
                            value="{{$nama_siswa}}"
                            color="violet"
                            icon="o-user"
                            class="transform rounded-xl bg-white/50 shadow-lg backdrop-blur-sm transition-transform duration-300 hover:scale-105"
                        />
                        <x-mary-stat
                            label="Kelas"
                            value="{{$kelas_siswa}}"
                            color="violet"
                            icon="o-academic-cap"
                            class="transform rounded-xl bg-white/50 shadow-lg backdrop-blur-sm transition-transform duration-300 hover:scale-105"
                        />
                        <x-mary-stat
                            label="Tanggal Ujian"
                            value="{{$tanggal}}"
                            color="violet"
                            icon="o-calendar"
                            class="transform rounded-xl bg-white/50 shadow-lg backdrop-blur-sm transition-transform duration-300 hover:scale-105"
                        />
                        <x-mary-stat
                            label="Waktu Mulai"
                            value="{{$waktu_mulai}}"
                            color="violet"
                            icon="o-clock"
                            class="transform rounded-xl bg-white/50 shadow-lg backdrop-blur-sm transition-transform duration-300 hover:scale-105"
                        />
                        <x-mary-stat
                            label="Waktu Selesai"
                            value="{{$waktu_selesai}}"
                            color="violet"
                            icon="o-clock"
                            class="transform rounded-xl bg-white/50 shadow-lg backdrop-blur-sm transition-transform duration-300 hover:scale-105"
                        />
                        <x-mary-stat
                            label="Durasi"
                            value="{{$durasi ?? '-'}}"
                            color="violet"
                            icon="o-clock"
                            class="transform rounded-xl bg-white/50 shadow-lg backdrop-blur-sm transition-transform duration-300 hover:scale-105"
                        />
                    </div>
                </div>
            </x-mary-card>

            <!-- Score & Statistics -->
            <div class="mb-8 grid grid-cols-1 gap-6 lg:grid-cols-4">
                <!-- Nilai Akhir Card dengan efek glassmorphism -->
                <x-mary-card
                    class="relative overflow-hidden border border-white/20 shadow-2xl backdrop-blur-lg lg:col-span-1"
                    style="
                        background: linear-gradient(
                            135deg,
                            rgba(124, 58, 237, 0.9),
                            rgba(99, 102, 241, 0.9)
                        );
                    "
                >
                    <div
                        class="absolute right-0 top-0 -mr-16 -mt-16 h-32 w-32 rounded-full bg-violet-400/30 blur-2xl"
                    ></div>
                    <div
                        class="absolute bottom-0 left-0 -mb-16 -ml-16 h-32 w-32 rounded-full bg-indigo-400/30 blur-2xl"
                    ></div>

                    <div class="relative z-10 py-8 text-center">
                        <div class="mb-2">
                            <span class="text-lg font-medium text-white/80">
                                Nilai Akhir
                            </span>
                        </div>
                        <div class="mb-2 text-6xl font-black text-white">
                            {{ $nilai }}
                        </div>
                        <div class="flex justify-center">
                            <span
                                class="inline-flex items-center rounded-full bg-white/20 px-3 py-1 text-sm font-medium text-white"
                            >
                                <x-mary-icon
                                    name="o-sparkles"
                                    class="mr-1 h-4 w-4"
                                />
                                Hasil Ujian
                            </span>
                        </div>
                    </div>
                </x-mary-card>

                <!-- Statistik Card -->
                <x-mary-card
                    class="hover:shadow-3xl relative overflow-hidden border-2 border-violet-200/50 bg-white/30 shadow-2xl backdrop-blur-xl transition-all duration-500 lg:col-span-3"
                >
                    <!-- Decorative elements -->
                    <div
                        class="absolute -right-24 -top-24 h-48 w-48 animate-pulse rounded-full bg-violet-400/30 blur-3xl"
                    ></div>
                    <div
                        class="absolute -bottom-24 -left-24 h-48 w-48 animate-pulse rounded-full bg-indigo-400/30 blur-3xl"
                    ></div>

                    <div class="relative z-10 grid grid-cols-3 gap-8">
                        <!-- Total Soal -->
                        <div
                            class="group rounded-3xl border-2 border-violet-200/50 bg-gradient-to-br from-violet-50/90 to-violet-100/80 p-8 shadow-lg transition-all duration-500 hover:-translate-y-1 hover:shadow-2xl"
                        >
                            <x-mary-stat
                                label="Total Soal"
                                icon="o-document-text"
                                value="{{$total_soal}}"
                                color="violet"
                                class="transform transition-all duration-500 group-hover:scale-110"
                            />
                            <div
                                class="mt-2 h-1 w-0 bg-gradient-to-r from-violet-400 to-violet-600 transition-all duration-500 group-hover:w-full"
                            ></div>
                        </div>

                        <!-- Terjawab -->
                        <div
                            class="group rounded-3xl border-2 border-indigo-200/50 bg-gradient-to-br from-indigo-50/90 to-indigo-100/80 p-8 shadow-lg transition-all duration-500 hover:-translate-y-1 hover:shadow-2xl"
                        >
                            <x-mary-stat
                                label="Terjawab"
                                icon="o-check-circle"
                                value="{{$total_jawaban}}"
                                color="indigo"
                                class="transform transition-all duration-500 group-hover:scale-110"
                            />
                            <div
                                class="mt-2 h-1 w-0 bg-gradient-to-r from-indigo-400 to-indigo-600 transition-all duration-500 group-hover:w-full"
                            ></div>
                        </div>

                        <!-- Jawaban Benar -->
                        <div
                            class="group rounded-3xl border-2 border-blue-200/50 bg-gradient-to-br from-blue-50/90 to-blue-100/80 p-8 shadow-lg transition-all duration-500 hover:-translate-y-1 hover:shadow-2xl"
                        >
                            <x-mary-stat
                                label="Jawaban Benar"
                                icon="o-check-badge"
                                value="{{$total_benar ?? '-'}}"
                                color="blue"
                                class="transform transition-all duration-500 group-hover:scale-110"
                            />
                            <div
                                class="mt-2 h-1 w-0 bg-gradient-to-r from-blue-400 to-blue-600 transition-all duration-500 group-hover:w-full"
                            ></div>
                        </div>
                    </div>
                </x-mary-card>
            </div>

            <!-- Questions & Answers -->
            @foreach ($jawaban as $j)
                <x-mary-card class="mb-4">
                    <div
                        class="flex items-center justify-between border-b border-gray-100 pb-4"
                    >
                        <h3 class="text-lg font-semibold">
                            Soal {{ $j["nomor"] }}
                        </h3>
                        @if ($j["jenis_soal"] !== "essay")
                            @if ($j["is_correct"] === true)
                                <div
                                    class="flex items-center gap-2 rounded-xl bg-emerald-100 px-4 py-2 text-emerald-700"
                                >
                                    <x-mary-icon
                                        name="s-check-circle"
                                        class="h-5 w-5"
                                    />
                                    <span class="font-medium">
                                        Benar (+{{ $j["bobot"] }})
                                    </span>
                                </div>
                            @elseif ($j["is_correct"] === false)
                                <div
                                    class="flex items-center gap-2 rounded-xl bg-red-100 px-4 py-2 text-red-700"
                                >
                                    <x-mary-icon
                                        name="s-x-circle"
                                        class="h-5 w-5"
                                    />
                                    <span class="font-medium">Salah (0)</span>
                                </div>
                            @else
                                <div
                                    class="flex items-center gap-2 rounded-xl bg-amber-100 px-4 py-2 text-amber-700"
                                >
                                    <x-mary-icon
                                        name="s-clock"
                                        class="h-5 w-5"
                                    />
                                    <span class="font-medium">
                                        Belum Dinilai
                                    </span>
                                </div>
                            @endif
                        @endif
                    </div>

                    <div class="mt-4">
                        <div class="prose mb-4 max-w-none">
                            {!! $j["pertanyaan"] !!}
                        </div>

                        @if (isset($j["pilihan"]) && ($j["jenis_soal"] === "pilihan_ganda" || $j["jenis_soal"] === "multiple_choice"))
                            <div class="space-y-3">
                                @foreach ($j["pilihan"] as $key => $pilihan)
                                    @php
                                        $isSelected = in_array($key, (array) $j["jawaban_siswa"]);
                                        $isCorrect = in_array($key, (array) $j["kunci_jawaban"]);

                                        // Menentukan warna background dan border
                                        $bgColor = "bg-white";
                                        $borderColor = "border-gray-200";
                                        $textColor = "text-gray-700";

                                        if ($isSelected && $isCorrect) {
                                            $bgColor = "bg-emerald-50";
                                            $borderColor = "border-emerald-500";
                                            $textColor = "text-emerald-700";
                                        } elseif ($isSelected && ! $isCorrect) {
                                            $bgColor = "bg-red-50";
                                            $borderColor = "border-red-500";
                                            $textColor = "text-red-700";
                                        } elseif (! $isSelected && $isCorrect) {
                                            $bgColor = "bg-violet-50";
                                            $borderColor = "border-violet-500";
                                            $textColor = "text-violet-700";
                                        }
                                    @endphp

                                    <div
                                        class="{{ $bgColor }} {{ $borderColor }} {{ $textColor }} flex items-center rounded-lg border-2 p-4"
                                    >
                                        <div
                                            class="{{
                                                $isSelected
                                                    ? ($isCorrect
                                                        ? "bg-emerald-500 text-white"
                                                        : "bg-red-500 text-white")
                                                    : ($isCorrect
                                                        ? "bg-violet-500 text-white"
                                                        : "bg-gray-200 text-gray-700")
                                            }} mr-4 flex h-8 w-8 items-center justify-center rounded-full"
                                        >
                                            {{ chr(65 + $loop->index) }}
                                        </div>
                                        <div class="flex-1">
                                            {!! $pilihan !!}
                                        </div>
                                        @if ($isSelected)
                                            <div class="ml-4">
                                                @if ($isCorrect)
                                                    <x-mary-icon
                                                        name="s-check-circle"
                                                        class="h-6 w-6 text-emerald-500"
                                                    />
                                                @else
                                                    <x-mary-icon
                                                        name="s-x-circle"
                                                        class="h-6 w-6 text-red-500"
                                                    />
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <div class="mt-6 grid gap-6 md:grid-cols-2">
                        <!-- Jawaban Siswa -->
                        <div
                            class="{{
                                $j["is_correct"] === true
                                    ? "border-2 border-emerald-200 bg-emerald-50"
                                    : ($j["is_correct"] === false
                                        ? "border-2 border-red-200 bg-red-50"
                                        : "border-2 border-gray-200 bg-gray-50")
                            }} rounded-lg p-4"
                        >
                            <p
                                class="{{
                                    $j["is_correct"] === true
                                        ? "text-emerald-600"
                                        : ($j["is_correct"] === false
                                            ? "text-red-600"
                                            : "text-gray-600")
                                }} text-sm font-medium"
                            >
                                Jawaban Anda
                            </p>
                            <p class="mt-2">
                                {{ $j["jawaban_siswa"] ?? "Tidak dijawab" }}
                            </p>
                        </div>

                        <!-- Kunci Jawaban -->
                        <div
                            class="rounded-lg border-2 border-violet-200 bg-violet-50 p-4"
                        >
                            <p class="text-sm font-medium text-violet-600">
                                Kunci Jawaban
                            </p>
                            <p class="mt-2">
                                @if ($j["jenis_soal"] === "multiple_choice")
                                    {{ $j["kunci_jawaban"] }}
                                    <span class="text-xs text-violet-500">
                                        (Pilihan yang benar)
                                    </span>
                                @else
                                    {{ $j["kunci_jawaban"] }}
                                @endif
                            </p>
                        </div>

                        <!-- Pembahasan -->
                        @if (isset($j["pembahasan"]))
                            <div
                                class="rounded-lg border-2 border-blue-200 bg-blue-50 p-4 md:col-span-2"
                            >
                                <div class="mb-2 flex items-center gap-2">
                                    <x-mary-icon
                                        name="s-light-bulb"
                                        class="h-5 w-5 text-blue-500"
                                    />
                                    <p
                                        class="text-sm font-medium text-blue-600"
                                    >
                                        Pembahasan
                                    </p>
                                </div>
                                <div class="prose max-w-none">
                                    {!! $j["pembahasan"] !!}
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Catatan Perbaikan untuk Jawaban Salah -->
                    @if ($j["is_correct"] === false)
                        <div
                            class="mt-4 rounded-lg border-2 border-amber-200 bg-amber-50 p-4"
                        >
                            <div class="mb-2 flex items-center gap-2">
                                <x-mary-icon
                                    name="s-exclamation-circle"
                                    class="h-5 w-5 text-amber-500"
                                />
                                <p class="text-sm font-medium text-amber-700">
                                    Catatan Perbaikan
                                </p>
                            </div>
                            <p class="text-amber-600">
                                @if ($j["jenis_soal"] === "multiple_choice")
                                    Perhatikan bahwa soal ini memerlukan lebih
                                    dari satu jawaban yang benar. Jawaban yang
                                    benar adalah: {{ $j["kunci_jawaban"] }}
                                @else
                                    Jawaban Anda:
                                    {{ $j["jawaban_siswa"] ?? "Tidak dijawab" }}
                                    Jawaban yang benar:
                                    {{ $j["kunci_jawaban"] }}
                                @endif
                            </p>
                        </div>
                    @endif
                </x-mary-card>
            @endforeach

            <!-- Footer -->
            <x-mary-card class="mt-8">
                <h3 class="mb-6 text-2xl font-bold">Catatan Penting</h3>
                <div class="space-y-3">
                    <div class="flex items-center space-x-4 py-3">
                        <svg
                            class="h-6 w-6 text-gray-600"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5"
                            />
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm text-gray-600">
                                Nilai akhir yang Anda peroleh
                            </p>
                            <p class="font-medium">{{ $nilai }}</p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4 py-3">
                        <svg
                            class="h-6 w-6 text-gray-600"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V19.5a2.25 2.25 0 0 0 2.25 2.25h.75m0-3H12m-.75 3h3.75m-3.75 0V19.5m0 3h3.75M9 21h3.75m-3.75 0V19.5"
                            />
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm text-gray-600">Soal terjawab</p>
                            <p class="font-medium">
                                {{ $total_jawaban }} dari {{ $total_soal }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4 py-3">
                        <svg
                            class="h-6 w-6 text-gray-600"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                            />
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm text-gray-600">Jawaban benar</p>
                            <p class="font-medium">
                                {{ $total_benar ?? "-" }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4 py-3">
                        <svg
                            class="h-6 w-6 text-gray-600"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125"
                            />
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm text-gray-600">
                                Soal essay akan dikoreksi manual oleh guru
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-4 py-3">
                        <svg
                            class="h-6 w-6 text-gray-600"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25"
                            />
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm text-gray-600">
                                Hasil ini digenerate otomatis oleh sistem
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-8 text-right">
                    <p class="text-sm text-gray-500">
                        Dicetak pada: {{ now()->format("d F Y H:i") }}
                    </p>
                </div>
            </x-mary-card>
        </div>

        @livewireScripts
    </body>
</html>
