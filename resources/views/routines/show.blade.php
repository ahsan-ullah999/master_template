@extends('layouts.app')
@section('title','Routine Details')

<x-navbar/>
@section('content')
<x-sidebar/>

        <div class="container mt-4">

            <!-- Routine Card -->
            <div class="card shadow-lg border-0" style="border-radius: 15px;">
                <div class="card-body p-4">

                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <h3 class="fw-bold mb-2 text-dark">
                                <i class="bi bi-calendar-check me-2"></i> Routine — {{ $routine->slot->name ?? 'No Slot' }}
                            </h3>
                            <p class="mb-1 text-muted">
                                <i class="bi bi-calendar-week me-1 text-primary"></i>
                                <strong>Off Day:</strong> {{ $routine->dayName() }} &nbsp; | &nbsp;
                                <i class="bi bi-clock me-1 text-success"></i>
                                <strong>Date:</strong> {{ $routine->date ?? '-' }} &nbsp; | &nbsp;
                                <i class="bi bi-list-ol me-1 text-danger"></i>
                                <strong>Count:</strong> {{ $routine->product_count ?? $routine->items->count() }}
                            </p>
                            <p class="mb-0 text-muted">
                                <i class="bi bi-geo-alt me-1 text-warning"></i>
                                <strong>Location:</strong>
                                {{ $routine->company->name ?? '-' }} /
                                {{ $routine->branch->name ?? '-' }} /
                                {{ $routine->building->name ?? '-' }}
                            </p>
                        </div>

                        <!-- Actions -->
                        <div class="text-end">
                            @can('edit routine')
                                <a href="{{ route('routines.edit', $routine->id) }}" 
                                class="btn btn-sm btn-warning shadow-sm me-1">
                                    <i class="bi bi-pencil-square"></i> Edit
                                </a>
                            @endcan
                            <a href="{{ route('routines.index') }}" 
                            class="btn btn-sm btn-secondary shadow-sm">
                                <i class="bi bi-arrow-left"></i> Back
                            </a>
                        </div>
                    </div>

                    <hr class="my-3">

                    <!-- Menu Items -->
                    <h5 class="fw-bold text-dark mb-3">
                        <i class="bi bi-list-ul me-2 text-primary"></i> Menu Items
                    </h5>
                    <div class="list-group mb-4">
                        @forelse($routine->items as $it)
                            <div class="list-group-item d-flex justify-content-between align-items-center 
                                        border-0 border-bottom py-3"
                                style="background: #f8f9fa; border-radius: 10px; margin-bottom: 8px;">
                                <div>
                                    <strong class="text-dark">{{ $it->product->name ?? 'N/A' }}</strong>
                                    @if($it->is_optional)
                                        <span class="badge bg-info ms-2">Optional</span>
                                    @endif
                                    <div class="small text-muted mt-1">
                                        @if($it->alternative)
                                            <i class="bi bi-arrow-repeat me-1 text-success"></i>
                                            Alternative: {{ $it->alternative->name }}
                                        @else
                                            <i class="bi bi-x-circle me-1 text-danger"></i>
                                            No alternative
                                        @endif
                                    </div>
                                </div>
                                <div class="text-end small text-muted">
                                    <i class="bi bi-pin-angle me-1"></i> Pos: {{ $it->position }}
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-light border text-center">No items available</div>
                        @endforelse
                    </div>

                    <!-- Notes -->
                    @if($routine->notes)
                        <div class="bg-light p-3 rounded" style="border-left: 4px solid #6610f2;">
                            <h6 class="fw-bold text-dark mb-2">
                                <i class="bi bi-sticky me-1 text-purple"></i> Notes
                            </h6>
                            <p class="mb-0">{{ $routine->notes }}</p>
                        </div>
                    @endif

                </div>
            </div>
        </div>
@endsection
