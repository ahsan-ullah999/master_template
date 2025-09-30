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

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light sticky-top">
                <tr>
                    <th>No.</th>
                    <th>Member</th>
                    <th>Date</th>
                    <th>Slot</th>
                    <th>Subtotal</th>
                    <th>Discount</th>
                    <th>Final Total</th>
                    <th>Status</th>
                    @canany(['show order', 'deliver order', 'cancel order'])
                        <th width="200">Actions</th>
                    @endcanany
                    
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $order->member->name ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($order->order_date)->format('d M, Y') }}</td>
                    <td>{{ $order->slot->name ?? '-' }}</td>
                    <td>{{ number_format($order->total,2) }} Tk</td>
                    <td>
                        @if($order->discount_amount > 0)
                            <span class="text-success fw-bold">-{{ number_format($order->discount_amount,2) }} Tk</span>
                        @else
                            <span class="text-muted">0 Tk</span>
                        @endif
                    </td>
                    <td><span class="fw-bold text-success">{{ number_format($order->grand_total,2) }} Tk</span></td>
                    <td>
                        <span class="badge
                            @if($order->status=='ordered') bg-info
                            @elseif($order->status=='delivered') bg-success
                            @elseif($order->status=='cancelled') bg-danger
                            @else bg-secondary @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td>
                        @can('show order')
                            <a href="{{ route('product_orders.show', $order->id) }}" class="btn btn btn-info">
                            <i class="bi bi-eye"></i>
                            </a>
                        @endcan
                        @if($order->status != 'delivered')
                        @can('deliver order')
                            <!-- Deliver -->
                            <button type="button" class="btn btn-success btn-deliver" data-form="#deliverForm{{ $order->id }}">
                                <i class="bi bi-truck"></i>
                            </button>
                            <form id="deliverForm{{ $order->id }}" action="{{ route('product_orders.deliver',$order->id) }}" method="POST" class="d-none">
                                @csrf @method('PATCH')
                            </form>
                        @endcan                        
                        @endif

                        @if($order->status != 'cancelled' && $order->status != 'delivered')
                        @can('cancel order')
                            <button type="button" class="btn btn-danger btn-cancel" data-form="#cancelForm{{ $order->id }}">
                                <i class="bi bi-x-circle"></i>
                            </button>

                            <form id="cancelForm{{ $order->id }}" 
                                action="{{ route('product_orders.cancel', $order->id) }}" 
                                method="POST" class="d-none">
                                @csrf @method('PATCH')
                            </form>
                        @endcan                       
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center text-muted">No orders found</td></tr>
                @endforelse
                </tbody>
        </table>
    </div>

    {{ $orders->links() }}
</div>
@endsection
