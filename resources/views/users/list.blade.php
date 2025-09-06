@extends('layouts.app')
@section('title','Users')
<x-navbar/>
@section('content')
<x-sidebar/>
<div class="container mt-3">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h2>Users List</h2>

        <div class="d-flex align-items-center gap-2">
            <!-- Search box -->
         
            <div class="d-flex mb-2">
                <input 
                type="text" 
                name="search" 
                id="searchInput" 
                class="form-control" 
                placeholder="Search users...">
            </div>
            
            <!-- Add product button -->
            @can('create user')
            <a href="{{ route('users.create') }}" class="btn btn-primary mb-2">
                <i class="bi bi-plus-lg"></i> Create Users
            </a>
            @endcan
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <!-- Product table (load partial here) -->
    <div id="userTable">
        @include('users.partials.table', ['users' => $users])
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
                            fetchUsers(1, $('#searchInput').val()); // reset to page 1
                        }, 300);
                    });

                    // Pagination with search term preserved
                    $(document).on('click', '#userTable .pagination a', function (e) {
                        e.preventDefault();
                        let page = $(this).attr('href').split('page=')[1];
                        let search = $('#searchInput').val();
                        fetchUsers(page, search);
                    });

                    // AJAX fetch
                    function fetchUsers(page = 1, search = "") {
                        $.ajax({
                            url: "{{ route('users.index') }}?page=" + page + "&search=" + search,
                            type: "GET",
                            success: function (data) {
                                $('#userTable').html(data);
                            },
                            error: function (xhr) {
                                console.error("Error loading users:", xhr.responseText);
                            }
                        });
                    }
                });

        </script>
    @endpush
@endsection
