@extends('layouts.app')
@section('title','Products/Edit')
<x-navbar/>
@section('content')
<x-sidebar/>
<div class="container mt-4">
    <h2>Edit Product</h2>
    <form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('put')

        <div class="mb-3">
            <label class="form-label">Product Name *</label>
            <input type="text" name="name" value="{{ old('name',$product->name) }}" class="form-control @error('name') is-invalid @enderror" required>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        
        <div class="mb-3">
            <label class="form-label">Description *</label>            
            <textarea name="description" class="form-control" rows="5">{{ old('description',$product->description ?? '') }}</textarea>
            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Product Price</label>
            <input type="text" name="price" value="{{ old('price',$product->price) }}" class="form-control @error('code') is-invalid @enderror">
            @error('price') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Product Code</label>
            <input type="text" name="code" value="{{ old('code',$product->code) }}" class="form-control @error('code') is-invalid @enderror">
            @error('code') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Product Image</label>
            @if($product->image)
                <div class="mb-2">
                    <img src="{{ asset('storage/'.$product->image) }}" width="80" class="rounded">
                </div>
            @endif
            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
            @error('image') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle"></i> Update</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
@endsection
