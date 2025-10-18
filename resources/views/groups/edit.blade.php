@extends('layouts.app')
@section('title','Edit')
<x-navbar/>
@section('content')
<x-sidebar/>
<div class="container mt-3">
    <h2>Edit Group</h2>

    <form action="{{ route('groups.update', $group->id) }}" method="post" enctype="multipart/form-data">
        @csrf @method('PUT')
        @include('groups.partials.form', ['group' => $group])
        <button type="submit" class="btn btn-success mt-3">Update</button>
        <a href="{{ route('groups.index') }}" class="btn btn-secondary mt-3">Cancel</a>
    </form>
</div>
@endsection
