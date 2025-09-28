@extends('layouts.app')
@section('title','Edit Slot')
<x-navbar/>
@section('content')
<x-sidebar/>
<div class="container mt-4">
    <h2>Edit Slot</h2>
    <form action="{{ route('slots.update', $slot->id) }}" method="post">
        @csrf
        @method('put')

        <div class="mb-3">
            <label class="form-label">Slot Name *</label>
            <input type="text" name="name" value="{{ old('name',$slot->name) }}" 
                   class="form-control @error('name') is-invalid @enderror" required>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Start Time</label>
                <input type="time" name="start_time" value="{{ old('start_time',$slot->start_time) }}" class="form-control">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">End Time</label>
                <input type="time" name="end_time" value="{{ old('end_time',$slot->end_time) }}" class="form-control">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Order Cutoff Time</label>
                <input type="time" name="order_cutoff_time" value="{{ old('order_cutoff_time',$slot->order_cutoff_time) }}" class="form-control">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Sort Order</label>
            <input type="number" name="sort_order" value="{{ old('sort_order',$slot->sort_order) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="active" {{ $slot->status === 'active' ? 'selected':'' }}>Active</option>
                <option value="inactive" {{ $slot->status === 'inactive' ? 'selected':'' }}>Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i> Update</button>
        <a href="{{ route('slots.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
