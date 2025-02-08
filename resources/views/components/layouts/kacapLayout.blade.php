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

        <div
            class="flex min-h-screen flex-col bg-gradient-to-br from-violet-50 via-indigo-50 to-blue-50"
        >
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
            <x-mary-main full-width class="flex-grow">
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
                                                Kepala Cabang
                                            </p>
                                            <p
                                                class="text-sm font-medium text-violet-600"
                                            >
                                                Cabang:
                                                {{ $user->cabang ?? "Belum diatur" }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <x-mary-menu-item
                                title="Dashboard"
                                icon="o-home"
                                link="/kacap/dashboard"
                                wire:navigate
                                class="mt-4 rounded-xl transition-all duration-300 hover:scale-[1.02] hover:bg-violet-50 hover:text-violet-700"
                            />

                            <x-mary-menu-item
                                title="Kelas"
                                icon="o-building-library"
                                link="/kacap/kelas"
                                wire:navigate
                                class="rounded-xl transition-all duration-300 hover:scale-[1.02] hover:bg-violet-50 hover:text-violet-700"
                            />

                            <x-mary-menu-sub
                                title="Siswa"
                                icon="o-users"
                                class="rounded-xl transition-all duration-300 hover:bg-violet-50"
                            >
                                <x-mary-menu-item
                                    title="Daftar Siswa"
                                    icon="o-user-group"
                                    link="/kacap/siswa/daftar"
                                    wire:navigate
                                    class="transition-all hover:translate-x-1 hover:bg-violet-50 hover:text-violet-700"
                                />
                                <x-mary-menu-item
                                    title="Pendaftaran"
                                    icon="o-user-plus"
                                    link="/kacap/siswa/pendaftaran"
                                    wire:navigate
                                    class="transition-all hover:translate-x-1 hover:bg-violet-50 hover:text-violet-700"
                                />
                            </x-mary-menu-sub>

                            <x-mary-menu-sub
                                title="Kurikulum"
                                icon="o-academic-cap"
                                class="rounded-xl transition-all duration-300 hover:bg-violet-50"
                            >
                                <x-mary-menu-item
                                    title="Daftar Pengajar"
                                    icon="o-clipboard-document-list"
                                    link="/kacap/kurikulum/pengajar"
                                    wire:navigate
                                    class="transition-all hover:translate-x-1 hover:bg-violet-50 hover:text-violet-700"
                                />
                                <x-mary-menu-item
                                    title="Daftar Mata Pelajaran"
                                    icon="o-book-open"
                                    link="/kacap/kurikulum/mata-pelajaran"
                                    wire:navigate
                                    class="transition-all hover:translate-x-1 hover:bg-violet-50 hover:text-violet-700"
                                />
                            </x-mary-menu-sub>

                            <x-mary-menu-item
                                title="Absensi"
                                icon="o-clipboard-document-list"
                                link="/kacap/absensi"
                                wire:navigate
                                class="rounded-xl transition-all duration-300 hover:bg-violet-50 hover:text-violet-700"
                            >

                            </x-mary-menu-item>

                            <x-mary-menu-sub
                                title="Keuangan"
                                icon="o-banknotes"
                                class="rounded-xl transition-all duration-300 hover:bg-violet-50"
                            >
                                <x-mary-menu-item
                                    title="Laporan Keuangan"
                                    icon="o-document-chart-bar"
                                    link="/kacap/keuangan"
                                    wire:navigate
                                    class="transition-all hover:translate-x-1 hover:bg-violet-50 hover:text-violet-700"
                                />
                                <x-mary-menu-item
                                    title="Pembayaran"
                                    icon="o-credit-card"
                                    link="/kacap/keuangan/pembayaran"
                                    wire:navigate
                                    class="transition-all hover:translate-x-1 hover:bg-violet-50 hover:text-violet-700"
                                />
                            </x-mary-menu-sub>

                            <x-mary-menu-item
                                title="Logout"
                                icon="o-power"
                                link="/kacap/logout"
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
                                    href="/kacap"
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

                    <div
                        class="bg-gradient-to-br from-violet-50/50 via-indigo-50/50 to-blue-50/50 p-6"
                    >
                        {{ $slot }}
                    </div>
                </x-slot>
            </x-mary-main>

            {{-- Notification --}}
            <x-mary-toast />
        </div>

        {{-- Scripts --}}
        @livewireScripts
        @stack("scripts")
    </body>
</html>
