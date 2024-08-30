@php
if (! isset($scrollTo)) {
    $scrollTo = 'body';
}

$scrollIntoViewJsSnippet = ($scrollTo !== false)
    ? <<<JS
       (\$el.closest('{$scrollTo}') || document.querySelector('{$scrollTo}')).scrollIntoView()
    JS
    : '';
@endphp

<div>
    @if ($paginator->hasPages())
        <nav class="w-full sm:mr-auto sm:w-auto">
            <ul class="flex w-full mr-0 sm:mr-auto sm:w-auto">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="flex-1 sm:flex-initial disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                        <button
                            class="min-w-0 sm:min-w-[40px] shadow-none font-normal flex items-center justify-center border-transparent text-slate-800 sm:mr-2 dark:text-slate-300 px-1 sm:px-3"
                            aria-hidden="true"
                        >
                        <span class="page-link" aria-hidden="true">&lsaquo;</span>
                        </button>
                    </li>
                @else
                    <li class="flex-1 sm:flex-initial">
                        <button
                            dusk="previousPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}"
                            class="min-w-0 sm:min-w-[40px] shadow-none font-normal flex items-center justify-center border-transparent text-slate-800 sm:mr-2 dark:text-slate-300 px-1 sm:px-3"
                            wire:click="previousPage('{{ $paginator->getPageName() }}')"
                            x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" rel="prev"
                            aria-label="@lang('pagination.previous')"
                        >
                        <span class="page-link" aria-hidden="true">&lsaquo;</span>
                        </button>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <li class="flex-1 sm:flex-initial">
                            <button
                                class="min-w-0 sm:min-w-[40px] shadow-none font-normal flex items-center justify-center border-transparent text-slate-800 sm:mr-2 dark:text-slate-300 px-1 sm:px-3"
                            >
                                {{ $element }}
                            </button>
                        </li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="flex-1 sm:flex-initial" wire:key="paginator-{{ $paginator->getPageName() }}-page-{{ $page }}" aria-current="page">
                                    <button
                                        class="min-w-0 sm:min-w-[40px] shadow-none flex items-center justify-center border-transparent text-slate-800 sm:mr-2 dark:text-slate-300 px-1 sm:px-3 !box font-medium dark:bg-darkmode-400"
                                    >
                                        {{ $page }}
                                    </button>
                                </li>
                            @else
                                <li class="flex-1 sm:flex-initial" wire:key="paginator-{{ $paginator->getPageName() }}-page-{{ $page }}">
                                    <button
                                        class="min-w-0 sm:min-w-[40px] shadow-none flex items-center justify-center border-transparent text-slate-800 sm:mr-2 dark:text-slate-300 px-1 sm:px-3"
                                        wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}"
                                    >
                                        {{ $page }}
                                    </button>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="flex-1 sm:flex-initial">
                        <button
                            class="min-w-0 sm:min-w-[40px] shadow-none font-normal flex items-center justify-center border-transparent text-slate-800 sm:mr-2 dark:text-slate-300 px-1 sm:px-3"
                            dusk="nextPage{{ $paginator->getPageName() == 'page' ? '' : '.' . $paginator->getPageName() }}" class="page-link" wire:click="nextPage('{{ $paginator->getPageName() }}')" x-on:click="{{ $scrollIntoViewJsSnippet }}" wire:loading.attr="disabled" rel="next" aria-label="@lang('pagination.next')"
                        >
                        <span class="page-link" aria-hidden="true">&rsaquo;</span>
                        </button>
                    </li>
                @else
                    <li class="flex-1 sm:flex-initial disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                        <button
                            class="min-w-0 sm:min-w-[40px] shadow-none font-normal flex items-center justify-center border-transparent text-slate-800 sm:mr-2 dark:text-slate-300 px-1 sm:px-3"
                            aria-hidden="true"
                        >
                        <span class="page-link" aria-hidden="true">&rsaquo;</span>
                        </button>
                    </li>
                @endif
            </ul>
        </nav>

    @endif
</div>
