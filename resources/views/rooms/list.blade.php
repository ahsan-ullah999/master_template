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

        <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
            <table class="table align-middle table-hover table-striped">
                <thead class="table-light sticky-top" style="z-index: 1;">
                    <tr>
                        <th>Flat</th>
                        <th>Room Name</th>
                        <th>Room Number</th>
                        <th>Status</th>
                        @canany(['edit room','delete room'])
                            <th>Actions</th>
                        @endcanany
                    </tr>
                </thead>
                <tbody>
                    @forelse($rooms as $room)
                    <tr>
                        <td>{{ $room->flat->name }}</td>
                        <td>{{ $room->name }}</td>
                        <td>{{ $room->room_number }}</td>
                        <td>
                            <span class="badge {{ $room->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($room->status) }}
                            </span>
                        </td>
                        @canany(['edit room','delete room'])
                        <td>
                            <div class="gap-2">
                                @can('edit room')
                                <a href="{{ route('rooms.edit',$room->id) }}" class="btn btn-primary rounded-circle btn-sm">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @endcan
                                @can('delete room')
                                <form action="{{ route('rooms.destroy',$room->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger rounded-circle btn-sm"
                                            onclick="return confirm('Delete this room?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                        @endcanany
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted">No rooms found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $rooms->links() }}
</div>
@endsection
