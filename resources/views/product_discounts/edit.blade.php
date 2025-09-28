@extends('layouts.app')
@section('title','Edit Discount')
<x-navbar/>
@section('content')
<x-sidebar/>

<div class="container mt-4">
    <h2>Edit Meal Discount</h2>

    <form action="{{ route('product-discounts.update', $productDiscount->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Minimum Count *</label>
            <input type="number" name="min_count" class="form-control" 
                   value="{{ old('min_count', $productDiscount->min_count) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Maximum Count</label>
            <input type="number" name="max_count" class="form-control" 
                   value="{{ old('max_count', $productDiscount->max_count) }}">
            <small class="text-muted">Leave empty for unlimited</small>
        </div>

        <div class="mb-3">
            <label class="form-label">Minimum Subtotal (Tk)</label>
            <input type="number" step="0.01" name="min_subtotal" class="form-control"
                   value="{{ old('min_subtotal', $productDiscount->min_subtotal) }}">
            <small class="text-muted">Order subtotal must be at least this value for discount to apply (optional)</small>
        </div>

        <div class="mb-3">
            <label class="form-label">Discount Type *</label>
            <select name="discount_type" class="form-select" required>
                <option value="fixed" {{ old('discount_type', $productDiscount->discount_type) == 'fixed' ? 'selected' : '' }}>
                    Fixed amount (Tk)
                </option>
                <option value="percent" {{ old('discount_type', $productDiscount->discount_type) == 'percent' ? 'selected' : '' }}>
                    Percentage (%)
                </option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Discount Value *</label>
            <input type="number" step="0.01" name="discount_amount" class="form-control" 
                   value="{{ old('discount_amount', $productDiscount->discount_amount) }}" required>
            <small class="text-muted">If type=fixed enter amount (e.g. 100). If percent enter 10 for 10%.</small>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="active" value="1" class="form-check-input" 
                   {{ old('active', $productDiscount->active) ? 'checked' : '' }}>
            <label class="form-check-label">Active</label>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('product-discounts.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
