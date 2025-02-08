<div>
    <div class="min-h-screen bg-gray-50 p-4 lg:p-8">
        <!-- Header Section -->
        <div
            class="transition duration-300 ease-out"
            x-transition:enter-start="-translate-y-4 transform opacity-0"
            x-transition:enter-end="translate-y-0 transform opacity-100"
            class="mb-8"
        >
            <h1
                class="bg-gradient-to-r from-violet-600 to-indigo-600 bg-clip-text text-3xl font-bold text-transparent"
                role="heading"
                aria-level="1"
            >
                Dashboard Admin
            </h1>
            <p class="mt-2 text-gray-600">
                Selamat datang kembali, {{ $userCurrent->name }}!
            </p>
        </div>

        <!-- Stats Grid -->
        <div
            x-transition:enter="transition delay-150 duration-300 ease-out"
            x-transition:enter-start="translate-y-4 transform opacity-0"
            x-transition:enter-end="translate-y-0 transform opacity-100"
            class="mb-8 grid grid-cols-1 gap-6 md:grid-cols-3"
        >
            <!-- Cabang Stats -->
            <x-mary-card
                shadow
                class="border-none bg-gradient-to-br from-white to-gray-50 transition-all duration-300 hover:scale-[1.02]"
            >
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">
                                Total Cabang
                            </h3>
                            <p class="mt-1 text-3xl font-bold text-violet-600">
                                {{ $cabang_count ?? 0 }}
                            </p>
                        </div>
                        <div class="rounded-lg bg-violet-100 p-3">
                            <x-mary-icon
                                name="o-building-office"
                                class="h-8 w-8 text-violet-600"
                            />
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-sm text-gray-600">
                            Lokasi tersebar di Indonesia
                        </p>
                    </div>
                </div>
            </x-mary-card>

            <!-- Siswa Stats -->
            <x-mary-card
                shadow
                class="border-none bg-gradient-to-br from-white to-gray-50 transition-all duration-300 hover:scale-[1.02]"
            >
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">
                                Total Siswa
                            </h3>
                            <p class="mt-1 text-3xl font-bold text-green-600">
                                {{ $siswa_count ?? 0 }}
                            </p>
                        </div>
                        <div class="rounded-lg bg-green-100 p-3">
                            <x-mary-icon
                                name="o-academic-cap"
                                class="h-8 w-8 text-green-600"
                            />
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-sm text-gray-600">
                            Siswa aktif bimbingan
                        </p>
                    </div>
                </div>
            </x-mary-card>

            <!-- Tentor Stats -->
            <x-mary-card
                shadow
                class="border-none bg-gradient-to-br from-white to-gray-50 transition-all duration-300 hover:scale-[1.02]"
            >
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800">
                                Total Pengajar
                            </h3>
                            <p class="mt-1 text-3xl font-bold text-blue-600">
                                {{ $tentor_count ?? 0 }}
                            </p>
                        </div>
                        <div class="rounded-lg bg-blue-100 p-3">
                            <x-mary-icon
                                name="o-users"
                                class="h-8 w-8 text-blue-600"
                            />
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-sm text-gray-600">Tentor profesional</p>
                    </div>
                </div>
            </x-mary-card>
        </div>

        <!-- Quick Actions -->
        <div class="mb-8">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-4">
                <a href="{{ route('admin.siswa.create') }}" class="flex items-center gap-2 bg-violet-600 text-white hover:bg-violet-700 px-4 py-2 rounded-lg transition-colors duration-200">
                    <x-mary-icon name="o-plus" class="h-5 w-5" />
                    Tambah Siswa Baru
                </a>
                <a href="#" class="flex items-center gap-2 bg-emerald-600 text-white hover:bg-emerald-700 px-4 py-2 rounded-lg transition-colors duration-200">
                    <x-mary-icon name="o-plus" class="h-5 w-5" />
                    Tambah Tentor
                </a>
                <a href="{{ route('admin.cabang.index') }}" class="flex items-center gap-2 bg-blue-600 text-white hover:bg-blue-700 px-4 py-2 rounded-lg transition-colors duration-200">
                    <x-mary-icon name="o-building-office" class="h-5 w-5" />
                    Kelola Cabang
                </a>
                <a href="#" class="flex items-center gap-2 bg-amber-600 text-white hover:bg-amber-700 px-4 py-2 rounded-lg transition-colors duration-200">
                    <x-mary-icon name="o-document-chart-bar" class="h-5 w-5" />
                    Laporan
                </a>
            </div>
        </div>

        <!-- Table Section -->
        <div class="overflow-hidden rounded-xl bg-white shadow-lg">
            <!-- Table Header -->
            <div class="border-b border-gray-200 p-6">
                <div
                    class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between"
                >
                    <h2 class="text-xl font-semibold text-gray-800">
                        Daftar Pengguna
                    </h2>

                    <!-- Search Input -->
                    <div class="flex items-center gap-4">
                        <x-mary-select wire:model.live="roleFilter" class="w-40">
                            <option value="">Semua Role</option>
                            <option value="admin">Admin</option>
                            <option value="tentor">Tentor</option>
                            <option value="siswa">Siswa</option>
                        </x-mary-select>

                        <x-mary-select wire:model.live="cabangFilter" class="w-40">
                            <option value="">Semua Cabang</option>
                            @foreach($cabangs as $cabang)
                                <option value="{{ $cabang->id }}">{{ $cabang->nama }}</option>
                            @endforeach
                        </x-mary-select>
                    </div>
                </div>
            </div>

            <!-- Table Content -->
            <div class="overflow-x-auto">
                <x-mary-table
                    :headers="$headers"
                    :rows="$users"
                    :sort-by="$sortBy"
                >
                    @scope("cell_roles", $user)
                        <div class="flex items-center gap-2">
                            @if ($user->roles->first()?->name === "admin")
                                <div
                                    class="inline-flex items-center gap-1.5 rounded-full bg-gradient-to-r from-blue-500/10 to-blue-600/10 px-3 py-1.5 text-sm font-medium text-blue-700"
                                >
                                    <x-mary-icon
                                        name="o-shield-check"
                                        class="h-4 w-4"
                                    />
                                    {{ ucfirst($user->roles->first()->name) }}
                                </div>
                            @elseif ($user->roles->first()?->name === "tentor")
                                <div
                                    class="inline-flex items-center gap-1.5 rounded-full bg-gradient-to-r from-emerald-500/10 to-emerald-600/10 px-3 py-1.5 text-sm font-medium text-emerald-700"
                                >
                                    <x-mary-icon
                                        name="o-academic-cap"
                                        class="h-4 w-4"
                                    />
                                    {{ ucfirst($user->roles->first()->name) }}
                                </div>
                            @elseif ($user->roles->first()?->name === "siswa")
                                <div
                                    class="inline-flex items-center gap-1.5 rounded-full bg-gradient-to-r from-violet-500/10 to-violet-600/10 px-3 py-1.5 text-sm font-medium text-violet-700"
                                >
                                    <x-mary-icon
                                        name="o-user"
                                        class="h-4 w-4"
                                    />
                                    {{ ucfirst($user->roles->first()->name) }}
                                </div>
                            @endif
                        </div>
                    @endscope

                    @scope("actions", $user)
                        <div class="flex items-center gap-2">
                            <x-mary-button
                                class="bg-violet-100 text-violet-700 hover:bg-violet-200 focus:ring-2 focus:ring-violet-500 focus:ring-offset-2"
                                size="sm"
                                aria-label="Edit {{ $user->name }}"
                            >
                                <x-mary-icon
                                    name="o-pencil-square"
                                    class="h-4 w-4"
                                />
                            </x-mary-button>
                            <x-mary-button
                                wire:click="delete({{ $user->id }})"
                                class="bg-red-100 text-red-700 hover:bg-red-200 focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                                size="sm"
                                aria-label="Delete {{ $user->name }}"
                            >
                                <x-mary-icon name="o-trash" class="h-4 w-4" />
                            </x-mary-button>
                        </div>
                    @endscope
                </x-mary-table>
            </div>
        </div>
    </div>
</div>
