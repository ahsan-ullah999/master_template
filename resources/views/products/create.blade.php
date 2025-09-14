@extends('layouts.app')
@section('title','Products/Create')
<x-navbar/>
@section('content')
<x-sidebar/>
<div class="container mt-4">
    <h2>Add Product</h2>
    <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label class="form-label">Product Name *</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" required>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Description *</label>
            <textarea name="description" class="form-control" rows="5">{{ old('description',$product->description ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Product Code</label>
            <input type="text" name="code" class="form-control @error('code') is-invalid @enderror">
            @error('code') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Product Image</label>
            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
            @error('image') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-success"><i class="bi bi-check-circle"></i> Save</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
