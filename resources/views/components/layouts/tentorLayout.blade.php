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
        class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 font-sans antialiased"
    >
        <x-ts-toast />

        {{-- NAVBAR mobile only --}}
        <x-mary-nav
            sticky
            class="border-b border-gray-200/50 bg-white/80 shadow-sm backdrop-blur-md lg:hidden"
        >
            <x-slot:brand>
                <x-app-brand
                    wire:navigate
                    class="transition-transform hover:scale-105"
                />
            </x-slot>
            <x-slot:actions>
                <label for="main-drawer" class="me-3 lg:hidden">
                    <x-mary-icon
                        name="o-bars-3"
                        class="h-6 w-6 cursor-pointer text-gray-700 transition-colors hover:text-violet-600"
                    />
                </label>
            </x-slot>
        </x-mary-nav>

        {{-- MAIN --}}
        <x-mary-main
            full-width
            class="bg-gradient-to-br from-violet-50 via-indigo-50 to-blue-50"
        >
            {{-- SIDEBAR --}}
            @persist("scrollbar")
                <x-slot:sidebar
                    drawer="main-drawer"
                    wire:scroll
                    collapsible
                    collapse-text="Tutup Sidebar"
                    class="overflow-y-auto border-r border-gray-200/50 bg-white/80 shadow-lg backdrop-blur-md"
                >
                    {{-- BRAND --}}
                    <x-app-brand
                        class="p-5 pt-3 transition-transform hover:scale-105"
                        wire:navigate
                    />

                    {{-- MENU --}}
                    <x-mary-menu activate-by-route class="px-4">
                        {{-- User --}}
                        @if ($user = auth()->user())
                            <x-mary-menu-separator />
                            <div
                                class="mb-4 rounded-2xl border border-white/50 bg-gradient-to-br from-violet-50 to-indigo-50 p-4 shadow-lg transition-all duration-300 hover:scale-[1.02] hover:shadow-xl"
                            >
                                <div class="flex items-center space-x-4">
                                    <div
                                        class="rounded-lg bg-gradient-to-br from-violet-600 to-indigo-600 p-2 text-white"
                                    >
                                        <x-mary-icon
                                            name="o-user"
                                            class="h-6 w-6"
                                        />
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-gray-800">
                                            {{ $user->nama_lengkap }}
                                        </h3>
                                        <p
                                            class="text-sm font-medium text-violet-600"
                                        >
                                            Tentor
                                        </p>
                                        <p
                                            class="text-sm font-medium text-violet-600"
                                        >
                                            Mata Pelajaran:
                                            {{ $user->mata_pelajaran ?? "Belum diatur" }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <x-mary-menu-item
                            title="Dashboard"
                            icon="o-home"
                            link="/tentor/dashboard"
                            wire:navigate
                            class="mt-4 rounded-xl transition-all duration-300 hover:scale-[1.02] hover:bg-violet-50 hover:text-violet-700"
                        />

                        <x-mary-menu-sub
                            title="Jadwal Mengajar"
                            icon="o-academic-cap"
                            class="rounded-xl transition-all duration-300 hover:bg-violet-50"
                        >
                            <x-mary-menu-item
                                title="Daftar Jadwal"
                                icon="o-clipboard-document-list"
                                link="/tentor/jadwal/daftar-jadwal"
                                wire:navigate
                                class="transition-all hover:translate-x-1 hover:bg-violet-50 hover:text-violet-700"
                            />
                            <x-mary-menu-item
                                title="Riwayat Mengajar"
                                icon="o-clock"
                                link="/tentor/jadwal/riwayat"
                                wire:navigate
                                class="transition-all hover:translate-x-1 hover:bg-violet-50 hover:text-violet-700"
                            />
                        </x-mary-menu-sub>

                        <x-mary-menu-sub
                            title="Kelas & Siswa"
                            icon="o-users"
                            class="rounded-xl transition-all duration-300 hover:bg-violet-50"
                        >
                            <x-mary-menu-item
                                title="Daftar Kelas"
                                icon="o-academic-cap"
                                link="/tentor/kelas"
                                wire:navigate
                                class="transition-all hover:translate-x-1 hover:bg-violet-50 hover:text-violet-700"
                            />
                            <x-mary-menu-item
                                title="Daftar Siswa"
                                icon="o-user"
                                link="/tentor/siswa"
                                wire:navigate
                                class="transition-all hover:translate-x-1 hover:bg-violet-50 hover:text-violet-700"
                            />
                        </x-mary-menu-sub>

                        <x-mary-menu-sub
                            title="Manajemen Ujian"
                            icon="o-pencil-square"
                            class="rounded-xl transition-all duration-300 hover:bg-violet-50"
                        >
                            <x-mary-menu-item
                                title="Bank Soal"
                                icon="o-document-text"
                                link="/tentor/ujian/soal"
                                wire:navigate
                                class="transition-all hover:translate-x-1 hover:bg-violet-50 hover:text-violet-700"
                            />
                            <x-mary-menu-item
                                title="Hasil Ujian"
                                icon="o-chart-bar"
                                link="/tentor/ujian/hasil"
                                wire:navigate
                                class="transition-all hover:translate-x-1 hover:bg-violet-50 hover:text-violet-700"
                            />
                        </x-mary-menu-sub>

                        <x-mary-menu-item
                            title="Logout"
                            icon="o-power"
                            link="{{ route('tentor.logout') }}"
                            wire:navigate
                            class="mt-4 rounded-xl text-red-600 transition-all duration-300 hover:scale-[1.02] hover:bg-red-50 hover:text-red-700"
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
                                href="{{ route('tentor.dashboard') }}"
                                class="inline-flex items-center text-sm font-medium text-gray-700 transition-all duration-300 hover:scale-105 hover:text-violet-600"
                                wire:navigate
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
                                            {{ ucwords(str_replace('-', ' ', $segment)) }}
                                        </span>
                                    @else
                                        <a
                                            href="{{ $url }}"
                                            class="ml-1 inline-flex items-center text-sm font-medium text-gray-700 transition-all duration-300 hover:scale-105 hover:text-violet-600 md:ml-2"
                                            wire:navigate
                                        >
                                            <span class="font-semibold">
                                                {{ ucwords(str_replace('-', ' ', $segment)) }}
                                            </span>
                                        </a>
                                    @endif
                                </div>
                            </li>
                        @endforeach
                    </ol>
                </nav>

                <div
                    class="bg-gradient-to-br from-violet-50/50 via-indigo-50/50 to-blue-50/50 p-6"
                >
                    {{ $slot }}
                </div>
            </x-slot>
        </x-mary-main>

        {{-- TOAST area --}}
        <x-mary-toast />

        @livewireScripts
    </body>
</html>
