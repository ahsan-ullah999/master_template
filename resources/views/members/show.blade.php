@extends('layouts.app')
@section('title','Member Details')
<x-navbar/>
@section('content')
<x-sidebar/>

<div class="container mt-4">
    <div class="card shadow-lg border-0 p-4" style="border-radius: 18px;">

        <!-- Header -->
        <h4 class="fw-bold text-secondary mb-4">
            <i class="bi bi-person-lines-fill me-2 text-primary"></i> Member Information
        </h4>

        <div class="row g-2">
            <!-- Profile Photo -->
            <div class="col-md-3 text-center">
                @if($member->photo)
                    <img alt="Member Photo" 
                         src="{{ asset('storage/'.$member->photo) }}" 
                         class="img-thumbnail shadow-sm border rounded"
                         style="width:130px; height:160px; object-fit: cover; border-radius: 8px;">
                @else
                    <img alt="Default Avatar" 
                         src="https://bootdey.com/img/Content/avatar/avatar7.png" 
                         class="img-thumbnail shadow-sm border rounded"
                         style="width:130px; height:160px; object-fit: cover;">
                @endif
            </div>

            <!-- Left Half: Personal Info -->
            <div class="col-md-4">
                <table class="table table-borderless table-sm align-middle">
                    <tbody>
                        <tr>
                            <td class="fw-semibold text-muted"><i class="bi bi-person-badge text-primary me-2"></i> Name</td>
                            <td class="text-dark">{{ $member->name ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold text-muted"><i class="bi bi-upc-scan text-primary me-2"></i> Rental ID</td>
                            <td class="text-dark">{{ $member->rental_id ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold text-muted"><i class="bi bi-envelope text-primary me-2"></i> Email</td>
                            <td class="text-dark">{{ $member->email ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold text-muted"><i class="bi bi-telephone text-primary me-2"></i> Phone</td>
                            <td class="text-dark">{{ $member->phone ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold text-muted"><i class="bi bi-calendar text-primary me-2"></i> Date of Birth</td>
                            <td class="text-dark">{{ \Carbon\Carbon::parse($member->date_of_birth)->format('d M, Y') ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold text-muted"><i class="bi bi-droplet text-danger me-2"></i> Blood Group</td>
                            <td class="text-dark">{{ $member->blood_group ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td class="fw-semibold text-muted"><i class="bi bi-credit-card text-primary me-2"></i> National ID</td>
                            <td class="text-dark">{{ $member->national_id ?? '-' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            
            <!-- Right Half: Accounts Info -->
            <div class="col-md-5">
                <div class="card shadow-lg border-0" 
                    style="border-radius: 15px; overflow: hidden; background-color: #f8f9fa;">
                    
                    <!-- Card Header -->
                    <div class="card-header text-white fw-bold d-flex justify-content-between align-items-center"
                        style="background: linear-gradient(135deg, #007bff, #6610f2); font-size: 1.05rem; border: none;">
                        <div><i class="bi bi-wallet2 me-2"></i> Accounts Summary</div>

                        <a href="{{ route('members.account', $member->id) }}" 
                            class="btn btn-light btn-sm fw-semibold" 
                            style="border-radius: 20px; padding: 2px 12px;">
                            <i class="bi bi-eye"></i> View Details
                        </a>
                    </div>
                    
                    <!-- Card Body -->
                    <div class="card-body" style="padding: 1rem 1.2rem;">
                        <table class="table table-borderless table-sm mb-0">
                            <tbody>
                                
                                <tr>
                                    <td class="fw-semibold text-muted">
                                        <i class="bi bi-egg-fried text-warning me-2"></i> Total Meal
                                    </td>
                                    <td class="text-end text-dark fw-bold">
                                        {{ $orderCount }}
                                    </td>

                                </tr>
                                <tr>
                                    <td class="fw-semibold text-muted">
                                        <i class="bi bi-cash-stack text-success me-2"></i> Balance
                                    </td>
                                    <td class="text-dark text-end fw-semibold">
                                        ৳ {{ number_format($balance, 2) }}
                                    </td>
                                </tr>

                                <tr>
                                    <td class="fw-semibold text-muted">
                                        <i class="bi bi-cart-check text-success me-2"></i> Last Payment
                                    </td>
                                    <td class="text-dark text-end">
                                        {{ $member->last_payment_date ?? '-' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td class="fw-semibold text-muted">
                                        <i class="bi bi-receipt-cutoff text-primary me-2"></i> Payment Method
                                    </td>
                                    <td class="text-dark text-end">
                                        {{ $member->payment_method ?? 'Not specified' }}
                                    </td>
                                </tr>

                                <tr>
                                    <td class="fw-semibold text-muted">
                                        <i class="bi bi-calendar-check text-primary me-2"></i> Effective Date
                                    </td>
                                    <td class="text-dark text-end">
                                        {{ \Carbon\Carbon::parse($member->effective_date)->format('d M, Y') ?? '-' }}
                                    </td>
                                </tr>

                                <!-- New Row: Total Due -->
                                <tr style="border-top: 1px solid #dee2e6;">
                                    <td class="fw-semibold text-danger pt-3">
                                        <i class="bi bi-exclamation-octagon text-danger me-2"></i> Total Due
                                    </td>
                                    <td class="text-end text-danger fw-bold pt-3">
                                        ৳ {{ number_format($totalDue, 2) }}
                                    </td>
                                </tr>

                                
                            </tbody>
                        </table>
                    </div>

                    <!-- Card Footer -->
                    <div class="card-footer bg-light text-center py-2" 
                        style="font-size: 0.9rem; color: #6c757d; border-top: 1px solid #e9ecef;">
                        Updated on: {{ now()->setTimezone('Asia/Dhaka')->format('d M Y, h:i A') }}
                    </div>
                </div>
            </div>

        </div>

        <hr class="my-4">

        <!-- Bottom Table: Other Details -->
        <div class="table-responsive">
            <table class="table table-sm table-borderless">
                <tbody>
                    <tr>
                        <td class="fw-semibold text-muted"><i class="bi bi-building text-primary me-2"></i> Location</td>
                        <td class="text-dark">
                            <b>Company:</b> {{ $member->company->name ?? '-' }} |
                            <b>Branch:</b> {{ $member->branch->name ?? '-' }} |
                            <b>Building:</b> {{ $member->building->name ?? '-' }} <br>
                            <b>Floor:</b> {{ $member->floor->name ?? '-' }} |
                            <b>Flat:</b> {{ $member->flat->name ?? '-' }} |
                            <b>Room:</b> {{ $member->room->name ?? '-' }} |
                            <b>Seat:</b> {{ $member->seats->pluck('seat_number')->join(', ') ?: '-' }}
                            ({{ $member->seats->pluck('description')->join(', ') ?: '-' }})
                        </td>
                    </tr>
                    <tr>
                        <td class="fw-semibold text-muted"><i class="bi bi-house-door text-primary me-2"></i> Address</td>
                        <td class="text-dark">{{ $member->permanent_address ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold text-muted"><i class="bi bi-person text-primary me-2"></i> Father's Name</td>
                        <td class="text-dark">{{ $member->father_name ?? '-' }} ({{ $member->father_contact ?? '-' }})</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold text-muted"><i class="bi bi-person text-primary me-2"></i> Mother's Name</td>
                        <td class="text-dark">{{ $member->mother_name ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold text-muted"><i class="bi bi-people text-primary me-2"></i> Local Guardian</td>
                        <td class="text-dark">{{ $member->local_guardian_name ?? '-' }} ({{ $member->local_guardian_relation ?? '-' }}) - {{ $member->local_guardian_contact ?? '-' }}</td>
                    </tr>
                     <tr>
                        <td class="fw-semibold text-muted"><i class="bi bi-calendar-event text-primary me-2"></i> Joined</td>
                        <td class="text-dark">{{ \Carbon\Carbon::parse($member->admission_date)->format('d M, Y') ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td class="fw-semibold text-muted"><i class="bi bi-activity text-danger me-2"></i> Status</td>
                        <td>
                            <span class="badge bg-{{ $member->status == 'active' ? 'success' : 'secondary' }}">
                                {{ ucfirst($member->status) }}
                            </span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Action Buttons -->
        <div class="mt-4 d-flex justify-content-between">
            <a href="{{ route('members.index') }}" class="btn btn-secondary shadow-sm rounded-pill px-4">
                <i class="bi bi-arrow-left"></i> Back
            </a>
            <a href="{{ route('members.edit', $member->id) }}" class="btn btn-primary shadow-sm rounded-pill px-4">
                <i class="bi bi-pencil-square"></i> Edit
            </a>
        </div>

    </div>
</div>
@endsection
