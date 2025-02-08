@props([
    "name",
    "label" => null,
    "value" => null,
    "placeholder" => null,
    "helper" => null,
    "rows" => 3,
    "disabled" => false,
    "readonly" => false,
    "required" => false,
    "error" => null,
])

<div class="w-full">
    @if ($label)
        <x-ts-label
            for="{{ $name }}"
            class="mb-1.5 inline-block font-medium text-gray-700"
        >
            {{ $label }}
            @if ($required)
                <span class="ml-1 text-red-500">*</span>
            @endif
        </x-ts-label>
    @endif

    <x-ts-textarea
        :name="$name"
        :id="$name"
        :value="$value"
        :placeholder="$placeholder"
        :rows="$rows"
        :disabled="$disabled"
        :readonly="$readonly"
        :required="$required"
        :error="$error"
        @class([
            "w-full rounded-lg shadow-sm",
            "border-gray-300 focus:border-violet-500 focus:ring-violet-500",
            "border-red-300 text-red-900 placeholder-red-300 focus:border-red-500 focus:ring-red-500" => $error,
            "bg-gray-50 text-gray-500" => $disabled,
        ])
        {{ $attributes->except(["class"]) }}
    />

    @if ($helper && ! $error)
        <p class="mt-1 text-sm text-gray-500">{{ $helper }}</p>
    @endif

    @if ($error)
        <p class="mt-1 text-sm text-red-600">{{ $error }}</p>
    @endif
</div>
