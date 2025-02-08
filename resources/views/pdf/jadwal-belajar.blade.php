<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Jadwal Belajar</title>

        @livewireStyles
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @livewireScripts
    </head>
    <body class="bg-gray-50 p-8">
        <!-- Header -->
        <div class="mb-8 text-center">
            <h1 class="mb-2 text-3xl font-bold text-gray-900">Daftar Jadwal Belajar</h1>
            <p class="text-lg text-gray-600">{{ now()->isoFormat('D MMMM Y') }}</p>
        </div>

        <!-- Info Card -->
        <div class="mb-6 rounded-xl bg-gradient-to-br from-violet-50 to-violet-100 p-4 shadow-sm">
            <div class="flex items-center gap-2">
                <x-mary-icon name="o-information-circle" class="h-5 w-5 text-violet-500" />
                <span class="font-bold text-gray-700">Total Jadwal:</span>
                <span class="font-semibold text-violet-600">{{ count($jadwals) }} jadwal</span>
            </div>
        </div>

        <!-- Table -->
        <div class="mb-8 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-lg">
            <table class="w-full">
                <thead>
                    <tr class="bg-gradient-to-r from-violet-600 to-fuchsia-600">
                        <th class="px-4 py-3 text-left text-sm font-semibold text-white">No</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-white">Nama Jadwal</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-white">Mata Pelajaran</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-white">Hari</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-white">Waktu</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-white">Ruangan</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-white">Tentor</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold text-white">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($jadwals as $jadwal)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $loop->iteration }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $jadwal->nama_jadwal }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $jadwal->mataPelajaran->nama_pelajaran }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $jadwal->hari }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">
                                {{ $jadwal->jam_mulai }} - {{ $jadwal->jam_selesai }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $jadwal->ruangan }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $jadwal->tentor->user->name }}</td>
                            <td class="px-4 py-3 text-sm">
                                <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $jadwal->status === 'aktif' ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">
                                    <span class="mr-1.5 h-1.5 w-1.5 rounded-full {{ $jadwal->status === 'aktif' ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                                    {{ ucfirst($jadwal->status) }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Footer -->
        <div class="text-center text-sm text-gray-500">
            <p class="mb-1">Dicetak pada {{ now()->isoFormat('D MMMM Y HH:mm:ss') }}</p>
            <p>© {{ date('Y') }} CBT SINTETA - Sistem Informasi Bimbingan Belajar</p>
        </div>
    </body>
</html>
