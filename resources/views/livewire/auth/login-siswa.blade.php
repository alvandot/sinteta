<div
    class="flex min-h-screen items-center justify-center bg-gradient-to-br from-indigo-100 to-purple-100"
>
    <div class="grid w-full max-w-6xl grid-cols-1 gap-8 p-8 md:grid-cols-2">
        <!-- Left Side - Text & Animation -->
        <div
            class="hidden flex-col items-start justify-center space-y-6 md:flex"
        >
            <h1 class="text-5xl font-bold text-indigo-900">
                Selamat Datang di Portal Siswa
            </h1>
            <p class="text-xl text-indigo-600">
                Platform pembelajaran digital untuk meningkatkan kualitas
                pendidikan dan pengembangan diri siswa.
            </p>

            <div class="relative w-full">
                <img
                    src="{{ asset("storage/logo.webp") }}"
                    alt="Students Learning"
                    class="animate-float h-auto min-w-96 rounded-2xl"
                />
            </div>
        </div>
        <!-- Right Side - Login Form -->
        <div
            class="rounded-2xl border border-indigo-100 bg-white/80 p-8 shadow-xl backdrop-blur-sm"
        >
            <div class="mb-8 flex flex-col items-center">
                <div class="relative">
                    <img
                        src="{{ asset("storage/logo_siswa.webp") }}"
                        alt="Logo"
                        class="mb-4 h-24 w-24 rounded-2xl object-cover shadow-lg"
                    />
                    <div
                        class="absolute -bottom-2 -right-2 rounded-lg bg-indigo-500 px-3 py-1 text-xs font-semibold text-white"
                    >
                        Siswa
                    </div>
                </div>
                <h1 class="text-3xl font-bold text-indigo-900">Portal Siswa</h1>
                <p class="mt-2 text-sm text-indigo-600">
                    Masuk untuk mengakses pembelajaran
                </p>
            </div>

            <x-mary-form wire:submit="login" class="space-y-5">
                <x-mary-input
                    label="Email"
                    icon="o-envelope"
                    wire:model="email"
                    type="email"
                    placeholder="nama@sekolah.com"
                    class="w-full rounded-xl border-2 border-indigo-200 bg-white/50 focus:ring-2 focus:ring-indigo-400"
                />

                <x-mary-password
                    label="Password"
                    clearable
                    wire:model="password"
                    password-icon="o-lock-closed"
                    password-visible-icon="o-lock-open"
                    placeholder="Masukkan password"
                    class="w-full rounded-xl border-2 border-indigo-200 bg-white/50 focus:ring-2 focus:ring-indigo-400"
                />

                <div class="flex items-center justify-between">
                    <x-mary-checkbox wire:model="remember">
                        <x-slot:label>
                            <span class="text-sm font-medium text-indigo-700">
                                Ingat saya
                            </span>
                        </x-slot>
                    </x-mary-checkbox>
                </div>

                <x-slot:actions>
                    <x-mary-button
                        label="Masuk ke Portal"
                        class="w-full transform rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 py-3 text-sm font-bold text-white shadow-lg transition duration-300 hover:scale-[1.02] hover:from-indigo-700 hover:to-purple-700"
                        type="submit"
                        spinner="login"
                    />
                </x-slot>
            </x-mary-form>
        </div>
    </div>
</div>
