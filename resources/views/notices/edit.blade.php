@extends('layouts.app')
@section('title','Edit Notice')
<x-navbar/>
@section('content')
<x-sidebar/>

<div class="container mt-4">
    <div class="card shadow rounded-4">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0">Edit Notice</h4>
                <a href="{{ route('notices.index') }}" class="btn btn-secondary btn-sm px-3" style="border-radius: 20px;">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>

            <form action="{{ route('notices.update', $notice->id) }}" method="POST">
                @csrf @method('PUT')

                @include('notices.partials.scope-select')

                <div class="mb-3">
                    <label class="form-label">Title *</label>
                    <input type="text" name="title" class="form-control" value="{{ $notice->title }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Details</label>
                    <textarea name="details" class="form-control" rows="4">{{ $notice->details }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Priority *</label>
                    <select name="priority" class="form-select" required>
                        <option value="normal" {{ $notice->priority=='normal'?'selected':'' }}>Normal</option>
                        <option value="high" {{ $notice->priority=='high'?'selected':'' }}>High</option>
                        <option value="urgent" {{ $notice->priority=='urgent'?'selected':'' }}>Urgent</option>
                    </select>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-4">Update Notice</button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('notices.partials.dependent-script')
@endsection
