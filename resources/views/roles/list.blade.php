@extends('layouts.app')
@section('title','Roles')
<x-navbar/>
@section('content')
<x-sidebar/>

<div class="content p-3">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Roles / List</h3>
    {{-- @can('create role') --}}
        <a href="{{ route('roles.create') }}" class="btn btn-primary">Create</a>
    {{-- @endcan --}}
  

    
  </div>
            @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        <table class="table align-middle table-hover table-striped">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Permission</th>                     
                    <th>Created</th>  
                    @canany(['edit role','delete role'])
                    <th>Actions</th>
                    @endcanany                                
                </tr>
            </thead>
                <tbody>
                    @if ($roles->isNotEmpty())
                    
                    @foreach ($roles as $role)
                        <tr>
                            <td>
                            {{ $loop->iteration }}
                            </td>
                            <td>
                            {{ ucfirst(strtolower($role->name)) }}
                            </td>
                            <td style="max-width: 300px; white-space: normal;">
                            {{ $role->permissions->pluck('name')->implode(', ') }}
                            </td>
                            <td>
                            {{ \Carbon\Carbon::parse($role->created_at)->format('d M, Y') }}
                            </td>
                            @canany(['edit role','delete role'])
                                <td>
                                    @can('edit role')     
                                    <a class="btn btn-sm btn-primary" href="{{ route('roles.edit',$role->id) }}">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @endcan
                                    @can('delete role')
                                    <form id="deleteForm{{ $role->id }}" action="{{ route('roles.destroy',$role->id) }}" 
                                            method="POST" 
                                            class="d-inline"
                                            onsubmit="return confirm('Are you sure you want to delete this role?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm btn-delete" data-form="#deleteForm{{ $role->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </td>
                            @endcanany

                        </tr>
                    @endforeach
                    @endif
                

                
                </tbody>
        </table>
   
    <div class="d-flex-between  mt-3">
    {{ $roles->links() }}
    </div>
  
</div>
@endsection
