<div>
    <x-ts-card
        class="overflow-hidden rounded-2xl border-2 border-indigo-100 bg-white/90 shadow-xl"
    >
        <div class="p-8">
            <!-- Header Section -->
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h2
                        class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-3xl font-bold tracking-tight text-gray-900 text-transparent"
                    >
                        Data Siswa Bimbel
                    </h2>
                    <p class="mt-1 text-gray-600">
                        Manajemen data siswa bimbingan belajar
                    </p>
                </div>
                <x-ts-button
                    href="/kacap/siswa/daftar"
                    wire:navigate
                    class="flex transform items-center gap-2 rounded-lg bg-gradient-to-r from-indigo-600 to-purple-600 px-5 py-2.5 shadow-md transition-all duration-300 hover:-translate-y-1 hover:from-indigo-700 hover:to-purple-700"
                >
                    <x-ts-icon name="user-plus" class="h-4 w-4" />
                    <span>Tambah Siswa Baru</span>
                </x-ts-button>
            </div>

            <!-- Filter Section -->
            <div
                class="mb-8 rounded-xl border border-indigo-200 bg-gradient-to-br from-indigo-50 to-purple-50 p-6"
            >
                <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                    <x-ts-select.styled
                        wire:model.live="kelasFilter"
                        label="Filter Kelas"
                        placeholder="Semua Kelas"
                        :options="['7','8','9','10','11','12']"
                        class="transition hover:ring-2 hover:ring-indigo-200"
                    />
                    <x-ts-select.styled
                        wire:model.live="statusFilter"
                        label="Filter Status"
                        placeholder="Semua Status"
                        :options="['Aktif', 'Non-Aktif']"
                        class="transition hover:ring-2 hover:ring-indigo-200"
                    />
                    <x-ts-input
                        wire:model.live="search"
                        label="Pencarian"
                        placeholder="Masukkan nama siswa..."
                        class="transition hover:ring-2 hover:ring-indigo-200"
                    />
                </div>
            </div>

            <!-- Table Section -->
            <x-ts-table
                :headers="$headers"
                :rows="$rows"
                filter
                loading
                :sort="$sort"
                class="overflow-hidden rounded-xl border border-indigo-200 bg-white/95 shadow-lg"
            >
                <x-slot:header>
                    @interact("column_id", $row)
                        <span
                            class="rounded-lg bg-indigo-50 px-3 py-2 text-sm font-medium text-indigo-700 transition hover:bg-indigo-100"
                        >
                            {{ $row["id"] }}
                        </span>
                    @endinteract

                    @interact("column_nama", $row)
                        <span
                            class="rounded-lg bg-gradient-to-r from-indigo-50 to-purple-50 px-3 py-2 text-sm font-medium text-indigo-700 transition hover:from-indigo-100 hover:to-purple-100"
                        >
                            {{ $row["nama_lengkap"] }}
                        </span>
                    @endinteract

                    @interact("column_kelas", $row)
                        <span
                            class="transform rounded-lg bg-gradient-to-r from-indigo-500 to-purple-500 px-3 py-2 text-sm font-medium text-white transition hover:-translate-y-0.5 hover:opacity-90"
                        >
                            <x-ts-icon
                                name="book-open"
                                class="mr-1 inline h-4 w-4"
                            />
                            Kelas {{ $row["kelasBimbel"]["nama_kelas"] }}
                        </span>
                    @endinteract

                    @interact("column_status", $row)
                        <span
                            class="{{ $row["status"] === "Aktif" ? "bg-teal-50 text-teal-700" : "bg-pink-50 text-pink-700" }} rounded-lg px-3 py-2 text-sm font-medium transition"
                        >
                            <span
                                class="{{ $row["status"] === "Aktif" ? "bg-teal-500" : "bg-pink-500" }} mr-2 inline-block h-2 w-2 rounded-full"
                            ></span>
                            {{ $row["status"] }}
                        </span>
                    @endinteract

                    @interact("column_action", $row)
                        <div class="flex items-center gap-3">
                            <x-ts-button.circle
                                color="indigo"
                                icon="information-circle"
                                href="#"
                                title="Detail"
                                class="transition hover:-translate-y-1"
                            />
                            <x-ts-button.circle
                                color="amber"
                                icon="pencil-square"
                                href="#"
                                title="Edit"
                                class="transition hover:-translate-y-1"
                            />
                            <x-ts-button.circle
                                color="rose"
                                icon="x-mark"
                                wire:click="delete('{{ $row['id'] }}')"
                                title="Hapus"
                                wire:confirm="Yakin ingin menghapus data siswa ini?"
                                class="transition hover:-translate-y-1"
                            />
                        </div>
                    @endinteract
                </x-slot>

                <x-slot:footer>
                    <div class="px-4 py-3">
                        {{ $rows->links() }}
                    </div>
                </x-slot>
            </x-ts-table>
        </div>
    </x-ts-card>
</div>
