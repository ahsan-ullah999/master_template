@extends('layouts.app')
@section('title','Products')
<x-navbar/>
@section('content')
<x-sidebar/>
<div class="container mt-3">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h2>Product List</h2>

        <div class="d-flex align-items-center gap-2">
            <!-- Search box -->
         
            <div class="d-flex mb-2">
                <input 
                type="text" 
                name="search" 
                id="searchInput" 
                class="form-control" 
                placeholder="Search products...">
            </div>
                <!-- Sort By dropdown -->
    <div class="d-flex mb-2">
        <select id="sortSelect" class="form-select">
            <option value="latest">Latest</option>
            <option value="oldest">Oldest</option>
            <option value="name_asc">Name (A → Z)</option>
            <option value="name_desc">Name (Z → A)</option>
        </select>
    </div>
            
            <!-- Add product button -->
            @can('create product')
            <a href="{{ route('products.create') }}" class="btn btn-primary mb-2">
                <i class="bi bi-plus-lg"></i> Add Product
            </a>
            @endcan
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <!-- Product table (load partial here) -->
    <div id="productTable">
        @include('products.partials.table', ['products' => $products])
    </div>
</div>


        @push('scripts')
        <script>
        $(document).ready(function () {
            let delayTimer;

            // Search
            $('#searchInput').on('keyup', function () {
                clearTimeout(delayTimer);
                delayTimer = setTimeout(function() {
                    fetchProducts(1, $('#searchInput').val(), $('#sortSelect').val());
                }, 300);
            });

            // Sort change
            $('#sortSelect').on('change', function () {
                fetchProducts(1, $('#searchInput').val(), $(this).val());
            });

            // Pagination
            $(document).on('click', '#productTable .pagination a', function (e) {
                e.preventDefault();
                let page = $(this).attr('href').split('page=')[1];
                fetchProducts(page, $('#searchInput').val(), $('#sortSelect').val());
            });

            // Fetch function
            function fetchProducts(page = 1, search = "", sort = "latest") {
                $.ajax({
                    url: "{{ route('products.index') }}?page=" + page + "&search=" + search + "&sort=" + sort,
                    type: "GET",
                    success: function (data) {
                        $('#productTable').html(data);
                    },
                    error: function (xhr) {
                        console.error("Error loading products:", xhr.responseText);
                    }
                });
            }
        });
        </script>
        @endpush








@endsection
