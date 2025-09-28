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
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror">
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Description *</label>
            <textarea name="description" class="form-control" rows="5">{{ old('description',$product->description ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="text" name="price" class="form-control @error('price') is-invalid @enderror">
            @error('price') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Product Code</label>
            <input type="text" name="code" class="form-control @error('code') is-invalid @enderror">
            @error('code') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Product Image</label>
            <input type="file" name="image" id="imageInput" class="form-control @error('image') is-invalid @enderror" accept="image/*">
            @error('image') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- Image Preview -->
       <div class="mb-3">
            <img id="previewImage" src="#" alt="Image Preview" 
                class="rounded border d-none" 
                style="max-width: 120px; max-height: 120px; object-fit: cover;">
        </div>

        <button type="submit" class="btn btn-success"><i class="bi bi-check-circle"></i> Save</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

@push('scripts')
<script>
    document.getElementById("imageInput").addEventListener("change", function(e) {
        const preview = document.getElementById("previewImage");
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(event) {
                preview.src = event.target.result;
                preview.classList.remove("d-none"); // show
            }
            reader.readAsDataURL(file);
        } else {
            preview.src = "#";
            preview.classList.add("d-none"); // hide
        }
    });
</script>
@endpush

@endsection
