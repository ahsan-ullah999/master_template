@extends('layouts.app')
@section('title','Add room')
<x-navbar/>
@section('content')
<x-sidebar/>
<div class="container mt-3">
    <h2>Add Room</h2>
    <form action="{{ route('rooms.store') }}" method="POST">
        @csrf
        @include('rooms.partials.form')
        <button type="submit" class="btn btn-success mt-3">Save</button>
        <a href="{{ route('rooms.index') }}" class="btn btn-secondary mt-3">Cancel</a>
    </form>
</div>
@endsection
