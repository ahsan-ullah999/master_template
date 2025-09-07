@extends('layouts.app')
@section('title','Add Floor')
<x-navbar/>
@section('content')
<x-sidebar/>
<div class="container mt-3">
    <h2>Add Floor</h2>
    <form action="{{ route('floors.store') }}" method="POST">
        @csrf
        @include('floors.partials.form')
        <button type="submit" class="btn btn-success mt-3">Save</button>
        <a href="{{ route('floors.index') }}" class="btn btn-secondary mt-3">Cancel</a>
    </form>
</div>
@endsection
