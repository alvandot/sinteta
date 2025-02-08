@if ($paginator->hasPages())
    <nav
        role="navigation"
        aria-label="{{ __("Pagination Navigation") }}"
        class="flex items-center justify-center space-x-4 py-4"
    >
        <div class="flex flex-1 items-center justify-between">
            @if ($paginator->onFirstPage())
                <span
                    class="inline-flex transform cursor-default items-center px-4 py-2 text-sm font-medium text-gray-400 transition-transform duration-300 hover:scale-110"
                >
                    {!! __("pagination.previous") !!}
                </span>
            @else
                <a
                    href="{{ $paginator->previousPageUrl() }}"
                    class="inline-flex transform items-center px-4 py-2 text-sm font-medium text-gray-600 transition-transform duration-300 hover:scale-110 hover:text-violet-600"
                >
                    {!! __("pagination.previous") !!}
                </a>
            @endif

            <div class="flex space-x-2">
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span
                            class="inline-flex transform cursor-default items-center px-4 py-2 text-sm font-medium text-gray-500 transition-transform duration-300 hover:scale-110"
                        >
                            {{ $element }}
                        </span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span
                                    class="inline-flex transform items-center rounded-full bg-gradient-to-r from-violet-500 to-indigo-500 px-4 py-2 text-sm font-medium text-white shadow-lg transition-transform duration-300 hover:scale-110"
                                >
                                    {{ $page }}
                                </span>
                            @else
                                <a
                                    href="{{ $url }}"
                                    class="inline-flex transform items-center px-4 py-2 text-sm font-medium text-gray-600 transition-transform duration-300 hover:scale-110 hover:text-violet-600"
                                >
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            @if ($paginator->hasMorePages())
                <a
                    href="{{ $paginator->nextPageUrl() }}"
                    class="inline-flex transform items-center px-4 py-2 text-sm font-medium text-gray-600 transition-transform duration-300 hover:scale-110 hover:text-violet-600"
                >
                    {!! __("pagination.next") !!}
                </a>
            @else
                <span
                    class="inline-flex transform cursor-default items-center px-4 py-2 text-sm font-medium text-gray-400 transition-transform duration-300 hover:scale-110"
                >
                    {!! __("pagination.next") !!}
                </span>
            @endif
        </div>
    </nav>
@endif
