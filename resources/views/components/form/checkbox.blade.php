@props([
    "name" => "",
    "label" => null,
    "helper" => null,
    "error" => null,
    "disabled" => false,
    "readonly" => false,
    "required" => false,
    "inline" => false,
])

@php
    $hasError = $error !== null;
    $checkboxClasses = "h-4 w-4 rounded border-gray-300 text-violet-600 transition-colors duration-200 focus:ring-violet-500 disabled:cursor-not-allowed disabled:opacity-50";

    if ($hasError) {
        $checkboxClasses = str_replace("border-gray-300", "border-red-300", $checkboxClasses);
        $checkboxClasses = str_replace("text-violet-600", "text-red-600", $checkboxClasses);
        $checkboxClasses = str_replace("focus:ring-violet-500", "focus:ring-red-500", $checkboxClasses);
    }
@endphp

<div @class(["flex" => $inline])>
    <div class="flex items-start">
        <div class="flex h-5 items-center">
            <input
                type="checkbox"
                id="{{ $name }}"
                name="{{ $name }}"
                {{ $disabled ? "disabled" : "" }}
                {{ $readonly ? "readonly" : "" }}
                {{ $required ? "required" : "" }}
                {{ $attributes->merge(["class" => $checkboxClasses]) }}
            />
        </div>
        @if ($label)
            <div class="ml-3 text-sm">
                <label
                    for="{{ $name }}"
                    @class([
                        "font-medium",
                        "text-gray-700" => ! $hasError,
                        "text-red-600" => $hasError,
                        "cursor-not-allowed opacity-50" => $disabled,
                    ])
                >
                    {{ $label }}
                    @if ($required)
                        <span class="text-red-500">*</span>
                    @endif
                </label>
                @if ($helper && ! $hasError)
                    <p class="text-gray-500">{{ $helper }}</p>
                @endif

                @if ($hasError)
                    <p class="text-red-600">{{ $error }}</p>
                @endif
            </div>
        @endif
    </div>
</div>
