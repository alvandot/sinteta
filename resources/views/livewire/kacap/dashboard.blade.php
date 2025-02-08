<div>
    <div class="p-6">
        <!-- Welcome Section -->
        <div class="mb-10">
            <x-mary-card
                shadow
                class="transform overflow-hidden rounded-2xl border-none bg-gradient-to-br from-indigo-600 to-violet-600 transition-all hover:shadow-2xl"
            >
                <div
                    class="absolute right-0 top-0 -mr-32 -mt-32 h-64 w-64 rounded-full bg-white/10 blur-3xl"
                ></div>
                <div
                    class="absolute bottom-0 left-0 -mb-32 -ml-32 h-64 w-64 rounded-full bg-white/10 blur-3xl"
                ></div>
                <div class="relative flex items-center justify-between">
                    <div class="text-white">
                        <h2 class="text-4xl font-bold">Selamat Datang! 👋</h2>
                        <p class="mt-2 text-lg opacity-90">
                            {{ now()->isoFormat("dddd, D MMMM Y") }}
                        </p>
                    </div>
                    <div class="flex space-x-3">
                        <x-ts-button.circle
                            icon="bell"
                            color="white"
                            class="bg-white/20 shadow-xl backdrop-blur-sm transition-transform hover:scale-110"
                        />
                        <x-ts-button.circle
                            icon="cog-6-tooth"
                            color="white"
                            class="bg-white/20 shadow-xl backdrop-blur-sm transition-transform hover:scale-110"
                        />
                    </div>
                </div>
            </x-mary-card>
        </div>

        <!-- Quick Stats -->
        <div class="mb-10 grid grid-cols-1 gap-6 md:grid-cols-3">
            <x-ts-card
                shadow
                class="transform overflow-hidden rounded-xl border-none bg-gradient-to-br from-blue-600 to-cyan-500 transition-all hover:scale-105"
            >
                <div
                    class="absolute right-0 top-0 -mr-16 -mt-16 h-32 w-32 rounded-full bg-white/10 blur-2xl"
                ></div>
                <div class="relative text-white">
                    <div class="flex items-center justify-between">
                        <span class="text-5xl">👨‍🎓</span>
                        <span class="text-3xl font-bold">24</span>
                    </div>
                    <h3 class="mt-4 text-lg font-semibold">Total Siswa</h3>
                    <div class="mt-2 text-sm text-white/80">
                        +3 dari bulan lalu
                    </div>
                </div>
            </x-ts-card>

            <x-mary-card
                shadow
                class="transform overflow-hidden rounded-xl border-none bg-gradient-to-br from-emerald-600 to-green-500 transition-all hover:scale-105"
            >
                <div
                    class="absolute right-0 top-0 -mr-16 -mt-16 h-32 w-32 rounded-full bg-white/10 blur-2xl"
                ></div>
                <div class="relative text-white">
                    <div class="flex items-center justify-between">
                        <span class="text-5xl">👨‍🏫</span>
                        <span class="text-3xl font-bold">8</span>
                    </div>
                    <h3 class="mt-4 text-lg font-semibold">Total Pengajar</h3>
                    <div class="mt-2 text-sm text-white/80">
                        Semua aktif mengajar
                    </div>
                </div>
            </x-mary-card>

            <x-ts-card
                shadow
                class="transform overflow-hidden rounded-xl border-none bg-gradient-to-br from-amber-600 to-yellow-500 transition-all hover:scale-105"
            >
                <div
                    class="absolute right-0 top-0 -mr-16 -mt-16 h-32 w-32 rounded-full bg-white/10 blur-2xl"
                ></div>
                <div class="relative text-white">
                    <div class="flex items-center justify-between">
                        <span class="text-5xl">🏫</span>
                        <span class="text-3xl font-bold">6</span>
                    </div>
                    <h3 class="mt-4 text-lg font-semibold">
                        Ruangan Aktif
                        <x-ts-badge
                            text="{{ now()->locale('id')->isoFormat('dddd') }}"
                            icon="building-office"
                            position="right"
                        />
                    </h3>
                    <div class="mt-2 text-sm text-white/80">
                        Semua ruangan terpakai
                    </div>
                </div>
            </x-ts-card>
        </div>

        <!-- Jadwal -->
        <div class="grid grid-cols-1 gap-8">
            <x-mary-card
                shadow
                class="transform rounded-2xl border-none bg-gradient-to-br from-white to-indigo-50 transition-all hover:shadow-2xl"
            >
                <div class="mb-8 flex items-center justify-between">
                    <div>
                        <h3
                            class="bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-3xl font-bold text-transparent"
                        >
                            <span class="mr-3 inline-block">📅</span>
                            Jadwal Sesi Hari Ini
                        </h3>
                    </div>
                    <x-ts-button.circle
                        icon="calendar"
                        color="indigo"
                        class="shadow-xl transition-transform hover:scale-110"
                    />
                </div>

                <div class="space-y-4">
                    <div class="relative">
                        <div
                            class="absolute left-4 top-0 h-full w-0.5 bg-gradient-to-b from-indigo-500 via-violet-500 to-purple-500"
                        ></div>
                        <div class="space-y-8">
                            <div class="ml-10">
                                <div
                                    class="absolute -left-12 top-2 h-6 w-6 animate-pulse rounded-full bg-indigo-500 shadow-lg ring-4 ring-indigo-100"
                                ></div>
                                <x-ts-card
                                    class="border-l-4 border-indigo-500 transition-all hover:shadow-xl"
                                >
                                    <div
                                        class="flex items-center justify-between"
                                    >
                                        <span
                                            class="text-sm font-semibold text-indigo-600"
                                        >
                                            08:00 - 09:30
                                        </span>
                                        <span
                                            class="rounded-full bg-indigo-100 px-4 py-1.5 text-xs font-semibold text-indigo-700"
                                        >
                                            Sedang Berlangsung
                                        </span>
                                    </div>
                                    <h4
                                        class="mt-2 text-xl font-bold text-gray-800"
                                    >
                                        Matematika
                                    </h4>
                                    <div
                                        class="mt-2 flex items-center gap-2 text-gray-600"
                                    >
                                        <x-mary-icon
                                            name="o-map-pin"
                                            class="h-4 w-4"
                                        />
                                        <span>Ruang 201</span>
                                        <span class="text-gray-300">•</span>
                                        <x-mary-icon
                                            name="o-user"
                                            class="h-4 w-4"
                                        />
                                        <span>Pak Budi</span>
                                    </div>
                                </x-ts-card>
                            </div>

                            <div class="ml-10">
                                <div
                                    class="absolute -left-12 top-2 h-6 w-6 rounded-full bg-gray-300 shadow-lg ring-4 ring-gray-100"
                                ></div>
                                <x-mary-card
                                    class="transition-all hover:shadow-xl"
                                >
                                    <div
                                        class="flex items-center justify-between"
                                    >
                                        <span
                                            class="text-sm font-semibold text-gray-600"
                                        >
                                            10:00 - 11:30
                                        </span>
                                        <span
                                            class="rounded-full bg-gray-100 px-4 py-1.5 text-xs font-semibold text-gray-700"
                                        >
                                            Akan Datang
                                        </span>
                                    </div>
                                    <h4
                                        class="mt-2 text-xl font-bold text-gray-800"
                                    >
                                        Bahasa Inggris
                                    </h4>
                                    <div
                                        class="mt-2 flex items-center gap-2 text-gray-600"
                                    >
                                        <x-mary-icon
                                            name="o-map-pin"
                                            class="h-4 w-4"
                                        />
                                        <span>Ruang 302</span>
                                        <span class="text-gray-300">•</span>
                                        <x-mary-icon
                                            name="o-user"
                                            class="h-4 w-4"
                                        />
                                        <span>Mrs. Sarah</span>
                                    </div>
                                </x-mary-card>
                            </div>

                            <div class="ml-10">
                                <div
                                    class="absolute -left-12 top-2 h-6 w-6 rounded-full bg-gray-300 shadow-lg ring-4 ring-gray-100"
                                ></div>
                                <x-ts-card
                                    class="transition-all hover:shadow-xl"
                                >
                                    <div
                                        class="flex items-center justify-between"
                                    >
                                        <span
                                            class="text-sm font-semibold text-gray-600"
                                        >
                                            13:00 - 14:30
                                        </span>
                                        <span
                                            class="rounded-full bg-gray-100 px-4 py-1.5 text-xs font-semibold text-gray-700"
                                        >
                                            Akan Datang
                                        </span>
                                    </div>
                                    <h4
                                        class="mt-2 text-xl font-bold text-gray-800"
                                    >
                                        Fisika
                                    </h4>
                                    <div
                                        class="mt-2 flex items-center gap-2 text-gray-600"
                                    >
                                        <x-mary-icon
                                            name="o-map-pin"
                                            class="h-4 w-4"
                                        />
                                        <span>Ruang 103</span>
                                        <span class="text-gray-300">•</span>
                                        <x-mary-icon
                                            name="o-user"
                                            class="h-4 w-4"
                                        />
                                        <span>Pak Ahmad</span>
                                    </div>
                                </x-ts-card>
                            </div>

                            <div class="ml-10">
                                <div
                                    class="absolute -left-12 top-2 h-6 w-6 rounded-full bg-gray-300 shadow-lg ring-4 ring-gray-100"
                                ></div>
                                <x-mary-card
                                    class="transition-all hover:shadow-xl"
                                >
                                    <div
                                        class="flex items-center justify-between"
                                    >
                                        <span
                                            class="text-sm font-semibold text-gray-600"
                                        >
                                            15:00 - 16:30
                                        </span>
                                        <span
                                            class="rounded-full bg-gray-100 px-4 py-1.5 text-xs font-semibold text-gray-700"
                                        >
                                            Akan Datang
                                        </span>
                                    </div>
                                    <h4
                                        class="mt-2 text-xl font-bold text-gray-800"
                                    >
                                        Kimia
                                    </h4>
                                    <div
                                        class="mt-2 flex items-center gap-2 text-gray-600"
                                    >
                                        <x-mary-icon
                                            name="o-map-pin"
                                            class="h-4 w-4"
                                        />
                                        <span>Ruang Lab</span>
                                        <span class="text-gray-300">•</span>
                                        <x-mary-icon
                                            name="o-user"
                                            class="h-4 w-4"
                                        />
                                        <span>Bu Siti</span>
                                    </div>
                                </x-mary-card>
                            </div>
                        </div>
                    </div>
                </div>
            </x-mary-card>
        </div>
    </div>
</div>
