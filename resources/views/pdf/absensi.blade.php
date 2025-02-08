<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Laporan Absensi</title>

        @livewireStyles
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireScripts

        <style>
            body {
                font-family: Arial, sans-serif;
                font-size: 12px;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-top: 10px;
            }
            th, td {
                border: 1px solid #ddd;
                padding: 8px;
                text-align: left;
            }
            th {
                background-color: #f2f2f2;
            }
            .header {
                margin-bottom: 20px;
            }
            .filter-info {
                margin-bottom: 10px;
                font-size: 11px;
            }
        </style>
    </head>
    <body class="bg-gray-50 p-8">
        <!-- Header -->
        <div class="mb-12 text-center">
            <div class="relative mb-6">
                <div class="absolute -inset-1 rounded-lg bg-gradient-to-r from-violet-600 to-fuchsia-600 opacity-25 blur"></div>
                <div class="relative flex items-center justify-center rounded-lg bg-white p-4">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo SINTETA" class="h-24 w-auto drop-shadow-lg">
                </div>
            </div>
            <div class="space-y-4">
                <h1 class="bg-gradient-to-r from-violet-600 to-fuchsia-600 bg-clip-text text-4xl font-extrabold text-transparent">
                    LAPORAN ABSENSI SISWA
                </h1>
                <div class="inline-flex items-center rounded-full bg-gradient-to-r from-violet-100 to-fuchsia-100 px-6 py-2">
                    <span class="mr-2 text-lg font-medium text-gray-700">Periode:</span>
                    <span class="text-lg font-bold text-violet-700">{{ $start_date }} - {{ $end_date }}</span>
                </div>
                <p class="text-xl font-semibold text-gray-700">
                    Bimbingan Belajar SINTETA
                </p>
            </div>
        </div>

        @if($filterInfo)
            <!-- Info Card -->
            <div class="mb-6 rounded-xl bg-gradient-to-br from-violet-50 to-violet-100 p-4 shadow-sm">
                <div class="flex items-center gap-2">
                    <x-mary-icon name="o-information-circle" class="h-5 w-5 text-violet-500" />
                    <span class="font-bold text-gray-700">Filter yang diterapkan:</span>
                    <span class="font-semibold text-violet-600">{{ $filterInfo }}</span>
                </div>
            </div>
        @endif

        <!-- Summary Card -->
        <div class="mb-6 rounded-xl bg-gradient-to-br from-violet-50 to-violet-100 p-4 shadow-sm">
            <h3 class="mb-4 text-lg font-semibold text-gray-900">Ringkasan Absensi</h3>
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div class="flex items-center gap-2">
                    <x-mary-icon name="o-document-text" class="h-5 w-5 text-violet-500" />
                    <span class="font-bold text-gray-700">Total Data:</span>
                    <span class="font-semibold text-violet-600">{{ $absensiList->total() }}</span>
                </div>
                <div class="flex flex-wrap gap-3">
                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-emerald-100 text-emerald-800">
                        <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                        Hadir: {{ $absensiList->where('status', 'hadir')->count() }}
                    </span>
                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-yellow-100 text-yellow-800">
                        <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-yellow-500"></span>
                        Izin: {{ $absensiList->where('status', 'izin')->count() }}
                    </span>
                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-blue-100 text-blue-800">
                        <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-blue-500"></span>
                        Sakit: {{ $absensiList->where('status', 'sakit')->count() }}
                    </span>
                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium bg-red-100 text-red-800">
                        <span class="mr-1.5 h-1.5 w-1.5 rounded-full bg-red-500"></span>
                        Alpha: {{ $absensiList->where('status', 'alpha')->count() }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="mb-8 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-lg">
            <table class="w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-violet-600 to-fuchsia-600">
                        <th class="px-4 py-3 text-left text-sm font-semibold text-white">No</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-white">Tanggal</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-white">Siswa</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-white">Tentor</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-white">Mata Pelajaran</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-white">Status</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-white">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($absensiList as $index => $absensi)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $absensi->tanggal->format('d/m/Y') }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $absensi->siswa->nama_lengkap }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $absensi->tentor->name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $absensi->mataPelajaran->nama_pelajaran }}</td>
                            <td class="px-4 py-3 text-sm">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ match($absensi->status) {
                                    'hadir' => 'bg-emerald-100 text-emerald-800',
                                    'izin' => 'bg-yellow-100 text-yellow-800',
                                    'sakit' => 'bg-blue-100 text-blue-800',
                                    'alpha' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-100 text-gray-800'
                                } }}">
                                    <span class="mr-1.5 h-1.5 w-1.5 rounded-full {{ match($absensi->status) {
                                        'hadir' => 'bg-emerald-500',
                                        'izin' => 'bg-yellow-500',
                                        'sakit' => 'bg-blue-500',
                                        'alpha' => 'bg-red-500',
                                        default => 'bg-gray-500'
                                    } }}"></span>
                                    {{ ucfirst($absensi->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $absensi->keterangan ?: '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <x-mary-icon name="o-document" class="h-12 w-12 text-gray-300"/>
                                    <span class="mt-2 font-medium">Tidak ada data absensi</span>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <div class="text-center text-sm text-gray-500">
            <p class="mb-1">Dicetak pada {{ now()->isoFormat('D MMMM Y HH:mm:ss') }}</p>
            <p>© {{ date('Y') }} CBT SINTETA - Sistem Informasi Bimbingan Belajar</p>
            <p class="mt-4">Halaman {{ $absensiList->currentPage() }} dari {{ $absensiList->lastPage() }}</p>
        </div>
    </body>
</html>
