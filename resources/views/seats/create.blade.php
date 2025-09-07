@extends('layouts.app')
@section('title','Add seat')
<x-navbar/>
@section('content')
<x-sidebar/>
<div class="container mt-3">
    <h2>Add Seat</h2>
    <form action="{{ route('seats.store') }}" method="POST">
        @csrf
        @include('seats.partials.form')
        <button type="submit" class="btn btn-success mt-3">Save</button>
        <a href="{{ route('seats.index') }}" class="btn btn-secondary mt-3">Cancel</a>
    </form>
</div>
@endsection
