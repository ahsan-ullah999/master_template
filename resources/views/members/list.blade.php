@extends('layouts.app')
@section('title','Members')
<x-navbar/>
@section('content')
<x-sidebar/>
<div class="container mt-3">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Members List</h2>
        @can('create member')
            <a href="{{ route('members.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Add Member
             </a>
        @endcan
    </div>

    @if(session('success')) 
        <div class="alert alert-success">{{ session('success') }}</div> 
    @endif

        <table class="table align-middle table-hover">
            <thead class="table-light">
                <tr>
                    <th>Name</th>
                    <th>Building</th>
                    <th>Seat</th>
                    @canany(['suspend member', 'reactivate member'])
                    <th>Status</th>                        
                    @endcanany

                    @canany(['edit member', 'delete member', 'view member'])
                        <th class="text-center">Actions</th>
                    @endcanany
                    
                </tr>
            </thead>
            <tbody>
                @forelse($members as $member)
                <tr class="{{ $member->status == 'suspended' ? 'table-secondary text-muted' : '' }}">
                    <!-- User info -->
                    <td>
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                @if($member->photo)
                                    <img src="{{ asset('storage/'.$member->photo) }}" 
                                        alt=" {{ ucfirst(strtolower($member->name )) }}" 
                                        class="rounded-circle" 
                                        width="50" height="50">
                                @else
                                    <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center"
                                        style="width:50px; height:50px;">
                                        <i class="bi bi-person text-white"></i>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <h6 class="mb-0">{{ ucfirst(strtolower($member->name ?? '-')) }}</h6>
                                <small class="text-muted">{{ $member->email ?? '-' }}</small>
                            </div>
                        </div>
                    </td>

                    <!-- Building -->
                    <td>{{ ucfirst(strtolower($member->building->name ?? '-')) }}</td>

                    <!-- Seat -->
                    <td>
                        @if($member->seats->isEmpty())
                            -
                        @else
                            {{ $member->seats->pluck('seat_number')->join(', ') }}
                        @endif
                    </td>

                    <!-- Status + Toggle -->
                        <td>                         
                            @if($member->status == 'active')
                             @can('suspend member')
                                <form action="{{ route('members.suspend',$member->id) }}" method="POST" class="d-inline suspend-form">
                                    @csrf @method('PATCH')
                                    <button type="button" class="btn btn-sm btn-success suspend-btn rounded-pill">
                                        <i class="bi bi-check-circle"></i> Active
                                    </button>
                                </form>
                              @endcan   
                            @else
                            @can('reactivate member')
                                <form action="{{ route('members.reactivate',$member->id) }}" method="POST" class="d-inline reactivate-form">
                                    @csrf @method('PATCH')
                                    <button type="button" class="btn btn-sm btn-danger reactivate-btn rounded-pill">
                                        <i class="bi bi-slash-circle"></i> Suspended
                                    </button>
                                </form>
                            @endcan                               
                            @endif                           
                        </td>


                    <!-- Actions -->
                    <td class="text-center">
                        <div class="gap-2 justify-content-center">
                            <!-- View -->
                            @can('view member')
                                <a href="{{ route('members.show',$member->id) }}" 
                                class="btn btn-info btn-sm {{ $member->status == 'suspended' ? 'disabled' : '' }}"
                                title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                            @endcan
                            

                            <!-- Edit -->
                            @can('edit member')
                                <a href="{{ route('members.edit',$member->id) }}" 
                                class="btn btn-primary btn-sm {{ $member->status == 'suspended' ? 'disabled' : '' }}"
                                title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            @endcan
                            

                            <!-- Delete -->
                            @can('delete member')
                                <form id="deleteForm{{ $member->id }}" action="{{ route('members.destroy',$member->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="button" class="btn btn-danger btn-sm btn-delete" data-form="#deleteForm{{ $member->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                                </form>
                            @endcan
                            
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted">No members found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    {{ $members->links() }}
</div>
@endsection
