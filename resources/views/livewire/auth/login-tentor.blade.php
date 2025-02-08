<div
    x-data="{
        showPassword: false,
        isLoading: false,
        stats: {
            tentors: '500+',
            students: '1000+',
            success: '95%'
        },
        startLoading() {
            this.isLoading = true;
        },
        stopLoading() {
            this.isLoading = false;
        }
    }"
    class="flex min-h-screen items-center justify-center bg-gradient-to-br from-purple-50 via-fuchsia-50 to-pink-50"
>
    <div class="grid w-full max-w-6xl grid-cols-1 gap-12 p-8 md:grid-cols-2">
        <!-- Left Side - Branding & Inspiration -->
        <div class="hidden flex-col justify-center space-y-8 md:flex">
            <div class="space-y-6">
                <h1 class="bg-gradient-to-r from-purple-700 to-fuchsia-700 bg-clip-text font-serif text-5xl font-bold text-transparent">
                    Portal Tentor SINTETA
                </h1>
                <p class="text-xl font-light leading-relaxed text-gray-700">
                    "Pendidikan adalah seni membantu orang lain menemukan potensi terbaik dalam diri mereka."
                    <span class="mt-2 block text-sm italic text-gray-600">
                        - Maria Montessori
                    </span>
                </p>
            </div>

            <div class="relative">
                <div class="absolute -inset-1 rounded-3xl bg-gradient-to-r from-purple-500 to-fuchsia-500 opacity-20 blur-3xl"></div>
                <div class="relative overflow-hidden rounded-3xl bg-white/40 p-8 backdrop-blur-sm">
                    <div class="grid grid-cols-3 gap-4">
                        <template x-for="(value, key) in stats" :key="key">
                            <div class="space-y-2 text-center">
                                <div
                                    x-text="value"
                                    class="text-3xl font-bold"
                                    :class="{
                                        'text-purple-700': key === 'tentors',
                                        'text-fuchsia-700': key === 'students',
                                        'text-pink-700': key === 'success'
                                    }"
                                ></div>
                                <div class="text-sm text-gray-600" x-text="key === 'tentors' ? 'Tentor Aktif' : key === 'students' ? 'Siswa Bimbel' : 'Tingkat Kelulusan'"></div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <div class="relative mt-8">
                <div class="absolute inset-0 rounded-3xl bg-gradient-to-br from-purple-400/20 to-fuchsia-400/20 blur-3xl"></div>
                <img
                    src="{{ asset('storage/logo.webp') }}"
                    alt="Teacher Teaching"
                    class="relative w-full transform rounded-3xl shadow-2xl transition-all duration-700 hover:scale-[1.02] animate-float"
                />
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="relative">
            <div class="absolute inset-0 rounded-3xl bg-white/40 backdrop-blur-xl"></div>
            <div class="relative rounded-3xl border border-purple-100/50 bg-white/70 p-10 shadow-2xl transition-all duration-500 hover:bg-white/80">
                <div class="mb-12 flex flex-col items-center">
                    <div class="relative mb-6">
                        <div class="absolute inset-0 rounded-full bg-gradient-to-br from-purple-400 to-fuchsia-400 opacity-30 blur-lg"></div>
                        <img
                            src="{{ asset('storage/logo_guru.webp') }}"
                            alt="Logo"
                            class="relative h-36 w-36 transform rounded-full object-cover shadow-xl transition-all duration-500 hover:scale-105"
                            x-on:mouseenter="$el.classList.add('scale-105')"
                            x-on:mouseleave="$el.classList.remove('scale-105')"
                        />
                        <div class="absolute -bottom-3 left-1/2 -translate-x-1/2 rounded-full bg-gradient-to-r from-purple-600 to-fuchsia-600 px-5 py-2 text-sm font-medium text-white shadow-lg">
                            Area Tentor
                        </div>
                    </div>
                    <h2 class="mt-4 font-serif text-3xl font-bold text-gray-800">
                        Selamat Datang Kembali
                    </h2>
                    <p class="mt-2 text-gray-600">
                        Mari bersama mencerdaskan generasi bangsa
                    </p>
                </div>

                <x-mary-form
                    wire:submit="login"
                    x-on:submit="startLoading"
                    x-on:livewire:load="stopLoading"
                    class="space-y-7"
                >
                    <x-ts-input
                        label="Email"
                        icon="envelope"
                        wire:model="email"
                        type="email"
                        placeholder="tentor@sinteta.com"
                        class="w-full rounded-xl border-2 border-purple-100 bg-white/80 transition-all duration-300 focus:ring-2 focus:ring-purple-400/40"
                    />

                    <div class="relative">
                        <x-ts-input
                            label="Password"
                            icon="key"
                            wire:model="password"
                            x-bind:type="showPassword ? 'text' : 'password'"
                            placeholder="••••••••"
                            class="w-full rounded-xl border-2 border-purple-100 bg-white/80 transition-all duration-300 focus:ring-2 focus:ring-purple-400/40"
                        />
                        <button
                            type="button"
                            class="absolute right-3 top-1/2 text-gray-500 hover:text-purple-600"
                            x-on:click="showPassword = !showPassword"
                        >
                            <template x-if="!showPassword">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </template>
                            <template x-if="showPassword">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                                </svg>
                            </template>
                        </button>
                    </div>

                    <div class="flex items-center justify-between">
                        <x-ts-checkbox
                            wire:model="remember"
                            label="Ingat saya"
                            class="text-sm font-medium text-gray-700 transition-colors duration-300 hover:text-purple-700"
                        />
                        <a
                            href="#"
                            class="text-sm font-medium text-purple-600 transition-colors duration-300 hover:text-purple-800"
                            x-on:mouseenter="$el.classList.add('text-purple-800')"
                            x-on:mouseleave="$el.classList.remove('text-purple-800')"
                        >
                            Lupa password?
                        </a>
                    </div>

                    <x-mary-button
                        label="Masuk ke Portal"
                        type="submit"
                        spinner
                        x-bind:disabled="isLoading"
                        class="w-full transform rounded-xl bg-gradient-to-r from-purple-600 to-fuchsia-600 py-4 font-medium text-white shadow-lg transition-all duration-500 hover:scale-[1.02] hover:from-purple-700 hover:to-fuchsia-700 hover:shadow-xl"
                    >
                        <span x-show="!isLoading">Masuk ke Portal</span>
                        <span x-show="isLoading">Memproses...</span>
                    </x-mary-button>
                </x-mary-form>

                <div class="mt-8 space-y-4">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-300"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="bg-white/70 px-2 text-gray-500">atau</span>
                        </div>
                    </div>

                    <div class="flex justify-center gap-4">
                        <a
                            href="/"
                            class="group flex items-center gap-2 rounded-lg border border-gray-300 bg-white/80 px-4 py-2 text-sm font-medium text-gray-700 transition-all duration-300 hover:border-purple-400 hover:bg-purple-50"
                            x-on:mouseenter="$el.querySelector('svg').classList.add('text-purple-600')"
                            x-on:mouseleave="$el.querySelector('svg').classList.remove('text-purple-600')"
                        >
                            <svg class="h-5 w-5 text-gray-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Beranda
                        </a>
                        <a
                            href="#"
                            class="group flex items-center gap-2 rounded-lg border border-gray-300 bg-white/80 px-4 py-2 text-sm font-medium text-gray-700 transition-all duration-300 hover:border-purple-400 hover:bg-purple-50"
                            x-on:mouseenter="$el.querySelector('svg').classList.add('text-purple-600')"
                            x-on:mouseleave="$el.querySelector('svg').classList.remove('text-purple-600')"
                        >
                            <svg class="h-5 w-5 text-gray-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Bantuan
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
