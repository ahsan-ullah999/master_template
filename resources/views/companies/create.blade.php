@extends('layouts.app')
@section('title','Create')
<x-navbar/>
@section('content')
<x-sidebar/>
<div class="container mt-3">
    <h2>Create Company</h2>

    <form action="{{ route('companies.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @include('companies.partials.form')
        <button type="submit" class="btn btn-success mt-3">Save</button>
        <a href="{{ route('companies.index') }}" class="btn btn-secondary mt-3">Cancel</a>
    </form>
</div>
@endsection
