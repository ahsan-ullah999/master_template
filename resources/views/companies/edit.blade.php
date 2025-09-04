@extends('layouts.app')
@section('title','Edit')
<x-navbar/>
@section('content')
<x-sidebar/>
<div class="container mt-3">
    <h2>Edit Company</h2>

    <form action="{{ route('companies.update', $company->id) }}" method="post" enctype="multipart/form-data">
        @csrf @method('PUT')
        @include('companies.partials.form', ['company' => $company])
        <button type="submit" class="btn btn-success mt-3">Update</button>
        <a href="{{ route('companies.index') }}" class="btn btn-secondary mt-3">Cancel</a>
    </form>
</div>
@endsection
