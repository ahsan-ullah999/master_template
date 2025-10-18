@extends('layouts.app')
@section('title','Groups')
<x-navbar/>
@section('content')
<x-sidebar/>
<div class="container mt-3">
    <div class="d-flex justify-content-between mb-2">
        <h2>Groups List</h2>
          <!-- Search box -->
          <div class="d-flex gap-2 mb-2">
                <div class="d-flex ">
                    <input 
                    type="text" 
                    name="search" 
                    id="searchInput" 
                    class="form-control" 
                    placeholder="Search groups...">
                </div>
                {{-- @can('create company') --}}
                    {{-- <a href="{{ route('groups.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i> Add Group
                    </a> --}}
                {{-- @endcan --}}

          </div>

    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
        <!-- Company table (load partial here) -->
    <div id="groupTable">
        @include('groups.partials.table', ['groups' => $groups])
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
                            fetchgroups(1, $('#searchInput').val()); // reset to page 1
                        }, 300);
                    });

                    // Pagination with search term preserved
                    $(document).on('click', '#groupTable .pagination a', function (e) {
                        e.preventDefault();
                        let page = $(this).attr('href').split('page=')[1];
                        let search = $('#searchInput').val();
                        fetchgroups(page, search);
                    });

                    // AJAX fetch
                    function fetchgroups(page = 1, search = "") {
                        $.ajax({
                            url: "{{ route('groups.index') }}?page=" + page + "&search=" + search,
                            type: "GET",
                            success: function (data) {
                                $('#groupTable').html(data);
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
