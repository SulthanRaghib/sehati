@if ($paginator->total() > 0)
    <div class="d-flex justify-content-between align-items-center mt-4">

        {{-- Items per page & range info --}}
        <form method="GET" action="{{ url()->current() }}" id="perPageForm" class="d-flex align-items-center gap-2">
            {{-- Pertahankan query lain jika ada --}}
            @foreach (request()->except('perPage', 'page') as $key => $value)
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endforeach

            <label class="mb-0">Items per page</label>
            <select name="perPage" class="form-select form-select-sm" style="width: 70px;"
                onchange="document.getElementById('perPageForm').submit()">
                @foreach ([6, 12, 18, 24, 30] as $size)
                    <option value="{{ $size }}"
                        {{ request('perPage', $paginator->perPage()) == $size ? 'selected' : '' }}>{{ $size }}
                    </option>
                @endforeach
            </select>

            <div class="text-muted small">
                {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} of {{ $paginator->total() }} items
            </div>
        </form>

        {{-- Pagination controls hanya ditampilkan jika ada lebih dari 1 halaman --}}
        @if ($paginator->hasPages() && $paginator->total() > $paginator->perPage())
            <div class="d-flex align-items-center gap-2">

                {{-- First Page --}}
                <a class="btn btn-sm btn-outline-secondary {{ $paginator->onFirstPage() ? 'disabled' : '' }}"
                    href="{{ $paginator->onFirstPage() ? '#' : $paginator->url(1) . '&perPage=' . request('perPage', $paginator->perPage()) }}">
                    &#171;
                </a>

                {{-- Previous Page --}}
                <a class="btn btn-sm btn-outline-secondary {{ $paginator->onFirstPage() ? 'disabled' : '' }}"
                    href="{{ $paginator->onFirstPage() ? '#' : $paginator->previousPageUrl() . '&perPage=' . request('perPage', $paginator->perPage()) }}">
                    &lsaquo; Previous
                </a>

                {{-- Page input --}}
                <input type="text" class="form-control form-control-sm text-center"
                    value="{{ $paginator->currentPage() }}" style="width: 50px;" readonly>
                <span class="small text-muted">of {{ $paginator->lastPage() }}</span>

                {{-- Next Page --}}
                <a class="btn btn-sm btn-outline-secondary {{ !$paginator->hasMorePages() ? 'disabled' : '' }}"
                    href="{{ $paginator->hasMorePages() ? $paginator->nextPageUrl() . '&perPage=' . request('perPage', $paginator->perPage()) : '#' }}">
                    Next &rsaquo;
                </a>

                {{-- Last Page --}}
                <a class="btn btn-sm btn-outline-secondary {{ !$paginator->hasMorePages() ? 'disabled' : '' }}"
                    href="{{ $paginator->hasMorePages() ? $paginator->url($paginator->lastPage()) . '&perPage=' . request('perPage', $paginator->perPage()) : '#' }}">
                    &#187;
                </a>

            </div>
        @endif
    </div>
@endif
