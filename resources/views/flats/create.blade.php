@extends('layouts.app')
@section('title','Add flat')
<x-navbar/>
@section('content')
<x-sidebar/>
<div class="container mt-3">
    <h2>Add Flat</h2>
    <form action="{{ route('flats.store') }}" method="POST">
        @csrf
        @include('flats.partials.form')
        <button type="submit" class="btn btn-success mt-3">Save</button>
        <a href="{{ route('flats.index') }}" class="btn btn-secondary mt-3">Cancel</a>
    </form>
</div>
@endsection
