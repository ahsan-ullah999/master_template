@extends('layouts.app')
@section('title','Flats')
<x-navbar/>
@section('content')
<x-sidebar/>

<div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h2>Flats List</h2>
        @can('create flat')
        <a href="{{ route('flats.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Add Flat
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
                        <th>Floor</th>
                        <th>Flat Name</th>
                        <th>Flat Number</th>
                        <th>Status</th>
                        @canany(['edit flat','delete flat'])
                            <th>Actions</th>
                        @endcanany
                    </tr>
                </thead>
                <tbody>
                    @forelse($flats as $flat)
                    <tr>
                        <td>{{ $flat->floor->name }}</td>
                        <td>{{ $flat->name }}</td>
                        <td>{{ $flat->flat_number }}</td>
                        <td>
                            <span class="badge {{ $flat->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($flat->status) }}
                            </span>
                        </td>
                        @canany(['edit flat','delete flat'])
                        <td>
                            <div class="gap-2">
                                @can('edit flat')
                                <a href="{{ route('flats.edit',$flat->id) }}" class="btn btn-primary rounded-circle btn-sm">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @endcan
                                @can('delete flat')
                                <form action="{{ route('flats.destroy',$flat->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-danger rounded-circle btn-sm"
                                            onclick="return confirm('Delete this flat?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                        @endcanany
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted">No flats found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $flats->links() }}

</div>
@endsection
