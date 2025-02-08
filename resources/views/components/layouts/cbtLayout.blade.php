<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta
            name="description"
            content="Sistem CBT SINTETA - Computer Based Test untuk Bimbingan Belajar"
        />
        <meta name="author" content="SINTETA" />
        <meta name="theme-color" content="#8B5CF6" />

        <title>{{ $title ?? config("app.name", "CBT SINTETA") }}</title>

        {{-- Fonts --}}
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
            href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
            rel="stylesheet"
        />

        <tallstackui:script />
        {{-- Scripts and Styles --}}
        @vite(["resources/css/app.css", "resources/js/app.js"])
        @livewireStyles
        @stack("styles")
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body
        class="min-h-screen bg-base-200/50 font-sans antialiased dark:bg-base-200"
    >
        {{-- MAIN --}}
        <x-mary-main full-width>
            {{-- The `$slot` goes here --}}
            <x-slot:content>
                {{ $slot }}
            </x-slot>
        </x-mary-main>

        {{-- Toast --}}
        <x-mary-toast />
    </body>
</html>
