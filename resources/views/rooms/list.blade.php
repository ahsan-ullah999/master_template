@extends('layouts.app')
@section('title','Rooms')
<x-navbar/>
@section('content')
<x-sidebar/>

<div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center mb-2 flex-wrap gap-2">
        <h2>Room List</h2>
        <div class="d-flex gap-2">
            <input type="text" id="searchRoom" class="form-control" placeholder="Search..." style="max-width: 250px;">
            @can('create room')
                <a href="{{ route('rooms.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> Add Room
                </a>
            @endcan
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div id="roomTableContainer">
        @include('rooms.partials.table', ['rooms' => $rooms])
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {

    // Search event
    $('#searchRoom').on('keyup', function () {
        fetchRooms($(this).val());
    });

    // Pagination (AJAX)
    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
        fetchRooms($('#searchRoom').val(), $(this).attr('href'));
    });

    function fetchRooms(query = '', url = "{{ route('rooms.index') }}") {
        $.ajax({
            url: url,
            type: 'GET',
            data: { search: query },
            success: function (data) {
                $('#roomTableContainer').html(data);
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