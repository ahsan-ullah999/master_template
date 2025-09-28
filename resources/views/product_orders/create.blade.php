@extends('layouts.app')
@section('title','Create Order')
<x-navbar/>
@section('content')
<x-sidebar/>

<div class="container mt-4">
    <h2>Create Order</h2>

    <form method="POST" action="{{ route('product_orders.store') }}">
        @csrf

        <div class="row g-3 mb-3">
            <div class="mb-3">
                <label class="form-label">Member *</label>
                <select name="member_id" class="form-select @error('member_id') is-invalid @enderror" required>
                    <option value="">Select Member</option>
                    @foreach(\App\Models\Member::all() as $member)
                        <option value="{{ $member->id }}" {{ old('member_id')==$member->id?'selected':'' }}>
                            {{ $member->name }} ({{ $member->rental_id }})
                        </option>
                    @endforeach
                </select>
                @error('member_id') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label">Order Date</label>
                <input type="date" name="order_date" class="form-control" 
                       value="{{ old('order_date', date('Y-m-d')) }}" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Slot</label>
                <select name="slot_id" id="slotSelect" class="form-select" required>
                    <option value="">-- Select Slot --</option>
                    @foreach($slots as $slot)
                        <option value="{{ $slot->id }}"
                            data-cutoff="{{ $slot->order_cutoff_time ?? '' }}">
                            {{ $slot->name }} ({{ $slot->start_time ?? '-' }} - {{ $slot->end_time ?? '-' }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Items table -->
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Items</strong>
                <button type="button" id="addItem" class="btn btn-sm btn-success">
                    <i class="bi bi-plus-lg"></i> Add Item
                </button>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0" id="itemsTable">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th style="width:120px;">Price</th>
                                <th style="width:120px;">Qty</th>
                                <th style="width:120px;">Total</th>
                                <th style="width:70px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- one empty row by default --}}
                            <tr>
                                <td>
                                    <select name="items[0][product_id]" 
                                            class="form-select product-select" required>
                                        <option value="">-- Select Product --</option>
                                        {{-- JS fills based on slot/date --}}
                                    </select>
                                </td>
                                <td class="price-cell align-middle">0.00</td>
                                <td><input type="number" min="1" value="1" name="items[0][qty]" 
                                           class="form-control qty-input" required></td>
                                <td class="line-total align-middle">0.00</td>
                                <td class="align-middle text-end">
                                    <button type="button" class="btn btn-sm btn-danger remove-row">&times;</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer text-end">
                <div class="fw-bold">
                    Grand Total: <span id="grandTotal">0.00</span>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Place Order</button>
            <a href="{{ route('product_orders.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    const routinesData = @json($routines);

    $(function(){
        let rowIndex = 1;

        function getRoutineProducts(slotId, date) {
            if (!slotId || !routinesData[slotId]) return [];
            let routines = routinesData[slotId];
            if (routines.length === 0) return [];

            // for simplicity: use last routine for slot
            let routine = routines[routines.length-1];

            return routine.items.map(it => {
                let main = {
                    id: it.product.id,
                    name: it.product.name,
                    price: it.product.price || 0
                };
                let alt = it.alternative ? {
                    id: it.alternative.id,
                    name: it.alternative.name + " (Alt)",
                    price: it.alternative.price || 0
                } : null;
                return alt ? [main, alt] : [main];
            }).flat();
        }

        function refillSelect($select) {
            const slotId = $('#slotSelect').val();
            const orderDate = $('input[name="order_date"]').val();
            const products = getRoutineProducts(slotId, orderDate);

            $select.empty().append('<option value="">-- Select Product --</option>');
            products.forEach(p => {
                $select.append(`<option value="${p.id}" data-price="${p.price}">${p.name}</option>`);
            });
        }

        function recalcRow($row) {
            const price = parseFloat($row.find('.product-select option:selected').data('price') || 0);
            const qty = parseInt($row.find('.qty-input').val() || 0);
            const total = (price * qty) || 0;
            $row.find('.price-cell').text(price.toFixed(2));
            $row.find('.line-total').text(total.toFixed(2));
            recalcGrand();
        }

        function recalcGrand() {
            let sum = 0;
            $('#itemsTable tbody tr').each(function(){
                sum += parseFloat($(this).find('.line-total').text() || 0);
            });
            $('#grandTotal').text(sum.toFixed(2));
        }

        // when slot/date changes → refill product dropdowns
        $('#slotSelect, input[name="order_date"]').on('change', function(){
            $('#itemsTable .product-select').each(function(){
                refillSelect($(this));
            });
        });

        // product change
        $(document).on('change', '.product-select', function(){
            recalcRow($(this).closest('tr'));
        });

        // qty change
        $(document).on('input', '.qty-input', function(){
            recalcRow($(this).closest('tr'));
        });

        // add row
        $('#addItem').on('click', function(){
            let $tr = $('<tr>');
            let prodSelect = $('<select class="form-select product-select" required>')
                .attr('name', `items[${rowIndex}][product_id]`);
            $tr.append($('<td>').append(prodSelect));
            $tr.append($('<td class="price-cell align-middle">').text('0.00'));
            $tr.append($('<td>').append(`<input type="number" min="1" value="1" 
                        name="items[${rowIndex}][qty]" class="form-control qty-input" required>`));
            $tr.append($('<td class="line-total align-middle">').text('0.00'));
            $tr.append($('<td class="align-middle text-end">').append(
                '<button type="button" class="btn btn-sm btn-danger remove-row">&times;</button>'
            ));
            $('#itemsTable tbody').append($tr);

            refillSelect(prodSelect);
            rowIndex++;
        });

        // remove row
        $(document).on('click', '.remove-row', function(){
            $(this).closest('tr').remove();
            recalcGrand();
        });
    });
</script>
@endpush

@endsection
