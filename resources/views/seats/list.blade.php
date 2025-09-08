@extends('layouts.app')
@section('title','Seats')
<x-navbar/>
@section('content')
<x-sidebar/>

<div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h2>Seats List</h2>
        @can('create seat')
        <a href="{{ route('seats.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Add Seat
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
                <th>Room</th>
                <th>Seat Number</th>
                <th>Status</th>
                @canany(['edit seat','delete seat'])
                <th width="200">Actions</th>
                @endcanany

            </tr>
        </thead>
        <tbody>
            @forelse($seats as $seat)
                <tr>
                    <td>{{ $seat->id }}</td>
                    <td>{{ $seat->room->name }}</td>
                    <td>{{ $seat->seat_number }}</td>
                    <td>
                        <span class="badge bg-{{ $seat->status == 'active' ? 'success' : 'secondary' }}">
                            {{ ucfirst($seat->status) }}
                        </span>
                    </td>
                    @canany(['edit seat','delete seat'])
                    <td>
                        @can('edit seat')
                        <a href="{{ route('seats.edit',$seat->id) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        @endcan
                        @can('delete seat')
                        <form action="{{ route('seats.destroy',$seat->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this seat?')">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                        @endcan
                    </td>
                    @endcanany

                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted">No seat found</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $seats->links() }}
</div>
@endsection
