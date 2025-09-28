@extends('layouts.app')
@section('title','Create Discount')
<x-navbar/>
@section('content')
<x-sidebar/>

<div class="container mt-4">
    <h2>Create Meal Discount</h2>
    <form action="{{ route('product-discounts.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Minimum Count *</label>
            <input type="number" name="min_count" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Maximum Count</label>
            <input type="number" name="max_count" class="form-control">
            <small class="text-muted">Leave empty for unlimited</small>
        </div>

        <div class="mb-3">
            <label class="form-label">Minimum Subtotal (e.g., 100 Tk) - optional</label>
            <input type="number" step="0.01" name="min_subtotal" class="form-control">
            <small class="text-muted">If provided, rule will apply only when order subtotal ≥ this value.</small>
        </div>

        <div class="mb-3">
            <label class="form-label">Discount Type *</label>
            <select name="discount_type" class="form-select" required>
                <option value="fixed">Fixed amount (Tk)</option>
                <option value="percent">Percentage (%)</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Discount Value *</label>
            <input type="number" step="0.01" name="discount_amount" class="form-control" required>
            <small class="text-muted">If type=fixed enter amount (e.g. 100). If percent enter 10 for 10%.</small>
        </div>

        <div class="mb-3 form-check">
            <input type="checkbox" name="active" value="1" class="form-check-input" checked>
            <label class="form-check-label">Active</label>
        </div>

        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('product-discounts.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
