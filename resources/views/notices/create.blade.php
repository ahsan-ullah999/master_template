@extends('layouts.app')
@section('title','Create Notice')
<x-navbar/>
@section('content')
<x-sidebar/>

<div class="container mt-4">
    <div class="card shadow rounded-4">
        <div class="card-body position-relative">

            {{-- 🔹 Header --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0">Create Notice</h4>
                <a href="{{ route('notices.index')}}" class="btn btn-secondary btn-sm px-3" style="border-radius: 20px;">
                    <i class="bi bi-arrow-left"></i> Back
                </a>
            </div>

            {{-- 🔹 Form --}}
            <form action="{{ route('notices.store') }}" method="POST">
                @csrf

                @include('notices.partials.scope-select')

                <div class="mb-3">
                    <label class="form-label">Title *</label>
                    <input type="text" name="title" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Details</label>
                    <textarea name="details" class="form-control" rows="4"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Priority *</label>
                    <select name="priority" class="form-select" required>
                        <option value="normal">Normal</option>
                        <option value="high">High</option>
                        <option value="urgent">Urgent</option>
                    </select>
                </div>

                <div class="text-end mt-4">
                    <button type="submit" class="btn btn-primary px-4 shadow-sm" style="border-radius: 20px;">
                        <i class="bi bi-save"></i> Save Notice
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@include('notices.partials.dependent-script')
@endsection
