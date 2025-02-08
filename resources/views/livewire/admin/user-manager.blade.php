<div>
    {{-- Header Card --}}
    <x-card class="mb-6">
        <div class="sm:flex sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Manajemen Pengguna
                </h1>
                <p class="mt-2 text-sm text-gray-700">
                    Kelola data pengguna sistem
                </p>
            </div>
            <div class="mt-4 sm:mt-0">
                <x-ts-button wire:click="create" primary icon="o-plus">
                    Tambah Pengguna
                </x-ts-button>
            </div>
        </div>
    </x-card>

    {{-- Filter Card --}}
    <x-card class="mb-6">
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <x-form.input
                name="search"
                wire:model.live.debounce.300ms="search"
                placeholder="Cari pengguna..."
                leadingIcon="o-magnifying-glass"
            />

            <x-form.select
                name="role_filter"
                wire:model.live="role_filter"
                :options="$roles"
                placeholder="Filter Role"
                leadingIcon="o-user-group"
            />

            <x-form.select
                name="status_filter"
                wire:model.live="status_filter"
                :options="[
                    ['value' => '1', 'label' => 'Aktif'],
                    ['value' => '0', 'label' => 'Tidak Aktif'],
                ]"
                placeholder="Filter Status"
                leadingIcon="o-check-circle"
            />

            <x-form.select
                name="per_page"
                wire:model.live="per_page"
                :options="[
                    ['value' => 10, 'label' => '10 Data'],
                    ['value' => 25, 'label' => '25 Data'],
                    ['value' => 50, 'label' => '50 Data'],
                    ['value' => 100, 'label' => '100 Data'],
                ]"
                placeholder="Data per halaman"
                leadingIcon="o-list-bullet"
            />
        </div>
    </x-card>

    {{-- Table Card --}}
    <x-card>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                        >
                            Avatar
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                        >
                            Nama
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                        >
                            Email
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                        >
                            Role
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                        >
                            Status
                        </th>
                        <th
                            class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500"
                        >
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse ($users as $user)
                        <tr wire:key="{{ $user->id }}">
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="h-10 w-10">
                                    @if ($user->getFirstMediaUrl("avatar"))
                                        <img
                                            src="{{ $user->getFirstMediaUrl("avatar") }}"
                                            alt="{{ $user->name }}"
                                            class="h-10 w-10 rounded-full object-cover"
                                        />
                                    @else
                                        <div
                                            class="flex h-10 w-10 items-center justify-center rounded-full bg-violet-100 text-violet-600"
                                        >
                                            <x-ts-icon
                                                name="o-user"
                                                class="h-6 w-6"
                                            />
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $user->name }}
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="text-sm text-gray-500">
                                    {{ $user->email }}
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex items-center gap-1">
                                    @foreach ($user->roles as $role)
                                        <span
                                            class="inline-flex items-center rounded-full bg-violet-100 px-2.5 py-0.5 text-xs font-medium text-violet-800"
                                        >
                                            {{ ucwords(str_replace("_", " ", $role->name)) }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <span
                                    @class([
                                        "inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium",
                                        "bg-green-100 text-green-800" => $user->is_active,
                                        "bg-red-100 text-red-800" => ! $user->is_active,
                                    ])
                                >
                                    {{ $user->is_active ? "Aktif" : "Tidak Aktif" }}
                                </span>
                            </td>
                            <td
                                class="whitespace-nowrap px-6 py-4 text-right text-sm"
                            >
                                <x-ts-button
                                    wire:click="edit({{ $user->id }})"
                                    secondary
                                    icon="o-pencil-square"
                                    class="mr-1"
                                >
                                    Edit
                                </x-ts-button>
                                <x-ts-button
                                    wire:click="confirmDelete({{ $user->id }})"
                                    negative
                                    icon="o-trash"
                                >
                                    Hapus
                                </x-ts-button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td
                                colspan="6"
                                class="px-6 py-4 text-center text-gray-500"
                            >
                                Tidak ada data pengguna
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </x-card>

    {{-- Form Modal --}}
    <x-modal
        name="form-modal"
        :title="$modalTitle"
        wire:model="showModal"
        maxWidth="xl"
    >
        <form wire:submit="save" class="space-y-4">
            <x-form.input
                name="name"
                label="Nama"
                wire:model="name"
                required
                :error="$errors->first('name')"
                placeholder="Masukkan nama"
                leadingIcon="o-user"
            />

            <x-form.input
                type="email"
                name="email"
                label="Email"
                wire:model="email"
                required
                :error="$errors->first('email')"
                placeholder="Masukkan email"
                leadingIcon="o-envelope"
            />

            <div class="grid gap-4 sm:grid-cols-2">
                <x-form.input
                    type="password"
                    name="password"
                    label="Password"
                    wire:model="password"
                    :required="!$user_id"
                    :error="$errors->first('password')"
                    placeholder="Masukkan password"
                    leadingIcon="o-key"
                    helper="{{ $user_id ? 'Kosongkan jika tidak ingin mengubah password' : '' }}"
                />

                <x-form.input
                    type="password"
                    name="password_confirmation"
                    label="Konfirmasi Password"
                    wire:model="password_confirmation"
                    :required="!$user_id"
                    :error="$errors->first('password_confirmation')"
                    placeholder="Konfirmasi password"
                    leadingIcon="o-key"
                />
            </div>

            <x-form.select
                name="role"
                label="Role"
                wire:model="role"
                :options="$roles"
                required
                :error="$errors->first('role')"
                placeholder="Pilih role"
                leadingIcon="o-user-group"
            />

            <div>
                <x-ts-label value="Avatar" />
                <div class="mt-1 flex items-center space-x-4">
                    @if ($avatar)
                        <div class="relative h-20 w-20">
                            <img
                                src="{{ $avatar->temporaryUrl() }}"
                                class="h-20 w-20 rounded-full object-cover"
                            />
                            <button
                                type="button"
                                wire:click="$set('avatar', null)"
                                class="absolute -right-2 -top-2 rounded-full bg-red-500 p-1 text-white hover:bg-red-600"
                            >
                                <x-ts-icon name="o-x-mark" class="h-4 w-4" />
                            </button>
                        </div>
                    @endif

                    <x-ts-upload wire:model="avatar">
                        <x-ts-icon name="o-photo" class="h-6 w-6" />
                        <span class="text-sm">Upload Avatar</span>
                    </x-ts-upload>
                </div>
                @error("avatar")
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="inline-flex items-center">
                    <x-ts-toggle wire:model="is_active" />
                    <span class="ml-2 text-sm text-gray-600">Aktif</span>
                </label>
            </div>

            <div class="flex justify-end space-x-3">
                <x-ts-button wire:click="$toggle('showModal')" secondary>
                    Batal
                </x-ts-button>

                <x-ts-button type="submit" primary :loading="$loading">
                    Simpan
                </x-ts-button>
            </div>
        </form>
    </x-modal>

    {{-- Delete Modal --}}
    <x-modal
        name="delete-modal"
        title="Hapus Pengguna"
        subtitle="Apakah Anda yakin ingin menghapus pengguna ini?"
        icon="o-exclamation-triangle"
        wire:model="showDeleteModal"
    >
        <div class="mt-4 flex justify-end space-x-3">
            <x-ts-button wire:click="$toggle('showDeleteModal')" secondary>
                Batal
            </x-ts-button>

            <x-ts-button wire:click="delete" negative :loading="$loading">
                Hapus
            </x-ts-button>
        </div>
    </x-modal>
</div>
