@extends('layouts.app')
@section('title','Buildings')
<x-navbar/>
@section('content')
<x-sidebar/>

<div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h2>Building List</h2>
        <div class="d-flex gap-2">
            <input type="text" id="searchBuilding" class="form-control" placeholder="Search..." style="max-width: 250px;">
            @can('create building')
            <a href="{{ route('buildings.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Add Building
            </a>
            @endcan
        </div>


    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div id="buildingTableContainer">
        @include('buildings.partials.table', ['buildings' => $buildings])
    </div>
</div>
@endsection


@push('scripts')
<script>
$(document).ready(function () {

    // Search event
    $('#searchBuilding').on('keyup', function () {
        fetchBuildings($(this).val());
    });

    // Pagination (AJAX)
    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
        fetchBuildings($('#searchBuilding').val(), $(this).attr('href'));
    });

    function fetchBuildings(query = '', url = "{{ route('buildings.index') }}") {
        $.ajax({
            url: url,
            type: 'GET',
            data: { search: query },
            success: function (data) {
                $('#buildingTableContainer').html(data);
            }
        });
    }

    // SweetAlert for delete buttons
    $(document).on('click', '.btn-delete', function () {
        let form = $(this).data('form');
        Swal.fire({
            title: 'Delete this record?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
        }).then((result) => {
            if (result.isConfirmed) $(form).submit();
        });
    });
});
</script>
@endpush
