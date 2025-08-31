@extends('layouts.app')
@section('title','Permissions')
<x-navbar/>
@section('content')
<x-sidebar/>

<div class="content p-3">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Permissions</h3>
    @can('create permission')
       <a href="{{ route('permissions.create') }}" class="btn btn-primary">Create</a>
    @endcan
   
  </div>
  @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
  <table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Created</th>
            @canany(['edit permission','delete permission'])
              <th>Actions</th>
            @endcanany
            
        </tr>
    </thead>
    <tbody>
      @if ($permissions->isNotEmpty())
        
      @foreach ($permissions as $permission)
        <tr>
        <td>
          {{ $permission->id }}
        </td>
        <td>
          {{ $permission->name }}
        </td>
        <td>
          {{ \Carbon\Carbon::parse($permission->created_at)->format('d M, Y') }}
        </td>
            @canany(['edit permission','delete permission'])
              <td>
                @can('edit permission')
                  <a class="btn btn-sm btn-warning" href="{{ route('permissions.edit',$permission->id) }}">Edit</a>
                @endcan
                
                  @can('delete permission')          
                    <form action="{{ route('permissions.destroy',$permission->id) }}" 
                          method="POST" 
                          class="d-inline"
                          onsubmit="return confirm('Are you sure you want to delete this permission?');">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="btn btn-sm btn-danger">Delete</button>
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
    {{ $permissions->links() }}
    </div>
  
</div>
@endsection
