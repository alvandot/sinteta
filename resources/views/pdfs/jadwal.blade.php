<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>Jadwal Belajar</title>
        @livewireStyles
        @vite(["resources/css/app.css", "resources/js/app.js"])
        <style>
            .watermark {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%) rotate(-45deg);
                font-size: 100px;
                opacity: 0.1;
                z-index: -1;
                color: #4f46e5;
                font-weight: bold;
                white-space: nowrap;
                pointer-events: none;
            }
        </style>
    </head>
    <body class="bg-gradient-to-br from-gray-50 to-gray-100 p-4 font-sans">
        <!-- Watermark -->
        <div class="watermark">SINTETA</div>

        <!-- Header Section -->
        <div class="mb-6 flex flex-col items-center justify-center text-center">
            <div class="relative">
                <div
                    class="absolute -inset-1 rounded-lg bg-gradient-to-r from-indigo-500 to-purple-500 opacity-25 blur"
                ></div>
                <div class="relative rounded-xl bg-white px-6 py-3 shadow-xl">
                    <div class="mb-2 flex items-center justify-center gap-4">
                        <img
                            src="{{ public_path("images/logo.webp") }}"
                            alt="Logo"
                            class="h-16 w-16"
                        />
                        <div
                            class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-2xl font-bold text-transparent"
                        >
                            SINTETA Learning Center
                        </div>
                    </div>
                    <div>
                        <h1
                            class="mb-1 text-3xl font-black tracking-tight text-gray-900"
                        >
                            DAFTAR JADWAL BELAJAR
                        </h1>
                        <p class="text-base font-medium text-gray-600">
                            {{ \Carbon\Carbon::parse($tanggal)->isoFormat("dddd, D MMMM Y") }}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Info Card -->
        <div
            class="mb-4 rounded-2xl border border-gray-100 bg-white p-4 shadow-lg"
        >
            <div class="flex items-center gap-2">
                <svg
                    class="h-4 w-4 text-indigo-500"
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
                <span class="font-bold text-gray-700">Total Jadwal:</span>
                <span class="font-semibold text-indigo-600">
                    {{ count($jadwals) }} jadwal
                </span>
            </div>
        </div>

        <!-- Table -->
        <div
            class="mb-6 overflow-hidden rounded-2xl border border-gray-100 bg-white shadow-xl"
        >
            <table class="min-w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-indigo-500 to-purple-500">
                        <th
                            class="w-[5%] px-2 py-2 text-left text-xs font-semibold text-white"
                        >
                            No
                        </th>
                        <th
                            class="w-[15%] px-2 py-2 text-left text-xs font-semibold text-white"
                        >
                            Nama Jadwal
                        </th>
                        <th
                            class="w-[15%] px-2 py-2 text-left text-xs font-semibold text-white"
                        >
                            Mata Pelajaran
                        </th>
                        <th
                            class="w-[10%] px-2 py-2 text-left text-xs font-semibold text-white"
                        >
                            Tentor
                        </th>
                        <th
                            class="w-[15%] px-2 py-2 text-left text-xs font-semibold text-white"
                        >
                            Waktu
                        </th>
                        <th
                            class="w-[10%] px-2 py-2 text-left text-xs font-semibold text-white"
                        >
                            Ruangan
                        </th>
                        <th
                            class="w-[10%] px-2 py-2 text-left text-xs font-semibold text-white"
                        >
                            Kelas
                        </th>
                        <th
                            class="w-[10%] px-2 py-2 text-left text-xs font-semibold text-white"
                        >
                            Kapasitas
                        </th>
                        <th
                            class="w-[10%] px-2 py-2 text-left text-xs font-semibold text-white"
                        >
                            Status
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($jadwals as $jadwal)
                        <tr class="transition duration-150 hover:bg-gray-50">
                            <td class="px-2 py-2 text-xs text-gray-600">
                                {{ $loop->iteration }}
                            </td>
                            <td
                                class="px-2 py-2 text-xs font-medium text-gray-700"
                            >
                                {{ $jadwal->nama_jadwal }}
                            </td>
                            <td class="px-2 py-2 text-xs text-gray-600">
                                {{ $jadwal->mataPelajaran->nama_pelajaran }}
                            </td>
                            <td class="px-2 py-2 text-xs text-gray-600">
                                {{ $jadwal->tentor->user->name }}
                            </td>
                            <td class="px-2 py-2 text-xs text-gray-600">
                                {{ $jadwal->hari }}, {{ $jadwal->jam_mulai }}
                                - {{ $jadwal->jam_selesai }}
                            </td>
                            <td class="px-2 py-2 text-xs text-gray-600">
                                {{ $jadwal->ruangan }}
                            </td>
                            <td class="px-2 py-2 text-xs text-gray-600">
                                {{ $jadwal->kelas->nama_kelas }}
                            </td>
                            <td class="px-2 py-2 text-xs">
                                <span
                                    class="{{ $jadwal->status === "aktif" ? "bg-emerald-100 text-emerald-700" : "bg-red-100 text-red-700" }} inline-flex items-center rounded-full px-2 py-0.5 text-xs font-semibold"
                                >
                                    <span
                                        class="{{ $jadwal->status === "aktif" ? "bg-emerald-500" : "bg-red-500" }} mr-1 h-1 w-1 rounded-full"
                                    ></span>
                                    {{ ucfirst($jadwal->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td
                                colspan="9"
                                class="px-2 py-6 text-center text-gray-500"
                            >
                                <div
                                    class="flex flex-col items-center justify-center"
                                >
                                    <svg
                                        class="mb-2 h-8 w-8 text-gray-400"
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
                                    <p class="text-base font-medium">
                                        Tidak ada jadwal pada tanggal ini
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <div class="text-center text-sm text-gray-600">
            <p>SINTETA Learning Center</p>
            <p>{{ now()->isoFormat("D MMMM Y HH:mm") }}</p>
        </div>
    </body>
</html>
