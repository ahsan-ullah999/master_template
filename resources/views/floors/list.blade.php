@extends('layouts.app')
@section('title','Floors')
<x-navbar/>
@section('content')
<x-sidebar/>

<div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h2>Floors List</h2>
        @can('create floor')
        <a href="{{ route('floors.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Add Floor
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
                <th>Building</th>
                <th>Floor Name</th>
                <th>Floor Number</th>
                <th>Status</th>
                @canany(['edit floor', 'delete floor'])
                    <th width="200">Actions</th>
                @endcanany             
            </tr>
        </thead>
        <tbody>
            @forelse($floors as $floor)
                <tr>
                    <td>{{ $floor->id }}</td>
                    <td>{{ $floor->building->name }}</td>
                    <td>{{ $floor->name }}</td>
                    <td>{{ $floor->number }}</td>
                    <td>
                        <span class="badge bg-{{ $floor->status == 'active' ? 'success' : 'secondary' }}">
                            {{ ucfirst($floor->status) }}
                        </span>
                    </td>
                    @canany(['edit floor', 'delete floor'])
                    <td>
                        @can('edit floor')
                        <a href="{{ route('floors.edit',$floor->id) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        @endcan
                        @can('delete floor')
                        <form action="{{ route('floors.destroy',$floor->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this floor?')">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                        @endcan                     
                    </td>
                    @endcanany
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted">No floor found</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $floors->links() }}
</div>
@endsection
