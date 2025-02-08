<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Daftar Ujian</title>
        @livewireStyles
        @vite(["resources/css/app.css", "resources/js/app.js"])
        <style>
            .watermark {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%) rotate(-45deg);
                font-size: 200px;
                opacity: 0.05;
                z-index: -1;
                color: var(--mary-primary);
                font-weight: bold;
                white-space: nowrap;
                pointer-events: none;
                width: 100%;
                height: 100%;
                display: flex;
                align-items: center;
                justify-content: center;
                overflow: hidden;
                text-transform: uppercase;
                letter-spacing: 0.5em;
                line-height: 1;
                text-align: center;
            }

            @page {
                margin: 0;
            }
        </style>
    </head>
    <body class="mary-bg-surface min-h-screen">
        <!-- Watermark -->
        <div class="watermark">SINTETA</div>

        <!-- Header Section -->
        <div class="mb-8 flex flex-col items-center justify-center text-center">
            <div class="relative w-full max-w-4xl">
                <div
                    class="absolute -inset-1 rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 opacity-25 blur"
                ></div>
                <div class="relative rounded-xl bg-white px-8 py-6 shadow-2xl">
                    <div class="mb-4 flex items-center justify-center gap-6">
                        <img
                            src="{{ public_path("images/logo.webp") }}"
                            alt="Logo"
                            class="h-24 w-24"
                        />
                        <div>
                            <h1
                                class="mb-2 text-3xl font-black tracking-tight text-gray-900"
                            >
                                DAFTAR UJIAN
                            </h1>
                            <div
                                class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-xl font-bold text-transparent"
                            >
                                SINTETA Learning Center
                            </div>
                            <p class="mt-2 text-lg font-medium text-gray-600">
                                {{ \Carbon\Carbon::parse($tanggal)->isoFormat("dddd, D MMMM Y") }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Card -->
        <div
            class="mb-6 rounded-2xl border border-gray-200 bg-white p-6 shadow-xl"
        >
            <div class="flex items-center gap-3">
                <svg
                    class="h-5 w-5 text-indigo-600"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                </svg>
                <span class="text-lg font-bold text-gray-800">
                    Total Ujian:
                </span>
                <span class="text-lg font-bold text-indigo-600">
                    {{ $ujians->count() }} ujian
                </span>
            </div>
        </div>

        <!-- Table -->
        <div
            class="mb-8 overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-2xl"
        >
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-indigo-600 to-purple-600">
                        <th
                            class="w-[5%] px-4 py-3 text-left text-sm font-bold text-white"
                        >
                            No
                        </th>
                        <th
                            class="w-[20%] px-4 py-3 text-left text-sm font-bold text-white"
                        >
                            Nama Ujian
                        </th>
                        <th
                            class="w-[15%] px-4 py-3 text-left text-sm font-bold text-white"
                        >
                            Mata Pelajaran
                        </th>
                        <th
                            class="w-[15%] px-4 py-3 text-left text-sm font-bold text-white"
                        >
                            Tentor
                        </th>
                        <th
                            class="w-[15%] px-4 py-3 text-left text-sm font-bold text-white"
                        >
                            Waktu Mulai
                        </th>
                        <th
                            class="w-[10%] px-4 py-3 text-left text-sm font-bold text-white"
                        >
                            Durasi
                        </th>
                        <th
                            class="w-[10%] px-4 py-3 text-left text-sm font-bold text-white"
                        >
                            Peserta
                        </th>
                        <th
                            class="w-[10%] px-4 py-3 text-left text-sm font-bold text-white"
                        >
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($ujians as $ujian)
                        <tr class="transition duration-150 hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-700">
                                {{ $loop->iteration }}
                            </td>
                            <td
                                class="px-4 py-3 text-sm font-medium text-gray-800"
                            >
                                {{ $ujian->nama }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                {{ $ujian->daftarUjianSiswa->first()->mataPelajaran->nama_pelajaran ?? "-" }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                {{ $ujian->daftarUjianSiswa->first()->tentor->user->name ?? "-" }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                {{ $ujian->waktu_mulai->format("d M Y H:i") }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                {{ $ujian->durasi }} Menit
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                {{ $ujian->daftarUjianSiswa->count() }}
                            </td>
                            <td class="px-4 py-3 text-sm">
                                <span
                                    class="{{ $ujian->status === "published" ? "bg-emerald-100 text-emerald-800" : "bg-red-100 text-red-800" }} inline-flex items-center rounded-full px-3 py-1 text-sm font-semibold"
                                >
                                    <span
                                        class="{{ $ujian->status === "published" ? "bg-emerald-500" : "bg-red-500" }} mr-2 h-1.5 w-1.5 rounded-full"
                                    ></span>
                                    {{ ucfirst($ujian->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td
                                colspan="8"
                                class="px-4 py-8 text-center text-gray-500"
                            >
                                <div
                                    class="flex flex-col items-center justify-center"
                                >
                                    <svg
                                        class="mb-3 h-12 w-12 text-gray-400"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                        />
                                    </svg>
                                    <p class="text-lg font-medium">
                                        Tidak ada data ujian pada periode ini
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <div class="text-center text-gray-700">
            <p class="text-base font-medium">SINTETA Learning Center</p>
            <p class="text-sm">{{ now()->isoFormat("D MMMM Y HH:mm") }}</p>
        </div>
    </body>
</html>
