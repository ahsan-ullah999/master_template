@extends('layouts.app')
@section('title','Users')
<x-navbar/>
@section('content')
<x-sidebar/>

<div class="content p-3">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>User / List</h3>
    @can('create user')
         <a href="{{ route('users.create') }}" class="btn btn-primary">Create</a>
    @endcan
   
  </div>
            @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Created</th>
                    @canany(['edit user','delete user'])
                        <th>Actions</th>
                    @endcan
                    
                </tr>
            </thead>
                <tbody>
                    @if ($users->isNotEmpty())
                    
                    @foreach ($users as $user)
                        <tr>
                            <td>
                            {{ $user->id }}
                            </td>
                            <td>
                            {{ $user->name }}
                            </td>
                            <td>
                            {{ $user->email }}
                            </td>
                            <td>
                            {{ $user->roles->pluck('name')->implode(', ') }}
                            </td>
                            <td>
                            {{ \Carbon\Carbon::parse($user->created_at)->format('d M, Y') }}
                            </td>
                            @canany(['edit user', 'delete user'])
                            <td>
                                @can('edit user')
                                <a class="btn btn-sm btn-warning" href="{{ route('users.edit',$user->id) }}">Edit</a>
                                @endcan
                                @can('delete user')          
                                    <form action="{{ route('users.destroy',$user->id) }}" 
                                        method="POST" 
                                        class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this User?');">
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
    {{ $users->links() }}
    </div>
  
</div>
@endsection
