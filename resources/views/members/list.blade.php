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

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Photo</th>
                <th>Building</th>
                <th>Seat</th>
                <th>Status</th>
                <th width="220">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($members as $member)
            <tr class="{{ $member->status == 'suspended' ? 'table-secondary text-muted' : '' }}">
                <td>{{ $member->name ?? '-' }}</td>
                <td>{{ $member->email ?? '-' }}</td>
                <td>
                    @if($member->photo)
                        <img src="{{ asset('storage/'.$member->photo) }}" width="60" height="60" class="rounded">
                    @else
                        <span class="text-muted">No Image</span>
                    @endif
                </td>
                <td>{{ $member->building->name ?? '-' }}</td>
                <td>{{ $member->seat->seat_number ?? '-' }}</td>
                <td>
                    @if($member->status == 'active')
                        <form action="{{ route('members.suspend',$member->id) }}" method="POST" class="d-inline">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="bi bi-arrow-counterclockwise"></i> Active
                            </button>
                        </form>
                    @else
                        <form action="{{ route('members.reactivate',$member->id) }}" method="POST" class="d-inline">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-arrow-counterclockwise"></i> Suspend
                            </button>
                        </form>
                    @endif
                </td>
                <td>
                    <a href="{{ route('members.show',$member->id) }}" 
                       class="btn btn-sm btn-info {{ $member->status == 'suspended' ? 'disabled' : '' }}">
                        <i class="bi bi-eye"></i> View
                    </a>
                    <a href="{{ route('members.edit',$member->id) }}" 
                       class="btn btn-sm btn-warning {{ $member->status == 'suspended' ? 'disabled' : '' }}">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>

                    <form action="{{ route('members.destroy',$member->id) }}" method="POST" class="d-inline"
                          onsubmit="return confirm('Delete this member?');">
                        @csrf @method('DELETE')
                        <button class="btn btn btn-danger"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="text-center text-muted">No members found</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $members->links() }}
</div>
@endsection
