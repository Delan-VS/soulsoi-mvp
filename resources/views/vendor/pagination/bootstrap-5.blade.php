@if ($paginator->hasPages())
    <nav class="d-flex justify-items-center justify-content-between">
        <div class="d-flex justify-content-between flex-fill d-sm-none">
            <ul class="pagination">
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">&laquo; Prev</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo; Prev</a>
                    </li>
                @endif

                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Next &raquo;</a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">Next &raquo;</span>
                    </li>
                @endif
            </ul>
        </div>

        <div class="d-none flex-sm-fill d-sm-flex align-items-sm-center justify-content-sm-between">
            <div class="small text-muted">
                Showing
                <span class="fw-semibold">{{ $paginator->firstItem() }}</span>
                to
                <span class="fw-semibold">{{ $paginator->lastItem() }}</span>
                of
                <span class="fw-semibold">{{ $paginator->total() }}</span>
                results
            </div>

            <div>
                <ul class="pagination mb-0" style="display:flex; align-items:center; gap:4px; list-style:none; padding:0; margin:0;">

                    {{-- Previous Button --}}
                    @if ($paginator->onFirstPage())
                        <li>
                            <span style="display:inline-flex; align-items:center; justify-content:center; width:34px; height:34px; border-radius:8px; border:1px solid #e2e8f0; background:#f8fafc; color:#cbd5e1; font-size:16px; cursor:not-allowed; user-select:none;">&lsaquo;</span>
                        </li>
                    @else
                        <li>
                            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" style="display:inline-flex; align-items:center; justify-content:center; width:34px; height:34px; border-radius:8px; border:1px solid #5cc42c; background:white; color:#5cc42c; font-size:16px; text-decoration:none; font-weight:600; transition:all 0.2s;" onmouseover="this.style.background='#5cc42c';this.style.color='white';" onmouseout="this.style.background='white';this.style.color='#5cc42c';">&lsaquo;</a>
                        </li>
                    @endif

                    {{-- Page Numbers --}}
                    @foreach ($elements as $element)
                        @if (is_string($element))
                            <li>
                                <span style="display:inline-flex; align-items:center; justify-content:center; width:34px; height:34px; border-radius:8px; border:1px solid #e2e8f0; background:#f8fafc; color:#94a3b8; font-size:13px;">…</span>
                            </li>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <li>
                                        <span style="display:inline-flex; align-items:center; justify-content:center; width:34px; height:34px; border-radius:8px; background:#5cc42c; border:1px solid #5cc42c; color:white; font-size:13px; font-weight:700;">{{ $page }}</span>
                                    </li>
                                @else
                                    <li>
                                        <a href="{{ $url }}" style="display:inline-flex; align-items:center; justify-content:center; width:34px; height:34px; border-radius:8px; border:1px solid #e2e8f0; background:white; color:#374151; font-size:13px; text-decoration:none; transition:all 0.2s;" onmouseover="this.style.background='#f0fdf4';this.style.borderColor='#5cc42c';this.style.color='#5cc42c';" onmouseout="this.style.background='white';this.style.borderColor='#e2e8f0';this.style.color='#374151';">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Button --}}
                    @if ($paginator->hasMorePages())
                        <li>
                            <a href="{{ $paginator->nextPageUrl() }}" rel="next" style="display:inline-flex; align-items:center; justify-content:center; width:34px; height:34px; border-radius:8px; border:1px solid #5cc42c; background:white; color:#5cc42c; font-size:16px; text-decoration:none; font-weight:600; transition:all 0.2s;" onmouseover="this.style.background='#5cc42c';this.style.color='white';" onmouseout="this.style.background='white';this.style.color='#5cc42c';">&rsaquo;</a>
                        </li>
                    @else
                        <li>
                            <span style="display:inline-flex; align-items:center; justify-content:center; width:34px; height:34px; border-radius:8px; border:1px solid #e2e8f0; background:#f8fafc; color:#cbd5e1; font-size:16px; cursor:not-allowed; user-select:none;">&rsaquo;</span>
                        </li>
                    @endif

                </ul>
            </div>
        </div>
    </nav>
@endif
