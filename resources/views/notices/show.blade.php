@extends('layouts.app')
@section('title','Notice Details')
<x-navbar/>
@section('content')
<x-sidebar/>

<div class="container mt-4">
    <div class="card shadow-lg border-0 rounded-4" 
         style="background: linear-gradient(135deg, #c1c7cc, #d8d7d7); border-radius: 20px;">

        {{-- 🔹 Header --}}
        <div class="card-header bg-primary text-white rounded-top-4"
             style="padding: 1rem 1.5rem; background: linear-gradient(135deg, #007bff, #6610f2);">
            <h4 class="fw-bold mb-0">
                <i class="bi bi-megaphone-fill me-2"></i> {{ $notice->title }}
            </h4>
        </div>

        {{-- 🔹 Body --}}
        <div class="card-body p-4">

            {{-- 🔸 Notice Details (Rich Text View Style) --}}
            <div class="card mb-4 border-0 shadow-sm" 
                 style="background: #f8f9fa; border-radius: 10px;">
                <div class="card-header bg-light border-0 fw-semibold">
                    <i class="bi bi-file-earmark-text me-1 text-primary"></i> Details
                </div>
                <div class="card-body">
                    <div id="notice-details-view" 
                         style="background: #ffffff; min-height: 160px; padding: 1rem; border-radius: 10px; 
                                border: 1px solid #dee2e6; box-shadow: inset 0 1px 2px rgba(0,0,0,0.05); 
                                font-size: 1rem; line-height: 1.6; color: #212529;">
                        {!! nl2br(e($notice->details)) ?: '<span class="text-muted fst-italic">No details provided.</span>' !!}
                    </div>
                </div>
            </div>

            <hr style="border-top: 2px dashed #dee2e6;">

            {{-- 🔹 Notice Info Section --}}
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="p-3 shadow-sm rounded-4 text-center" 
                         style="background: linear-gradient(135deg, #e3f2fd, #bbdefb);">
                        <i class="bi bi-flag-fill text-primary" style="font-size: 1.8rem;"></i>
                        <h6 class="mt-2 text-muted mb-1">Priority</h6>
                        <span class="badge px-3 py-2 rounded-pill 
                            bg-{{ $notice->priority == 'high' ? 'danger' : ($notice->priority == 'urgent' ? 'warning text-dark' : 'secondary') }}">
                            {{ ucfirst($notice->priority) }}
                        </span>
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="p-3 shadow-sm rounded-4"
                         style="background: linear-gradient(135deg, #f3e5f5, #ede7f6);">
                        <h6 class="fw-semibold text-dark mb-2">
                            <i class="bi bi-geo-alt-fill text-purple me-1"></i> Scope
                        </h6>
                        <div class="d-flex flex-wrap align-items-center gap-2" style="font-size: 0.95rem;">
                            @if($notice->company)
                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">
                                    <i class="bi bi-building me-1"></i>Company: {{ $notice->company->name }}
                                </span>
                            @endif
                            @if($notice->branch)
                                <i class="bi bi-chevron-right text-muted"></i>
                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">
                                    <i class="bi bi-diagram-3 me-1"></i>Branch: {{ $notice->branch->name }}
                                </span>
                            @endif
                            @if($notice->building)
                                <i class="bi bi-chevron-right text-muted"></i>
                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">
                                    <i class="bi bi-house-door me-1"></i>Building: {{ $notice->building->name }}
                                </span>
                            @endif
                            @if($notice->floor)
                                <i class="bi bi-chevron-right text-muted"></i>
                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">
                                    <i class="bi bi-layers-half me-1"></i>Floor: {{ $notice->floor->name }}
                                </span>
                            @endif
                            @if($notice->flat)
                                <i class="bi bi-chevron-right text-muted"></i>
                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">
                                    <i class="bi bi-door-open me-1"></i>Flat: {{ $notice->flat->name }}
                                </span>
                            @endif
                            @if($notice->room)
                                <i class="bi bi-chevron-right text-muted"></i>
                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle">
                                    <i class="bi bi-door-closed me-1"></i>Room: {{ $notice->room->name }}
                                </span>
                            @endif
                            @if(!$notice->company)
                                <span class="text-muted"><i class="bi bi-globe me-1"></i> All</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            {{-- 🔹 Created Date --}}
            <div class="mt-4 text-muted">
                <i class="bi bi-calendar3 text-primary me-1"></i>
                <strong>Created:</strong> {{ $notice->created_at->format('d M, Y') }}
            </div>

            {{-- 🔹 Action Buttons --}}
            <div class="mt-4 d-flex justify-content-between">
                <a href="{{ route('notices.index') }}" class="btn btn-secondary px-4 py-2 shadow-sm">
                    <i class="bi bi-arrow-left me-1"></i> Back
                </a>
                <a href="{{ route('notices.edit',$notice->id) }}" 
                   class="btn btn-primary px-4 py-2 rounded-pill shadow-sm">
                    <i class="bi bi-pencil-square me-1"></i> Edit
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
