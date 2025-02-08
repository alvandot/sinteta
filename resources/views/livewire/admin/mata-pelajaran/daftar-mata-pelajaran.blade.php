<div
    x-data="{
        showFilters: false,
        selectedMapel: @entangle("selectedMapel").live,
        confirmDelete: @entangle("showDeleteModal").live,
        darkMode: localStorage.getItem('darkMode') === 'true',
        previewMode: @entangle("showPreviewModal").live,
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

            // Animasi shake untuk toast error
            if (type === 'error') {
                this.$refs.toastContainer.classList.add('animate-shake')
                setTimeout(() => {
                    this.$refs.toastContainer.classList.remove('animate-shake')
                }, 500)
            }

            // Animasi fade out
            setTimeout(() => {
                this.toast.show = false
            }, 3000)
        },
        init() {
            if (this.darkMode) {
                document.documentElement.classList.add('dark')
            }

            // Tambahkan animasi loading awal
            this.$nextTick(() => {
                this.$el.classList.add('animate-fade-in')
            })
        },
    }"
    x-init="init()"
    class="relative min-h-screen overflow-y-auto bg-gradient-to-br from-gray-50 to-white transition-all duration-500 dark:from-gray-900 dark:to-gray-800"
    :class="{ 'dark': darkMode }"
>
    {{-- Dark Mode Toggle dengan animasi --}}
    <button
        @click="toggleDarkMode()"
        class="fixed right-4 top-4 z-50 rounded-full bg-white/10 p-3 shadow-lg backdrop-blur-md transition-all duration-300 hover:scale-110 hover:bg-gray-200 dark:hover:bg-gray-700"
    >
        <x-mary-icon
            x-show="!darkMode"
            name="o-moon"
            class="h-6 w-6 text-gray-700 dark:text-gray-300"
            x-transition:enter="transition-transform duration-300"
            x-transition:enter-start="rotate-180"
            x-transition:enter-end="rotate-0"
        />
        <x-mary-icon
            x-show="darkMode"
            name="o-sun"
            class="h-6 w-6 text-yellow-400"
            x-transition:enter="transition-transform duration-300"
            x-transition:enter-start="rotate-180"
            x-transition:enter-end="rotate-0"
        />
    </button>

    {{-- Toast Notification dengan efek glassmorphism --}}
    <div
        x-show="toast.show"
        x-ref="toastContainer"
        x-transition:enter="transition duration-300 ease-out"
        x-transition:enter-start="translate-y-2 opacity-0"
        x-transition:enter-end="translate-y-0 opacity-100"
        x-transition:leave="transition duration-200 ease-in"
        x-transition:leave-start="translate-y-0 opacity-100"
        x-transition:leave-end="translate-y-2 opacity-0"
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
                'bg-blue-500/90': toast.type === 'info',
                'bg-green-500/90': toast.type === 'success',
                'bg-red-500/90': toast.type === 'error',
                'bg-yellow-500/90': toast.type === 'warning'
            }"
            class="flex min-w-[320px] max-w-md transform items-start space-x-4 rounded-xl p-4 text-white shadow-2xl backdrop-blur-lg transition-all duration-300 hover:scale-105"
        >
            <div class="flex-shrink-0 pt-0.5">
                <template x-if="toast.type === 'info'">
                    <x-mary-icon
                        name="o-information-circle"
                        class="h-6 w-6 animate-bounce text-blue-100"
                    />
                </template>
                <template x-if="toast.type === 'success'">
                    <x-mary-icon
                        name="o-check-circle"
                        class="h-6 w-6 animate-bounce text-green-100"
                    />
                </template>
                <template x-if="toast.type === 'error'">
                    <x-mary-icon
                        name="o-x-circle"
                        class="h-6 w-6 animate-bounce text-red-100"
                    />
                </template>
                <template x-if="toast.type === 'warning'">
                    <x-mary-icon
                        name="o-exclamation-triangle"
                        class="h-6 w-6 animate-bounce text-yellow-100"
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
                class="ml-4 flex-shrink-0 rounded-full p-1.5 text-white transition-all duration-200 hover:scale-110 hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-white"
            >
                <x-mary-icon name="o-x-mark" class="h-5 w-5" />
            </button>
        </div>
    </div>

    {{-- Header Card dengan efek glassmorphism --}}
    <x-mary-card
        class="mb-6 transform border-l-4 border-primary-500 bg-white/80 shadow-2xl backdrop-blur-md transition-all duration-300 hover:scale-[1.02] dark:bg-gray-800/80"
    >
        <div class="relative sm:flex sm:items-center sm:justify-between">
            <div class="relative z-10">
                <h1
                    class="bg-gradient-to-r from-primary-500 via-secondary-500 to-primary-500 bg-clip-text text-4xl font-black tracking-tight text-transparent"
                >
                    Daftar Mata Pelajaran
                </h1>
                <p
                    class="mt-2 text-sm font-medium text-gray-700 dark:text-gray-300"
                >
                    Kelola daftar mata pelajaran yang tersedia di sistem
                </p>
            </div>
            <div class="relative flex sm:mt-0">
                <x-ts-button
                    wire:click="create"
                    primary
                    icon="plus"
                    x-on:click="showToast('Membuat Mata Pelajaran Baru', 'Silahkan isi form yang tersedia', 'info')"
                    class="transform bg-gradient-to-r from-primary-500 via-secondary-500 to-primary-500 font-semibold transition-all duration-300 hover:scale-110 hover:shadow-lg"
                >
                    Tambah Mata Pelajaran
                </x-ts-button>
            </div>

            <!-- Decorative Elements dengan animasi -->
            <div
                class="absolute -bottom-8 -right-8 h-32 w-32 animate-pulse rounded-full bg-primary-500/20 blur-2xl"
            ></div>
            <div
                class="absolute -left-8 -top-8 h-32 w-32 animate-pulse rounded-full bg-secondary-500/20 blur-2xl"
            ></div>
        </div>
    </x-mary-card>

    {{-- Search Card with Advanced Filters --}}
    <x-mary-card class="mb-6 bg-white/80 backdrop-blur-md dark:bg-gray-800/80">
        <div class="space-y-4">
            <div class="relative">
                <x-mary-input
                    wire:model.live.debounce.300ms="search"
                    placeholder="Cari mata pelajaran..."
                    icon="o-magnifying-glass"
                    class="w-full transition-all duration-300 focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white"
                    x-on:input="showToast('Mencari Mata Pelajaran', 'Menampilkan hasil pencarian', 'info')"
                />
                <div class="absolute right-2 top-2">
                    <button
                        @click="showFilters = !showFilters"
                        class="rounded-full p-2 text-gray-400 transition-all duration-200 hover:scale-110 hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-700 dark:hover:text-gray-300"
                    >
                        <x-mary-icon
                            name="o-adjustments-horizontal"
                            class="h-5 w-5"
                        />
                    </button>
                </div>
            </div>

            {{-- Advanced Filters dengan animasi --}}
            <div
                x-show="showFilters"
                x-transition:enter="transition duration-200 ease-out"
                x-transition:enter-start="-translate-y-2 opacity-0"
                x-transition:enter-end="translate-y-0 opacity-100"
                x-transition:leave="transition duration-150 ease-in"
                x-transition:leave-start="translate-y-0 opacity-100"
                x-transition:leave-end="-translate-y-2 opacity-0"
                class="space-y-4 rounded-lg bg-gray-50/80 p-4 backdrop-blur-sm dark:bg-gray-700/80"
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
                                ['label' => 'Aktif', 'value' => '1'],
                                ['label' => 'Tidak Aktif', 'value' => '0']
                            ]"
                            class="w-full transition-all duration-300 hover:ring-2 hover:ring-primary-500 dark:bg-gray-600"
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
                                ['label' => 'Kode', 'value' => 'kode'],
                                ['label' => 'Terbaru', 'value' => 'created_at']
                            ]"
                            class="w-full transition-all duration-300 hover:ring-2 hover:ring-primary-500 dark:bg-gray-600"
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
                            class="w-full transition-all duration-300 hover:ring-2 hover:ring-primary-500 dark:bg-gray-600"
                        />
                    </div>
                </div>
            </div>
        </div>
    </x-mary-card>

    {{-- Grid View dengan animasi yang lebih smooth --}}
    <div
        class="grid grid-cols-1 gap-6 overflow-hidden md:grid-cols-2 lg:grid-cols-3"
        x-transition:enter="transition-all duration-500 ease-out"
        x-transition:enter-start="scale-95 transform opacity-0"
        x-transition:enter-end="scale-100 transform opacity-100"
    >
        @forelse ($mataPelajarans as $mapel)
            <x-mary-card
                x-data="{ hover: false }"
                x-on:mouseenter="hover = true"
                x-on:mouseleave="hover = false"
                x-on:click.prevent="$wire.preview({{ $mapel->id }}); previewMode = true"
                class="group relative mx-2 rounded-xl border-2 border-gray-200 bg-white/80 backdrop-blur-md transition-all duration-300 ease-in-out hover:cursor-pointer hover:border-primary-500 dark:border-gray-700 dark:bg-gray-800/80"
                x-bind:class="{ 'transform scale-105 shadow-2xl': hover }"
            >
                <div class="relative space-y-4">
                    <!-- Status Badge dengan animasi -->
                    <div class="absolute right-0 top-0">
                        <span
                            @class([
                                "inline-flex items-center rounded-bl-xl px-3 py-1.5 text-xs font-medium",
                                "bg-green-100 text-green-800 backdrop-blur-sm dark:bg-green-800/80 dark:text-green-100" =>
                                    $mapel->is_active,
                                "bg-red-100 text-red-800 backdrop-blur-sm dark:bg-red-800/80 dark:text-red-100" => ! $mapel->is_active,
                            ])
                        >
                            <span
                                @class([
                                    "animate-pulse bg-green-600" => $mapel->is_active,
                                    "bg-red-600" => ! $mapel->is_active,
                                ])
                                class="mr-1.5 h-2 w-2 rounded-full"
                            ></span>
                            {{ $mapel->is_active ? "Aktif" : "Tidak Aktif" }}
                        </span>
                    </div>

                    <!-- Header dengan animasi -->
                    <div class="mb-2">
                        <h3
                            class="text-lg font-semibold text-gray-900 decoration-primary-500 decoration-2 group-hover:underline dark:text-white"
                        >
                            {{ $mapel->nama_pelajaran }}
                        </h3>
                    </div>

                    <!-- Content dengan hover effects -->
                    <div class="space-y-3">
                        <div
                            class="flex items-center rounded-lg bg-gray-50/80 p-2 text-sm text-gray-600 transition-all duration-300 hover:scale-[1.02] hover:bg-primary-50 dark:bg-gray-700/50 dark:text-gray-300"
                        >
                            <x-mary-icon
                                name="o-academic-cap"
                                class="mr-2.5 h-5 w-5 text-primary-500"
                            />
                            <span class="font-medium">
                                {{ $mapel->kode_pelajaran }}
                            </span>
                        </div>

                        <div
                            class="flex items-start rounded-lg bg-gray-50/80 p-2 text-sm text-gray-600 transition-all duration-300 hover:scale-[1.02] hover:bg-primary-50 dark:bg-gray-700/50 dark:text-gray-300"
                        >
                            <x-mary-icon
                                name="o-document-text"
                                class="mr-2.5 h-5 w-5 text-primary-500"
                            />
                            <span class="line-clamp-2">
                                {{ $mapel->deskripsi ?? "Tidak ada deskripsi" }}
                            </span>
                        </div>
                    </div>

                    <!-- Actions dengan animasi -->
                    <div class="flex justify-end space-x-2 pt-3">
                        <x-ts-button
                            wire:click="edit({{ $mapel->id }})"
                            secondary
                            icon="pencil"
                            size="sm"
                            class="transform bg-primary-50 transition-all duration-300 hover:scale-110 hover:bg-primary-600 hover:text-white dark:bg-gray-700"
                        >
                            Edit
                        </x-ts-button>
                        <x-ts-button
                            x-on:click="selectedMapel = {{ $mapel->id }}; confirmDelete = true"
                            negative
                            icon="trash"
                            size="sm"
                            class="transform transition-all duration-300 hover:scale-110 hover:bg-red-600"
                        >
                            Hapus
                        </x-ts-button>
                    </div>
                </div>
            </x-mary-card>
        @empty
            <div class="col-span-full">
                <x-mary-card
                    class="bg-white/80 text-center text-gray-500 backdrop-blur-md dark:bg-gray-800/80 dark:text-gray-400"
                >
                    <div class="py-12">
                        <x-mary-icon
                            name="o-book-open"
                            class="mx-auto h-12 w-12 animate-bounce text-gray-400 dark:text-gray-500"
                        />
                        <h3 class="mt-4 text-lg font-medium dark:text-white">
                            Tidak ada mata pelajaran yang ditemukan
                        </h3>
                        <p
                            class="mt-2 text-sm text-gray-500 dark:text-gray-400"
                        >
                            Coba ubah kata kunci pencarian Anda
                        </p>
                    </div>
                </x-mary-card>
            </div>
        @endforelse
    </div>

    {{-- Pagination dengan Smooth Scroll --}}
    @if (count($mataPelajarans))
        <div
            class="mt-6"
            x-data="{ scrollToTop: false }"
            x-on:click="
                scrollToTop = true
                window.scrollTo({ top: 0, behavior: 'smooth' })
            "
            x-on:click.window="scrollToTop = false"
        >
            {{ $mataPelajarans->links() }}
        </div>
    @endif

    {{-- Delete Confirmation Modal dengan Enhanced UI --}}
    <div
        x-cloak
        x-show="confirmDelete"
        x-transition:enter="transition duration-300 ease-out"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition duration-200 ease-in"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm"
        x-on:keydown.escape.window="confirmDelete = false"
    >
        <div
            x-show="confirmDelete"
            x-transition
            class="mx-auto max-w-md transform rounded-xl bg-white/90 p-6 shadow-2xl backdrop-blur-md transition-all duration-300 dark:bg-gray-800/90"
            x-on:click.away="confirmDelete = false"
        >
            <div class="flex items-center space-x-3 text-red-600">
                <x-mary-icon
                    name="o-exclamation-triangle"
                    class="h-6 w-6 animate-pulse"
                />
                <h3 class="text-lg font-medium">Konfirmasi Hapus</h3>
            </div>

            <p class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                Apakah Anda yakin ingin menghapus mata pelajaran ini? Tindakan
                ini tidak dapat dibatalkan.
            </p>

            <div class="mt-6 flex justify-end space-x-3">
                <x-ts-button
                    x-on:click="confirmDelete = false"
                    secondary
                    class="transition-all duration-300 hover:scale-105 hover:bg-gray-200 dark:hover:bg-gray-700"
                >
                    Batal
                </x-ts-button>
                <x-ts-button
                    wire:click="delete(selectedMapel)"
                    negative
                    x-on:click="confirmDelete = false"
                    class="transform bg-gradient-to-r from-red-500 to-red-600 transition-all duration-300 hover:scale-110"
                >
                    Hapus
                </x-ts-button>
            </div>
        </div>
    </div>

    {{-- Preview Modal dengan Enhanced UI --}}
    <div
        x-cloak
        x-show="previewMode"
        x-transition:enter="transition duration-300 ease-out"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition duration-200 ease-in"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-50 flex items-center justify-center overflow-hidden bg-black/50 backdrop-blur-sm"
        x-on:keydown.escape.window="previewMode = false"
    >
        <div
            x-show="previewMode"
            x-transition
            class="mx-auto my-8 w-full max-w-2xl transform overflow-hidden rounded-xl bg-white/90 shadow-2xl backdrop-blur-md transition-all duration-300 dark:bg-gray-800/90"
            x-on:click.away="previewMode = false"
        >
            <!-- Header -->
            <div
                class="sticky top-0 z-10 border-b border-gray-200 bg-gradient-to-r from-primary-500 to-secondary-500 px-6 py-4 dark:border-gray-700"
            >
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-white">
                        Preview Mata Pelajaran
                    </h3>
                    <button
                        x-on:click="previewMode = false"
                        class="rounded-full p-1 text-white transition-all duration-200 hover:scale-110 hover:bg-white/20"
                    >
                        <x-mary-icon name="o-x-mark" class="h-5 w-5" />
                    </button>
                </div>
            </div>

            <!-- Content -->
            <div class="max-h-[calc(90vh-8rem)] overflow-hidden px-6 py-4">
                <div class="space-y-6">
                    <!-- Status Badge -->
                    <div class="flex justify-end">
                        <span
                            @class([
                                "inline-flex items-center rounded-full px-3 py-1 text-sm font-medium",
                                "bg-green-100 text-green-800 dark:bg-green-800 dark:text-green-100" =>
                                    $selectedMapelData?->is_active,
                                "bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-100" => ! $selectedMapelData?->is_active,
                            ])
                        >
                            <span
                                @class([
                                    "mr-1.5 h-2 w-2 rounded-full",
                                    "bg-green-500" => $selectedMapelData?->is_active,
                                    "bg-red-500" => ! $selectedMapelData?->is_active,
                                ])
                            ></span>
                            {{ $selectedMapelData?->is_active ? "Aktif" : "Tidak Aktif" }}
                        </span>
                    </div>

                    <!-- Kode Pelajaran -->
                    <div class="rounded-lg bg-gray-50 p-4 dark:bg-gray-700/50">
                        <div class="flex items-center space-x-3">
                            <x-mary-icon
                                name="o-academic-cap"
                                class="h-6 w-6 text-primary-500"
                            />
                            <div>
                                <p
                                    class="text-sm font-medium text-gray-500 dark:text-gray-400"
                                >
                                    Kode Pelajaran
                                </p>
                                <p
                                    class="text-lg font-semibold text-gray-900 dark:text-white"
                                >
                                    {{ $selectedMapelData?->kode_pelajaran }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Nama Pelajaran -->
                    <div class="rounded-lg bg-gray-50 p-4 dark:bg-gray-700/50">
                        <div class="flex items-center space-x-3">
                            <x-mary-icon
                                name="o-book-open"
                                class="h-6 w-6 text-primary-500"
                            />
                            <div>
                                <p
                                    class="text-sm font-medium text-gray-500 dark:text-gray-400"
                                >
                                    Nama Pelajaran
                                </p>
                                <p
                                    class="text-lg font-semibold text-gray-900 dark:text-white"
                                >
                                    {{ $selectedMapelData?->nama_pelajaran }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="rounded-lg bg-gray-50 p-4 dark:bg-gray-700/50">
                        <div class="flex items-start space-x-3">
                            <x-mary-icon
                                name="o-document-text"
                                class="h-6 w-6 text-primary-500"
                            />
                            <div>
                                <p
                                    class="text-sm font-medium text-gray-500 dark:text-gray-400"
                                >
                                    Deskripsi
                                </p>
                                <p class="mt-1 text-gray-900 dark:text-white">
                                    {{ $selectedMapelData?->deskripsi ?? "Tidak ada deskripsi" }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Daftar Tentor -->
                    <div class="rounded-lg bg-gray-50 p-4 dark:bg-gray-700/50">
                        <div class="flex items-start space-x-3">
                            <x-mary-icon
                                name="o-users"
                                class="h-6 w-6 text-primary-500"
                            />
                            <div class="w-full">
                                <p
                                    class="text-sm font-medium text-gray-500 dark:text-gray-400"
                                >
                                    Daftar Tentor
                                </p>
                                @if ($selectedMapelData?->tentors->count() > 0)
                                    <div
                                        class="mt-3 divide-y divide-gray-200 dark:divide-gray-600"
                                    >
                                        @foreach ($selectedMapelData->tentors as $tentor)
                                            <div
                                                class="flex items-center justify-between py-2"
                                            >
                                                <div
                                                    class="flex items-center space-x-3"
                                                >
                                                    <div
                                                        class="flex h-8 w-8 items-center justify-center rounded-full bg-primary-100 dark:bg-primary-800"
                                                    >
                                                        <span
                                                            class="text-sm font-medium text-primary-700 dark:text-primary-300"
                                                        >
                                                            {{ substr($tentor->user->name, 0, 1) }}
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <p
                                                            class="text-sm font-medium text-gray-900 dark:text-white"
                                                        >
                                                            {{ $tentor->user->name }}
                                                        </p>
                                                        <p
                                                            class="text-sm font-medium text-gray-600 dark:text-white"
                                                        >
                                                            {{ $tentor->no_telepon }}
                                                        </p>
                                                        <p
                                                            class="text-xs text-gray-500 dark:text-gray-400"
                                                        >
                                                            {{ $tentor->email }}
                                                        </p>
                                                    </div>
                                                </div>
                                                <span
                                                    @class([
                                                        "inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium",
                                                        "bg-green-100 text-green-800 dark:bg-green-800/30 dark:text-green-500" =>
                                                            $tentor->pivot->status === "aktif",
                                                        "bg-yellow-100 text-yellow-800 dark:bg-yellow-800/30 dark:text-yellow-500" =>
                                                            $tentor->pivot->status === "pending",
                                                        "bg-red-100 text-red-800 dark:bg-red-800/30 dark:text-red-500" =>
                                                            $tentor->pivot->status === "nonaktif",
                                                    ])
                                                >
                                                    {{ ucfirst($tentor->pivot->status) }}
                                                </span>
                                            </div>
                                            @if ($tentor->pivot->catatan)
                                                <p
                                                    class="mt-1 text-xs italic text-gray-500 dark:text-gray-400"
                                                >
                                                    Catatan:
                                                    {{ $tentor->pivot->catatan }}
                                                </p>
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <p
                                        class="mt-2 text-sm text-gray-500 dark:text-gray-400"
                                    >
                                        Belum ada tentor yang ditugaskan
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Metadata -->
                    <div class="grid grid-cols-2 gap-4">
                        <div
                            class="rounded-lg bg-gray-50 p-4 dark:bg-gray-700/50"
                        >
                            <p
                                class="text-sm font-medium text-gray-500 dark:text-gray-400"
                            >
                                Dibuat pada
                            </p>
                            <p class="mt-1 text-gray-900 dark:text-white">
                                @if ($selectedMapelData?->created_at instanceof \Carbon\Carbon)
                                    {{ $selectedMapelData->created_at->format("d M Y H:i") }}
                                @else
                                        -
                                @endif
                            </p>
                        </div>
                        <div
                            class="rounded-lg bg-gray-50 p-4 dark:bg-gray-700/50"
                        >
                            <p
                                class="text-sm font-medium text-gray-500 dark:text-gray-400"
                            >
                                Terakhir diupdate
                            </p>
                            <p class="mt-1 text-gray-900 dark:text-white">
                                @if ($selectedMapelData?->updated_at instanceof \Carbon\Carbon)
                                    {{ $selectedMapelData->updated_at->format("d M Y H:i") }}
                                @else
                                        -
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div
                class="sticky bottom-0 border-t border-gray-200 bg-gray-50 px-6 py-4 dark:border-gray-700 dark:bg-gray-800"
            >
                <div class="flex justify-end">
                    <x-mary-button
                        x-on:click="previewMode = false"
                        class="bg-gradient-to-r from-primary-500 to-secondary-500 text-white transition-all duration-300 hover:scale-105"
                    >
                        Tutup
                    </x-mary-button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Form dengan Enhanced UI --}}
    <x-mary-modal
        wire:model="showModal"
        class="transform overflow-hidden backdrop-blur-lg transition-all duration-300 dark:bg-gray-800/90"
    >
        <!-- Header dengan gradient dan icon -->
        <div
            class="-mx-6 -mt-6 mb-6 flex items-center space-x-3 bg-gradient-to-r from-primary-500 to-secondary-500 p-4 text-white"
        >
            <x-mary-icon name="o-academic-cap" class="h-8 w-8 animate-bounce" />
            <div class="text-lg font-medium leading-6">
                {{ $editMode ? "Edit Mata Pelajaran" : "Tambah Mata Pelajaran Baru" }}
            </div>
        </div>

        <div class="space-y-6 overflow-y-auto">
            <!-- Kode Pelajaran -->
            <div class="group">
                <label
                    class="mb-2 block text-sm font-medium leading-6 text-gray-900 transition-colors duration-300 group-hover:text-primary-500 dark:text-gray-100"
                >
                    Kode Pelajaran
                </label>
                <div class="relative">
                    <x-mary-icon
                        name="o-identification"
                        class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400 transition-colors duration-300 group-hover:text-primary-500"
                    />
                    <x-mary-input
                        wire:model="kode_pelajaran"
                        placeholder="Masukkan kode pelajaran"
                        class="w-full pl-10 transition-all duration-300 hover:shadow-md focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white"
                    />
                </div>
                @error("kode_pelajaran")
                    <span
                        class="mt-1 flex animate-pulse items-center text-sm text-red-500"
                    >
                        <x-mary-icon
                            name="o-exclamation-circle"
                            class="mr-1 h-4 w-4"
                        />
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <!-- Nama Pelajaran -->
            <div class="group">
                <label
                    class="mb-2 block text-sm font-medium leading-6 text-gray-900 transition-colors duration-300 group-hover:text-primary-500 dark:text-gray-100"
                >
                    Nama Pelajaran
                </label>
                <div class="relative">
                    <x-mary-icon
                        name="o-book-open"
                        class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400 transition-colors duration-300 group-hover:text-primary-500"
                    />
                    <x-mary-input
                        wire:model="nama_pelajaran"
                        placeholder="Masukkan nama pelajaran"
                        class="w-full pl-10 transition-all duration-300 hover:shadow-md focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white"
                    />
                </div>
                @error("nama_pelajaran")
                    <span
                        class="mt-1 flex animate-pulse items-center text-sm text-red-500"
                    >
                        <x-mary-icon
                            name="o-exclamation-circle"
                            class="mr-1 h-4 w-4"
                        />
                        {{ $message }}
                    </span>
                @enderror
            </div>

            <!-- Deskripsi -->
            <div class="group">
                <label
                    class="mb-2 block text-sm font-medium leading-6 text-gray-900 transition-colors duration-300 group-hover:text-primary-500 dark:text-gray-100"
                >
                    Deskripsi
                </label>
                <div class="relative">
                    <x-mary-icon
                        name="o-document-text"
                        class="absolute left-3 top-3 h-5 w-5 text-gray-400 transition-colors duration-300 group-hover:text-primary-500"
                    />
                    <x-mary-textarea
                        wire:model="deskripsi"
                        placeholder="Masukkan deskripsi mata pelajaran"
                        class="w-full pl-10 transition-all duration-300 hover:shadow-md focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white"
                        rows="4"
                    />
                </div>
                @error("deskripsi")
                    <span
                        class="mt-1 flex animate-pulse items-center text-sm text-red-500"
                    >
                        <x-mary-icon
                            name="o-exclamation-circle"
                            class="mr-1 h-4 w-4"
                        />
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>

        <!-- Footer dengan efek glassmorphism -->
        <x-slot name="footer">
            <div
                class="-mx-6 -mb-6 flex justify-end gap-x-4 bg-white/10 p-4 backdrop-blur-lg dark:bg-gray-800/10"
            >
                <x-mary-button
                    wire:click="$toggle('showModal')"
                    variant="secondary"
                    class="flex transform items-center gap-x-2 transition-all duration-300 hover:scale-105 hover:shadow-lg dark:hover:bg-gray-700"
                >
                    <x-mary-icon name="o-x-mark" class="h-4 w-4" />
                    Batal
                </x-mary-button>
                <x-mary-button
                    wire:click="save"
                    class="flex transform items-center gap-x-2 bg-gradient-to-r from-primary-500 to-secondary-500 text-white transition-all duration-300 hover:scale-105 hover:shadow-lg"
                >
                    <x-mary-icon name="o-check" class="h-4 w-4" />
                    {{ $editMode ? "Simpan Perubahan" : "Simpan" }}
                </x-mary-button>
            </div>
        </x-slot>
    </x-mary-modal>
</div>
