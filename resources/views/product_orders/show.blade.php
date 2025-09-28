@extends('layouts.app')
@section('title', 'Order Details')
<x-navbar/>
@section('content')
<x-sidebar/>

            <div class="container py-4">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-5">

                    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                <h2 class="fw-bold mb-0 text-dark">Order No.{{ $order->id }}</h2>

                <span class="badge rounded-pill px-3 py-2 fs-6
                    @if($order->status == 'delivered') bg-success text-white
                    @elseif($order->status == 'cancelled') bg-danger text-white
                    @else bg-info text-dark
                    @endif">
                    {{ ucfirst($order->status) }}
                </span>
            </div>

            <div class="row mb-4 gx-5">
                <div class="col-md-4">
                    <p class="mb-1"><strong class="text-muted">Member:</strong></p>
                    <p class="fw-bold">{{ $order->member->name ?? '-' }}</p>
                </div>
                <div class="col-md-4">
                    <p class="mb-1"><strong class="text-muted">Order Date:</strong></p>
                    <p class="fw-bold">{{ \Carbon\Carbon::parse($order->order_date)->format('d M, Y') }}</p>
                </div>
                <div class="col-md-4">
                    <p class="mb-1"><strong class="text-muted">Slot:</strong></p>
                    <p class="fw-bold">{{ $order->slot->name ?? '-' }}</p>
                </div>
            </div>

            <hr class="my-4">

            <h5 class="fw-bold mb-3 text-secondary">Ordered Items</h5>
            <div class="table-responsive">
                <table class="table table-hover table-borderless table-sm">
                    <thead class="bg-light">
                        <tr>
                            <th scope="col">Product</th>
                            <th scope="col" class="text-end">Price</th>
                            <th scope="col" class="text-end">Qty</th>
                            <th scope="col" class="text-end">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $it)
                        <tr>
                            <td>{{ $it->product->name ?? 'N/A' }}</td>
                            <td class="text-end">{{ number_format($it->price,2) }} Tk</td>
                            <td class="text-end">{{ $it->qty }}</td>
                            <td class="text-end">{{ number_format($it->total,2) }} Tk</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="border-top">
                        <tr class="text-end fw-semibold">
                            <td colspan="3">Subtotal</td>
                            <td>{{ number_format($order->total,2) }} Tk</td>
                        </tr>
                        @if($order->discount_amount > 0)
                        <tr class="text-end text-success fw-semibold">                      
                            <td colspan="3">
                                Discount
                                @if($discountRule && $discountRule->discount_type === 'percent')
                                    {{ number_format($discountRule->discount_amount, 2) }}%
                                @else
                                    {{ number_format($discountRule->discount_amount, 2) }} Tk
                                @endif
                            </td>                                                
                            <td>- {{ number_format($order->discount_amount,2) }} Tk</td>
                        </tr>
                        @endif
                        <tr class="text-end fw-bold text-primary fs-5" style="background-color: #f0f8ff;">
                            <td colspan="3">Grand Total</td>
                            <td>{{ number_format($order->grand_total,2) }} Tk</td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="mt-4 d-flex justify-content-between align-items-center">
                <a href="{{ route('product_orders.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to list
                </a>
                <div class="d-flex gap-2">
                    @if($order->status == 'ordered')
                    <form id="deliverForm{{ $order->id }}" action="{{ route('product_orders.deliver', $order->id) }}" method="POST" class="d-inline">
                        @csrf @method('PATCH')
                        <button type="button" class="btn btn-success btn-deliver" data-form="#deliverForm{{ $order->id }}">
                            <i class="bi bi-truck"></i> Mark Delivered
                        </button>
                    </form>
                    <form id="cancelForm{{ $order->id }}"  action="{{ route('product_orders.cancel', $order->id) }}" method="POST" class="d-inline">
                        @csrf @method('PATCH')
                        <button type="button" class="btn btn-danger btn-cancel" data-form="#cancelForm{{ $order->id }}">
                            <i class="bi bi-x-circle"></i> Cancel
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Simple JavaScript to add a hover effect for visual flair
    document.addEventListener('DOMContentLoaded', function() {
        const grandTotalRow = document.querySelector('.fs-5');
        if (grandTotalRow) {
            grandTotalRow.style.transition = 'transform 0.2s ease-in-out';
            grandTotalRow.onmouseover = function() {
                this.style.transform = 'scale(1.01)';
            };
            grandTotalRow.onmouseout = function() {
                this.style.transform = 'scale(1)';
            };
        }
    });
</script>
@endpush