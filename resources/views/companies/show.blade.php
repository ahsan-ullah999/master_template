

@extends('layouts.app')
@section('title','Company Info')
<x-navbar/>
@section('content')
<x-sidebar/>

<div class="container mt-4">

    <!-- Tabs -->
    <ul class="nav nav-tabs" id="companyTabs" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="company-tab" data-bs-toggle="tab" href="#company" role="tab">Company</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="branches-tab" data-bs-toggle="tab" href="#branches" role="tab">Branches</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="buildings-tab" data-bs-toggle="tab" href="#buildings" role="tab">Buildings</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="flats-tab" data-bs-toggle="tab" href="#flats" role="tab">Flats</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="rooms-tab" data-bs-toggle="tab" href="#rooms" role="tab">Rooms</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="seats-tab" data-bs-toggle="tab" href="#seats" role="tab">Seats</a>
        </li>
    </ul>

    <!-- Tab Contents -->
    <div class="tab-content mt-4" id="companyTabsContent">
        <!-- Company Info -->
<div class="tab-pane fade show active" id="company" role="tabpanel">
        <div class="d-flex align-items-center mb-3 p-3 bg-light rounded shadow-sm">
        <!-- Logo -->
        <div class="me-3">
            @if($company->logo)
                <img src="{{ asset('storage/'.$company->logo) }}" 
                     class="rounded-circle border shadow-sm"
                     style="width:70px; height:70px; object-fit:cover;">
            @else
                <span class="badge bg-secondary p-3">No Logo</span>
            @endif
        </div>

        <!-- Name + Status -->
        <div>
            <h3 class="fw-bold mb-1">{{ $company->name }}</h3>
            <span class="badge bg-{{ $company->status == 'active' ? 'success' : 'secondary' }}">
                {{ ucfirst($company->status) }}
            </span>
        </div>
    </div>
 
    <div class="card shadow border-0">      
        <div class="card-body">
            <div class="row">
                <!-- Left Column -->
                <div class="col-md-4">
                    <p><strong>Email:</strong> {{ $company->email }}</p>
                    <p><strong>Address:</strong> {{ $company->address }}</p>                    
                    <p><strong>Website:</strong> {{ $company->website ?? '-' }}</p>
                    <p><strong>Contact:</strong> {{ $company->contact_number ?? '-' }}</p>
                    <p><strong>Alternate Contact:</strong> {{ $company->alternate_contact_number ?? '-' }}</p>
                    <p><strong>Time Zone:</strong> {{ $company->time_zone ?? '-' }}</p>
                    <p><strong>Off Days:</strong> {{ $company->off_days ?? '-' }}</p>
                </div>

                <!-- Right Column -->
                <div class="col-md-4">
                    <p><strong>Zip Code:</strong> {{ $company->zip_code ?? '-' }}</p>
                    <p><strong>Country:</strong> {{ $company->country ?? '-' }}</p>
                    <p><strong>District:</strong> {{ $company->district ?? '-' }}</p>
                    <p><strong>Upazila:</strong> {{ $company->upazila ?? '-' }}</p>
                    <p><strong>Leave Approval:</strong> {{ $company->leave_approval_structure ?? '-' }}</p>
                    <p><strong>Attendance Approval:</strong> {{ $company->attendance_approval ?? '-' }}</p>
                    
                </div>
                <div class="col-md-4">
                    <p><strong>Landmark:</strong> {{ $company->landmark ?? '-' }}</p>
                    <p><strong>Financial Year Start:</strong> {{ $company->financial_year_start_month ?? '-' }}</p>
                    <p><strong>Currency:</strong> {{ $company->currency ?? '-' }}</p>
                    <p><strong>Currency Precision:</strong> {{ $company->currency_precision ?? '-' }}</p>
                    <p><strong>Quantity Precision:</strong> {{ $company->quantity_precision ?? '-' }}</p>
                    <p><strong>Probation Period:</strong> {{ $company->probation_period ?? '-' }}</p>
                    <p><strong>Service Age:</strong> {{ $company->service_age ?? '-' }}</p>
                </div>
                <div class="card-footer bg-transparent border-0 text-end">
                    <a href="{{ route('companies.index') }}" class="btn btn-sm btn-secondary"><i class="bi bi-arrow-counterclockwise"></i> Back to List</a>
                </div>
            </div>
        </div>                
    </div>
</div>

        <!-- Branches -->
        <div class="tab-pane fade" id="branches" role="tabpanel">
            <div class="row g-4">
                @forelse($company->branches as $branch)
                    <div class="col-md-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body row">
                                <h5 class="card-title fw-bold text-dark">
                                    <i class="bi bi-diagram-3 me-2"></i>{{ $branch->name }}
                                </h5>
                                <div class="row">
                                    <p class="card-text mb-2">
                                        <strong>Company:</strong>
                                        <span class="text-secondary">{{ $branch->company->name ?? '-' }}</span>
                                    </p>
                                    <p class="card-text mb-1">
                                    <strong>ID:</strong> {{ $branch->branch_id }}
                                    </p>
                                    <p class="card-text mb-1">
                                        <strong>Address:</strong> {{ $branch->upazila }}, {{ $branch->district }}, {{ $branch->country }}
                                    </p>
                                    <p class="card-text mb-3">
                                        <strong>Status:</strong>
                                        <span class="badge bg-{{ $branch->status == 'active' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($branch->status) }}
                                        </span>
                                    </p>
                                </div>                      
                            </div>
                            <div class="card-footer bg-transparent border-0 text-end">
                                <a href="{{ route('branches.show', $branch->id) }}" class="btn btn-sm btn-info">
                                    <i class="bi bi-eye"></i> View
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-muted">No branches available.</p>
                    </div>
                @endforelse
            </div>
        </div>

                <!-- Buildings -->
        <div class="tab-pane fade" id="buildings" role="tabpanel">
            <div class="row g-4">
                @forelse($company->branches as $branch)
                    @foreach($branch->buildings as $building)
                        <div class="col-md-4">
                            <div class="card shadow-sm h-100">
                                <div class="card-body">
                                    <!-- Title and ID in one row -->
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h5 class="card-title fw-bold text-dark mb-0">
                                            <i class="bi bi-building me-2"></i>{{ $building->name }}
                                        </h5>
                                    </div>
                                    <!-- Branch Name -->
                                    <p class="card-text mb-2">
                                        <strong>Branch:</strong>
                                        <span class="text-secondary">{{ $building->branch->name ?? '-' }}</span>
                                    </p>

                                    <!-- Address -->
                                    <p class="card-text mb-2">
                                        <strong>Address:</strong> 
                                        <span class="text-secondary">{{ $building->address ?? '-' }}</span>
                                    </p>

                                    <!-- Status -->
                                    <p class="card-text mb-3">
                                        <strong>Status:</strong>
                                        <span class="badge bg-{{ $building->status == 'active' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($building->status) }}
                                        </span>
                                    </p>
                                </div>

                                <!-- Footer -->
                                <div class="card-footer bg-transparent border-0 text-end">
                                    <a href="{{ route('buildings.index') }}" class="btn btn-sm btn-secondary"><i class="bi bi-arrow-counterclockwise"></i> Back to List</a>
                                </div>
                            </div>
                        </div>

                    @endforeach
                @empty
                    <div class="col-12"><p class="text-muted">No buildings available.</p></div>
                @endforelse
            </div>
        </div>

        <div class="tab-pane fade" id="flats" role="tabpanel">
            <div class="row g-4">
                @forelse($company->branches as $branch)
                    @foreach($branch->buildings as $building)
                        @foreach($building->floors as $floor)
                            @foreach($floor->flats as $flat)
                                <div class="col-md-4">
                                    <div class="card shadow-sm h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h5 class="card-title fw-bold text-dark mb-0">
                                                    <i class="bi bi-building me-2"></i>{{ $flat->name }}
                                                </h5>
                                            </div>
                                            
                                            <p class="card-text mb-2">
                                            <strong>Building:</strong>
                                            <span class="text-secondary">{{ $floor->building->name ?? '-' }}</span>
                                            </p>
                                            <p class="card-text mb-2">
                                            <strong>Floor:</strong>
                                            <span class="text-secondary">{{ $flat->floor->name ?? '-' }}</span>
                                            </p>
                                            <p class="card-text mb-1"><strong>Flat No:</strong> {{ $flat->flat_number ?? '-' }}</p>
                                            <p class="card-text mb-3">
                                                <strong>Status:</strong>
                                                <span class="badge bg-{{ $flat->status == 'active' ? 'success' : 'secondary' }}">
                                                    {{ ucfirst($flat->status) }}
                                                </span>
                                            </p>
                                        </div>
                                        <div class="card-footer bg-transparent border-0 text-end">
                                            <a href="{{ route('flats.index') }}" class="btn btn-sm btn-secondary"><i class="bi bi-arrow-counterclockwise"></i> Back to List</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    @endforeach
                @empty
                    <div class="col-12"><p class="text-muted">No flats available.</p></div>
                @endforelse
            </div>
        </div>


        <!-- Rooms -->
        <div class="tab-pane fade" id="rooms" role="tabpanel">
            <div class="row g-4">
                @forelse($company->branches as $branch)
                    @foreach($branch->buildings as $building)
                        @foreach($building->floors as $floor)
                            @foreach($floor->flats as $flat)
                                @foreach($flat->rooms as $room)
                                    <div class="col-md-4">
                                        <div class="card shadow-sm h-100">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <h5 class="card-title fw-bold text-dark mb-0">
                                                            Room Name :{{ $room->name }}
                                                        </h5>
                                                </div>
                                                <p class="card-text mb-2">
                                                <strong>Branch:</strong>
                                                <span class="text-secondary">{{ $building->branch->name ?? '-' }}</span>
                                                </p>
                                                <p class="card-text mb-2">
                                                <strong>Building:</strong>
                                                <span class="text-secondary">{{ $floor->building->name ?? '-' }}</span>
                                                </p>
                                                <p class="card-text mb-2">
                                                <strong>Floor:</strong>
                                                <span class="text-secondary">{{ $flat->floor->name ?? '-' }}</span>
                                                </p>
                                                <p class="card-text mb-2">
                                                    <strong>Flat:</strong>
                                                    <span class="text-secondary">{{ $room->flat->name ?? '-' }}</span>
                                                </p>
                                                <p class="card-text mb-1"><strong>Room No:</strong> {{ $room->room_number ?? '-' }}</p>
                                                <p class="card-text mb-3">
                                                    <strong>Status:</strong>
                                                    <span class="badge bg-{{ $room->status == 'active' ? 'success' : 'secondary' }}">
                                                        {{ ucfirst($room->status) }}
                                                    </span>
                                                </p>
                                            </div>
                                            <div class="card-footer bg-transparent border-0 text-end">
                                                    <a href="{{ route('rooms.index') }}" class="btn btn-sm btn-secondary"><i class="bi bi-arrow-counterclockwise"></i> Back to List</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endforeach
                        @endforeach
                    @endforeach
                @empty
                    <div class="col-12"><p class="text-muted">No rooms available.</p></div>
                @endforelse
            </div>
        </div>


        <div class="tab-pane fade" id="seats" role="tabpanel">
            <div class="row g-4">
                @forelse($company->branches as $branch)
                    @foreach($branch->buildings as $building)
                        @foreach($building->floors as $floor)
                            @foreach($floor->flats as $flat)
                                @foreach($flat->rooms as $room)
                                    @foreach($room->seats as $seat)
                                        <div class="col-md-4">
                                            <div class="card shadow-sm h-100">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <h5 class="card-title fw-bold text-dark mb-0">
                                                            Seat Number :{{ $seat->seat_number }} ({{ $seat->description ?? '-' }})
                                                        </h5>
                                                    </div>
                                                    <p class="card-text mb-2">
                                                        <strong>Branch:</strong>
                                                        <span class="text-secondary">{{ $building->branch->name ?? '-' }}</span>
                                                        </p>
                                                        <p class="card-text mb-2">
                                                        <strong>Building:</strong>
                                                        <span class="text-secondary">{{ $floor->building->name ?? '-' }}</span>
                                                        </p>
                                                        <p class="card-text mb-2">
                                                        <strong>Floor:</strong>
                                                        <span class="text-secondary">{{ $flat->floor->name ?? '-' }}</span>
                                                        </p>
                                                        <p class="card-text mb-2">
                                                            <strong>Flat:</strong>
                                                            <span class="text-secondary">{{ $room->flat->name ?? '-' }}</span>
                                                        </p>
                                                        <p class="card-text mb-2">
                                                            <strong>Room:</strong>
                                                            <span class="text-secondary">{{ $seat->room->name ?? '-' }}</span>
                                                        </p>
                                                    <p class="card-text mb-3">
                                                        <strong>Status:</strong>
                                                        <span class="badge bg-{{ $seat->status == 'active' ? 'success' : 'secondary' }}">
                                                            {{ ucfirst($seat->status) }}
                                                        </span>
                                                    </p>
                                                </div>
                                                <div class="card-footer bg-transparent border-0 text-end">
                                                    <a href="{{ route('seats.index') }}" class="btn btn-sm btn-secondary"><i class="bi bi-arrow-counterclockwise"></i> Back to List</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endforeach
                            @endforeach
                        @endforeach
                    @endforeach
                @empty
                    <div class="col-12"><p class="text-muted">No seats available.</p></div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection
