<div
    x-data="{
        showSuccessMessage: false,
        showForm: true,
        formStep: 1,
        maxSteps: 2,
        nextStep() {
            if (this.formStep < this.maxSteps) this.formStep++
        },
        prevStep() {
            if (this.formStep > 1) this.formStep--
        },
    }"
    class="min-h-screen"
>
    {{-- Header Card dengan Animasi --}}
    <div
        x-show="showForm"
        x-transition:enter="transition duration-300 ease-out"
        x-transition:enter-start="-translate-y-4 transform opacity-0"
        x-transition:enter-end="translate-y-0 transform opacity-100"
    >
        <x-mary-card
            class="mb-6 border-0 bg-gradient-to-br from-indigo-50 via-white to-indigo-50 shadow-xl"
        >
            <div class="px-2 sm:flex sm:items-center sm:justify-between">
                <div class="relative">
                    <div
                        class="absolute -left-1 top-0 h-16 w-1 animate-pulse rounded-full bg-indigo-500"
                    ></div>
                    <h1
                        class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-3xl font-bold text-transparent"
                    >
                        Tambah Siswa Baru
                    </h1>
                    <p class="mt-2 text-sm font-medium text-gray-600">
                        <span class="inline-flex items-center">
                            <x-mary-icon
                                name="o-user-plus"
                                class="mr-1 inline-block h-4 w-4 animate-bounce"
                            />
                            Tambahkan data siswa baru
                        </span>
                    </p>
                </div>
                <div class="mt-4 flex space-x-3 sm:mt-0">
                    <x-mary-button
                        wire:navigate
                        href="{{ route('admin.siswa.index') }}"
                        class="transform bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-lg transition-all duration-200 hover:scale-105 hover:from-indigo-700 hover:to-purple-700 hover:shadow-indigo-200"
                        icon="o-arrow-left"
                    >
                        Kembali ke Daftar
                    </x-mary-button>
                </div>
            </div>
        </x-mary-card>
    </div>

    {{-- Progress Steps --}}
    <div class="mb-8 flex justify-center">
        <div class="relative">
            <div class="flex items-center space-x-12">
                <template x-for="in 2 step" :key="step">
                    <div class="flex flex-col items-center">
                        <div
                            :class="{
                                'bg-indigo-600': formStep >= step,
                                'bg-gray-300': formStep < step
                            }"
                            class="flex h-8 w-8 items-center justify-center rounded-full font-bold text-white transition-all duration-300"
                            x-text="step"
                        ></div>
                        <span
                            class="mt-2 text-xs font-medium"
                            x-text="step === 1 ? 'Data Pribadi' : 'Data Akademik'"
                        ></span>
                    </div>
                </template>
            </div>
            <div class="absolute top-4 -z-10 h-0.5 w-full bg-gray-300">
                <div
                    class="h-full bg-indigo-600 transition-all duration-300"
                    :style="'width: ' + (((formStep - 1) / (maxSteps - 1)) * 100) + '%'"
                ></div>
            </div>
        </div>
    </div>

    {{-- Form Card dengan Step Navigation --}}
    <x-mary-card
        class="overflow-hidden border-0 bg-gradient-to-br from-white via-indigo-50/30 to-white shadow-xl"
    >
        <x-mary-form wire:submit="save" class="space-y-8">
            {{-- Step 1: Data Pribadi --}}
            <div
                x-show="formStep === 1"
                x-transition:enter="transition duration-300 ease-out"
                x-transition:enter-start="translate-x-4 transform opacity-0"
                x-transition:enter-end="translate-x-0 transform opacity-100"
            >
                <div class="space-y-6">
                    <div class="flex items-center space-x-3">
                        <div class="h-8 w-1 rounded-full bg-indigo-500"></div>
                        <h2
                            class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-xl font-bold text-transparent"
                        >
                            Data Pribadi
                        </h2>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2">
                        <x-mary-input
                            label="Nama Lengkap"
                            wire:model="nama_lengkap"
                            placeholder="Masukkan nama lengkap"
                            icon="o-user"
                            class="transform shadow-sm transition-transform duration-300 hover:scale-105"
                            hint="Nama lengkap sesuai dokumen resmi"
                            required
                        />

                        <x-mary-input
                            label="Email"
                            wire:model="email"
                            type="email"
                            placeholder="Masukkan email"
                            icon="o-envelope"
                            class="transform shadow-sm transition-transform duration-300 hover:scale-105"
                            hint="Email untuk login"
                            required
                        />

                        <x-mary-input
                            label="Nomor Telepon"
                            wire:model="no_telepon"
                            placeholder="Masukkan nomor telepon"
                            icon="o-phone"
                            class="transform shadow-sm transition-transform duration-300 hover:scale-105"
                            hint="Nomor telepon aktif"
                            required
                        />

                        <x-mary-datepicker
                            label="Tanggal Lahir"
                            wire:model="tanggal_lahir"
                            icon="o-calendar"
                            class="transform shadow-sm transition-transform duration-300 hover:scale-105"
                            hint="Tanggal lahir siswa"
                        />

                        <x-mary-select
                            label="Jenis Kelamin"
                            wire:model="jenis_kelamin"
                            :options="[
                                ['value' => 'L', 'label' => 'Laki-laki'],
                                ['value' => 'P', 'label' => 'Perempuan']
                            ]"
                            option-label="label"
                            option-value="value"
                            placeholder="Pilih jenis kelamin"
                            icon="o-user"
                            class="transform shadow-sm transition-transform duration-300 hover:scale-105"
                            hint="Jenis kelamin siswa"
                        />

                        <x-mary-input
                            label="Nama Wali"
                            wire:model="nama_wali"
                            placeholder="Masukkan nama wali"
                            icon="o-user-group"
                            class="transform shadow-sm transition-transform duration-300 hover:scale-105"
                            hint="Nama orang tua/wali"
                            required
                        />

                        <x-mary-input
                            label="Nomor Telepon Wali"
                            wire:model="no_telepon_wali"
                            placeholder="Masukkan nomor telepon wali"
                            icon="o-phone"
                            class="transform shadow-sm transition-transform duration-300 hover:scale-105"
                            hint="Nomor telepon wali yang aktif"
                            required
                        />

                        <div class="col-span-2">
                            <x-mary-file
                                label="Foto Siswa"
                                wire:model="foto"
                                hint="Format: JPG, JPEG, PNG. Maksimal 2MB (Opsional)"
                                accept="image/*"
                                class="transform shadow-sm transition-transform duration-300 hover:scale-105"
                            >
                                <x-slot:help>
                                    @if ($foto)
                                        <div class="mt-2">
                                            <img
                                                src="{{ $foto->temporaryUrl() }}"
                                                alt="Preview"
                                                class="h-32 w-32 rounded-lg border-2 border-indigo-500/20 object-cover"
                                            />
                                        </div>
                                    @endif
                                </x-slot>
                            </x-mary-file>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Step 2: Data Akademik --}}
            <div
                x-show="formStep === 2"
                x-transition:enter="transition duration-300 ease-out"
                x-transition:enter-start="translate-x-4 transform opacity-0"
                x-transition:enter-end="translate-x-0 transform opacity-100"
            >
                <div class="space-y-6">
                    <div class="flex items-center space-x-3">
                        <div class="h-8 w-1 rounded-full bg-violet-500"></div>
                        <h2
                            class="bg-gradient-to-r from-violet-600 to-indigo-600 bg-clip-text text-xl font-bold text-transparent"
                        >
                            Data Akademik
                        </h2>
                    </div>

                    <div class="grid gap-6 sm:grid-cols-2">
                        <x-mary-select
                            label="Cabang"
                            wire:model="cabang_id"
                            :options="$cabangs"
                            option-label="nama"
                            option-value="id"
                            placeholder="Pilih cabang"
                            icon="o-building-office"
                            class="transform shadow-sm transition-transform duration-300 hover:scale-105"
                            hint="Cabang tempat belajar"
                            required
                        />

                        <x-mary-input
                            label="Asal Sekolah"
                            wire:model="asal_sekolah"
                            placeholder="Masukkan nama sekolah"
                            icon="o-building-library"
                            class="transform shadow-sm transition-transform duration-300 hover:scale-105"
                            hint="Nama sekolah asal"
                            required
                        />

                        <x-mary-select
                            label="Kelas Bimbel"
                            wire:model="kelas_bimbel_id"
                            :options="$kelas_bimbels"
                            option-label="nama_kelas"
                            option-value="id"
                            placeholder="Pilih kelas"
                            icon="o-academic-cap"
                            class="transform shadow-sm transition-transform duration-300 hover:scale-105"
                            hint="Kelas yang akan diikuti"
                            required
                        />

                        <x-mary-input
                            label="Kelas"
                            wire:model="kelas"
                            placeholder="Contoh: X, XI, XII"
                            icon="o-academic-cap"
                            class="transform shadow-sm transition-transform duration-300 hover:scale-105"
                            hint="Kelas di sekolah"
                            required
                        />

                        <x-mary-input
                            label="Jurusan"
                            wire:model="jurusan"
                            placeholder="Contoh: IPA, IPS, dll"
                            icon="o-academic-cap"
                            class="transform shadow-sm transition-transform duration-300 hover:scale-105"
                            hint="Jurusan di sekolah (opsional)"
                        />

                        <x-mary-textarea
                            label="Alamat"
                            wire:model="alamat"
                            placeholder="Masukkan alamat lengkap"
                            rows="3"
                            icon="o-home"
                            class="transform shadow-sm transition-transform duration-300 hover:scale-105"
                            hint="Alamat tempat tinggal siswa"
                            required
                        />
                    </div>
                </div>
            </div>

            {{-- Navigation Buttons --}}
            <div class="mt-8 flex justify-between">
                <x-mary-button
                    x-show="formStep > 1"
                    @click="prevStep()"
                    class="transform border border-white/20 bg-gradient-to-br from-gray-500/40 via-gray-600/40 to-gray-700/40 font-medium text-white shadow-lg backdrop-blur-xl transition-all duration-300 hover:scale-105 hover:from-gray-500/60 hover:via-gray-600/60 hover:to-gray-700/60"
                    icon="o-arrow-left"
                >
                    Sebelumnya
                </x-mary-button>

                <div class="flex gap-4">
                    <x-mary-button
                        x-show="formStep < maxSteps"
                        @click="nextStep()"
                        class="transform border border-white/20 bg-gradient-to-br from-indigo-500/40 via-purple-500/40 to-violet-500/40 font-medium text-white shadow-lg backdrop-blur-xl transition-all duration-300 hover:scale-105 hover:from-indigo-500/60 hover:via-purple-500/60 hover:to-violet-500/60"
                        icon="o-arrow-right"
                    >
                        Selanjutnya
                    </x-mary-button>

                    <x-mary-button
                        x-show="formStep === maxSteps"
                        type="submit"
                        class="transform border border-white/20 bg-gradient-to-br from-emerald-500/40 via-teal-500/40 to-green-500/40 font-medium text-white shadow-lg backdrop-blur-xl transition-all duration-300 hover:scale-105 hover:from-emerald-500/60 hover:via-teal-500/60 hover:to-green-500/60"
                        icon="o-check"
                    >
                        Simpan Data
                    </x-mary-button>
                </div>
            </div>
        </x-mary-form>
    </x-mary-card>
</div>
