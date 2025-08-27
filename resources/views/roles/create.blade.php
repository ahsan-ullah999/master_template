@extends('layouts.app')
@section('title','Create Permission')
<x-navbar/>
@section('content')
<x-sidebar/>
<div class="content mt-4 px-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Roles / Creat</h3>
    <a href="{{ route('roles.index') }}" class="btn btn-dark">Back</a>
</div>
  <form method="post" action="{{ route('roles.store') }}" class="col-md-6">
    @csrf
    <div class="mb-3">
      <label class="form-label">Name</label>
      <input type="text" name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror">
      @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <div class="input-group gap-3">
        @if ($permissions ->isNotempty())
            @foreach($permissions as $permission)
                <div class="form-check justify-content-between ">
                    <input id="permission-{{ $permission->id }}" class="form-check-input " type="checkbox" name="permission[]" value="{{ $permission->name }}">
                    <label class="form-check-label" for="permission-{{ $permission->id }}">{{ $permission->name }}</label>
                </div>
            @endforeach
        @endif
    </div>


    <button class="btn btn-primary">Save</button>
  </form>
</div>
@endsection
