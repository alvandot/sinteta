<div
    class="min-h-screen bg-gradient-to-br from-red-50 via-orange-50 to-yellow-50"
>
    <div class="mx-auto max-w-7xl px-6 py-8">
        <!-- Header Section -->
        <div class="relative mb-12 text-center">
            <h1
                class="bg-gradient-to-r from-red-600 via-orange-600 to-yellow-600 bg-clip-text text-5xl font-black tracking-tight text-transparent drop-shadow-xl"
            >
                Riwayat Pembelajaran
            </h1>
            <p class="mt-3 text-lg font-medium text-gray-600/80">
                Daftar jadwal pembelajaran yang telah selesai
            </p>
            <div
                class="absolute -bottom-4 left-1/2 h-1.5 w-24 -translate-x-1/2 transform rounded-full bg-gradient-to-r from-red-500 via-orange-500 to-yellow-500"
            ></div>
        </div>

        <!-- Search Bar -->
        <div class="relative mb-8">
            <input
                wire:model.debounce.300ms="search"
                type="text"
                class="w-full rounded-xl border border-orange-100 bg-white/70 px-6 py-3 pl-12 text-base backdrop-blur-sm transition-all duration-300 focus:border-transparent focus:outline-none focus:ring-2 focus:ring-orange-400"
                placeholder="Cari riwayat berdasarkan mata pelajaran, ruangan, atau kelas..."
            />
            <x-mary-icon
                name="o-magnifying-glass"
                class="absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 transform text-gray-400"
            />
        </div>

        <!-- Riwayat Table -->
        <div
            class="overflow-hidden rounded-2xl border-2 border-orange-200 bg-white/80 shadow-xl backdrop-blur-sm"
        >
            <table class="min-w-full divide-y divide-orange-100">
                <thead
                    class="bg-gradient-to-r from-red-50/80 via-orange-50/80 to-yellow-50/80 backdrop-blur-sm"
                >
                    <tr>
                        <th scope="col" class="px-6 py-4 text-left">
                            <div
                                class="flex cursor-pointer items-center gap-2 transition-all duration-300 hover:text-orange-600"
                                wire:click="sortBy('created_at')"
                            >
                                <span
                                    class="text-sm font-bold uppercase tracking-wider text-gray-600"
                                >
                                    Tanggal Selesai
                                </span>
                                <x-mary-icon
                                    name="{{ $sortField === 'created_at' ? ($sortDirection === 'asc' ? 'o-chevron-up' : 'o-chevron-down') : 'o-chevron-up-down' }}"
                                    class="h-4 w-4 text-orange-400"
                                />
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-4 text-left">
                            <span
                                class="text-sm font-bold uppercase tracking-wider text-gray-600"
                            >
                                Mata Pelajaran
                            </span>
                        </th>
                        <th scope="col" class="px-6 py-4 text-left">
                            <span
                                class="text-sm font-bold uppercase tracking-wider text-gray-600"
                            >
                                Ruangan
                            </span>
                        </th>
                        <th scope="col" class="px-6 py-4 text-left">
                            <span
                                class="text-sm font-bold uppercase tracking-wider text-gray-600"
                            >
                                Kelas
                            </span>
                        </th>
                        <th scope="col" class="px-6 py-4 text-left">
                            <span
                                class="text-sm font-bold uppercase tracking-wider text-gray-600"
                            >
                                Tentor
                            </span>
                        </th>
                        <th scope="col" class="px-6 py-4 text-left">
                            <span
                                class="text-sm font-bold uppercase tracking-wider text-gray-600"
                            >
                                Waktu
                            </span>
                        </th>
                        <th scope="col" class="px-6 py-4 text-left">
                            <span
                                class="text-sm font-bold uppercase tracking-wider text-gray-600"
                            >
                                Status
                            </span>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-orange-100 bg-white/50">
                    @forelse ($riwayatJadwal as $jadwal)
                        <tr
                            class="transition-all duration-300 hover:bg-orange-50/80 hover:shadow-md"
                        >
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="rounded-full bg-orange-100 p-2">
                                        <x-mary-icon
                                            name="o-calendar"
                                            class="h-4 w-4 text-orange-600"
                                        />
                                    </div>
                                    <div
                                        class="text-sm font-medium text-gray-900"
                                    >
                                        {{ $jadwal->created_at->format("d M Y") }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div
                                    class="text-sm font-semibold text-gray-900"
                                >
                                    {{ $jadwal->MataPelajaran->nama_pelajaran }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <x-mary-icon
                                        name="o-building-office-2"
                                        class="h-4 w-4 text-gray-400"
                                    />
                                    <div class="text-sm text-gray-900">
                                        {{ $jadwal->ruangan->nama }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div
                                    class="inline-flex rounded-full bg-yellow-100 px-3 py-1"
                                >
                                    <div
                                        class="text-sm font-medium text-yellow-800"
                                    >
                                        {{ $jadwal->kelasBimbel->nama_kelas }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div
                                        class="h-8 w-8 rounded-full bg-purple-100 p-1"
                                    >
                                        <x-mary-icon
                                            name="o-user"
                                            class="h-6 w-6 text-purple-600"
                                        />
                                    </div>
                                    <div
                                        class="text-sm font-medium text-gray-900"
                                    >
                                        {{ $jadwal->tentor->user->name }}
                                    </div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <x-mary-icon
                                        name="o-clock"
                                        class="h-4 w-4 text-blue-500"
                                    />
                                    <div
                                        class="text-sm font-medium text-gray-900"
                                    >
                                        {{ $jadwal->jam_mulai }} -
                                        {{ $jadwal->jam_selesai }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center gap-1 rounded-full bg-green-100 px-3 py-1 text-sm font-semibold text-green-800"
                                >
                                    <span
                                        class="h-2 w-2 rounded-full bg-green-500"
                                    ></span>
                                    Selesai
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center">
                                <div
                                    class="flex flex-col items-center justify-center space-y-4"
                                >
                                    <div class="rounded-full bg-orange-100 p-6">
                                        <x-mary-icon
                                            name="o-clock"
                                            class="h-12 w-12 animate-pulse text-orange-400"
                                        />
                                    </div>
                                    <h3 class="text-xl font-bold text-gray-900">
                                        Tidak ada riwayat
                                    </h3>
                                    <p class="max-w-sm text-gray-500">
                                        Belum ada jadwal pembelajaran yang
                                        selesai. Setelah kamu menyelesaikan
                                        pembelajaran, riwayatnya akan muncul di
                                        sini.
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $riwayatJadwal->links() }}
        </div>
    </div>
</div>
