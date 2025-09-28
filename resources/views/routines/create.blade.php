@extends('layouts.app')
@section('title','Create Routine')
<x-navbar/>
@section('content')
<x-sidebar/>

<div class="container mt-4">
    <h2>Create Routine</h2>

    <form action="{{ route('routines.store') }}" method="POST">
        @csrf

        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label">Slot *</label>
                <select name="slot_id" class="form-select" required>
                    <option value="">Select slot</option>
                    @foreach($slots as $slot)
                    <option value="{{ $slot->id }}" @selected(old('slot_id') == $slot->id)>{{ $slot->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Day of Week (optional)</label>
                <select name="day_of_week" class="form-select">
                    <option value="">-- Optional --</option>
                    @foreach(['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'] as $i=>$day)
                    <option value="{{ $i }}" @selected(old('day_of_week') == $i)>{{ $day }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Date (special day)</label>
                <input type="date" name="date" value="{{ old('date') }}" class="form-control">
            </div>
        </div>

        <hr>

        <h5>Location / Scope (optional)</h5>
        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <label class="form-label">Company</label>
                <select name="company_id" class="form-select">
                    <option value="">-- Any --</option>
                    @foreach($companies as $c)
                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Branch</label>
                <select name="branch_id" class="form-select">
                    <option value="">-- Any --</option>
                    @foreach($branches as $b)
                    <option value="{{ $b->id }}">{{ $b->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Building</label>
                <select name="building_id" class="form-select">
                    <option value="">-- Any --</option>
                    @foreach($buildings as $bd)
                    <option value="{{ $bd->id }}">{{ $bd->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <hr>

        <h5>Routine Items</h5>
        <div id="routineItems">
            <div class="row mb-2 routine-item">
                <div class="col-md-5">
                    <select name="items[0][product_id]" class="form-select" required>
                        <option value="">Select product</option>
                        @foreach($products as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-5">
                    <select name="items[0][alternative_product_id]" class="form-select">
                        <option value="">-- Alternative (optional) --</option>
                        @foreach($products as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-1">
                    <input type="hidden" name="items[0][is_optional]" value="0">
                    <div class="form-check mt-2">
                        <input class="form-check-input" type="checkbox" name="items[0][is_optional]" value="1" id="opt0">
                        <label class="form-check-label small" for="opt0">Optional</label>
                    </div>
                </div>
                <div class="col-md-1 text-end">
                    <button type="button" class="btn btn-sm btn-danger remove-item">&times;</button>
                </div>
            </div>
        </div>

        <button type="button" id="addItem" class="btn btn-sm btn-secondary mb-3">
            <i class="bi bi-plus-lg"></i> Add Item
        </button>

        <div class="mb-3">
            <label class="form-label">Product Count (optional)</label>
            <input type="number" name="product_count" class="form-control" value="{{ old('product_count') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Notes</label>
            <textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea>
        </div>

        <button class="btn btn-primary">Save Routine</button>
        <a href="{{ route('routines.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

@push('scripts')
<script>
    (function(){
        const products = {!! json_encode($products->map(fn($p)=>['id'=>$p->id,'name'=>$p->name])) !!};
        let idx = 1;

        $('#addItem').click(function(){
            let options = '<option value="">Select product</option>';
            products.forEach(p => options += `<option value="${p.id}">${p.name}</option>`);

            let altOptions = '<option value="">-- Alternative (optional) --</option>' + options;
            let html = `
                <div class="row mb-2 routine-item">
                    <div class="col-md-5">
                        <select name="items[${idx}][product_id]" class="form-select" required>
                            ${options}
                        </select>
                    </div>
                    <div class="col-md-5">
                        <select name="items[${idx}][alternative_product_id]" class="form-select">
                            ${altOptions}
                        </select>
                    </div>
                    <div class="col-md-1">
                        <input type="hidden" name="items[${idx}][is_optional]" value="0">
                        <div class="form-check mt-2">
                            <input class="form-check-input" type="checkbox" name="items[${idx}][is_optional]" value="1" id="opt${idx}">
                            <label class="form-check-label small" for="opt${idx}">Optional</label>
                        </div>
                    </div>
                    <div class="col-md-1 text-end">
                        <button type="button" class="btn btn-sm btn-danger remove-item">&times;</button>
                    </div>
                </div>`;
            $('#routineItems').append(html);
            idx++;
        });

        $(document).on('click', '.remove-item', function(){
            $(this).closest('.routine-item').remove();
        });
    })();
</script>
@endpush

@endsection
