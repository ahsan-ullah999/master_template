@extends('layouts.app')
@section('title','Member Details')
<x-navbar/>
@section('content')
<x-sidebar/>
<div class="container bootstrap snippets bootdey mt-4">
    <div class="panel-body inf-content card shadow-lg p-4">

<strong class="fs-5 text-secondary">Member Information</strong>
        <div class="row">
            <!-- Left: Photo -->
            <div class="col-md-3 text-center mt-4">
                @if($member->photo)
                    <img alt="Member Photo" class="img-circle img-thumbnail shadow-sm" 
                         src="{{ asset('storage/'.$member->photo) }}" style="width:130px; height:150px; object-fit;">
                @else
                    <img alt="Default Avatar" class="img-circle img-thumbnail shadow-sm" 
                         src="https://bootdey.com/img/Content/avatar/avatar7.png" style="width:140px;">
                @endif                
            </div>
                <div class="table-responsive mt-2 col-8">
                    <table class="table table-user-information">
                        <tbody>
                            <tr>
                                <td><i class="bi bi-person-badge text-primary me-2"></i> Name</td>
                                <td class="text-dark">{{ $member->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-upc-scan text-primary me-2"></i> Rental ID</td>
                                <td class="text-dark">{{ $member->rental_id ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-envelope text-primary me-2"></i> Email</td>
                                <td class="text-dark">{{ $member->email ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-telephone text-primary me-2"></i> Phone</td>
                                <td class="text-dark">{{ $member->phone ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-calendar text-primary me-2"></i> Date of Birth</td>
                                <td class="text-dark">{{ $member->date_of_birth ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-droplet text-danger me-2"></i> Blood Group</td>
                                <td class="text-dark">{{ $member->blood_group ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-credit-card text-primary me-2"></i> National ID</td>
                                <td class="text-dark">{{ $member->national_id ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                                       <!-- Right: Info Table -->
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-user-information">
                        <tbody>
                            
                            <tr>
                                <td><i class="bi bi-building text-primary me-2"></i> Location</td>
                                <td class="text-dark">
                                  <b>Company:</b>{{ $member->company->name ?? '-' }} | 
                                   <b>Branch:</b>{{ $member->branch->name ?? '-' }} |
                                    <b>Building:</b>{{ $member->building->name ?? '-' }}<br>
                                    <b>Floor:</b>{{ $member->floor->name ?? '-' }} |
                                    <b>Flat:</b>{{ $member->flat->name ?? '-' }} |
                                    <b>Room:</b>{{ $member->room->name ?? '-' }} |                                   
                                    <b>Seat:</b> {{ $member->seats->pluck('seat_number')->join(', ') ?: '-' }}
                                    ({{ $member->seats->pluck('description')->join(', ') ?: '-' }})

                                </td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-house-door text-primary me-2"></i> Address</td>
                                <td class="text-dark">{{ $member->permanent_address ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-person text-primary me-2"></i> Father's Name</td>
                                <td class="text-dark">{{ $member->father_name ?? '-' }} ({{ $member->father_contact ?? '-' }})</td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-person text-primary me-2"></i> Mother's Name</td>
                                <td class="text-dark ">{{ $member->mother_name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-person text-primary me-2"></i> Local Guardian</td>
                                <td class="text-dark">{{ $member->local_guardian_name ?? '-' }} ({{ $member->local_guardian_relation ?? '-' }}) - {{ $member->local_guardian_contact ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-calendar-event text-primary me-2"></i> Admission Date</td>
                                <td class="text-dark">{{ \Carbon\Carbon::parse($member->admission_date)->format('d M, Y') ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-calendar-check text-primary me-2"></i> Effective Date</td>
                                <td class="text-dark">{{ \Carbon\Carbon::parse($member->effective_date)->format('d M, Y') ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-activity text-danger me-2"></i> Status</td>
                                <td>
                                    <span class="badge bg-{{ $member->status == 'active' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($member->status) }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                
                <!-- Buttons -->
                <div class="mt-4 d-flex justify-content-between">
                    <a href="{{ route('members.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back to List
                    </a>
                    <a href="{{ route('members.edit', $member->id) }}" class="btn btn-primary">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>
                </div>
            </div>



        </div>
    </div>
</div>
@endsection
