@extends('layouts.app')
@section('title','My Orders')
<x-navbar/>
@section('content')
<x-sidebar/>

<div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h2>My Orders</h2>
        <a href="{{ route('member_orders.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Place Order
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light sticky-top">
                <tr>
                    <th>Date</th>
                    <th>Slot</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d M, Y') }}</td>
                    <td>{{ $order->slot->name ?? '-' }}</td>
                    <td>{{ number_format($order->total,2) }} Tk</td>
                    <td>
                        <span class="badge 
                            @if($order->status=='ordered') bg-info 
                            @elseif($order->status=='delivered') bg-success
                            @elseif($order->status=='cancelled') bg-danger
                            @else bg-secondary @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center text-muted">No orders found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    {{ $orders->links() }}
</div>
@endsection
