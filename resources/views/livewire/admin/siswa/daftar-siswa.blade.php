<div class="min-h-screen bg-gray-100">
    <div class="mx-auto max-w-7xl px-6 py-8">
        <!-- Widgets -->
        <div class="mb-8 flex flex-wrap justify-center gap-6">
            <!-- Widget Total Siswa -->
            <div
                class="rounded-2xl border-4 border-violet-400 bg-white px-6 py-4 shadow-lg"
            >
                <div class="flex items-center gap-3">
                    <div class="rounded-full bg-violet-100 p-3">
                        <x-mary-icon
                            name="o-users"
                            class="h-8 w-8 text-violet-600"
                        />
                    </div>
                    <div>
                        <p class="text-sm font-medium text-violet-600">
                            Total Siswa
                        </p>
                        <h3 class="text-2xl font-bold text-gray-800">
                            {{ $siswa->total() }}
                        </h3>
                    </div>
                </div>
            </div>

            <!-- Widget Status Aktif -->
            <div
                class="rounded-2xl border-4 border-fuchsia-400 bg-white px-6 py-4 shadow-lg"
            >
                <div class="flex items-center gap-3">
                    <div class="rounded-full bg-fuchsia-100 p-3">
                        <x-mary-icon
                            name="o-check-circle"
                            class="h-8 w-8 text-fuchsia-600"
                        />
                    </div>
                    <div>
                        <p class="text-sm font-medium text-fuchsia-600">
                            Status Aktif
                        </p>
                        <h3 class="text-2xl font-bold text-gray-800">
                            {{ $siswa->where("status", "aktif")->count() }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Header Section -->
        <div class="relative mb-12 text-center">
            <div class="absolute inset-0 -z-10">
                <div
                    class="absolute inset-0 bg-gradient-to-r from-violet-200 via-fuchsia-200 to-pink-200 opacity-30"
                ></div>
            </div>
            <h1 class="font-comic text-5xl font-black text-gray-800">
                👨‍🎓 Daftar Siswa 👩‍🎓
            </h1>
            <p class="mt-3 text-xl font-medium text-gray-600">
                Kelola data siswa bimbingan belajar dengan mudah! 📚
            </p>
        </div>

        <!-- Control Panel -->
        <div class="mb-6">
            <x-mary-card
                shadow
                class="rounded-3xl border-none bg-gradient-to-br from-gray-100 to-slate-200 backdrop-blur-lg"
            >
                <div
                    class="flex flex-wrap items-center justify-between gap-4 p-4"
                >
                    <!-- Search & Filter Section -->
                    <div class="flex flex-grow flex-wrap items-center gap-4">
                        <div class="min-w-[200px] flex-1">
                            <x-mary-input
                                wire:model.live.debounce="search"
                                placeholder="Cari siswa..."
                                icon="o-magnifying-glass"
                                class="w-full"
                            />
                        </div>
                        <div class="min-w-[200px] flex-1">
                            <x-mary-select
                                wire:model.live="selectedKelasBimbel"
                                :options="$kelasBimbelOptions"
                                option-label="nama_kelas"
                                option-value="id"
                                placeholder="Filter Kelas Bimbel"
                            />
                        </div>
                    </div>

                    <!-- Export Button -->
                    <div>
                        <x-mary-button
                            wire:click="exportToExcel"
                            :disabled="!$selectedKelasBimbel"
                            class="bg-gradient-to-r from-emerald-500 to-green-500 text-white transition-all duration-300 hover:scale-105 disabled:cursor-not-allowed disabled:opacity-50"
                        >
                            <x-mary-icon
                                name="o-document-arrow-down"
                                class="mr-2 h-5 w-5"
                            />
                            {{ $selectedKelasBimbel ? "Export Excel" : "Pilih Kelas Dulu" }}
                        </x-mary-button>
                    </div>
                </div>
            </x-mary-card>
        </div>

        <!-- Siswa Cards -->
        <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($siswa as $s)
                <div
                    wire:click="redirectToDetail({{ $s->id }})"
                    class="relative transform cursor-pointer rounded-3xl border-4 border-violet-400 bg-white shadow-xl transition-all duration-300 hover:scale-105 hover:cursor-pointer hover:border-fuchsia-400"
                >
                    <div class="p-6">
                        <!-- Header -->
                        <div class="mb-6 flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="relative flex-shrink-0">
                                    @if ($s->foto)
                                        <img
                                            src="{{ Storage::url($s->foto) }}"
                                            alt="{{ $s->nama_lengkap }}"
                                            class="h-14 w-14 rounded-full object-cover ring-4 ring-violet-200"
                                        />
                                    @else
                                        <div
                                            class="flex h-14 w-14 items-center justify-center rounded-full bg-gradient-to-br from-violet-400 to-fuchsia-500 ring-4 ring-violet-200"
                                        >
                                            <span
                                                class="text-xl font-bold text-white"
                                            >
                                                {{ substr($s->nama_lengkap, 0, 1) }}
                                            </span>
                                        </div>
                                    @endif

                                    <div class="absolute -bottom-1 -right-1">
                                        @if ($s->status === "aktif")
                                            <div
                                                class="h-4 w-4 rounded-full bg-green-400 ring-2 ring-white"
                                                title="Aktif"
                                            ></div>
                                        @elseif ($s->status === "nonaktif")
                                            <div
                                                class="h-4 w-4 rounded-full bg-red-400 ring-2 ring-white"
                                                title="Nonaktif"
                                            ></div>
                                        @else
                                            <div
                                                class="h-4 w-4 rounded-full bg-gray-400 ring-2 ring-white"
                                                title="Pending"
                                            ></div>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800">
                                        {{ $s->nama_lengkap }}
                                    </h3>
                                    <p class="text-md text-fuchsia-600">
                                        {{ $s->email }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Info Cards -->
                        <div class="space-y-4">
                            <div
                                class="flex items-center gap-4 rounded-xl bg-violet-50 p-4"
                            >
                                <x-mary-icon
                                    name="o-academic-cap"
                                    class="h-8 w-8 text-violet-500"
                                />
                                <div>
                                    <p
                                        class="text-sm font-medium text-violet-600"
                                    >
                                        Kelas Bimbel
                                    </p>
                                    <p class="text-lg font-bold text-gray-800">
                                        {{ $s->kelasBimbel->nama_kelas ?? "Belum ada kelas" }}
                                    </p>
                                </div>
                            </div>

                            <div
                                class="flex items-center gap-4 rounded-xl bg-fuchsia-50 p-4"
                            >
                                <x-mary-icon
                                    name="o-book-open"
                                    class="h-8 w-8 text-fuchsia-500"
                                />
                                <div>
                                    <p
                                        class="text-sm font-medium text-fuchsia-600"
                                    >
                                        Tingkat
                                    </p>
                                    <p class="text-lg font-bold text-gray-800">
                                        {{ $s->kelas }}
                                    </p>
                                </div>
                            </div>

                            <div
                                class="flex items-center gap-4 rounded-xl bg-pink-50 p-4"
                            >
                                <x-mary-icon
                                    name="o-calendar"
                                    class="h-8 w-8 text-pink-500"
                                />
                                <div>
                                    <p
                                        class="text-sm font-medium text-pink-600"
                                    >
                                        Terdaftar
                                    </p>
                                    <p class="text-lg font-bold text-gray-800">
                                        {{ $s->created_at->format("d M Y") }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Decorative Elements -->
                        <div class="absolute -right-2 -top-2">
                            <div
                                class="h-6 w-6 animate-bounce rounded-full bg-violet-400"
                            ></div>
                        </div>
                        <div class="absolute -bottom-2 -left-2">
                            <div
                                class="h-6 w-6 animate-bounce rounded-full bg-fuchsia-400 delay-150"
                            ></div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div
                        class="rounded-3xl border-4 border-violet-300 bg-white p-12 text-center shadow-xl"
                    >
                        <div class="flex flex-col items-center justify-center">
                            <div
                                class="mb-6 flex h-24 w-24 items-center justify-center rounded-full bg-violet-100"
                            >
                                <x-mary-icon
                                    name="o-users"
                                    class="h-14 w-14 text-violet-500"
                                />
                            </div>
                            <h3 class="mb-4 text-2xl font-bold text-gray-800">
                                Belum Ada Siswa 👨‍🎓
                            </h3>
                            <p class="text-lg text-gray-600">
                                Yuk mulai tambahkan data siswa baru! 📚
                            </p>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $siswa->links() }}
        </div>
    </div>
</div>
