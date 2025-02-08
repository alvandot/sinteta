<div>
    {{-- Header Card --}}
    <x-card class="mb-6">
        <div class="sm:flex sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Manajemen Role</h1>
                <p class="mt-2 text-sm text-gray-700">
                    Kelola role dan permission sistem
                </p>
            </div>
            <div class="mt-4 sm:mt-0">
                <x-ts-button wire:click="create" primary icon="o-plus">
                    Tambah Role
                </x-ts-button>
            </div>
        </div>
    </x-card>

    {{-- Filter Card --}}
    <x-card class="mb-6">
        <div class="grid gap-4 sm:grid-cols-2">
            <x-form.input
                name="search"
                wire:model.live.debounce.300ms="search"
                placeholder="Cari role..."
                leadingIcon="o-magnifying-glass"
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
                            Role
                        </th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                        >
                            Permissions
                        </th>
                        <th
                            class="px-6 py-3 text-center text-xs font-medium uppercase tracking-wider text-gray-500"
                        >
                            Pengguna
                        </th>
                        <th
                            class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-gray-500"
                        >
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse ($roles as $role)
                        <tr
                            wire:key="{{ $role->id }}"
                            @class([
                                "group transition-colors duration-200",
                                "hover:bg-gray-50" => ! $role->is_admin,
                                "bg-violet-50 hover:bg-violet-100" => $role->is_admin,
                            ])
                        >
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="flex items-center">
                                    @if ($role->is_admin)
                                        <span class="mr-2 flex h-2 w-2">
                                            <span
                                                class="absolute inline-flex h-2 w-2 animate-ping rounded-full bg-violet-400 opacity-75"
                                            ></span>
                                            <span
                                                class="relative inline-flex h-2 w-2 rounded-full bg-violet-500"
                                            ></span>
                                        </span>
                                    @endif

                                    <span
                                        @class([
                                            "text-sm font-medium",
                                            "text-gray-900" => ! $role->is_admin,
                                            "text-violet-900" => $role->is_admin,
                                        ])
                                    >
                                        {{ $role->formatted_name }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-2">
                                    @foreach ($role->grouped_permissions as $group => $permissions)
                                        <div
                                            class="flex flex-col rounded-lg border border-gray-200 bg-white p-2 shadow-sm"
                                        >
                                            <span
                                                class="mb-1 text-xs font-semibold uppercase text-gray-500"
                                            >
                                                {{ ucwords($group) }}
                                            </span>
                                            <div class="flex flex-wrap gap-1">
                                                @foreach ($permissions as $permission)
                                                    <span
                                                        class="inline-flex items-center rounded-full bg-violet-100 px-2.5 py-0.5 text-xs font-medium text-violet-800"
                                                    >
                                                        {{ $permission->clean_name }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4 text-center">
                                <span
                                    @class([
                                        "inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium",
                                        "bg-gray-100 text-gray-800" => ! $role->is_admin,
                                        "bg-violet-100 text-violet-800" => $role->is_admin,
                                    ])
                                >
                                    {{ $role->users_count }} Pengguna
                                </span>
                            </td>
                            <td
                                class="whitespace-nowrap px-6 py-4 text-right text-sm"
                            >
                                <div
                                    class="invisible flex justify-end space-x-2 group-hover:visible"
                                >
                                    <x-ts-button
                                        wire:click="edit({{ $role->id }})"
                                        secondary
                                        icon="o-pencil-square"
                                        :title="$role->is_name_editable ? 'Edit role' : 'Role admin tidak dapat diubah namanya'"
                                    >
                                        Edit
                                    </x-ts-button>
                                    @if (! $role->is_admin)
                                        <x-ts-button
                                            wire:click="confirmDelete({{ $role->id }})"
                                            negative
                                            icon="o-trash"
                                            :disabled="!$role->is_deletable"
                                            :title="!$role->is_deletable ? 'Role masih digunakan oleh pengguna' : 'Hapus role'"
                                        >
                                            Hapus
                                        </x-ts-button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td
                                colspan="4"
                                class="px-6 py-4 text-center text-gray-500"
                            >
                                Tidak ada data role
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $roles->links() }}
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
                label="Nama Role"
                wire:model="name"
                required
                :error="$errors->first('name')"
                placeholder="Masukkan nama role"
                leadingIcon="o-user-group"
                helper="Gunakan underscore untuk spasi, contoh: super_admin"
            />

            <div>
                <x-ts-label value="Permissions" />
                <div class="mt-2 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($grouped_permissions as $group => $permissions)
                        <div
                            class="rounded-lg border border-gray-200 p-4 transition-colors duration-200 hover:border-violet-200 hover:bg-violet-50/50"
                        >
                            <div class="mb-2 flex items-center justify-between">
                                <span
                                    class="text-sm font-semibold uppercase text-gray-700"
                                >
                                    {{ ucwords($group) }}
                                </span>
                                <button
                                    type="button"
                                    wire:click="$set('selected_permissions', @js(collect($permissions)->pluck("name")->toArray()))"
                                    class="text-xs text-violet-600 transition-colors duration-200 hover:text-violet-700"
                                >
                                    Pilih Semua
                                </button>
                            </div>
                            <div class="space-y-2">
                                @foreach ($permissions as $permission)
                                    <label class="flex items-center">
                                        <input
                                            type="checkbox"
                                            wire:model="selected_permissions"
                                            value="{{ $permission["name"] }}"
                                            class="rounded border-gray-300 text-violet-600 transition-colors duration-200 focus:ring-violet-500"
                                        />
                                        <span
                                            class="ml-2 text-sm text-gray-700"
                                        >
                                            {{ $permission["label"] }}
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                @error("selected_permissions")
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
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
        title="Hapus Role"
        subtitle="Apakah Anda yakin ingin menghapus role ini?"
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
