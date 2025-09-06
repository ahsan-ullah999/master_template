@extends('layouts.app')
@section('title','View Branch')
<x-navbar/>
@section('content')
<x-sidebar/>
<div class="container mt-3">
    <div class="card p-4 shadow">
        <h3 class="mb-3">Branch: {{ $branch->name }}</h3>
        <p><strong>Company:</strong> {{ $branch->company->name }}</p>
        <p><strong>Email:</strong> {{ $branch->email }}</p>
        <p><strong>Mobile:</strong> {{ $branch->mobile_number }}</p>
        <p><strong>Branch ID:</strong> {{ $branch->branch_id }}</p>
        <p><strong>Website:</strong> {{ $branch->website }}</p>
        <p><strong>Address:</strong> {{ $branch->upazila }}, {{ $branch->district }}, {{ $branch->country }}</p>
        <p><strong>Zip:</strong> {{ $branch->zip_code }}</p>
        <p><strong>Landmark:</strong> {{ $branch->landmark }}</p>
        <div>
        <a href="{{ route('companies.show', $branch->company->id) }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to view
        </a>
        </div>
    </div>
</div>
@endsection
