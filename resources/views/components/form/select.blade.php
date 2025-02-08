@props([
    "name" => "",
    "label" => null,
    "placeholder" => "",
    "options",
    "helper" => null,
    "leadingIcon" => null,
    "error" => null,
    "disabled" => false,
    "readonly" => false,
    "required" => false,
    "multiple" => false,
    "searchable" => false,
    "kelas_options",
    "disables",
])

@php
    $hasError = $error !== null;
    $selectClasses = "block w-full rounded-lg border-gray-300 shadow-sm transition-colors duration-200 focus:border-violet-500 focus:ring-violet-500 disabled:cursor-not-allowed disabled:bg-gray-50 disabled:text-gray-500";
    $iconClasses = "pointer-events-none absolute inset-y-0 flex items-center text-gray-400";

    if ($hasError) {
        $selectClasses = str_replace("border-gray-300", "border-red-300", $selectClasses);
        $selectClasses = str_replace("focus:border-violet-500 focus:ring-violet-500", "focus:border-red-500 focus:ring-red-500", $selectClasses);
    }

    if ($leadingIcon) {
        $selectClasses .= " pl-10";
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

        @if ($searchable)
            <x-mary-choices
                :name="$name"
                :id="$name"
                :placeholder="$placeholder"
                :options="$options"
                :disabled="$disabled"
                :readonly="$readonly"
                :required="$required"
                :multiple="$multiple"
                :error="$error"
                searchable
                {{ $attributes->merge(["class" => $selectClasses]) }}
            />
        @else
            <select
                id="{{ $name }}"
                name="{{ $name }}"
                {{ $disabled ? "disabled" : "" }}
                {{ $readonly ? "readonly" : "" }}
                {{ $required ? "required" : "" }}
                {{ $multiple ? "multiple" : "" }}
                {{ $attributes->merge(["class" => $selectClasses]) }}
            >
                @if ($placeholder && ! $multiple)
                    <option value="">{{ $placeholder }}</option>
                @endif

                @foreach ($options as $option)
                    <option
                        value="{{ $option["value"] }}"
                        {{ isset($option["disabled"]) && $option["disabled"] ? "disabled" : "" }}
                    >
                        {{ $option["label"] }}
                    </option>
                @endforeach
            </select>

            @if (! $multiple)
                <div class="{{ $iconClasses }} right-0 pr-3">
                    <x-mary-icon name="o-chevron-down" class="h-5 w-5" />
                </div>
            @endif
        @endif
    </div>

    @if ($helper && ! $hasError)
        <p class="mt-1 text-sm text-gray-500">{{ $helper }}</p>
    @endif

    @if ($hasError)
        <p class="mt-1 text-sm text-red-600">{{ $error }}</p>
    @endif
</div>
