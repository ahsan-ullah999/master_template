@extends('layouts.app')
@section('title','Routines')
<x-navbar/>
@section('content')
<x-sidebar/>

<div class="container mt-3">

    <div class="d-flex justify-content-between align-items-center mb-2">
        <h2>Routine List</h2>

        <div class="d-flex align-items-center gap-2">
            <!-- Search -->
            <div class="d-flex mb-2">
                <input type="text" id="searchInput" class="form-control" placeholder="Search routines...">
            </div>

            <!-- Sort -->
            <div class="d-flex mb-2">
                <select id="sortSelect" class="form-select">
                    <option value="latest">Latest</option>
                    <option value="oldest">Oldest</option>
                </select>
            </div>

            <!-- Add button -->
            @can('create routine')
            <a href="{{ route('routines.create') }}" class="btn btn-primary mb-2">
                <i class="bi bi-plus-lg"></i> Add Routine
            </a>
            @endcan
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Table -->
    <div id="routineTable">
        @include('routines.partials.table', ['routines' => $routines])
    </div>
</div>

    @push('scripts')
    <script>
    $(document).ready(function () {
        let delayTimer;

        $('#searchInput').on('keyup', function () {
            clearTimeout(delayTimer);
            delayTimer = setTimeout(() => {
                fetchRoutines(1, $('#searchInput').val(), $('#sortSelect').val());
            }, 300);
        });

        $('#sortSelect').on('change', function () {
            fetchRoutines(1, $('#searchInput').val(), $(this).val());
        });

        $(document).on('click', '#routineTable .pagination a', function (e) {
            e.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            fetchRoutines(page, $('#searchInput').val(), $('#sortSelect').val());
        });

        function fetchRoutines(page = 1, search = "", sort = "latest") {
            $.ajax({
                url: "{{ route('routines.index') }}?page=" + page + "&search=" + search + "&sort=" + sort,
                type: "GET",
                success: data => $('#routineTable').html(data),
                error: xhr => console.error("Error:", xhr.responseText)
            });
        }
    });
    </script>
    @endpush
@endsection
