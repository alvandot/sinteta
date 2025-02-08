@props([
    "soal",
    "soalPG",
    "soalES",
])

<div class="flex items-center space-x-2">
    <span class="text-sm font-medium text-gray-500">
        Bobot: {{ $soalPG->bobot }}
    </span>
    <div
        class="opacity-0 transition-opacity duration-200 group-hover:opacity-100"
    >
        <x-mary-button
            icon="o-pencil"
            size="xs"
            wire:click="editSoal({{ $soalPG->id }})"
            class="bg-indigo-600 hover:bg-indigo-700"
            spinner
        />
        <x-mary-button
            icon="o-trash"
            size="xs"
            wire:click="hapusSoal({{ $soalPG->id }})"
            class="bg-red-600 hover:bg-red-700"
            spinner
        />
    </div>
</div>
