@props([
    "header" => null,
    "footer" => null,
    "padding" => true,
    "shadow" => true,
    "rounded" => true,
    "border" => true,
    "hover" => false,
])

@php
    $baseClasses = "bg-white";
    $classes = [
        "shadow" => $shadow ? "shadow-sm" : "",
        "rounded" => $rounded ? "rounded-lg" : "",
        "border" => $border ? "border border-gray-200" : "",
        "hover" => $hover ? "transition-all duration-200 hover:border-violet-200 hover:shadow-md" : "",
    ];
@endphp

<div
    {{ $attributes->merge(["class" => $baseClasses . " " . implode(" ", array_filter($classes))]) }}
>
    {{-- Card Header --}}
    @if ($header)
        <div
            @class([
                "border-b border-gray-200 bg-gray-50/50",
                "rounded-t-lg" => $rounded,
                "px-4 py-3" => $padding,
            ])
        >
            {{ $header }}
        </div>
    @endif

    {{-- Card Body --}}
    <div @class([
        "px-4 py-3" => $padding,
    ])>
        {{ $slot }}
    </div>

    {{-- Card Footer --}}
    @if ($footer)
        <div
            @class([
                "border-t border-gray-200 bg-gray-50/50",
                "rounded-b-lg" => $rounded,
                "px-4 py-3" => $padding,
            ])
        >
            {{ $footer }}
        </div>
    @endif
</div>
