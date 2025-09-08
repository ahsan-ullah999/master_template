@extends('layouts.app')
@section('title','Buildings')
<x-navbar/>
@section('content')
<x-sidebar/>

<div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h2>Building List</h2>
        @can('create building')
        <a href="{{ route('buildings.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Add Building
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
                <th>Branch</th>
                <th>Building Name</th>
                <th>Address</th>
                <th>Status</th>
                @canany(['edit building', 'delete building'])
                    <th width="200">Actions</th>
                @endcanany                
            </tr>
        </thead>
        <tbody>
            @forelse($buildings as $building)
                <tr>
                    <td>{{ $building->id }}</td>
                    <td>{{ $building->branch->name }}</td>
                    <td>{{ $building->name }}</td>
                    <td>{{ $building->address }}</td>
                    <td>
                        <span class="badge bg-{{ $building->status == 'active' ? 'success' : 'secondary' }}">
                            {{ ucfirst($building->status) }}
                        </span>
                    </td>
                    @canany(['edit building', 'delete building'])
                    <td>
                        @can('edit building')
                        <a href="{{ route('buildings.edit',$building->id) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        @endcan
                        @can('delete building')
                        <form action="{{ route('buildings.destroy',$building->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this building?')">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                        @endcan                        
                    </td>
                    @endcanany
                    
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted">No buildings found</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $buildings->links() }}
</div>
@endsection
