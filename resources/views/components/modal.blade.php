@props([
    "name" => "modal",
    "title" => null,
    "subtitle" => null,
    "icon" => null,
    "maxWidth" => "md",
    "persistent" => false,
    "closeButton" => true,
    "closeOnClickOutside" => true,
    "closeOnEscape" => true,
])

@php
    $maxWidthClasses =
        [
            "sm" => "sm:max-w-sm",
            "md" => "sm:max-w-md",
            "lg" => "sm:max-w-lg",
            "xl" => "sm:max-w-xl",
            "2xl" => "sm:max-w-2xl",
            "3xl" => "sm:max-w-3xl",
            "4xl" => "sm:max-w-4xl",
            "5xl" => "sm:max-w-5xl",
            "6xl" => "sm:max-w-6xl",
            "7xl" => "sm:max-w-7xl",
            "full" => "sm:max-w-full",
        ][$maxWidth] ?? "sm:max-w-md";
@endphp

<div
    x-data="{
        show: @entangle($attributes->wire('model')),
        focusables() {
            return [...$el.querySelectorAll('a, button, input, textarea, select, details, [tabindex]:not([tabindex=\'-1\'])')].filter(el => !el.hasAttribute('disabled'))
        },
        firstFocusable() { return this.focusables()[0] },
        lastFocusable() { return this.focusables().slice(-1)[0] },
        nextFocusable() { return this.focusables()[this.nextFocusableIndex()] || this.firstFocusable() },
        prevFocusable() { return this.focusables()[this.prevFocusableIndex()] || this.lastFocusable() },
        nextFocusableIndex() { return (this.focusables().indexOf(document.activeElement) + 1) % (this.focusables().length + 1) },
        prevFocusableIndex() { return Math.max(0, this.focusables().indexOf(document.activeElement)) - 1 },
        autofocus() { const focusable = $el.querySelector('[autofocus]'); if (focusable) focusable.focus() },
    }"
    x-init="
        $watch('show', (value) => {
            if (value) {
                document.body.classList.add('overflow-y-hidden')
                {{ $attributes->has("focusable") ? "setTimeout(() => autofocus(), 100)" : "" }}
            } else {
                document.body.classList.remove('overflow-y-hidden')
            }
        })
    "
    x-on:keydown.escape.window="show = false"
    x-on:keydown.tab.prevent="$event.shiftKey ? prevFocusable().focus() : nextFocusable().focus()"
    x-show="show"
    class="fixed inset-0 z-50 overflow-y-auto"
    style="display: none"
>
    {{-- Backdrop --}}
    <div
        x-show="show"
        x-transition:enter="duration-300 ease-out"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="duration-200 ease-in"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm transition-opacity"
        @if ($closeOnClickOutside && ! $persistent)
            x-on:click="show = false"
        @endif
    ></div>

    {{-- Modal Panel --}}
    <div
        x-show="show"
        x-transition:enter="duration-300 ease-out"
        x-transition:enter-start="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="translate-y-0 opacity-100 sm:scale-100"
        x-transition:leave="duration-200 ease-in"
        x-transition:leave-start="translate-y-0 opacity-100 sm:scale-100"
        x-transition:leave-end="translate-y-4 opacity-0 sm:translate-y-0 sm:scale-95"
        class="relative mx-auto mt-6 w-full px-4 sm:my-8"
    >
        <div
            class="{{ $maxWidthClasses }} relative mx-auto rounded-lg bg-white shadow-xl"
        >
            {{-- Modal Header --}}
            @if ($title || $subtitle || $icon || $closeButton)
                <div
                    class="flex items-start justify-between rounded-t-lg border-b border-gray-200 bg-gray-50/50 px-4 py-3"
                >
                    <div class="flex items-center space-x-3">
                        @if ($icon)
                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-full bg-violet-100 text-violet-600"
                            >
                                <x-mary-icon :name="$icon" class="h-6 w-6" />
                            </div>
                        @endif

                        <div>
                            @if ($title)
                                <h3
                                    class="text-lg font-semibold leading-6 text-gray-900"
                                >
                                    {{ $title }}
                                </h3>
                            @endif

                            @if ($subtitle)
                                <p class="mt-1 text-sm text-gray-600">
                                    {{ $subtitle }}
                                </p>
                            @endif
                        </div>
                    </div>
                    @if ($closeButton)
                        <button
                            type="button"
                            class="rounded-lg p-2 text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2"
                            x-on:click="show = false"
                        >
                            <span class="sr-only">Tutup</span>
                            <x-mary-icon name="o-x-mark" class="h-5 w-5" />
                        </button>
                    @endif
                </div>
            @endif

            {{-- Modal Content --}}
            <div class="p-4">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
