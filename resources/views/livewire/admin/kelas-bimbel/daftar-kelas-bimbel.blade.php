<div
    x-data="{
        showFilters: false,
        selectedKelas: @entangle("selectedKelas").live,
        confirmDelete: @entangle("showDeleteModal").live,
        darkMode: localStorage.getItem('darkMode') === 'true',
        toast: {
            show: false,
            type: 'info',
            message: '',
            description: '',
            position: 'bottom-right',
        },
        showToast(message, description = '', type = 'info') {
            this.toast.show = true
            this.toast.type = type
            this.toast.message = message
            this.toast.description = description

            if (type === 'error') {
                this.$refs.toastContainer.classList.add('animate-shake')
                setTimeout(() => {
                    this.$refs.toastContainer.classList.remove('animate-shake')
                }, 500)
            }

            setTimeout(() => {
                this.toast.show = false
            }, 3000)
        },
        toggleDarkMode() {
            this.darkMode = ! this.darkMode
            localStorage.setItem('darkMode', this.darkMode)
            document.documentElement.classList.toggle('dark')
        },
        init() {
            if (this.darkMode) {
                document.documentElement.classList.add('dark')
            }
        },
    }"
    x-init="init()"
    class="relative"
    :class="{ 'dark': darkMode }"
>
    {{-- Dark Mode Toggle --}}
    <button
        @click="toggleDarkMode()"
        class="fixed right-4 top-4 z-50 rounded-full p-2 transition-colors duration-200 hover:bg-gray-200 dark:hover:bg-gray-700"
    >
        <x-mary-icon
            x-show="!darkMode"
            name="o-moon"
            class="h-6 w-6 text-gray-700 dark:text-gray-300"
        />
        <x-mary-icon
            x-show="darkMode"
            name="o-sun"
            class="h-6 w-6 text-gray-300"
        />
    </button>

    {{-- Toast Notification --}}
    <div
        x-show="toast.show"
        x-ref="toastContainer"
        x-transition:enter="transition duration-300 ease-out"
        x-transition:enter-start="translate-y-2 transform opacity-0"
        x-transition:enter-end="translate-y-0 transform opacity-100"
        x-transition:leave="transition duration-200 ease-in"
        x-transition:leave-start="translate-y-0 transform opacity-100"
        x-transition:leave-end="translate-y-2 transform opacity-0"
        :class="{
            'bottom-4 right-4': toast.position === 'bottom-right',
            'top-4 right-4': toast.position === 'top-right',
            'bottom-4 left-4': toast.position === 'bottom-left',
            'top-4 left-4': toast.position === 'top-left'
        }"
        class="fixed z-50"
        x-cloak
    >
        <div
            :class="{
                'bg-blue-500 dark:bg-blue-600': toast.type === 'info',
                'bg-green-500 dark:bg-green-600': toast.type === 'success',
                'bg-red-500 dark:bg-red-600': toast.type === 'error',
                'bg-yellow-500 dark:bg-yellow-600': toast.type === 'warning'
            }"
            class="flex min-w-[320px] max-w-md transform items-start space-x-4 rounded-lg p-4 text-white shadow-lg transition-all duration-300 hover:scale-105"
        >
            <div class="flex-shrink-0 pt-0.5">
                <template x-if="toast.type === 'info'">
                    <x-mary-icon
                        name="o-information-circle"
                        class="h-6 w-6 animate-bounce"
                    />
                </template>
                <template x-if="toast.type === 'success'">
                    <x-mary-icon
                        name="o-check-circle"
                        class="h-6 w-6 animate-bounce"
                    />
                </template>
                <template x-if="toast.type === 'error'">
                    <x-mary-icon
                        name="o-x-circle"
                        class="h-6 w-6 animate-bounce"
                    />
                </template>
                <template x-if="toast.type === 'warning'">
                    <x-mary-icon
                        name="o-exclamation-triangle"
                        class="h-6 w-6 animate-bounce"
                    />
                </template>
            </div>
            <div class="flex-1">
                <p class="text-sm font-medium" x-text="toast.message"></p>
                <p
                    x-show="toast.description"
                    class="mt-1 text-sm opacity-90"
                    x-text="toast.description"
                ></p>
            </div>
            <button
                @click="toast.show = false"
                class="ml-4 flex-shrink-0 rounded-full p-1.5 text-white transition-colors duration-200 hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-white"
            >
                <x-mary-icon name="o-x-mark" class="h-5 w-5" />
            </button>
        </div>
    </div>

    {{-- Header Card --}}
    <x-mary-card
        class="mb-6 transform border-l-4 border-primary-500 bg-gradient-to-br from-white to-gray-50 shadow-xl transition-all duration-300 hover:scale-[1.02] dark:bg-gray-800 dark:from-gray-800 dark:to-gray-900"
    >
        <div
            class="relative overflow-hidden sm:flex sm:items-center sm:justify-between"
        >
            <div class="relative z-10">
                <h1
                    class="bg-gradient-to-r from-primary-500 to-secondary-500 bg-clip-text text-3xl font-extrabold tracking-tight text-transparent"
                >
                    Daftar Kelas Bimbel
                </h1>
                <p
                    class="mt-2 text-sm font-medium text-gray-700 dark:text-gray-300"
                >
                    Kelola daftar kelas bimbel yang tersedia di sistem
                </p>
            </div>
            <div class="relative z-10 mt-4 flex space-x-3 sm:mt-0">
                <x-ts-button
                    wire:click="create"
                    primary
                    icon="plus"
                    x-on:click="showToast('Membuat Kelas Bimbel Baru', 'Silahkan isi form yang tersedia', 'info')"
                    class="transform bg-gradient-to-r from-primary-500 to-secondary-500 font-semibold transition-all duration-300 hover:scale-110 hover:shadow-lg"
                >
                    Tambah Kelas Bimbel
                </x-ts-button>
            </div>

            <!-- Decorative Elements -->
            <div
                class="absolute -bottom-8 -right-8 h-32 w-32 rounded-full bg-primary-500/10 blur-2xl"
            ></div>
            <div
                class="absolute -left-8 -top-8 h-32 w-32 rounded-full bg-secondary-500/10 blur-2xl"
            ></div>
        </div>
    </x-mary-card>

    {{-- Search Card with Advanced Filters --}}
    <x-mary-card class="mb-6 dark:bg-gray-800">
        <div class="space-y-4">
            <div class="relative">
                <x-mary-input
                    wire:model.live.debounce.300ms="search"
                    placeholder="Cari kelas bimbel..."
                    icon="o-magnifying-glass"
                    class="w-full transition-all duration-300 focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white"
                    x-on:input="showToast('Mencari Kelas Bimbel', 'Menampilkan hasil pencarian', 'info')"
                />
                <div class="absolute right-2 top-2">
                    <button
                        @click="showFilters = !showFilters"
                        class="rounded-full p-2 text-gray-400 transition-colors duration-200 hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-700 dark:hover:text-gray-300"
                    >
                        <x-mary-icon
                            name="o-adjustments-horizontal"
                            class="h-5 w-5"
                        />
                    </button>
                </div>
            </div>

            {{-- Advanced Filters --}}
            <div
                x-show="showFilters"
                x-transition:enter="transition duration-200 ease-out"
                x-transition:enter-start="-translate-y-2 opacity-0"
                x-transition:enter-end="translate-y-0 opacity-100"
                x-transition:leave="transition duration-150 ease-in"
                x-transition:leave-start="translate-y-0 opacity-100"
                x-transition:leave-end="-translate-y-2 opacity-0"
                class="space-y-4 rounded-lg bg-gray-50 p-4 dark:bg-gray-700"
            >
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                    <div>
                        <label
                            class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300"
                        >
                            Status
                        </label>
                        <x-mary-select
                            wire:model.live="status"
                            :options="[
                                ['label' => 'Semua', 'value' => ''],
                                ['label' => 'Aktif', 'value' => 'active'],
                                ['label' => 'Tidak Aktif', 'value' => 'inactive'],
                                ['label' => 'Penuh', 'value' => 'full']
                            ]"
                            class="w-full dark:bg-gray-600"
                        />
                    </div>

                    <div>
                        <label
                            class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300"
                        >
                            Urutkan
                        </label>
                        <x-mary-select
                            wire:model.live="sortBy"
                            :options="[
                                ['label' => 'Nama (A-Z)', 'value' => 'nama_asc'],
                                ['label' => 'Nama (Z-A)', 'value' => 'nama_desc'],
                                ['label' => 'Kapasitas', 'value' => 'kapasitas'],
                                ['label' => 'Terbaru', 'value' => 'created_at']
                            ]"
                            class="w-full dark:bg-gray-600"
                        />
                    </div>

                    <div>
                        <label
                            class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300"
                        >
                            Per Halaman
                        </label>
                        <x-mary-select
                            wire:model.live="perPage"
                            :options="[
                                ['label' => '10', 'value' => 10],
                                ['label' => '25', 'value' => 25],
                                ['label' => '50', 'value' => 50],
                                ['label' => '100', 'value' => 100]
                            ]"
                            class="w-full dark:bg-gray-600"
                        />
                    </div>
                </div>
            </div>
        </div>
    </x-mary-card>

    {{-- Grid View with Animation --}}
    <div
        class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3"
        x-transition:enter="transition-opacity duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
    >
        @forelse ($kelasBimbels as $kelas)
            <x-mary-card
                x-data="{ hover: false }"
                x-on:mouseenter="hover = true"
                x-on:mouseleave="hover = false"
                :class="{ 'transform scale-105 shadow-xl': hover }"
                class="group relative overflow-hidden rounded-xl border-2 border-gray-200 bg-white transition-all duration-300 ease-in-out hover:border-primary-500 dark:border-gray-700 dark:bg-gray-800"
            >
                <div class="relative space-y-4">
                    <!-- Status Badge -->
                    <div class="absolute right-0 top-0">
                        <span
                            class="{{
                                $kelas->status === "active"
                                    ? "bg-green-100/80 text-green-800 backdrop-blur-sm dark:bg-green-800/80 dark:text-green-100"
                                    : ($kelas->status === "inactive"
                                        ? "bg-red-100/80 text-red-800 backdrop-blur-sm dark:bg-red-800/80 dark:text-red-100"
                                        : "bg-yellow-100/80 text-yellow-800 backdrop-blur-sm dark:bg-yellow-800/80 dark:text-yellow-100")
                            }} inline-flex items-center rounded-bl-xl px-3 py-1.5 text-xs font-medium"
                        >
                            <span
                                class="{{
                                    $kelas->status === "active"
                                        ? "animate-pulse bg-green-600"
                                        : ($kelas->status === "inactive"
                                            ? "bg-red-600"
                                            : "bg-yellow-600")
                                }} mr-1.5 h-2 w-2 rounded-full"
                            ></span>
                            {{ ucfirst($kelas->status) }}
                        </span>
                    </div>

                    <!-- Header -->
                    <div class="mb-2">
                        <h3
                            class="text-lg font-semibold text-gray-900 decoration-primary-500 group-hover:underline dark:text-white"
                        >
                            {{ $kelas->nama_kelas }}
                        </h3>
                    </div>

                    <!-- Content -->
                    <div class="space-y-3">
                        <div
                            class="flex items-center rounded-lg bg-gray-50 p-2 text-sm text-gray-600 transition-colors dark:bg-gray-700/50 dark:text-gray-300"
                        >
                            <x-mary-icon
                                name="o-academic-cap"
                                class="mr-2.5 h-5 w-5 text-primary-500"
                            />
                            <span class="font-medium">
                                {{ $kelas->program_bimbel }} -
                                {{ $kelas->tingkat_kelas }}
                            </span>
                        </div>

                        <div
                            class="flex items-center rounded-lg bg-gray-50 p-2 text-sm text-gray-600 transition-colors dark:bg-gray-700/50 dark:text-gray-300"
                        >
                            <x-mary-icon
                                name="o-users"
                                class="mr-2.5 h-5 w-5 text-primary-500"
                            />
                            <span class="font-medium">
                                Kapasitas: {{ $kelas->kapasitas }} siswa
                            </span>
                        </div>

                        <div
                            class="flex items-start rounded-lg bg-gray-50 p-2 text-sm text-gray-600 transition-colors dark:bg-gray-700/50 dark:text-gray-300"
                        >
                            <x-mary-icon
                                name="o-document-text"
                                class="mr-2.5 h-5 w-5 text-primary-500"
                            />
                            <span class="line-clamp-2">
                                {{ $kelas->deskripsi ?? "Tidak ada deskripsi" }}
                            </span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end space-x-2 pt-3">
                        <x-ts-button
                            wire:click="edit({{ $kelas->id }})"
                            secondary
                            icon="pencil"
                            size="sm"
                            class="transform bg-primary-50 transition-all duration-300 hover:scale-105 hover:bg-primary-600 hover:text-white dark:bg-gray-700"
                        >
                            Edit
                        </x-ts-button>
                        <x-ts-button
                            x-on:click="selectedKelas = {{ $kelas->id }}; confirmDelete = true"
                            negative
                            icon="trash"
                            size="sm"
                            class="transform transition-all duration-300 hover:scale-105 hover:bg-red-600"
                        >
                            Hapus
                        </x-ts-button>
                    </div>
                </div>
            </x-mary-card>
        @empty
            <div class="col-span-full">
                <div
                    class="flex flex-col items-center justify-center p-8 text-center"
                >
                    <div class="rounded-full bg-gray-100 p-3 dark:bg-gray-800">
                        <svg
                            class="h-8 w-8 text-gray-400"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5"
                            />
                        </svg>
                    </div>
                    <h3
                        class="mt-4 text-lg font-medium text-gray-900 dark:text-white"
                    >
                        Tidak ada data kelas bimbel
                    </h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Silahkan tambahkan kelas bimbel baru
                    </p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $kelasBimbels->links() }}
    </div>

    <!-- Form Modal -->
    <x-mary-modal
        wire:model="showModal"
        title="{{ $editMode ? 'Edit Kelas Bimbel' : 'Tambah Kelas Bimbel' }}"
    >
        <div class="grid gap-4">
            <div>
                <label
                    class="mb-2 block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100"
                >
                    Nama Kelas
                </label>
                <x-mary-input
                    wire:model="nama_kelas"
                    placeholder="Masukkan nama kelas"
                    class="w-full transition-all duration-300 focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white"
                />
                @error("nama_kelas")
                    <span class="mt-1 text-sm text-red-500">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div>
                <label
                    class="mb-2 block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100"
                >
                    Deskripsi
                </label>
                <x-mary-textarea
                    wire:model="deskripsi"
                    placeholder="Masukkan deskripsi kelas"
                    class="w-full transition-all duration-300 focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white"
                    rows="4"
                />
                @error("deskripsi")
                    <span class="mt-1 text-sm text-red-500">
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label
                        class="mb-2 block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100"
                    >
                        Program Bimbel
                    </label>
                    <x-mary-select
                        wire:model="program_bimbel"
                        :options="['Reguler', 'Intensif', 'Private']"
                        class="w-full dark:bg-gray-700"
                    />
                    @error("program_bimbel")
                        <span class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div>
                    <label
                        class="mb-2 block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100"
                    >
                        Kapasitas
                    </label>
                    <x-mary-input
                        type="number"
                        wire:model="kapasitas"
                        placeholder="Masukkan kapasitas"
                        class="w-full transition-all duration-300 focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white"
                    />
                    @error("kapasitas")
                        <span class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label
                        class="mb-2 block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100"
                    >
                        Tingkat Kelas
                    </label>
                    <x-mary-select
                        wire:model="tingkat_kelas"
                        :options="['X', 'XI', 'XII']"
                        class="w-full dark:bg-gray-700"
                    />
                    @error("tingkat_kelas")
                        <span class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div>
                    <label
                        class="mb-2 block text-sm font-medium leading-6 text-gray-900 dark:text-gray-100"
                    >
                        Status
                    </label>
                    <x-mary-select
                        wire:model="status"
                        :options="[
                            ['label' => 'Aktif', 'value' => 'active'],
                            ['label' => 'Tidak Aktif', 'value' => 'inactive'],
                            ['label' => 'Penuh', 'value' => 'full']
                        ]"
                        class="w-full dark:bg-gray-700"
                    />
                    @error("status")
                        <span class="mt-1 text-sm text-red-500">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
        </div>

        <x-slot name="footer">
            <div class="flex justify-end gap-x-4">
                <x-mary-button
                    wire:click="$toggle('showModal')"
                    variant="secondary"
                    class="transition-all duration-300 hover:bg-gray-200 dark:hover:bg-gray-700"
                >
                    Batal
                </x-mary-button>
                <x-mary-button
                    wire:click="save"
                    class="bg-primary-500 text-white transition-all duration-300 hover:bg-primary-600"
                >
                    {{ $editMode ? "Simpan Perubahan" : "Simpan" }}
                </x-mary-button>
            </div>
        </x-slot>
    </x-mary-modal>

    {{-- Delete Confirmation Modal --}}
    <div
        x-cloak
        x-show="confirmDelete"
        x-transition:enter="transition duration-200 ease-out"
        x-transition:enter-start="-translate-y-2 transform opacity-0"
        x-transition:enter-end="translate-y-0 transform opacity-100"
        x-transition:leave="transition duration-150 ease-in"
        x-transition:leave-start="translate-y-0 transform opacity-100"
        x-transition:leave-end="-translate-y-2 transform opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm"
        x-on:keydown.escape.window="confirmDelete = false"
    >
        <div
            x-show="confirmDelete"
            x-transition
            class="mx-auto max-w-md transform rounded-lg bg-white p-6 shadow-xl transition-all duration-300 dark:bg-gray-800"
            x-on:click.away="confirmDelete = false"
        >
            <div class="flex items-center space-x-3 text-red-600">
                <x-mary-icon name="o-exclamation-triangle" class="h-6 w-6" />
                <h3 class="text-lg font-medium">Konfirmasi Hapus</h3>
            </div>

            <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                Apakah Anda yakin ingin menghapus kelas bimbel ini? Tindakan ini
                tidak dapat dibatalkan.
            </p>

            <div class="mt-6 flex justify-end space-x-3">
                <x-ts-button
                    x-on:click="confirmDelete = false"
                    secondary
                    class="transition-all duration-300 hover:bg-gray-200 dark:hover:bg-gray-700"
                >
                    Batal
                </x-ts-button>
                <x-ts-button
                    wire:click="delete(selectedKelas)"
                    negative
                    x-on:click="confirmDelete = false"
                    class="transform transition-all duration-300 hover:scale-105"
                >
                    Hapus
                </x-ts-button>
            </div>
        </div>
    </div>
</div>
