@extends('layouts.app')
@section('title','Companies')
<x-navbar/>
@section('content')
<x-sidebar/>
<div class="container mt-3">
    <div class="d-flex justify-content-between mb-2">
        <h2>Companies</h2>
          <!-- Search box -->
          <div class="d-flex gap-2 mb-2">
                <div class="d-flex ">
                    <input 
                    type="text" 
                    name="search" 
                    id="searchInput" 
                    class="form-control" 
                    placeholder="Search companies...">
                </div>
                @can('create company')
                    <a href="{{ route('companies.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-lg"></i> Add Company
                    </a>
                @endcan

          </div>

    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
        <!-- Product table (load partial here) -->
    <div id="companyTable">
        @include('companies.partials.table', ['companies' => $companies])
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
                            fetchCompanies(1, $('#searchInput').val()); // reset to page 1
                        }, 300);
                    });

                    // Pagination with search term preserved
                    $(document).on('click', '#companyTable .pagination a', function (e) {
                        e.preventDefault();
                        let page = $(this).attr('href').split('page=')[1];
                        let search = $('#searchInput').val();
                        fetchCompanies(page, search);
                    });

                    // AJAX fetch
                    function fetchCompanies(page = 1, search = "") {
                        $.ajax({
                            url: "{{ route('companies.index') }}?page=" + page + "&search=" + search,
                            type: "GET",
                            success: function (data) {
                                $('#companyTable').html(data);
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
