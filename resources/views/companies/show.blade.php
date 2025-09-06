@extends('layouts.app')
@section('title','Company Info')
<x-navbar/>
@section('content')
<x-sidebar/>

<div class="container mt-4">
    <div class="card shadow-lg border-0">
        <div class="card-body bg-white">
            <div class="row align-items-center mb-4">
                <h5 class="text-secoundary">Company info :-</h5>
                <div class="col-12 d-flex align-items-center gap-5">
                    <div>
                        <h2 class="fw-bold">{{ $company->name }}</h2>
                    {{-- Show branches if available --}}
                    
                    @if($company->branches->count() > 0)
                        <p class="fw-semibold">
                            Branches:
                            @foreach($company->branches as $branch)
                                <a href="{{ route('branches.show', $branch->id) }}" class="text-decoration-none">
                                    {{ $branch->name }}
                                </a>@if(!$loop->last), @endif
                            @endforeach
                        </p>
                    @else
                        <p class="text-muted">No branches available</p>
                    @endif

                    

                        {{-- <h6>Branch : {{ $company->branch }}</h6> --}}
                    </div>


                    @if($company->logo)
                        <img src="{{ asset('storage/'.$company->logo) }}" 
                             class="img-thumbnail shadow-sm" 
                             style="max-height:120px; max-width:120px;">
                    @else
                        <span class="badge bg-secondary">No Logo</span>
                    @endif
                </div>


            </div>

            <!-- Cards Grid -->
            <div class="row g-3">
                <!-- Card 1 -->
                <div class="col-md-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body bg-light rounded">
                            <h6 class="fw-bold">General Info :</h6>
                            <p><strong>Email:</strong> {{ $company->email }}</p>
                            <p><strong>Address:</strong> {{ $company->address }}</p>
                            <p><strong>Business Code:</strong> {{ $company->code ?? '-' }}</p>
                            <p><strong>Start Date:</strong> {{ $company->start_date }}</p>
                            <p><strong>Status:</strong> 
                                <span class="badge bg-{{ $company->status == 'active' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($company->status) }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body bg-light rounded">
                            <h6 class="fw-bold">Contacts :</h6>
                            <p><strong>Contact:</strong> {{ $company->contact_number ?? '-' }}</p>
                            <p><strong>Alternate Contact:</strong> {{ $company->alternate_contact_number ?? '-' }}</p>
                            <p><strong>Website:</strong> {{ $company->website ?? '-' }}</p>
                            <p><strong>Zip Code:</strong> {{ $company->zip_code ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body bg-light rounded">
                            <h6 class="fw-bold">Location :</h6>
                            <p><strong>Country:</strong> {{ $company->country ?? '-' }}</p>
                            <p><strong>District:</strong> {{ $company->district ?? '-' }}</p>
                            <p><strong>Upazila:</strong> {{ $company->upazila ?? '-' }}</p>
                            <p><strong>Landmark:</strong> {{ $company->landmark ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body bg-light rounded">
                            <h6 class="fw-bold">Finance :</h6>
                            <p><strong>Financial Year Start:</strong> {{ $company->financial_year_start_month ?? '-' }}</p>
                            <p><strong>Currency:</strong> {{ $company->currency ?? '-' }}</p>
                            <p><strong>Currency Precision:</strong> {{ $company->currency_precision ?? '-' }}</p>
                            <p><strong>Quantity Precision:</strong> {{ $company->quantity_precision ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Card 5 -->
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body bg-light rounded">
                            <h6 class="fw-bold">Work & Attendance :</h6>
                            <p><strong>Time Zone:</strong> {{ $company->time_zone ?? '-' }}</p>
                            <p><strong>Off Days:</strong> {{ $company->off_days ?? '-' }}</p>
                            <p><strong>Leave Approval:</strong> {{ $company->leave_approval_structure ?? '-' }}</p>
                            <p><strong>Attendance Approval:</strong> {{ $company->attendance_approval ?? '-' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Card 6 -->
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body bg-light rounded">
                            <h6 class="fw-bold">Employee Info :</h6>
                            <p><strong>Probation Period:</strong> {{ $company->probation_period ?? '-' }}</p>
                            <p><strong>Service Age:</strong> {{ $company->service_age ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="mt-4 d-flex justify-content-between">
                <a href="{{ route('companies.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to List
                </a>
                @can('edit company')
                <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-warning">
                    <i class="bi bi-pencil-square"></i> Edit
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
