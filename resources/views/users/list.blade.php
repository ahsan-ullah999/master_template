@extends('layouts.app')
@section('title','Users')
<x-navbar/>
@section('content')
<x-sidebar/>

<div class="content p-3">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>User / List</h3>
    <a href="#" class="btn btn-primary">Create</a>
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
                    <th>Actions</th>
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
                            <td>
                                @can('edit user')
                                    <a class="btn btn-sm btn-warning" href="{{ route('users.edit',$user->id) }}">Edit</a>
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
    {{ $users->links() }}
    </div>
  
</div>
@endsection
