<div
    class="flex min-h-screen items-center justify-center bg-gradient-to-br from-emerald-100 via-teal-50 to-green-100"
>
    <div
        class="w-full max-w-md space-y-6 rounded-3xl border-2 border-white/70 bg-white/90 p-8 shadow-2xl backdrop-blur-md transition-all duration-300 hover:shadow-green-100"
    >
        <div class="space-y-3 text-center">
            <div class="relative">
                <img
                    src="{{ asset("storage/logo.webp") }}"
                    alt="Logo"
                    class="mx-auto h-20 w-20 animate-pulse"
                />
                <div
                    class="absolute inset-0 animate-pulse rounded-full bg-emerald-100 opacity-30 blur-2xl"
                >
                    <span></span>
                    Sinteta
                </div>
            </div>
            <h1
                class="bg-gradient-to-r from-emerald-600 via-green-600 to-teal-600 bg-clip-text text-3xl font-extrabold text-transparent"
            >
                Login Kepala Cabang
            </h1>
            <h2 class="text-xl font-bold text-emerald-600">SINTETA</h2>
            <p class="font-medium text-gray-600">
                Area khusus Kepala Cabang untuk mengelola cabang
            </p>
        </div>

        <form wire:submit="login" class="space-y-4">
            <x-ts-input
                wire:model="email"
                label="Email Kepala Cabang"
                type="email"
                placeholder="kacap@cabang.com"
                icon="building-office"
                class="w-full"
            />
            @error("email")
                <x-mary-alert
                    icon="o-exclamation-triangle"
                    class="animate-shake mt-1"
                >
                    {{ $message }}
                </x-mary-alert>
            @enderror

            <x-ts-input
                wire:model="password"
                label="Password"
                type="password"
                placeholder="Password Kepala Cabang"
                icon="key"
                class="w-full"
            />
            @error("password")
                <x-mary-alert
                    icon="o-exclamation-triangle"
                    class="animate-shake mt-1"
                >
                    {{ $message }}
                </x-mary-alert>
            @enderror

            <x-ts-toggle
                wire:model="remember"
                label="Ingat saya"
                class="text-sm"
            />

            <x-ts-button
                type="submit"
                class="w-full bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700"
                icon="building-office"
                spinner
            >
                Masuk sebagai Kepala Cabang
            </x-ts-button>
        </form>

        <div class="space-y-2 text-center">
            <p class="text-sm text-gray-600">
                Bukan Kepala Cabang? Login sebagai:
            </p>
            <div class="flex justify-center gap-2">
                <x-mary-button
                    link="/admin/login"
                    label="Admin"
                    icon="o-user-circle"
                    class="btn-ghost text-blue-600 transition-all duration-300 hover:scale-105 hover:text-indigo-600"
                    size="sm"
                />
                <x-mary-button
                    href="/"
                    label="Beranda"
                    icon="o-home"
                    class="btn-ghost text-emerald-600 transition-all duration-300 hover:scale-105 hover:text-green-600"
                    size="sm"
                />
            </div>
        </div>
    </div>
</div>
