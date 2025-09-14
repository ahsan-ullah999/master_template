@extends('layouts.app')
@section('title','Members')
<x-navbar/>
@section('content')
<x-sidebar/>
<div class="container mt-3">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Members List</h2>
        <a href="{{ route('members.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Add Member
        </a>
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
                    <th>Status</th>
                    <th class="text-center">Actions</th>
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
                                        alt="{{ $member->name }}" 
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
                                <h6 class="mb-0">{{ $member->name ?? '-' }}</h6>
                                <small class="text-muted">{{ $member->email ?? '-' }}</small>
                            </div>
                        </div>
                    </td>

                    <!-- Building -->
                    <td>{{ $member->building->name ?? '-' }}</td>

                    <!-- Seat -->
                    <td>{{ $member->seat->seat_number ?? '-' }}</td>

                    <!-- Status + Toggle -->
                    <td>
                        @if($member->status == 'active')
                            <form action="{{ route('members.suspend',$member->id) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-success rounded-pill">
                                    <i class="bi bi-check-circle"></i> Active
                                </button>
                            </form>
                        @else
                            <form action="{{ route('members.reactivate',$member->id) }}" method="POST" class="d-inline">
                                @csrf @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-danger rounded-pill">
                                    <i class="bi bi-slash-circle"></i> Suspended
                                </button>
                            </form>
                        @endif
                    </td>

                    <!-- Actions -->
                    <td class="text-center">
                        <div class="gap-2 justify-content-center">
                            <!-- View -->
                            <a href="{{ route('members.show',$member->id) }}" 
                            class="btn btn-info rounded-circle {{ $member->status == 'suspended' ? 'disabled' : '' }}"
                            title="View">
                                <i class="bi bi-eye"></i>
                            </a>

                            <!-- Edit -->
                            <a href="{{ route('members.edit',$member->id) }}" 
                            class="btn btn-primary rounded-circle {{ $member->status == 'suspended' ? 'disabled' : '' }}"
                            title="Edit">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <!-- Delete -->
                            <form action="{{ route('members.destroy',$member->id) }}" method="POST" class="d-inline"
                                onsubmit="return confirm('Delete this member?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger rounded-circle" title="Delete">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
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
