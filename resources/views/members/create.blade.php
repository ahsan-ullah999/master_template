@extends('layouts.app')
@section('title','Create Member')
<x-navbar/>
@section('content')
<x-sidebar/>
<div class="container mt-3">
    <h2>Create Member</h2>
    <form action="{{ route('members.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('members.partials.form')
        <button type="submit" class="btn btn-success mt-3">Save</button>
        <a href="{{ route('members.index') }}" class="btn btn-secondary mt-3">Cancel</a>
    </form>
</div>
@endsection
