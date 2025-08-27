@extends('layouts.app')
@section('title','Create Permission')
<x-navbar/>

@section('content')
<x-sidebar/>

<div class="content mt-4 px-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
    <h3>Permissions / Edit</h3>
    <a href="{{ route('permissions.index') }}" class="btn btn-dark">Back</a>
</div>
  <form method="post" action="{{ route("permissions.update",$permission->id) }}" class="col-md-6">
    @csrf
    <div class="mb-3">
      <label class="form-label">Name</label>
      <input type="text" name="name" value="{{ old('name',$permission->name) }}" class="form-control @error('name') is-invalid @enderror">
      @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <button class="btn btn-primary">Update</button>
  </form>
</div>
@endsection
