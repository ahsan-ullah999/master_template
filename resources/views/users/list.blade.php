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
         
<div class="d-flex mb-2 gap-2">
    <input 
        type="text" 
        name="search" 
        id="searchInput" 
        class="form-control" 
        placeholder="Search users...">

    <select id="sortSelect" class="form-select">
        <option value="latest">Latest</option>
        <option value="oldest">Oldest</option>
        <option value="role_asc">Role (A → Z)</option>
        <option value="role_desc">Role (Z → A)</option>
    </select>

    <select id="roleFilter" class="form-select">
        <option value="all">All Roles</option>
        @foreach($roles as $role)
            <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
        @endforeach
    </select>
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
            let delayTimer;

            // Search
            $('#searchInput').on('keyup', function () {
                clearTimeout(delayTimer);
                delayTimer = setTimeout(function() {
                    fetchUsers(1, $('#searchInput').val(), $('#sortSelect').val(), $('#roleFilter').val());
                }, 300);
            });

            // Sort
            $('#sortSelect').on('change', function () {
                fetchUsers(1, $('#searchInput').val(), $(this).val(), $('#roleFilter').val());
            });

            // Role filter
            $('#roleFilter').on('change', function () {
                fetchUsers(1, $('#searchInput').val(), $('#sortSelect').val(), $(this).val());
            });

            // Pagination
            $(document).on('click', '#userTable .pagination a', function (e) {
                e.preventDefault();
                let page = $(this).attr('href').split('page=')[1];
                fetchUsers(page, $('#searchInput').val(), $('#sortSelect').val(), $('#roleFilter').val());
            });

            // Fetch function
            function fetchUsers(page = 1, search = "", sort = "latest", role = "all") {
                $.ajax({
                    url: "{{ route('users.index') }}?page=" + page + "&search=" + search + "&sort=" + sort + "&role=" + role,
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
