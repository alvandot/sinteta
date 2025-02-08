<div>
    <x-card
        title="Form Example"
        subtitle="Contoh penggunaan komponen form"
        icon="o-document-text"
        :loading="$loading"
        hover
    >
        <form wire:submit="save" class="space-y-6">
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

            <x-form.select
                name="type"
                label="Tipe"
                wire:model="type"
                :options="$types"
                required
                searchable
                :error="$errors->first('type')"
                placeholder="Pilih tipe"
                leadingIcon="o-tag"
            />

            <x-form.textarea
                name="description"
                label="Deskripsi"
                wire:model="description"
                required
                :error="$errors->first('description')"
                placeholder="Masukkan deskripsi"
                rows="4"
            />

            <div>
                <x-ts-label value="Photo" />
                <div class="mt-1 flex items-center space-x-4">
                    @if ($photo)
                        <div class="relative h-20 w-20">
                            <img
                                src="{{ $photo->temporaryUrl() }}"
                                class="h-20 w-20 rounded-lg object-cover"
                            />
                            <button
                                type="button"
                                wire:click="$set('photo', null)"
                                class="absolute -right-2 -top-2 rounded-full bg-red-500 p-1 text-white hover:bg-red-600"
                            >
                                <x-ts-icon name="o-x-mark" class="h-4 w-4" />
                            </button>
                        </div>
                    @endif

                    <x-ts-upload wire:model="photo">
                        <x-ts-icon name="o-photo" class="h-6 w-6" />
                        <span class="text-sm">Upload Photo</span>
                    </x-ts-upload>
                </div>
                @error("photo")
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-3">
                <x-ts-button
                    type="button"
                    wire:click="$toggle('showModal')"
                    secondary
                    icon="o-eye"
                >
                    Preview
                </x-ts-button>

                <x-ts-button
                    type="submit"
                    primary
                    icon="o-paper-airplane"
                    :loading="$loading"
                >
                    Simpan
                </x-ts-button>
            </div>
        </form>
    </x-card>

    <x-modal
        name="preview-modal"
        title="Preview Data"
        subtitle="Review data sebelum disimpan"
        icon="o-eye"
        wire:model="showModal"
    >
        <div class="space-y-4">
            <div>
                <span class="text-sm font-medium text-gray-500">Nama:</span>
                <p class="text-gray-900">{{ $name ?: "-" }}</p>
            </div>

            <div>
                <span class="text-sm font-medium text-gray-500">Email:</span>
                <p class="text-gray-900">{{ $email ?: "-" }}</p>
            </div>

            <div>
                <span class="text-sm font-medium text-gray-500">Tipe:</span>
                <p class="text-gray-900">
                    {{ collect($types)->firstWhere("value", $type)["label"] ?? "-" }}
                </p>
            </div>

            <div>
                <span class="text-sm font-medium text-gray-500">
                    Deskripsi:
                </span>
                <p class="text-gray-900">{{ $description ?: "-" }}</p>
            </div>

            @if ($photo)
                <div>
                    <span class="text-sm font-medium text-gray-500">
                        Photo:
                    </span>
                    <img
                        src="{{ $photo->temporaryUrl() }}"
                        class="mt-1 h-32 w-32 rounded-lg object-cover"
                    />
                </div>
            @endif
        </div>

        <x-slot:footer>
            <x-ts-button wire:click="$toggle('showModal')" secondary>
                Tutup
            </x-ts-button>
        </x-slot>
    </x-modal>
</div>
