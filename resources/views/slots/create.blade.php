@extends('layouts.app')
@section('title','Create Slot')
<x-navbar/>
@section('content')
<x-sidebar/>
<div class="container mt-4">
    <h2>Add Slot</h2>
    <form action="{{ route('slots.store') }}" method="post">
        @csrf
        <div class="mb-3">
            <label class="form-label">Slot Name *</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Start Time</label>
                <input type="time" name="start_time" class="form-control">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">End Time</label>
                <input type="time" name="end_time" class="form-control">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Order Cutoff Time</label>
                <input type="time" name="order_cutoff_time" class="form-control">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Sort Order</label>
            <input type="number" name="sort_order" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success"><i class="bi bi-check-circle"></i> Save</button>
        <a href="{{ route('slots.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
