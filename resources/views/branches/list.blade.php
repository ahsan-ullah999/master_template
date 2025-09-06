@extends('layouts.app')
@section('title','Branches')
<x-navbar/>
@section('content')
<x-sidebar/>

<div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h2>Branches</h2>
        <div class="d-flex gap-2 mb-2">
            <div class="d-flex ">
                <input 
                type="text" 
                name="search" 
                id="searchInput" 
                class="form-control" 
                placeholder="Search branches...">
            </div>
            @can('create branch')
            <a href="{{ route('branches.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Add Branch
            </a>
            @endcan

        </div>

    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

            <!-- branch table (load partial here) -->
    <div id="branchTable">
        @include('branches.partials.table', ['branches' => $branches])
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
                            fetchBranches(1, $('#searchInput').val()); // reset to page 1
                        }, 300);
                    });

                    // Pagination with search term preserved
                    $(document).on('click', '#branchTable .pagination a', function (e) {
                        e.preventDefault();
                        let page = $(this).attr('href').split('page=')[1];
                        let search = $('#searchInput').val();
                        fetchBranches(page, search);
                    });

                    // AJAX fetch
                    function fetchBranches(page = 1, search = "") {
                        $.ajax({
                            url: "{{ route('branches.index') }}?page=" + page + "&search=" + search,
                            type: "GET",
                            success: function (data) {
                                $('#branchTable').html(data);
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
