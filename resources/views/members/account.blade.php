@extends('layouts.app')
@section('title', 'Member Account Summary')

<x-navbar/>
@section('content')
<x-sidebar/>

<div class="container mt-4" style="max-width: 900px;">
    <!-- Header -->
    <div class="text-center mb-4">
        <h3 class="fw-bold text-dark">
            <i class="bi bi-wallet2 text-primary me-2"></i> Account Summary
        </h3>
        <p class="text-muted mb-1">{{ $member->name ?? 'Member Name' }}</p>
        <p class="text-muted" style="font-size: 0.9rem;">
            {{ $member->company->name ?? '' }} / {{ $member->branch->name ?? '' }}
        </p>
    </div>

    <!-- Summary Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-center"
                 style="border-radius: 15px; background: linear-gradient(135deg, #007bff, #00b4d8); color: #fff;">
                <div class="card-body">
                    <h6 class="fw-semibold mb-1">Total Orders (30 days)</h6>
                    <h3 class="fw-bold mb-0">{{ $orderCount }}</h3>
                    <i class="bi bi-basket fs-3 mt-2"></i>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-center"
                 style="border-radius: 15px; background: linear-gradient(135deg, #6610f2, #6f42c1); color: #fff;">
                <div class="card-body">
                    <h6 class="fw-semibold mb-1">Total Spent</h6>
                    <h3 class="fw-bold mb-0">৳{{ number_format($balance, 2) }}</h3>
                    <i class="bi bi-cash-stack fs-3 mt-2"></i>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm border-0 text-center"
                 style="border-radius: 15px; background: linear-gradient(135deg, #dc3545, #ff6b6b); color: #fff;">
                <div class="card-body">
                    <h6 class="fw-semibold mb-1">Total Due</h6>
                    <h3 class="fw-bold mb-0">৳{{ number_format($totalDue, 2) }}</h3>
                    <i class="bi bi-exclamation-triangle fs-3 mt-2"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="card shadow-sm border-0" style="border-radius: 12px;">
        <div class="card-header text-white fw-bold d-flex justify-content-between align-items-center"
             style="background: linear-gradient(135deg, #007bff, #6610f2); font-size: 1.05rem; border: none;">
            <div><i class="bi bi-cart-check me-2"></i> Recent Orders</div>
            <a href="{{ route('members.show', $member->id) }}"
               class="btn btn-light btn-sm fw-semibold"
               style="border-radius: 20px; padding: 2px 12px;">
               <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th>NO.</th>
                            <th>Date</th>
                            <th>Slot</th>
                            <th>Product</th>
                            <th>Total (৳)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $index => $order)
                            <tr class="text-center">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</td>
                                <td>{{ $order->slot->name ?? 'N/A' }}</td>
                                <td>
                                    @foreach($order->items as $item)
                                        <span class="badge bg-light text-dark border me-1 mb-1"
                                              style="font-size: 0.8rem; border-radius: 10px;">
                                            {{ $item->product->name }} × {{ $item->qty }}
                                        </span>
                                    @endforeach
                                </td>
                                <td>{{ number_format($order->grand_total, 2) }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-3">No orders found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <p class="text-center text-muted mt-4" style="font-size: 0.85rem;">
        &copy; {{ date('Y') }} Web-Xpress. All rights reserved.
    </p>
</div>
@endsection

@push('scripts')
<!-- Bootstrap JS if not already loaded in layout -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endpush
