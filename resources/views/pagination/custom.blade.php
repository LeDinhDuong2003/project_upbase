@if ($paginator->hasPages())
    <nav aria-label="Page navigation" style="display: flex; justify-content: center; align-items: center;">
        <ul class="pagination">
            <!-- Previous Page Link -->
            @if ($paginator->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">Previous</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">Previous</a>
                </li>
            @endif

            <!-- Page Number Links with range limit -->
            @php
                $currentPage = $paginator->currentPage();
                $totalPages = $paginator->lastPage();
                $range = 2; // Number of pages to show before and after current page
                $start = max($currentPage - $range, 1);
                $end = min($currentPage + $range, $totalPages);
            @endphp

            @for ($page = $start; $page <= $end; $page++)
                <li class="page-item {{ $page == $currentPage ? 'active' : '' }}">
                    <a class="page-link" href="{{ $paginator->url($page) }}">{{ $page }}</a>
                </li>
            @endfor

            <!-- Next Page Link -->
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Next</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">Next</span>
                </li>
            @endif
        </ul>
    </nav>
@endif
