<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover"
        />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta
            name="description"
            content="Sistem CBT SINTETA - Computer Based Test untuk Bimbingan Belajar"
        />
        <meta name="author" content="SINTETA" />
        <meta name="theme-color" content="#8B5CF6" />

        <title>{{ $title ?? config("app.name", "CBT SINTETA") }}</title>

        {{-- Favicon --}}
        <link
            rel="icon"
            href="{{ asset("favicon.ico") }}"
            type="image/x-icon"
        />
        <link
            rel="apple-touch-icon"
            sizes="180x180"
            href="{{ asset("apple-touch-icon.png") }}"
        />
        <link
            rel="icon"
            type="image/png"
            sizes="32x32"
            href="{{ asset("favicon-32x32.png") }}"
        />
        <link
            rel="icon"
            type="image/png"
            sizes="16x16"
            href="{{ asset("favicon-16x16.png") }}"
        />
        <link rel="manifest" href="{{ asset("site.webmanifest") }}" />

        {{-- Fonts --}}
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
            rel="stylesheet"
        />

        {{-- Scripts and Styles --}}
        @vite(["resources/css/app.css", "resources/js/app.js"])
        @livewireStyles
        @stack("styles")
    </head>

    <body class="h-full font-sans antialiased">
        {{-- Loading State --}}
        <div
            wire:loading.delay.longer
            class="fixed inset-0 z-[100] flex items-center justify-center bg-white/50 backdrop-blur-sm"
        >
            <div class="flex flex-col items-center space-y-4">
                <div
                    class="h-12 w-12 animate-spin rounded-full border-4 border-violet-600 border-t-transparent"
                ></div>
                <span class="text-sm font-medium text-gray-700">Memuat...</span>
            </div>
        </div>

        {{-- Main Layout --}}
        <div class="flex min-h-full flex-col justify-center">
            <div class="">
                <div class="bg-white shadow sm:rounded-lg">
                    {{ $slot }}
                </div>
                @if (isset($footer))
                    <div class="text-center text-sm text-gray-500">
                        {{ $footer }}
                    </div>
                @endif
            </div>
        </div>

        {{-- Notification --}}
        <x-mary-toast />

        {{-- Scripts --}}
        @livewireScripts
        @stack("scripts")
    </body>
</html>
