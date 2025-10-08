@extends('layouts.app')
@section('title','Floors')
<x-navbar/>
@section('content')
<x-sidebar/>


<div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-2">
        <h2>Floor List</h2>
        <div class="d-flex gap-2">
            <input type="text" id="searchFloor" class="form-control" placeholder="Search..." style="max-width: 250px;">
            @can('create floor')
                <a href="{{ route('floors.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Add Floor
                </a>
            @endcan
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div id="floorTableContainer">
        @include('floors.partials.table', ['floors' => $floors])
    </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function () {

    // Search event
    $('#searchFloor').on('keyup', function () {
        fetchFloors($(this).val());
    });

    // Pagination (AJAX)
    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
        fetchFloors($('#searchFloor').val(), $(this).attr('href'));
    });

    function fetchFloors(query = '', url = "{{ route('floors.index') }}") {
        $.ajax({
            url: url,
            type: 'GET',
            data: { search: query },
            success: function (data) {
                $('#floorTableContainer').html(data);
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
