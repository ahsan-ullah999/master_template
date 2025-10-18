@extends('layouts.app')
@section('title','Create')
<x-navbar/>
@section('content')
<x-sidebar/>
<div class="container mt-3">
    <h2>Create Group</h2>

    <form action="{{ route('groups.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @include('groups.partials.form')
        <button type="submit" class="btn btn-success mt-3">Save</button>
        <a href="{{ route('groups.index') }}" class="btn btn-secondary mt-3">Cancel</a>
    </form>
</div>
@endsection
