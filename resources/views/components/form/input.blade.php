@props([
    "name" => "",
    "label" => null,
    "type" => "text",
    "placeholder" => "",
    "helper" => null,
    "leadingIcon" => null,
    "trailingIcon" => null,
    "error" => null,
    "disabled" => false,
    "readonly" => false,
    "required" => false,
    "autofocus" => false,
])

@php
    $hasError = $error !== null;
    $inputClasses = "block w-full rounded-lg border-gray-300 shadow-sm transition-colors duration-200 focus:border-violet-500 focus:ring-violet-500 disabled:cursor-not-allowed disabled:bg-gray-50 disabled:text-gray-500";
    $iconClasses = "pointer-events-none absolute inset-y-0 flex items-center text-gray-400";

    if ($hasError) {
        $inputClasses = str_replace("border-gray-300", "border-red-300", $inputClasses);
        $inputClasses = str_replace("focus:border-violet-500 focus:ring-violet-500", "focus:border-red-500 focus:ring-red-500", $inputClasses);
    }

    if ($leadingIcon) {
        $inputClasses .= " pl-10";
    }

    if ($trailingIcon) {
        $inputClasses .= " pr-10";
    }
@endphp

<div>
    @if ($label)
        <label
            for="{{ $name }}"
            class="mb-1 block text-sm font-medium text-gray-700"
        >
            {{ $label }}
            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <div class="relative">
        @if ($leadingIcon)
            <div class="{{ $iconClasses }} left-0 pl-3">
                <x-mary-icon :name="$leadingIcon" class="h-5 w-5" />
            </div>
        @endif

        <input
            type="{{ $type }}"
            id="{{ $name }}"
            name="{{ $name }}"
            placeholder="{{ $placeholder }}"
            {{ $disabled ? "disabled" : "" }}
            {{ $readonly ? "readonly" : "" }}
            {{ $required ? "required" : "" }}
            {{ $autofocus ? "autofocus" : "" }}
            {{ $attributes->merge(["class" => $inputClasses]) }}
        />

        @if ($trailingIcon)
            <div class="{{ $iconClasses }} right-0 pr-3">
                <x-mary-icon :name="$trailingIcon" class="h-5 w-5" />
            </div>
        @endif
    </div>

    @if ($helper && ! $hasError)
        <p class="mt-1 text-sm text-gray-500">{{ $helper }}</p>
    @endif

    @if ($hasError)
        <p class="mt-1 text-sm text-red-600">{{ $error }}</p>
    @endif
</div>
