@extends('layouts.app')
@section('title','Create User')
<x-navbar/>
@section('content')
<x-sidebar/>

<div class="content mt-4 px-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>User / Create</h3>
        <a href="{{ route('users.index') }}" class="btn btn-dark">Back</a>
    </div>

    <form method="post" action="{{ route('users.store') }}" class="col-md-6">
        @csrf

        <div class="mb-3">
            <label class="form-label">Name *</label>
            <input type="text" name="name" value="{{ old('name') }}" 
                class="form-control @error('name') is-invalid @enderror">
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Email *</label>
            <input type="email" name="email" value="{{ old('email') }}" 
                class="form-control @error('email') is-invalid @enderror">
            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Password *</label>
            <input type="password" name="password" 
                class="form-control @error('password') is-invalid @enderror">
            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Confirm Password *</label>
            <input type="password" name="password_confirmation" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label fw-bold">Assign Roles *</label>
            <div class="d-flex flex-wrap gap-3">
                @foreach($roles as $role)
                    <div class="form-check">
                        <input id="role-{{ $role->id }}" 
                               class="form-check-input" 
                               type="checkbox" 
                               name="role[]" 
                               value="{{ $role->name }}">
                        <label class="form-check-label" for="role-{{ $role->id }}">
                            {{ $role->name }}
                        </label>
                    </div>
                @endforeach
            </div>
        </div>

        <button class="btn btn-primary">Save</button>
    </form>
</div>
@endsection
