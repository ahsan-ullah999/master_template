@extends('layouts.app')
@section('title','Create Branch')
<x-navbar/>
@section('content')
<x-sidebar/>
<div class="container mt-3">
    <h2>Create Branch</h2>
    <form action="{{ route('branches.store') }}" method="POST">
        @csrf
        @include('branches.partials.form')
        <button type="submit" class="btn btn-success mt-3">Save</button>
        <a href="{{ route('branches.index') }}" class="btn btn-secondary mt-3">Cancel</a>
    </form>
</div>
</div>
@endsection
