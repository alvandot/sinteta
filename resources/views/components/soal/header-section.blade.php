@props(["title" => "Buat Soal Baru 📝", "subtitle" => "Tambahkan soal baru ke bank soal untuk digunakan dalam ujian"])

<x-ts-card
    class="group relative transform overflow-hidden rounded-3xl border-none transition-all duration-700 hover:scale-[1.02]"
    shadow="xl"
    blur
    color="white"
>
    {{-- Gradient Background --}}
    <div
        class="absolute inset-0 bg-gradient-to-br from-violet-50 via-indigo-50 to-blue-50 opacity-80"
    ></div>

    {{-- Decorative Elements --}}
    <div class="absolute inset-0">
        <div
            class="absolute -right-16 -top-16 h-64 w-64 rounded-full bg-violet-400/20 blur-3xl"
        ></div>
        <div
            class="absolute -bottom-16 -left-16 h-64 w-64 rounded-full bg-indigo-400/20 blur-3xl"
        ></div>
        <div
            class="absolute left-1/2 top-1/2 h-48 w-48 -translate-x-1/2 -translate-y-1/2 rounded-full bg-blue-400/10 blur-2xl"
        ></div>
    </div>

    {{-- Content --}}
    <div class="relative p-8">
        <div class="space-y-6">
            {{-- Title --}}
            <div
                class="space-y-2"
                x-data="{ show: false }"
                x-init="setTimeout(() => (show = true), 300)"
                x-show="show"
                x-transition:enter="transition duration-500 ease-out"
                x-transition:enter-start="-translate-y-4 transform opacity-0"
                x-transition:enter-end="translate-y-0 transform opacity-100"
            >
                <h1
                    class="transform cursor-default bg-gradient-to-r from-violet-600 via-indigo-600 to-blue-600 bg-clip-text text-4xl font-black tracking-tight text-transparent transition-all duration-300 hover:scale-105"
                    x-data="{ hover: false }"
                    @mouseenter="hover = true"
                    @mouseleave="hover = false"
                    :class="{ 'animate-pulse': hover }"
                >
                    {{ $title }}
                </h1>

                <p
                    class="max-w-2xl text-base font-medium leading-relaxed text-gray-600/90 transition-colors duration-300 hover:text-gray-800"
                    x-data="{ hover: false }"
                    @mouseenter="hover = true"
                    @mouseleave="hover = false"
                    :class="{ 'translate-x-2': hover }"
                    style="transition: transform 0.3s ease"
                >
                    {{ $subtitle }}
                </p>
            </div>

            {{-- Decorative Lines --}}
            <div class="flex items-center space-x-3">
                <div
                    class="h-1.5 w-24 rounded-full bg-gradient-to-r from-violet-600 via-indigo-600 to-blue-600"
                ></div>
                <div
                    class="h-1.5 w-12 rounded-full bg-gradient-to-r from-violet-600/40 to-indigo-600/40"
                ></div>
            </div>
        </div>
    </div>
</x-ts-card>
