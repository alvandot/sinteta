<!DOCTYPE html>
<html lang="{{ str_replace("_", "-", app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta
            name="description"
            content="Sistem CBT SINTETA - Platform Ujian Online Modern dan Interaktif"
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
            href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap"
            rel="stylesheet"
        />

        {{-- Cropper.js --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
        <link
            rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css"
        />

        {{-- Flatpickr --}}
        <link
            rel="stylesheet"
            href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"
        />
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

        {{-- Tallstack UI --}}
        <tallstackui:script />
        {{-- Scripts and Styles --}}
        @vite(["resources/css/app.css", "resources/js/app.js"])
        @livewireStyles
    </head>

    <body
        x-data="{
            darkMode: localStorage.getItem('darkMode') === 'false',
            sidebarOpen: window.innerWidth >= 1024,
            toggleDarkMode() {
                this.darkMode = ! this.darkMode
                localStorage.setItem('darkMode', this.darkMode)
            },
        }"
        class="min-h-screen bg-gradient-to-br from-base-100/50 to-base-200/50 font-sans antialiased transition-colors duration-300 dark:from-gray-900 dark:to-gray-800"
    >
        {{-- NAVBAR mobile only --}}
        <x-mary-nav
            sticky
            class="border-b border-gray-200 bg-white/80 backdrop-blur-lg dark:border-gray-800 dark:bg-gray-900/80 lg:hidden"
        >
            <x-slot:brand>
                <div class="ml-5 flex items-center space-x-3 pt-5">
                    <img
                        src="{{ asset("images/logo.webp") }}"
                        class="h-8 w-auto"
                        alt="Sinteta Logo"
                    />
                    <span
                        class="bg-gradient-to-r from-violet-600 to-indigo-600 bg-clip-text text-xl font-bold text-transparent"
                    >
                        Sinteta
                    </span>
                </div>
            </x-slot>
            <x-slot:actions>
                <div class="mr-3 flex items-center space-x-4">
                    <button
                        @click="toggleDarkMode()"
                        class="rounded-lg p-2 transition-colors hover:bg-gray-100 dark:hover:bg-gray-800"
                    >
                        <x-mary-icon
                            x-show="!darkMode"
                            name="o-sun"
                            class="h-5 w-5 text-yellow-500"
                        />
                        <x-mary-icon
                            x-show="darkMode"
                            name="o-moon"
                            class="h-5 w-5 text-blue-400"
                        />
                    </button>
                    <label for="main-drawer" class="lg:hidden">
                        <x-mary-icon
                            name="o-bars-3"
                            class="h-6 w-6 cursor-pointer transition-colors hover:text-violet-600 dark:hover:text-violet-400"
                        />
                    </label>
                </div>
            </x-slot>
        </x-mary-nav>

        {{-- MAIN --}}
        <x-mary-main full-width>
            {{-- SIDEBAR --}}
            <x-slot:sidebar
                drawer="main-drawer"
                collapsible
                class="border-r border-gray-200 bg-white transition-colors duration-300 dark:border-gray-800 dark:bg-gray-900"
            >
                {{-- BRAND --}}
                <div class="ml-5 flex items-center space-x-3 pt-5">
                    <img
                        src="{{ asset("images/logo.webp") }}"
                        class="h-8 w-auto"
                        alt="Sinteta Logo"
                    />
                    <span
                        class="bg-gradient-to-r from-violet-600 to-indigo-600 bg-clip-text text-xl font-bold text-transparent"
                    >
                        Sinteta
                    </span>
                </div>

                {{-- MENU --}}
                <x-mary-menu activate-by-route class="mt-8">
                    {{-- User --}}
                    @if ($user = auth()->user())
                        <x-mary-menu-separator />

                        <x-mary-list-item
                            :item="$user"
                            value="name"
                            sub-value="email"
                            no-separator
                            class="rounded-lg transition-colors duration-300 hover:bg-violet-50 dark:hover:bg-violet-900/20"
                        >
                            <x-slot:actions>
                                <x-mary-button
                                    icon="o-power"
                                    class="btn-circle btn-ghost btn-xs hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-900/20 dark:hover:text-red-400"
                                    tooltip-left="logoff"
                                    no-wire-navigate
                                    link="/admin/logout"
                                />
                            </x-slot>
                        </x-mary-list-item>

                        <x-mary-menu-separator />
                    @endif

                    <x-mary-menu-item
                        title="Dashboard"
                        icon="o-home"
                        link="/admin/dashboard"
                        wire:navigate
                        class="transition-colors duration-300 hover:bg-violet-50 dark:hover:bg-violet-900/20"
                    />

                    <x-mary-menu-sub title="Siswa" icon="o-user">
                        <x-mary-menu-item
                            title="Daftar Siswa"
                            icon="o-user"
                            link="/admin/siswa/daftar"
                            wire:navigate
                            class="transition-colors duration-300 hover:bg-violet-50 dark:hover:bg-violet-900/20"
                        />
                        <x-mary-menu-item
                            title="Buat Siswa"
                            icon="o-pencil-square"
                            link="/admin/siswa/buat"
                            wire:navigate
                            class="transition-colors duration-300 hover:bg-violet-50 dark:hover:bg-violet-900/20"
                        />
                    </x-mary-menu-sub>

                    {{-- Jadwal --}}
                    <x-mary-menu-sub title="Jadwal" icon="o-calendar">
                        <x-mary-menu-item
                            title="Daftar Jadwal"
                            icon="o-calendar"
                            link="/admin/jadwal"
                            wire:navigate
                            class="transition-colors duration-300 hover:bg-violet-50 dark:hover:bg-violet-900/20"
                        />
                        <x-mary-menu-item
                            title="Buat Jadwal"
                            icon="o-pencil-square"
                            link="/admin/jadwal/buat"
                            wire:navigate
                            class="transition-colors duration-300 hover:bg-violet-50 dark:hover:bg-violet-900/20"
                        />
                    </x-mary-menu-sub>

                    <x-mary-menu-sub title="Soal" icon="o-book-open">
                        <x-mary-menu-item
                            title="Daftar Soal"
                            icon="o-document-text"
                            link="/admin/soal/daftar"
                            wire:navigate
                            class="transition-colors duration-300 hover:bg-violet-50 dark:hover:bg-violet-900/20"
                        />
                        <x-mary-menu-item
                            title="Buat Soal"
                            icon="o-pencil-square"
                            link="/admin/soal/buat"
                            wire:navigate
                            class="transition-colors duration-300 hover:bg-violet-50 dark:hover:bg-violet-900/20"
                        />
                    </x-mary-menu-sub>

                    <x-mary-menu-sub title="Ujian" icon="o-pencil-square">
                        <x-mary-menu-item
                            title="Daftar Ujian"
                            icon="o-clipboard-document-list"
                            link="/admin/ujian/daftar"
                            wire:navigate
                            class="transition-colors duration-300 hover:bg-violet-50 dark:hover:bg-violet-900/20"
                        />
                        <x-mary-menu-item
                            title="Buat Ujian"
                            icon="o-pencil-square"
                            link="/admin/ujian/buat"
                            wire:navigate
                            class="transition-colors duration-300 hover:bg-violet-50 dark:hover:bg-violet-900/20"
                        />
                    </x-mary-menu-sub>

                    <x-mary-menu-sub title="Kelas Bimbel" icon="o-academic-cap">
                        <x-mary-menu-item
                            title="Daftar Kelas"
                            icon="o-users"
                            link="/admin/kelas-bimbel/daftar"
                            wire:navigate
                            class="transition-colors duration-300 hover:bg-violet-50 dark:hover:bg-violet-900/20"
                        />
                    </x-mary-menu-sub>

                    <x-mary-menu-sub title="Absensi" icon="o-clipboard-document-list">
                        <x-mary-menu-item
                            title="Daftar Absensi"
                            icon="o-clipboard-document-list"
                            link="/admin/absensi/daftar"
                            wire:navigate
                            class="transition-colors duration-300 hover:bg-violet-50 dark:hover:bg-violet-900/20"
                        />
                    </x-mary-menu-sub>

                    <x-mary-menu-sub title="Mata Pelajaran" icon="o-book-open">
                        <x-mary-menu-item
                            title="Daftar Mata Pelajaran"
                            icon="o-academic-cap"
                            link="/admin/mata-pelajaran/daftar"
                            wire:navigate
                            class="transition-colors duration-300 hover:bg-violet-50 dark:hover:bg-violet-900/20"
                        />
                    </x-mary-menu-sub>

                    <x-mary-menu-sub title="Cabang" icon="o-building-office">
                        <x-mary-menu-item
                            title="Daftar Cabang"
                            icon="o-building-office-2"
                            link="/admin/cabang/daftar"
                            wire:navigate
                            class="transition-colors duration-300 hover:bg-violet-50 dark:hover:bg-violet-900/20"
                        />
                    </x-mary-menu-sub>

                    <x-mary-menu-item
                        title="User Manager"
                        icon="o-users"
                        link="/admin/user-manager"
                        wire:navigate
                        class="transition-colors duration-300 hover:bg-violet-50 dark:hover:bg-violet-900/20"
                    />
                </x-mary-menu>
            </x-slot>

            {{-- The `$slot` goes here --}}
            <x-slot:content class="overflow-y-auto">
                <!-- Breadcrumb Navigation -->
                <nav class="mb-8" aria-label="Breadcrumb">
                    <ol class="group flex flex-wrap items-center gap-2 overflow-hidden rounded-2xl border-2 border-violet-100 bg-white/80 p-4 shadow-xl backdrop-blur-lg transition-all duration-500 hover:border-violet-200 hover:bg-white/90 hover:shadow-2xl dark:border-violet-900/50 dark:bg-gray-900/80 dark:hover:border-violet-900 dark:hover:bg-gray-900/90 md:gap-4">
                        <!-- Home Link -->
                        <li class="inline-flex items-center">
                            <a href="/admin" class="inline-flex items-center rounded-xl bg-gradient-to-br from-violet-50 to-indigo-50 px-3 py-1.5 text-xs font-semibold text-violet-700 shadow-sm transition-all duration-300 hover:scale-105 hover:from-violet-100 hover:to-indigo-100 hover:shadow-md dark:from-violet-900/50 dark:to-indigo-900/50 dark:text-violet-300 dark:hover:from-violet-900/70 dark:hover:to-indigo-900/70 sm:px-4 sm:py-2 sm:text-sm">
                                <x-mary-icon name="o-home" class="mr-1.5 h-3 w-3 sm:mr-2 sm:h-4 sm:w-4"/>
                                Dashboard
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
                                    <!-- Separator -->
                                    <x-mary-icon name="o-chevron-double-right" class="h-4 w-4 animate-pulse text-violet-400 dark:text-violet-600 sm:h-5 sm:w-5"/>

                                    @if ($loop->last)
                                        <!-- Current Page -->
                                        <span class="ml-1.5 rounded-xl bg-gradient-to-r from-violet-600 to-indigo-600 bg-clip-text px-3 py-1.5 text-xs font-black tracking-wide text-transparent transition-all duration-300 hover:scale-105 dark:from-violet-400 dark:to-indigo-400 sm:ml-2 sm:px-4 sm:py-2 sm:text-sm">
                                            {{ ucwords(str_replace('-', ' ', $segment)) }}
                                        </span>
                                    @else
                                        <!-- Navigation Link -->
                                        <a href="{{ $url }}" class="ml-1.5 inline-flex items-center rounded-xl bg-gradient-to-br from-violet-50/50 to-indigo-50/50 px-3 py-1.5 text-xs font-medium text-gray-600 shadow-sm transition-all duration-300 hover:scale-105 hover:from-violet-100/50 hover:to-indigo-100/50 hover:text-violet-700 hover:shadow-md dark:from-violet-900/30 dark:to-indigo-900/30 dark:text-gray-300 dark:hover:from-violet-900/50 dark:hover:to-indigo-900/50 dark:hover:text-violet-300 sm:ml-2 sm:px-4 sm:py-2 sm:text-sm">
                                            {{ ucwords(str_replace('-', ' ', $segment)) }}
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

        {{-- Toast --}}
        <x-mary-toast />
    </body>
</html>
