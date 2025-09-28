@extends('layouts.app')
@section('title','Routine Details')
<x-navbar/>
@section('content')
<x-sidebar/>

<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h4 class="mb-1">Routine — {{ $routine->slot->name ?? 'No Slot' }}</h4>
                    <p class="mb-0 text-muted">
                        <strong>Day:</strong> {{ $routine->dayName() }} |
                        <strong>Date:</strong> {{ $routine->date ?? '-' }} |
                        <strong>Count:</strong> {{ $routine->product_count ?? $routine->items->count() }}
                    </p>
                    <p class="mb-0 text-muted">
                        <strong>Location:</strong>
                        {{ $routine->company->name ?? '-' }} /
                        {{ $routine->branch->name ?? '-' }} /
                        {{ $routine->building->name ?? '-' }}
                    </p>
                </div>

                <div class="text-end">
                    @can('edit routine')
                        <a href="{{ route('routines.edit', $routine->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    @endcan
                    <a href="{{ route('routines.index') }}" class="btn btn-sm btn-secondary">Back</a>
                </div>
            </div>

            <hr>

            <h5>Menu Items</h5>
            <div class="list-group mb-3">
                @foreach($routine->items as $it)
                <div class="list-group-item d-flex justify-content-between align-items-center">
                    <div>
                        <strong>{{ $it->product->name ?? 'N/A' }}</strong>
                        @if($it->is_optional)
                            <span class="badge bg-info ms-2">Optional</span>
                        @endif
                        <div class="small text-muted">
                            @if($it->alternative)
                                Alternative: {{ $it->alternative->name }}
                            @else
                                No alternative
                            @endif
                        </div>
                    </div>
                    <div class="text-end small text-muted">
                        Pos: {{ $it->position }}
                    </div>
                </div>
                @endforeach
            </div>

            @if($routine->notes)
            <h6>Notes</h6>
            <p>{{ $routine->notes }}</p>
            @endif
        </div>
    </div>
</div>
@endsection
