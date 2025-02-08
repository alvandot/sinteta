<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AppBrand extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return <<<'HTML'
                <a href="/" wire:navigate>
                    <!-- Hidden when collapsed -->
                    <div {{ $attributes->class(["hidden-when-collapsed"]) }}>
                        <div class="flex items-center gap-3 transition-all duration-300 hover:scale-105">
                            <img src="{{ asset('storage/logo.webp') }}" alt="Logo" class="w-12 h-12 rounded-lg shadow-lg hover:shadow-purple-500/30">
                            <div class="flex flex-col space-y-1">
                                <span class="text-2xl font-extrabold bg-gradient-to-r from-purple-600 via-pink-500 to-blue-500 bg-clip-text  tracking-tight hover:from-blue-500 hover:via-pink-500 hover:to-purple-600 transition-all duration-300">SINTETA</span>
                                <span class="text-sm font-medium text-gray-600 dark:text-gray-300 tracking-wide uppercase">Learning Center</span>
                            </div>
                        </div>
                    </div>

                    <!-- Display when collapsed -->
                    <div class="display-when-collapsed hidden mx-5 mt-4 lg:mb-6 h-[28px]">
                        <x-mary-icon name="s-square-3-stack-3d" class="w-6 -mb-1 text-purple-500" />
                    </div>
                </a>
            HTML;
    }
}
