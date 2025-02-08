<div>
    <x-ts-card
        class="overflow-hidden rounded-3xl border-2 border-sky-100 bg-white/95 shadow-2xl transition-all duration-500"
    >
        <div class="p-12">
            <!-- Header Section -->
            <div class="mb-12 text-center">
                <div
                    class="mb-6 inline-block animate-pulse rounded-full bg-gradient-to-br from-sky-100 via-blue-100 to-indigo-100 p-4"
                >
                    <x-ts-icon
                        name="user-plus"
                        class="h-12 w-12 text-sky-600"
                    />
                </div>
                <h2
                    class="bg-gradient-to-r from-sky-600 via-blue-600 to-indigo-600 bg-clip-text text-5xl font-black tracking-tight text-transparent"
                >
                    Pendaftaran Siswa Baru
                </h2>
                <p class="mt-4 text-xl text-gray-600">
                    Mari bergabung dengan keluarga besar kami!
                </p>
            </div>

            <x-mary-form wire:submit="save" no-separator>
                <!-- Form Section -->
                <div class="space-y-10">
                    <!-- Data Pribadi -->
                    <div
                        class="group rounded-3xl border border-sky-200/50 bg-gradient-to-br from-sky-50/80 via-blue-50/80 to-indigo-50/80 p-8 transition-all duration-300 hover:border-sky-300/50 hover:shadow-xl"
                    >
                        <div class="mb-8 flex items-center gap-4">
                            <div
                                class="rounded-xl bg-sky-100 p-3 transition-colors group-hover:bg-sky-200"
                            >
                                <x-ts-icon
                                    name="identification"
                                    class="h-8 w-8 text-sky-600"
                                />
                            </div>
                            <h3
                                class="bg-gradient-to-r from-sky-700 to-blue-700 bg-clip-text text-2xl font-bold text-transparent"
                            >
                                Data Pribadi
                            </h3>
                        </div>
                        <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                            <x-ts-input
                                wire:model="form.nama"
                                label="Nama Lengkap *"
                                hint="Masukkan nama lengkap"
                                placeholder="Masukkan nama lengkap Anda"
                                icon="user"
                                class="transition-all duration-300 hover:shadow-md"
                                required
                            />

                            <x-ts-input
                                suffix="@gmail.com"
                                label="E-mail"
                                hint="Masukkan email"
                                placeholder="Masukkan email Anda"
                                icon="envelope"
                                class="transition-all duration-300 hover:shadow-md"
                                required
                            />

                            <x-ts-select.styled
                                wire:model="form.jenis_kelamin"
                                label="Jenis Kelamin *"
                                hint="Pilih jenis kelamin"
                                placeholder="Pilih jenis kelamin"
                                :options="['Laki-laki', 'Perempuan']"
                                icon="users"
                                class="transition-all duration-300 hover:shadow-md"
                                required
                            />

                            <x-ts-input
                                wire:model="form.tanggal_lahir"
                                type="date"
                                label="Tanggal Lahir *"
                                hint="Pilih tanggal lahir"
                                placeholder="DD/MM/YYYY"
                                icon="calendar"
                                class="transition-all duration-300 hover:shadow-md"
                                required
                            />

                            <x-ts-input
                                wire:model="form.no_telepon"
                                label="Nomor Telepon *"
                                hint="Masukkan nomor telepon"
                                placeholder="08xxxxxxxxxx"
                                icon="phone"
                                class="transition-all duration-300 hover:shadow-md"
                                required
                            />

                            <x-ts-textarea
                                wire:model="form.alamat"
                                label="Alamat *"
                                hint="Masukkan alamat lengkap"
                                placeholder="Masukkan alamat lengkap Anda"
                                class="transition-all duration-300 hover:shadow-md"
                                required
                            />
                        </div>
                    </div>

                    <!-- Data Sekolah -->
                    <div
                        class="group rounded-3xl border border-blue-200/50 bg-gradient-to-br from-blue-50/80 via-indigo-50/80 to-sky-50/80 p-8 transition-all duration-300 hover:border-blue-300/50 hover:shadow-xl"
                    >
                        <div class="mb-8 flex items-center gap-4">
                            <div
                                class="rounded-xl bg-blue-100 p-3 transition-colors group-hover:bg-blue-200"
                            >
                                <x-ts-icon
                                    name="academic-cap"
                                    class="h-8 w-8 text-blue-600"
                                />
                            </div>
                            <h3
                                class="bg-gradient-to-r from-blue-700 to-indigo-700 bg-clip-text text-2xl font-bold text-transparent"
                            >
                                Data Sekolah
                            </h3>
                        </div>
                        <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                            <x-ts-input
                                wire:model="form.asal_sekolah"
                                label="Asal Sekolah *"
                                hint="Masukkan nama sekolah"
                                placeholder="Nama sekolah Anda"
                                icon="building-library"
                                class="transition-all duration-300 hover:shadow-md"
                            />

                            <x-ts-select.styled
                                wire:model="form.kelas"
                                label="Kelas *"
                                hint="Masukkan kelas saat ini"
                                placeholder="Pilih kelas"
                                :placeholders="['default' => 'Pilih kelas', 'search' => 'Cari kelas', 'empty' => 'Tidak ada kelas']"
                                :options="
                                    [
                                        7 => 'Kelas 7 SMP',
                                        8 => 'Kelas 8 SMP',
                                        9 => 'Kelas 9 SMP',
                                        10 => 'Kelas 10 SMA',
                                        11 => 'Kelas 11 SMA',
                                        12 => 'Kelas 12 SMA'
                                ]"
                                class="transition-all duration-300 hover:shadow-md"
                            />

                            <x-ts-input
                                wire:model="form.jurusan"
                                label="Jurusan"
                                hint="Masukkan jurusan (opsional)"
                                placeholder="Contoh: IPA, IPS"
                                icon="academic-cap"
                                class="transition-all duration-300 hover:shadow-md"
                            />

                            <x-ts-select.styled
                                wire:model="form.kelas_bimbel_id"
                                label="Kelas Bimbel *"
                                hint="Pilih kelas bimbel"
                                placeholder="Pilih kelas bimbel"
                                :options="$kelas->pluck('nama_kelas', 'id')"
                                icon="user-group"
                                class="transition-all duration-300 hover:shadow-md"
                            />
                        </div>
                    </div>

                    <!-- Data Wali -->
                    <div
                        class="group rounded-3xl border border-indigo-200/50 bg-gradient-to-br from-indigo-50/80 via-sky-50/80 to-blue-50/80 p-8 transition-all duration-300 hover:border-indigo-300/50 hover:shadow-xl"
                    >
                        <div class="mb-8 flex items-center gap-4">
                            <div
                                class="rounded-xl bg-indigo-100 p-3 transition-colors group-hover:bg-indigo-200"
                            >
                                <x-ts-icon
                                    name="users"
                                    class="h-8 w-8 text-indigo-600"
                                />
                            </div>
                            <h3
                                class="bg-gradient-to-r from-indigo-700 to-sky-700 bg-clip-text text-2xl font-bold text-transparent"
                            >
                                Data Wali
                            </h3>
                        </div>
                        <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                            <x-ts-input
                                wire:model="form.nama_wali"
                                label="Nama Wali *"
                                hint="Masukkan nama wali"
                                placeholder="Nama lengkap wali"
                                icon="user"
                                class="transition-all duration-300 hover:shadow-md"
                            />

                            <x-ts-input
                                wire:model="form.no_telepon_wali"
                                label="Nomor Telepon Wali *"
                                hint="Masukkan nomor telepon wali"
                                placeholder="08xxxxxxxxxx"
                                icon="phone"
                                class="transition-all duration-300 hover:shadow-md"
                            />
                        </div>
                    </div>

                    <!-- Upload Foto -->
                    <div
                        class="group rounded-3xl border border-sky-200/50 bg-gradient-to-br from-sky-50/80 via-indigo-50/80 to-blue-50/80 p-8 transition-all duration-300 hover:border-sky-300/50 hover:shadow-xl"
                    >
                        <div class="mb-8 flex items-center gap-4">
                            <div
                                class="rounded-xl bg-sky-100 p-3 transition-colors group-hover:bg-sky-200"
                            >
                                <x-ts-icon
                                    name="camera"
                                    class="h-8 w-8 text-sky-600"
                                />
                            </div>
                            <h3
                                class="bg-gradient-to-r from-sky-700 to-blue-700 bg-clip-text text-2xl font-bold text-transparent"
                            >
                                Foto
                            </h3>
                        </div>
                        <div class="grid grid-cols-1 gap-8">
                            <div
                                class="relative transition-all duration-300 hover:shadow-md"
                            >
                                <x-ts-upload
                                    wire:model.live="foto"
                                    :placeholder="count($foto) . ' images'"
                                    delete
                                    delete-method="deleting"
                                    class="rounded-2xl border-2 border-dashed border-sky-200 hover:border-sky-400"
                                />
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Submit -->
                    <div class="flex justify-end pt-6">
                        <x-ts-button
                            wire:click="daftar"
                            class="transform rounded-2xl bg-gradient-to-br from-sky-500 via-blue-600 to-indigo-600 px-10 py-5 text-xl font-bold tracking-wide text-white shadow-xl transition-all duration-300 hover:-translate-y-1 hover:from-sky-600 hover:via-blue-700 hover:to-indigo-700 hover:shadow-sky-200/50 active:scale-95"
                        >
                            <x-ts-icon
                                name="user-plus"
                                class="mr-3 h-7 w-7 animate-pulse"
                            />
                            Daftar Sekarang
                        </x-ts-button>
                    </div>
                </div>
            </x-mary-form>
        </div>
    </x-ts-card>
</div>
