<div class="min-h-screen bg-gray-100">
    <div class="mx-auto max-w-7xl px-6 py-8">
        <!-- Widgets -->
        <div class="mb-8 flex flex-wrap justify-center gap-6">
            <!-- Widget Hari -->
            <div
                class="rounded-2xl border-4 border-yellow-400 bg-white px-6 py-4 shadow-lg"
            >
                <div class="flex items-center gap-3">
                    <div class="rounded-full bg-yellow-100 p-3">
                        <x-mary-icon
                            name="o-calendar"
                            class="h-8 w-8 text-yellow-600"
                        />
                    </div>
                    <div>
                        <p class="text-sm font-medium text-yellow-600">
                            Hari Ini
                        </p>
                        <h3
                            class="text-2xl font-bold text-gray-800"
                            x-data
                            x-init="$el.textContent = new Date().toLocaleDateString('id-ID', { weekday: 'long' })"
                        ></h3>
                    </div>
                </div>
            </div>

            <!-- Widget Jam -->
            <div
                class="rounded-2xl border-4 border-blue-400 bg-white px-6 py-4 shadow-lg"
            >
                <div class="flex items-center gap-3">
                    <div class="rounded-full bg-blue-100 p-3">
                        <x-mary-icon
                            name="o-clock"
                            class="h-8 w-8 text-blue-600"
                        />
                    </div>
                    <div>
                        <p class="text-sm font-medium text-blue-600">Waktu</p>
                        <h3
                            class="text-2xl font-bold text-gray-800"
                            x-data
                            x-init="
                                setInterval(
                                    () => ($el.textContent = new Date().toLocaleTimeString('id-ID')),
                                    1000,
                                )
                            "
                        ></h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Header Section -->
        <div class="relative mb-12 text-center">
            <div class="absolute inset-0 -z-10">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-yellow-200 via-pink-200 to-blue-200 opacity-30"
                ></div>
            </div>
            <h1 class="font-comic text-5xl font-black text-gray-800">
                📚 Jadwal Belajarku 📚
            </h1>
            <p class="mt-3 text-xl font-medium text-gray-600">
                Yuk lihat jadwal belajar kita hari ini! 🎯
            </p>
        </div>

        <!-- Search Bar -->
        <div class="relative mb-8">
            <x-ts-input
                wire:model.debounce.300ms="search"
                icon="magnifying-glass"
                placeholder="Cari jadwal pelajaranmu di sini..."
                class="w-full rounded-full border-4 border-purple-300 bg-white/90 px-6 py-4 text-lg transition-all duration-300 focus:border-purple-400 focus:ring-4 focus:ring-purple-200"
            />
        </div>

        <!-- Jadwal Cards -->
        <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($jadwalPelajarans as $jadwal)
                <div
                    class="relative transform rounded-3xl border-4 border-pink-400 bg-white shadow-xl transition-all duration-300 hover:scale-105 hover:border-purple-400"
                >
                    <div class="p-6">
                        <!-- Header -->
                        <div class="mb-6 flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div
                                    class="flex h-14 w-14 items-center justify-center rounded-full bg-gradient-to-br from-pink-400 to-purple-500"
                                >
                                    <x-mary-icon
                                        name="o-academic-cap"
                                        class="h-8 w-8 text-white"
                                    />
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800">
                                        {{ $jadwal->mataPelajaran->nama_pelajaran }}
                                    </h3>
                                    <span
                                        class="text-lg font-medium text-purple-600"
                                    >
                                        Kelas {{ $jadwal->kelasBimbel->kelas }}
                                    </span>
                                </div>
                            </div>
                            <div
                                class="flex h-12 w-12 items-center justify-center rounded-full bg-yellow-100"
                            >
                                <span class="text-lg font-bold text-yellow-600">
                                    #{{ $loop->iteration }}
                                </span>
                            </div>
                        </div>

                        <!-- Info Cards -->
                        <div class="space-y-4">
                            <div
                                class="flex items-center gap-4 rounded-xl bg-blue-50 p-4"
                            >
                                <x-mary-icon
                                    name="o-calendar"
                                    class="h-8 w-8 text-blue-500"
                                />
                                <div>
                                    <p
                                        class="text-sm font-medium text-blue-600"
                                    >
                                        Hari
                                    </p>
                                    <p class="text-lg font-bold text-gray-800">
                                        {{ $jadwal->hari }}
                                    </p>
                                </div>
                            </div>

                            <div
                                class="flex items-center gap-4 rounded-xl bg-green-50 p-4"
                            >
                                <x-mary-icon
                                    name="o-clock"
                                    class="h-8 w-8 text-green-500"
                                />
                                <div>
                                    <p
                                        class="text-sm font-medium text-green-600"
                                    >
                                        Waktu
                                    </p>
                                    <p class="text-lg font-bold text-gray-800">
                                        {{ $jadwal->jam_mulai }} -
                                        {{ $jadwal->jam_selesai }}
                                    </p>
                                </div>
                            </div>

                            <div
                                class="flex items-center gap-4 rounded-xl bg-purple-50 p-4"
                            >
                                <x-mary-icon
                                    name="o-building-office-2"
                                    class="h-8 w-8 text-purple-500"
                                />
                                <div>
                                    <p
                                        class="text-sm font-medium text-purple-600"
                                    >
                                        Ruangan
                                    </p>
                                    <p class="text-lg font-bold text-gray-800">
                                        {{ $jadwal->ruangan->nama }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Decorative Elements -->
                        <div class="absolute -right-2 -top-2">
                            <div
                                class="h-6 w-6 animate-bounce rounded-full bg-yellow-400"
                            ></div>
                        </div>
                        <div class="absolute -bottom-2 -left-2">
                            <div
                                class="h-6 w-6 animate-bounce rounded-full bg-pink-400 delay-150"
                            ></div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div
                        class="rounded-3xl border-4 border-blue-300 bg-white p-12 text-center shadow-xl"
                    >
                        <div class="flex flex-col items-center justify-center">
                            <div
                                class="mb-6 flex h-24 w-24 items-center justify-center rounded-full bg-blue-100"
                            >
                                <x-mary-icon
                                    name="o-calendar"
                                    class="h-14 w-14 text-blue-500"
                                />
                            </div>
                            <h3 class="mb-4 text-2xl font-bold text-gray-800">
                                Belum Ada Jadwal 📚
                            </h3>
                            <p class="text-lg text-gray-600">
                                Sepertinya jadwal belajarmu masih kosong nih! 🤔
                            </p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $jadwalPelajarans->links() }}
        </div>
    </div>
</div>
