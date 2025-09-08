@extends('layouts.app')
@section('title','Rooms')
<x-navbar/>
@section('content')
<x-sidebar/>

<div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h2>Rooms List</h2>
        @can('create room')
        <a href="{{ route('rooms.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Add Room
        </a>
        @endcan

    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Flat</th>
                <th>Room Name</th>
                <th>Room Number</th>
                <th>Status</th>
                @canany(['edit room', 'delete room'])
                 <th width="200">Actions</th>   
                @endcanany
            </tr>
        </thead>
        <tbody>
            @forelse($rooms as $room)
                <tr>
                    <td>{{ $room->id }}</td>
                    <td>{{ $room->flat->name }}</td>
                    <td>{{ $room->name }}</td>
                    <td>{{ $room->room_number }}</td>
                    <td>
                        <span class="badge bg-{{ $room->status == 'active' ? 'success' : 'secondary' }}">
                            {{ ucfirst($room->status) }}
                        </span>
                    </td>
                    @canany(['edit room', 'delete room'])
                    <td>
                        @can('edit room')
                            <a href="{{ route('rooms.edit',$room->id) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil-square"></i> Edit
                            </a>
                        @endcan
                        @can('delete room')
                        <form action="{{ route('rooms.destroy',$room->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this room?')">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                        @endcan
                    </td>
                    @endcanany

                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted">No room found</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $rooms->links() }}
</div>
@endsection
