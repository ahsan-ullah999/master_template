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
                         src="{{ asset('storage/'.$member->photo) }}" style="width:200px; height:200px; object-fit;">
                @else
                    <img alt="Default Avatar" class="img-circle img-thumbnail shadow-sm" 
                         src="https://bootdey.com/img/Content/avatar/avatar7.png" style="width:200px;">
                @endif                
            </div>
                <div class="table-responsive mt-2 col-8">
                    <table class="table table-user-information">
                        <tbody>
                            <tr>
                                <td><i class="bi bi-person-badge text-dark me-2"></i> Name</td>
                                <td class="text-dark">{{ $member->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-upc-scan text-dark me-2"></i> Rental ID</td>
                                <td class="text-dark">{{ $member->rental_id ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-envelope text-dark me-2"></i> Email</td>
                                <td class="text-dark">{{ $member->email ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-telephone text-dark me-2"></i> Phone</td>
                                <td class="text-dark">{{ $member->phone ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-calendar text-dark me-2"></i> Date of Birth</td>
                                <td class="text-dark">{{ $member->date_of_birth ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-droplet text-dark me-2"></i> Blood Group</td>
                                <td class="text-dark">{{ $member->blood_group ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-credit-card text-dark me-2"></i> National ID</td>
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
                                <td><i class="bi bi-building text-dark me-2"></i> Location</td>
                                <td class="text-dark">
                                  <b>Company:</b>{{ $member->company->name ?? '-' }} | 
                                   <b>Branch:</b>{{ $member->branch->name ?? '-' }} |
                                    <b>Building:</b>{{ $member->building->name ?? '-' }}<br>
                                    <b>Floor:</b>{{ $member->floor->name ?? '-' }} |
                                    <b>Flat:</b>{{ $member->flat->name ?? '-' }} |
                                    <b>Room:</b>{{ $member->room->name ?? '-' }} |
                                    <b>Seat:</b>{{ $member->seat->seat_number ?? '-' }} ({{ $member->seat->description ?? '-' }})
                                </td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-house-door text-dark me-2"></i> Address</td>
                                <td class="text-dark">{{ $member->permanent_address ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-person text-dark me-2"></i> Father's Name</td>
                                <td class="text-dark">{{ $member->father_name ?? '-' }} ({{ $member->father_contact ?? '-' }})</td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-person text-dark me-2"></i> Mother's Name</td>
                                <td class="text-dark ">{{ $member->mother_name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-person text-dark me-2"></i> Local Guardian</td>
                                <td class="text-dark">{{ $member->local_guardian_name ?? '-' }} ({{ $member->local_guardian_relation ?? '-' }}) - {{ $member->local_guardian_contact ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-calendar-event text-dark me-2"></i> Admission Date</td>
                                <td class="text-dark">{{ $member->admission_date ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-calendar-check text-dark me-2"></i> Effective Date</td>
                                <td class="text-dark">{{ $member->effective_date ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td><i class="bi bi-activity text-dark me-2"></i> Status</td>
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
                    <a href="{{ route('members.edit', $member->id) }}" class="btn btn-warning">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>
                </div>
            </div>



        </div>
    </div>
</div>
@endsection
