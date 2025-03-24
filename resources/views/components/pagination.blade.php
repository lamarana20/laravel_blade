<div class="mt-6 flex justify-end space-x-2">
    <!-- Previous Page Arrow -->
    @if ($posts->onFirstPage())
        <span class="px-4 py-2 border rounded-lg text-gray-400">←</span>
    @else
        <a href="{{ $posts->previousPageUrl() }}" class="px-4 py-2 border rounded-lg hover:bg-gray-200">←</a>
    @endif

    <!-- Page Numbers with Dynamic Ellipsis -->
    @php
        $currentPage = $posts->currentPage();
        $lastPage = $posts->lastPage();
    @endphp

    @if ($currentPage > 3)
        <a href="{{ $posts->url(1) }}" class="px-4 py-2 border rounded-lg hover:bg-gray-200">1</a>
        @if ($currentPage > 4)
            <span class="px-4 py-2 border rounded-lg text-gray-400">...</span>
        @endif
    @endif

    @for ($i = max(1, $currentPage - 2); $i <= min($lastPage, $currentPage + 2); $i++)
        <a href="{{ $posts->url($i) }}"
            class="px-4 py-2 border rounded-lg {{ $i == $currentPage ? 'bg-gray-800 text-white' : 'hover:bg-gray-200' }}">
            {{ $i }}
        </a>
    @endfor

    @if ($currentPage < $lastPage - 2)
        @if ($currentPage < $lastPage - 3)
            <span class="px-4 py-2 border rounded-lg text-gray-400">...</span>
        @endif
        <a href="{{ $posts->url($lastPage) }}"
            class="px-4 py-2 border rounded-lg hover:bg-gray-200">{{ $lastPage }}</a>
    @endif

    <!-- Next Page Arrow -->
    @if ($posts->hasMorePages())
        <a href="{{ $posts->nextPageUrl() }}" class="px-4 py-2 border rounded-lg hover:bg-gray-200">→</a>
    @else
        <span class="px-4 py-2 border rounded-lg text-gray-400">→</span>
    @endif
</div>