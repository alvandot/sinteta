<div>
    <x-ts-card
        class="overflow-hidden rounded-[2.5rem] border-2 border-indigo-200 bg-white/95 shadow-xl transition-all duration-500 hover:border-indigo-300 hover:shadow-2xl"
    >
        <div class="p-6">
            <!-- Header Section -->
            <div class="relative mb-20 text-center">
                <div class="absolute inset-0 flex items-center">
                    <div
                        class="w-full border-t-2 border-dashed border-indigo-200 opacity-50"
                    ></div>
                </div>
                <div class="relative flex justify-center">
                    <div
                        class="rounded-full bg-white bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text px-12 py-8 font-black text-transparent shadow-2xl transition-all duration-500 hover:scale-110 hover:shadow-indigo-200/50"
                    >
                        <span class="text-7xl">👨‍🏫 Daftar Tentor 👩‍🏫</span>
                    </div>
                </div>
                <p
                    class="mt-10 animate-pulse bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-2xl font-medium text-transparent"
                >
                    Berkolaborasi dengan pengajar profesional terbaik
                </p>
            </div>

            <!-- Search & Filter Section -->
            <div
                class="mb-16 flex flex-wrap items-center justify-between gap-8 rounded-[2rem] border-2 border-white bg-gradient-to-r from-indigo-50 via-purple-50 to-pink-50 p-10 shadow-xl"
            >
                <div class="w-full md:w-[28rem]">
                    <label
                        for="search"
                        class="mb-3 block text-lg font-medium text-gray-700"
                    >
                        Cari Tentor
                    </label>
                    <x-ts-input
                        id="search"
                        wire:model.live="search"
                        placeholder="Cari berdasarkan nama, spesialisasi, atau mata pelajaran..."
                        icon="magnifying-glass"
                        class="w-full text-lg shadow-xl focus:ring-4 focus:ring-indigo-200"
                    />
                </div>

            </div>

            <!-- Tentor Grid -->
            <div class="grid grid-cols-1 gap-10 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($tentors as $tentor)
                    <div class="group">
                        <div
                            class="transform overflow-hidden rounded-[2rem] border-2 border-indigo-100 bg-white shadow-xl transition-all duration-700 hover:-translate-y-3 hover:border-indigo-300 hover:shadow-2xl"
                        >
                            <!-- Card Header with Gradient -->
                            <div
                                class="bg-gradient-to-br from-indigo-100 via-purple-50 to-pink-100 p-6"
                            >
                                <div class="flex items-center justify-between">
                                    <span
                                        class="rounded-full bg-indigo-100 px-4 py-2 text-sm font-bold text-indigo-700 transition-all duration-500 hover:bg-indigo-200"
                                    >
                                        ID: {{ $tentor->id }}
                                    </span>
                                    <span
                                        class="{{ $tentor->status === "aktif" ? "bg-green-100 text-green-700" : "bg-gray-100 text-gray-700" }} rounded-full px-4 py-2 text-sm font-bold"
                                    >
                                        {{ ucfirst($tentor->status) }}
                                    </span>
                                </div>
                                <h3
                                    class="mt-4 text-3xl font-bold tracking-wide text-gray-800"
                                >
                                    {{ $tentor->user->name }}
                                </h3>
                            </div>

                            <!-- Card Content -->
                            <div class="p-6">
                                <div class="space-y-4">
                                    <div class="flex items-center gap-3">
                                        <span
                                            class="inline-flex transform items-center gap-2 rounded-full bg-purple-100 px-4 py-2 text-sm font-semibold text-purple-700 transition-all duration-500 hover:scale-105 hover:bg-purple-200"
                                        >
                                            <x-ts-icon
                                                name="academic-cap"
                                                class="h-5 w-5"
                                            />
                                            {{ $tentor->pendidikan_terakhir }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <span
                                            class="inline-flex transform items-center gap-2 rounded-full bg-indigo-100 px-4 py-2 text-sm font-semibold text-indigo-700 transition-all duration-500 hover:scale-105 hover:bg-indigo-200"
                                        >
                                            <x-ts-icon
                                                name="briefcase"
                                                class="h-5 w-5"
                                            />
                                            {{ $tentor->spesialisasi }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Mata Pelajaran List -->
                                <div class="mt-6 space-y-3">
                                    <h4 class="font-semibold text-gray-700">
                                        Mata Pelajaran yang Diampu:
                                    </h4>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach ($tentor->mapels as $mapel)
                                            <span
                                                class="rounded-full bg-indigo-100 px-3 py-1 text-sm text-indigo-700"
                                            >
                                                {{ $mapel->nama_pelajaran }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div
                                    class="mt-8 flex justify-end gap-4 border-t-2 border-dashed border-indigo-100 pt-8"
                                >
                                    <x-ts-button
                                        icon="pencil"
                                        class="bg-purple-100 px-6 py-4 text-lg font-medium text-purple-700 transition-all duration-500 hover:scale-110 hover:bg-purple-200 hover:shadow-xl"
                                        rounded="2xl"
                                        title="Edit data tentor"
                                        aria-label="Edit data tentor {{ $tentor->nama }}"
                                    />
                                    <x-ts-button
                                        icon="trash"
                                        class="bg-red-100 px-6 py-4 text-lg font-medium text-red-700 transition-all duration-500 hover:scale-110 hover:bg-red-200 hover:shadow-xl"
                                        rounded="2xl"
                                        title="Hapus tentor"
                                        aria-label="Hapus tentor {{ $tentor->nama }}"
                                        wire:click="delete({{ $tentor->id }})"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div
                class="mt-16 flex items-center justify-between rounded-[2rem] border-2 border-dashed border-indigo-200 bg-gradient-to-r from-indigo-50 via-purple-50 to-pink-50 px-10 py-8"
            >
                <span
                    class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-xl font-medium text-transparent"
                >
                    Showing {{ $tentors->firstItem() }} to
                    {{ $tentors->lastItem() }} of {{ $tentors->total() }}
                    results
                </span>
                <div class="flex gap-4" aria-label="Navigasi halaman">
                    {{ $tentors->links("vendor.livewire.tailwind") }}
                </div>
            </div>
        </div>
    </x-ts-card>
</div>
