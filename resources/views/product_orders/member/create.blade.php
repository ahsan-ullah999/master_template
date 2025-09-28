@extends('layouts.app')
@section('title','Place Meal Order')
<x-navbar/>
@section('content')
<x-sidebar/>

        <div class="container mt-3">
            <h2>Place Meal Order</h2>

            <form action="{{ route('member_orders.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Order Date *</label>
                        <input type="date" name="order_date" value="{{ old('order_date',date('Y-m-d')) }}" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Slot *</label>
                        <select name="slot_id" class="form-select" required>
                            <option value="">Select Slot</option>
                            @foreach($slots as $slot)
                                <option value="{{ $slot->id }}">{{ $slot->name }} ({{ $slot->start_time }} - {{ $slot->end_time }})</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <h5 class="mt-4">Order Items</h5>
                <div id="orderItems">
                    <div class="row mb-2 order-item">
                        <div class="col-md-6">
                            <select name="items[0][product_id]" class="form-select" required>
                                <option value="">Select Meal</option>
                                @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->price ?? 0 }} Tk)</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="number" name="items[0][qty]" class="form-control" placeholder="Qty" min="1" value="1" required>
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger remove-item w-100"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                </div>

                <button type="button" id="addItem" class="btn btn-sm btn-secondary mb-3">
                    <i class="bi bi-plus-lg"></i> Add Item
                </button>

                <div class="mt-3">
                    <button type="submit" class="btn btn-success"><i class="bi bi-check-circle"></i> Place Order</button>
                    <a href="{{ route('member_orders.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>

    @push('scripts')
    <script>
    $(function(){
        let index = 1;
        $('#addItem').click(function(){
            let html = `
            <div class="row mb-2 order-item">
                <div class="col-md-6">
                    <select name="items[${index}][product_id]" class="form-select" required>
                        <option value="">Select Meal</option>
                        @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->price ?? 0 }} Tk)</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="number" name="items[${index}][qty]" class="form-control" min="1" value="1" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-item w-100"><i class="bi bi-trash"></i></button>
                </div>
            </div>`;
            $('#orderItems').append(html);
            index++;
        });

        $(document).on('click','.remove-item',function(){
            $(this).closest('.order-item').remove();
        });
    });
    </script>
    @endpush
@endsection
