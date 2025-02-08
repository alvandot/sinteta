<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <meta
            name="viewport"
            content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover"
        />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>
            Sinteta | {{ ucwords(str_replace("/", " ", Request::path())) }}
        </title>

        <tallstackui:script />
        @livewireStyles
        @vite(["resources/css/app.css", "resources/js/app.js"])
    </head>

    <body
        class="min-h-screen bg-base-200/50 font-sans antialiased dark:bg-base-200"
    >
        <x-ts-toast />

        {{-- NAVBAR mobile only --}}
        <x-mary-nav sticky class="lg:hidden">
            <x-slot:brand>
                <x-app-brand wire:navigate />
            </x-slot>
            <x-slot:actions>
                <label for="main-drawer" class="me-3 lg:hidden">
                    <x-mary-icon name="o-bars-3" class="cursor-pointer" />
                </label>
            </x-slot>
        </x-mary-nav>

        {{-- MAIN --}}
        <x-mary-main full-width>
            {{-- SIDEBAR --}}
            @persist("scrollbar")
                <x-slot:sidebar
                    drawer="main-drawer"
                    wire:scroll
                    collapsible
                    collapse-text="Tutup Sidebar"
                    class="overflow-y-auto border-r border-gray-200/50 bg-gradient-to-br from-blue-100 via-indigo-100 to-purple-100 shadow-lg lg:bg-inherit"
                >
                    {{-- BRAND --}}
                    <x-app-brand class="p-5 pt-3" wire:navigate />

                    {{-- MENU --}}
                    <x-mary-menu activate-by-route class="px-4">
                        {{-- User --}}
                        @if ($user = auth()->guard("siswa")->user())
                            <x-mary-menu-separator />

                            <x-mary-list-item
                                :item="$user"
                                no-separator
                                no-hover
                                class="rounded-xl border border-white/50 bg-white/50 shadow-sm backdrop-blur-sm"
                            >
                                <x-slot:value>
                                    <span class="font-bold text-gray-800">
                                        {{ $user->nama_lengkap }}
                                    </span>
                                </x-slot>
                                <x-slot:sub-value>
                                    <div class="space-y-1">
                                        <span
                                            class="font-medium text-violet-600"
                                        >
                                            Siswa
                                        </span>
                                        <span
                                            class="block font-medium text-violet-600"
                                        >
                                            Kelas: {{ $user->kelas }}
                                        </span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <x-mary-icon
                                            name="o-map-pin"
                                            class="h-5 w-5 text-gray-400"
                                        />
                                        <span class="font-medium text-gray-800">
                                            {{ $user->cabang->nama }}
                                        </span>
                                    </div>
                                </x-slot>
                            </x-mary-list-item>

                            <x-mary-menu-separator />
                        @endif

                        <x-mary-menu-item
                            title="Dashboard"
                            icon="o-home"
                            link="/siswa/dashboard"
                            wire:navigate
                            class="mt-4 rounded-lg transition-colors duration-300 hover:bg-white/50"
                        />

                        <x-mary-menu-sub
                            title="Jadwal Belajar"
                            icon="o-academic-cap"
                            class="rounded-lg transition-colors duration-300 hover:bg-white/50"
                        >
                            <x-mary-menu-item
                                title="Daftar Jadwal"
                                icon="o-clipboard-document-list"
                                link="/siswa/jadwal"
                                wire:navigate
                                class="hover:bg-white/50"
                            />
                            <x-mary-menu-item
                                title="Riwayat Belajar"
                                icon="o-clock"
                                link="/siswa/jadwal/riwayat"
                                wire:navigate
                                class="hover:bg-white/50"
                            />
                        </x-mary-menu-sub>
                        <x-mary-menu-sub
                            title="Ujian"
                            icon="o-pencil-square"
                            class="rounded-lg transition-colors duration-300 hover:bg-white/50"
                        >
                            <x-mary-menu-item
                                title="Daftar Ujian"
                                icon="o-clipboard-document-list"
                                link="/siswa/ujian"
                                wire:navigate
                                class="hover:bg-white/50"
                            />
                            <x-mary-menu-item
                                title="Riwayat Ujian"
                                icon="o-calendar"
                                link="/siswa/ujian/riwayat"
                                wire:navigate
                                class="hover:bg-white/50"
                            />
                        </x-mary-menu-sub>

                        <x-mary-menu-item
                            title="Logout"
                            icon="o-power"
                            link="{{ route('login.siswa') }}"
                            wire:navigate
                            class="mt-4 rounded-lg text-red-600 transition-colors duration-300 hover:bg-red-50 hover:text-red-700"
                        />
                    </x-mary-menu>
                </x-slot>
            @endpersist

            {{-- The `$slot` goes here --}}
            <x-slot:content>

                    {{-- Breadcrumb --}}
                    <nav class="mb-8 flex" aria-label="Breadcrumb">
                        <ol
                            class="inline-flex items-center space-x-1 rounded-2xl border border-white/30 bg-white/40 p-3 shadow-lg backdrop-blur-md transition-all duration-300 hover:bg-white/50 hover:shadow-xl md:space-x-3"
                        >
                            <li class="inline-flex items-center">
                                <a
                                    href="/siswa"
                                    class="inline-flex items-center text-sm font-medium text-gray-700 transition-all duration-300 hover:scale-105 hover:text-violet-600"
                                >
                                    <x-mary-icon
                                        name="o-home"
                                        class="mr-2 h-4 w-4"
                                    />
                                    <span class="font-semibold">Home</span>
                                </a>
                            </li>
                            @php
                                $segments = Request::segments();
                                $url = "";
                            @endphp

                            @foreach ($segments as $segment)
                                @php
                                    $url .= "/" . $segment;
                                @endphp

                                <li>
                                    <div class="flex items-center">
                                        <x-mary-icon
                                            name="o-chevron-right"
                                            class="h-4 w-4 text-violet-400"
                                        />
                                        @if ($loop->last)
                                            <span
                                                class="ml-1 bg-gradient-to-r from-violet-600 to-indigo-600 bg-clip-text text-sm font-bold text-transparent md:ml-2"
                                            >
                                                {{ ucwords($segment) }}
                                            </span>
                                        @else
                                            <a
                                                href="{{ $url }}"
                                                class="ml-1 inline-flex items-center text-sm font-medium text-gray-700 transition-all duration-300 hover:scale-105 hover:text-violet-600 md:ml-2"
                                            >
                                                <span class="font-semibold">
                                                    {{ ucwords($segment) }}
                                                </span>
                                            </a>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ol>
                    </nav>
                {{ $slot }}
            </x-slot>
        </x-mary-main>

        {{-- TOAST area --}}
        <x-mary-toast />

        @stack("scripts")
        @livewireScripts
    </body>
</html>
