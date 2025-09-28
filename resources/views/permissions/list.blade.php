@extends('layouts.app')
@section('title','Permission')
<x-navbar/>
@section('content')
<x-sidebar/>
<div class="container mt-3">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h2>Permissions List</h2>

        <div class="d-flex align-items-center gap-2">
            <!-- Search box -->
         
            <div class="d-flex mb-2">
                <input 
                type="text" 
                name="search" 
                id="searchInput" 
                class="form-control" 
                placeholder="Search permissions...">
            </div>
            
            <!-- Add product button -->
            @can('create permission')
            <a href="{{ route('permissions.create') }}" class="btn btn-primary mb-2">
                <i class="bi bi-plus-lg"></i> Create Permission
            </a>
            @endcan
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <!-- Product table (load partial here) -->
    <div id="permissionTable">
        @include('permissions.partials.table', ['permissions' => $permissions])
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
                            fetchPermisions(1, $('#searchInput').val()); // reset to page 1
                        }, 300);
                    });

                    // Pagination with search term preserved
                    $(document).on('click', '#permissionTable .pagination a', function (e) {
                        e.preventDefault();
                        let page = $(this).attr('href').split('page=')[1];
                        let search = $('#searchInput').val();
                        fetchPermisions(page, search);
                    });

                    // AJAX fetch
                    function fetchPermisions(page = 1, search = "") {
                        $.ajax({
                            url: "{{ route('permissions.index') }}?page=" + page + "&search=" + search,
                            type: "GET",
                            success: function (data) {
                                $('#permissionTable').html(data);
                            },
                            error: function (xhr) {
                                console.error("Error loading permissions:", xhr.responseText);
                            }
                        });
                    }
                });

        </script>
    @endpush







@endsection
