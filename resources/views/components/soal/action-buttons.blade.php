@props(["submitLabel" => "Simpan"])

<div class="flex justify-end gap-x-4 pt-6">
    <x-mary-button
        type="button"
        secondary
        href="{{ route('admin.soal.index') }}"
        class="group relative overflow-hidden transition-transform duration-300 hover:scale-105"
        label="Batal"
    >
        <span
            class="absolute inset-0 bg-gradient-to-r from-gray-100 to-gray-200 opacity-0 transition-opacity duration-300 group-hover:opacity-10"
        ></span>
    </x-mary-button>

    <x-mary-button
        type="submit"
        primary
        class="group relative overflow-hidden bg-gradient-to-r from-violet-600 to-indigo-600 transition-all duration-300 hover:scale-105"
        :label="$submitLabel"
    >
        <span
            class="absolute inset-0 bg-gradient-to-r from-white to-transparent opacity-0 transition-opacity duration-300 group-hover:opacity-10"
        ></span>
    </x-mary-button>
</div>
