@extends('layouts.app')
@section('title','Roles')
<x-navbar/>
@section('content')
<x-sidebar/>

<div class="content p-3">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Roles / List</h3>
    <a href="{{ route('roles.create') }}" class="btn btn-primary">Create</a>
  </div>
            @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Permission</th>                     
                    <th>Created</th>                  
                    <th>Actions</th>
                  
                </tr>
            </thead>
                <tbody>
                    @if ($roles->isNotEmpty())
                    
                    @foreach ($roles as $role)
                        <tr>
                            <td>
                            {{ $role->id }}
                            </td>
                            <td>
                            {{ $role->name }}
                            </td>
                            <td>
                            {{ $role->permissions->pluck('name')->implode(', ') }}
                            </td>
                            <td>
                            {{ \Carbon\Carbon::parse($role->created_at)->format('d M, Y') }}
                            </td>
                            <td>
                                @can('edit role')     
                                  <a class="btn btn-sm btn-warning" href="{{ route('roles.edit',$role->id) }}">Edit</a>
                                @endcan
                                {{-- <form method="POST" action="#" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">Delete</button>
                                </form> --}}
                            </td>
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
