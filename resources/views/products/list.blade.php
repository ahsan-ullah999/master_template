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
                    // Debounced live search
                    let delayTimer;
                    $('#searchInput').on('keyup', function () {
                        clearTimeout(delayTimer);
                        delayTimer = setTimeout(function() {
                            fetchProducts(1, $('#searchInput').val()); // reset to page 1
                        }, 300);
                    });

                    // Pagination with search term preserved
                    $(document).on('click', '#productTable .pagination a', function (e) {
                        e.preventDefault();
                        let page = $(this).attr('href').split('page=')[1];
                        let search = $('#searchInput').val();
                        fetchProducts(page, search);
                    });

                    // AJAX fetch
                    function fetchProducts(page = 1, search = "") {
                        $.ajax({
                            url: "{{ route('products.index') }}?page=" + page + "&search=" + search,
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
