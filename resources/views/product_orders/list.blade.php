@extends('layouts.app')
@section('title','Product Orders')
<x-navbar/>
@section('content')
<x-sidebar/>

<div class="container mt-3">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h2>Meal Orders</h2>
        @can('create order')
            <a href="{{ route('product_orders.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> New Order
            </a>
        @endcan
    </div>
    {{-- 🔹 Filter Section --}}
    <div class="card mb-4 shadow-lg border-0" style="border-radius: 12px;">
        <div class="card-body d-flex flex-wrap align-items-end gap-3 p-4">

            {{-- Member Filter --}}
            <div class="flex-grow-1" style="min-width: 200px;">
                <label class="form-label fw-semibold text-secondary mb-1">Select Member</label>
                <select id="memberFilter" class="form-select select2 shadow-sm" style="border-radius: 8px;">
                    <option value="all" {{ ($selectedMember ?? 'all') == 'all' ? 'selected' : '' }}>All Members</option>
                    @foreach($members as $m)
                        <option value="{{ $m->id }}" 
                            {{ ($selectedMember ?? 'all') == $m->id ? 'selected' : '' }}>
                            {{ $m->name }} ({{ $m->phone ?? 'N/A' }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Date Range Filter --}}
            <div class="flex-grow-0" style="min-width: 150px;">
                <label class="form-label fw-semibold text-secondary mb-1">From Date</label>
                <input type="date" id="fromDate" class="form-control shadow-sm" style="border-radius: 8px;"
                    value="{{ $fromDate ?? '' }}">
            </div>
            <div class="flex-grow-0" style="min-width: 150px;">
                <label class="form-label fw-semibold text-secondary mb-1">To Date</label>
                <input type="date" id="toDate" class="form-control shadow-sm" style="border-radius: 8px;"
                    value="{{ $toDate ?? '' }}">
            </div>
        </div>
    </div>

        <div id="ordersTable">
        @include('product_orders.partials.table', ['orders' => $orders])
        </div>



    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('.select2').select2({ width: '100%' });

    function fetchOrders() {
        const member = $('#memberFilter').val();
        const from = $('#fromDate').val();
        const to = $('#toDate').val();

        $.ajax({
            url: "{{ route('product_orders.index') }}",
            data: { member, from, to },
            beforeSend: function() {
                $('#ordersTable').html('<div class="text-center py-5 text-muted"><i class="bi bi-hourglass-split me-2"></i>Loading...</div>');
            },
            success: function(data) {
                $('#ordersTable').html(data);
            },
            error: function() {
                $('#ordersTable').html('<div class="alert alert-danger text-center">Failed to load data.</div>');
            }
        });
    }

    // Auto-refresh on filter change
    $('#memberFilter, #fromDate, #toDate').on('change', fetchOrders);

    // Handle pagination links (AJAX)
    $(document).on('click', '#ordersTable .pagination a', function(e) {
        e.preventDefault();
        const url = $(this).attr('href');
        const params = {
            member: $('#memberFilter').val(),
            from: $('#fromDate').val(),
            to: $('#toDate').val()
        };
        $.get(url, params, function(data) {
            $('#ordersTable').html(data);
        });
    });
});
</script>
@endpush


@endsection



