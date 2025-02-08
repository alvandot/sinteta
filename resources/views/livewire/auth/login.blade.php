<div
    x-data="{
        darkMode: localStorage.getItem('darkMode') === 'true',
        toast: {
            show: false,
            type: 'info',
            message: '',
            description: '',
            position: 'bottom-right',
        },
        showToast(message, description = '', type = 'info') {
            this.toast.show = true
            this.toast.type = type
            this.toast.message = message
            this.toast.description = description

            setTimeout(() => {
                this.toast.show = false
            }, 3000)
        },
        toggleDarkMode() {
            this.darkMode = ! this.darkMode
            localStorage.setItem('darkMode', this.darkMode)
            document.documentElement.classList.toggle('dark')
        },
        init() {
            if (this.darkMode) {
                document.documentElement.classList.add('dark')
            }
        },
    }"
    x-init="init()"
    class="relative flex min-h-screen items-center justify-center bg-gradient-to-br from-gray-50 to-white transition-all duration-500 dark:from-gray-900 dark:to-gray-800"
    :class="{ 'dark': darkMode }"
>
    {{-- Dark Mode Toggle --}}
    <button
        @click="toggleDarkMode()"
        class="fixed right-4 top-4 z-50 rounded-full bg-white/10 p-3 shadow-lg backdrop-blur-md transition-all duration-300 hover:scale-110 hover:bg-gray-200 dark:hover:bg-gray-700"
    >
        <x-mary-icon
            x-show="!darkMode"
            name="o-moon"
            class="h-6 w-6 text-gray-700 dark:text-gray-300"
        />
        <x-mary-icon
            x-show="darkMode"
            name="o-sun"
            class="h-6 w-6 text-yellow-400"
        />
    </button>

    {{-- Toast Notification --}}
    <div
        x-show="toast.show"
        x-transition:enter="transition duration-300 ease-out"
        x-transition:enter-start="translate-y-2 opacity-0"
        x-transition:enter-end="translate-y-0 opacity-100"
        x-transition:leave="transition duration-200 ease-in"
        x-transition:leave-start="translate-y-0 opacity-100"
        x-transition:leave-end="translate-y-2 opacity-0"
        :class="{
            'bottom-4 right-4': toast.position === 'bottom-right',
            'top-4 right-4': toast.position === 'top-right',
            'bottom-4 left-4': toast.position === 'bottom-left',
            'top-4 left-4': toast.position === 'top-left'
        }"
        class="fixed z-50"
    >
        <div
            class="rounded-lg bg-white/80 p-4 shadow-xl backdrop-blur-sm dark:bg-gray-800/80"
        >
            <div class="flex items-center space-x-3">
                <div
                    :class="{
                    'text-green-500': toast.type === 'success',
                    'text-blue-500': toast.type === 'info',
                    'text-red-500': toast.type === 'error',
                    'text-yellow-500': toast.type === 'warning'
                }"
                >
                    <x-mary-icon
                        name="o-check-circle"
                        class="h-6 w-6"
                        x-show="toast.type === 'success'"
                    />
                    <x-mary-icon
                        name="o-information-circle"
                        class="h-6 w-6"
                        x-show="toast.type === 'info'"
                    />
                    <x-mary-icon
                        name="o-x-circle"
                        class="h-6 w-6"
                        x-show="toast.type === 'error'"
                    />
                    <x-mary-icon
                        name="o-exclamation-triangle"
                        class="h-6 w-6"
                        x-show="toast.type === 'warning'"
                    />
                </div>
                <div>
                    <p
                        class="font-medium text-gray-900 dark:text-white"
                        x-text="toast.message"
                    ></p>
                    <p
                        class="text-sm text-gray-600 dark:text-gray-300"
                        x-text="toast.description"
                    ></p>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full max-w-md px-4">
        <x-mary-card
            class="transform border-l-4 border-primary-500 bg-white/80 shadow-2xl backdrop-blur-md transition-all duration-300 hover:scale-[1.02] dark:bg-gray-800/80"
        >
            <!-- Logo/Brand -->
            <div class="mb-8 text-center">
                <x-app-brand class="mx-auto h-12 w-auto" />
                <h1
                    class="mt-4 bg-gradient-to-r from-primary-500 via-secondary-500 to-primary-500 bg-clip-text text-4xl font-black tracking-tight text-transparent"
                >
                    Login Admin
                </h1>
            </div>

            <!-- Form Login -->
            <form wire:submit="login" class="space-y-6">
                <!-- Email -->
                <div class="group">
                    <label
                        class="mb-2 block text-sm font-medium leading-6 text-gray-900 transition-colors duration-300 group-hover:text-primary-500 dark:text-gray-100"
                    >
                        Email
                    </label>
                    <div class="relative">
                        <x-mary-icon
                            name="o-envelope"
                            class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400 transition-colors duration-300 group-hover:text-primary-500"
                        />
                        <x-mary-input
                            wire:model="email"
                            type="email"
                            placeholder="admin@example.com"
                            class="w-full pl-10 transition-all duration-300 hover:shadow-md focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white"
                        />
                    </div>
                </div>

                <!-- Password -->
                <div class="group">
                    <label
                        class="mb-2 block text-sm font-medium leading-6 text-gray-900 transition-colors duration-300 group-hover:text-primary-500 dark:text-gray-100"
                    >
                        Password
                    </label>
                    <div class="relative">
                        <x-mary-icon
                            name="o-key"
                            class="absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-gray-400 transition-colors duration-300 group-hover:text-primary-500"
                        />
                        <x-mary-input
                            wire:model="password"
                            type="password"
                            placeholder="******"
                            class="w-full pl-10 transition-all duration-300 hover:shadow-md focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white"
                        />
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <x-mary-checkbox
                        wire:model="remember"
                        label="Ingat saya"
                        class="text-primary-500"
                    />
                </div>

                <!-- Login Button -->
                <x-mary-button
                    type="submit"
                    x-on:click="showToast('Mencoba login...', 'Mohon tunggu sebentar', 'info')"
                    class="w-full transform bg-gradient-to-r from-primary-500 via-secondary-500 to-primary-500 text-white transition-all duration-300 hover:scale-105 hover:shadow-lg"
                >
                    <x-mary-icon
                        name="o-arrow-right-on-rectangle"
                        class="mr-2 h-5 w-5"
                    />
                    Login
                </x-mary-button>
            </form>

            <!-- Decorative Elements -->
            <div
                class="absolute -bottom-8 -right-8 h-32 w-32 animate-pulse rounded-full bg-primary-500/20 blur-2xl"
            ></div>
            <div
                class="absolute -left-8 -top-8 h-32 w-32 animate-pulse rounded-full bg-secondary-500/20 blur-2xl"
            ></div>
        </x-mary-card>
    </div>
</div>
