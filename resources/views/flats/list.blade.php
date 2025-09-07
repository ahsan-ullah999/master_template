@extends('layouts.app')
@section('title','Flats')
<x-navbar/>
@section('content')
<x-sidebar/>

<div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h2>Flats List</h2>
        <a href="{{ route('flats.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Add Flat
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Floor</th>
                <th>Flat Name</th>
                <th>Flat Number</th>
                <th>Status</th>
                <th width="200">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($flats as $flat)
                <tr>
                    <td>{{ $flat->id }}</td>
                    <td>{{ $flat->floor->name }}</td>
                    <td>{{ $flat->name }}</td>
                    <td>{{ $flat->flat_number }}</td>
                    <td>
                        <span class="badge bg-{{ $flat->status == 'active' ? 'success' : 'secondary' }}">
                            {{ ucfirst($flat->status) }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('flats.edit',$flat->id) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        <form action="{{ route('flats.destroy',$flat->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this flat?')">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted">No flat found</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $flats->links() }}
</div>
@endsection
