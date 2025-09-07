@extends('layouts.app')
@section('title','Add Building')
<x-navbar/>
@section('content')
<x-sidebar/>
<div class="container mt-3">
    <h2>Add Building</h2>
    <form action="{{ route('buildings.store') }}" method="POST">
        @csrf
        @include('buildings.partials.form')
        <button type="submit" class="btn btn-success mt-3">Save</button>
        <a href="{{ route('buildings.index') }}" class="btn btn-secondary mt-3">Cancel</a>
    </form>
</div>
@endsection
