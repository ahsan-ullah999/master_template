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

        <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
            <table class="table align-middle table-hover table-striped">
                <thead class="table-light sticky-top" style="z-index: 1;">
                    <tr>
                        <th>No.</th>
                        <th>Branch</th>
                        <th>Building</th>
                        <th>Address</th>
                        <th>Status</th>
                        @canany(['edit building','delete building'])
                            <th>Actions</th>
                        @endcanany
                    </tr>
                </thead>
                <tbody>
                    @forelse($buildings as $building)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $building->branch->name }}</td>
                        <td>{{ ucfirst(strtolower($building->name)) }}</td>
                        <td>{{ $building->address }}</td>
                        <td>
                            <span class="badge {{ $building->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($building->status) }}
                            </span>
                        </td>
                        @canany(['edit building','delete building'])
                        <td >
                            <div class="gap-2">
                                @can('edit building')
                                <a href="{{ route('buildings.edit',$building->id) }}" 
                                class="btn btn-primary btn-sm" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @endcan
                                @can('delete building')
                                <form id="deleteForm{{ $building->id }}" action="{{ route('buildings.destroy',$building->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm btn-delete" data-form="#deleteForm{{ $building->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                        @endcanany
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted">No buildings found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $buildings->links() }}

</div>
@endsection
