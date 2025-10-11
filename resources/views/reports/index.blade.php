@extends('layouts.app')
@section('title','Reports')
<x-navbar/>
@section('content')
<x-sidebar/>

<div class="container mt-4">
    <h3 class="fw-bold mb-4 text-primary">
        <i class="bi bi-graph-up"></i> Reports
    </h3>

    {{-- 🔹 Filter Section --}}
    <div class="card mb-4 shadow-lg border-0" style="border-radius: 12px;">
        <div class="card-body d-flex flex-wrap align-items-end gap-3 p-4">

            {{-- Member Filter --}}
            <div class="flex-grow-1" style="min-width: 200px;">
                <label class="form-label fw-semibold text-secondary mb-1">Select Member</label>
                <select id="memberFilter" class="form-select select2 shadow-sm" style="border-radius: 8px;">
                    <option value="all" selected>All Members</option>
                    @foreach(\App\Models\Member::orderBy('name')->get() as $m)
                        <option value="{{ $m->id }}">{{ $m->name }} ({{ $m->phone ?? 'N/A' }})</option>
                    @endforeach
                </select>
            </div>

            {{-- Date Range Filter --}}
            <div class="flex-grow-0" style="min-width: 150px;">
                <label class="form-label fw-semibold text-secondary mb-1">From Date</label>
                <input type="date" id="fromDate" class="form-control shadow-sm" style="border-radius: 8px;">
            </div>
            <div class="flex-grow-0" style="min-width: 150px;">
                <label class="form-label fw-semibold text-secondary mb-1">To Date</label>
                <input type="date" id="toDate" class="form-control shadow-sm" style="border-radius: 8px;">
            </div>

            <div class="d-flex gap-2">
                <button id="applyFilter" class="btn btn-primary shadow-sm fw-bold" 
                        style="height: 40px; border-radius: 8px;">
                    <i class="bi bi-funnel me-1"></i> Apply
                </button>
            </div>
        </div>
    </div>

    {{-- 🔹 Tabs --}}
    <ul class="nav nav-tabs mb-3" id="reportTabs" role="tablist">
        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#today">Today</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#tomorrow">Tomorrow</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#monthly">Monthly</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#yearly">Yearly</a></li>
        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#range">Date Range</a></li>
    </ul>

    {{-- 🔹 Tab Content --}}
    <div class="tab-content">
        <div class="tab-pane fade show active" id="today"></div>
        <div class="tab-pane fade" id="tomorrow"></div>
        <div class="tab-pane fade" id="monthly"></div>
        <div class="tab-pane fade" id="yearly"></div>
        <div class="tab-pane fade" id="range"></div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // init select2
    $('.select2').select2({ width: '100%', placeholder: 'Select a member', allowClear: true });

    const routes = {
        '#today': "{{ route('reports.today') }}",
        '#tomorrow': "{{ route('reports.tomorrow') }}",
        '#monthly': "{{ route('reports.monthly') }}",
        '#yearly': "{{ route('reports.yearly') }}",
        '#range': "{{ route('reports.dateRange') }}"
    };

    // loading placeholder
    function loadingHtml(text = 'Loading...') {
        return `
            <div class="text-center text-muted my-5">
                <div class="spinner-border text-primary" role="status"></div>
                <p class="mt-3">${text}</p>
            </div>
        `;
    }

    function loadReport(tabId, url, appendParams = true) {
        const memberId = $('#memberFilter').val() || 'all';
        const fromDate = $('#fromDate').val();
        const toDate = $('#toDate').val();

        let fetchUrl = url;
        if (appendParams) {
            const params = new URLSearchParams();
            params.set('member', memberId ?? 'all');
            if (fromDate) params.set('from', fromDate);
            if (toDate) params.set('to', toDate);
            fetchUrl = url + '?' + params.toString();
        }

        $(tabId).html(loadingHtml());
        fetch(fetchUrl, { credentials: 'same-origin' })
            .then(res => {
                if (!res.ok) throw new Error('Network response was not ok');
                return res.text();
            })
            .then(html => {
                $(tabId).html(html);
                // Scroll to top of tab (optional)
                $(tabId).get(0).scrollIntoView({ behavior: 'smooth' });
            })
            .catch(() => {
                $(tabId).html('<p class="text-danger text-center mt-3">Failed to load report.</p>');
            });
    }

    // initial load
    loadReport('#today', routes['#today'], true);

    // when tabs show, load content
    $('#reportTabs a').on('shown.bs.tab', function(e) {
        const id = e.target.getAttribute('href');
        // If the tab is empty, load it (or always reload if you prefer)
        loadReport(id, routes[id], true);
    });

    // Apply filter button — reload the active tab with appended params
    $('#applyFilter').on('click', function() {
        const activeTab = $('#reportTabs .nav-link.active').attr('href');
        loadReport(activeTab, routes[activeTab], true);
    });
    $(document).on('click', '.tab-pane .pagination a', function(e) {
        e.preventDefault();

        const href = $(this).attr('href');
        if (!href) return;

        const $pane = $(this).closest('.tab-pane');
        const paneId = '#' + $pane.attr('id');
        loadReport(paneId, href, false);
    });

});
</script>
@endpush
