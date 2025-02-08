<div>
    <x-ts-card
        class="overflow-hidden rounded-2xl border-2 border-emerald-100 bg-white/90 shadow-xl"
    >
        <div class="p-8">
            <!-- Header Section -->
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <h2
                        class="bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-3xl font-bold tracking-tight text-gray-900 text-transparent"
                    >
                        Daftar Kelas Bimbel
                    </h2>
                    <p class="mt-1 text-gray-600">
                        Kelola semua kelas bimbingan belajar dengan mudah
                    </p>
                </div>
                <x-ts-button
                    href="#"
                    class="flex transform items-center gap-2 rounded-lg bg-gradient-to-r from-emerald-600 to-teal-600 px-5 py-2.5 shadow-md transition-all duration-300 hover:-translate-y-1 hover:from-emerald-700 hover:to-teal-700"
                >
                    <x-ts-icon name="plus" class="h-4 w-4" />
                    <span>Tambah Kelas Baru</span>
                </x-ts-button>
            </div>

            <!-- Filter Section -->
            <div
                class="mb-8 rounded-xl border border-emerald-200 bg-gradient-to-br from-emerald-50 to-teal-50 p-6"
            >
                <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                    <x-ts-select.styled
                        wire:model.live="tingkatFilter"
                        label="Tingkat Kelas"
                        placeholder="Pilih Tingkat"
                        :options="['SMP', 'SMA']"
                        class="transition hover:ring-2 hover:ring-emerald-200"
                    />
                    <x-ts-select.styled
                        wire:model.live="jenisFilter"
                        label="Jenis Kelas"
                        placeholder="Pilih Jenis"
                        :options="['Reguler', 'Intensif']"
                        class="transition hover:ring-2 hover:ring-emerald-200"
                    />
                    <x-ts-select.styled
                        wire:model.live="statusFilter"
                        label="Status Kelas"
                        placeholder="Pilih Status"
                        :options="['Aktif', 'Non-Aktif']"
                        class="transition hover:ring-2 hover:ring-emerald-200"
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
                class="overflow-hidden rounded-xl border border-emerald-200 bg-white/95 shadow-lg"
            >
                <x-slot:header>
                    @interact("column_id", $row)
                        <span
                            class="rounded-lg bg-emerald-50 px-3 py-2 text-sm font-medium text-emerald-700 transition hover:bg-emerald-100"
                        >
                            {{ $row["id"] }}
                        </span>
                    @endinteract

                    @interact("column_nama_kelas", $row)
                        <span
                            class="rounded-lg bg-gradient-to-r from-emerald-50 to-teal-50 px-3 py-2 text-sm font-medium text-emerald-700 transition hover:from-emerald-100 hover:to-teal-100"
                        >
                            {{ $row["nama_kelas"] }}
                        </span>
                    @endinteract

                    @interact("column_tingkat", $row)
                        <span
                            class="transform rounded-lg bg-gradient-to-r from-emerald-500 to-teal-500 px-3 py-2 text-sm font-medium text-white transition hover:-translate-y-0.5 hover:opacity-90"
                        >
                            <x-ts-icon
                                name="academic-cap"
                                class="mr-1 inline h-4 w-4"
                            />
                            {{ $row["tingkat"] }}
                        </span>
                    @endinteract

                    @interact("column_jenis", $row)
                        <span
                            class="rounded-lg bg-gradient-to-r from-emerald-50 to-teal-50 px-3 py-2 text-sm font-medium text-emerald-700 transition hover:from-emerald-100 hover:to-teal-100"
                        >
                            {{ $row["jenis"] }}
                        </span>
                    @endinteract

                    @interact("column_total_siswa", $row)
                        <span
                            class="rounded-lg bg-gradient-to-r from-emerald-50 to-teal-50 px-3 py-2 text-sm font-medium text-emerald-700 transition hover:from-emerald-100 hover:to-teal-100"
                        >
                            <x-ts-icon
                                name="users"
                                class="mr-1 inline h-4 w-4"
                            />
                            {{ $row["total_siswa"] }}
                        </span>
                    @endinteract

                    @interact("column_status", $row)
                        <span
                            class="{{ $row["status"] === "Aktif" ? "bg-emerald-50 text-emerald-700" : "bg-red-50 text-red-700" }} rounded-lg px-3 py-2 text-sm font-medium transition"
                        >
                            <span
                                class="{{ $row["status"] === "Aktif" ? "bg-emerald-500" : "bg-red-500" }} mr-2 inline-block h-2 w-2 rounded-full"
                            ></span>
                            {{ $row["status"] }}
                        </span>
                    @endinteract

                    @interact("column_action", $row)
                        <div class="flex items-center gap-3">
                            <x-ts-button.circle
                                color="emerald"
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
                                color="red"
                                icon="x-mark"
                                wire:click="delete('{{ $row['id'] }}')"
                                title="Hapus"
                                wire:confirm="Yakin ingin menghapus data kelas ini?"
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
