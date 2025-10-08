@extends('layouts.app')
@section('title','Flats')
<x-navbar/>
@section('content')
<x-sidebar/>

<div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <h2>Flats List</h2>
        <div class="d-flex gap-2">
            <input type="text" id="searchFlat" class="form-control" placeholder="Search..." style="max-width: 250px;">
            @can('create flat')
            <a href="{{ route('flats.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Add Flat
            </a>
            @endcan
        </div>
        

    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div id="flatTableContainer">
        @include('flats.partials.table', ['flats' => $flats])
    </div>

</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {

    // Search event
    $('#searchFlat').on('keyup', function () {
        fetchFlats($(this).val());
    });

    // Pagination (AJAX)
    $(document).on('click', '.pagination a', function (e) {
        e.preventDefault();
        fetchFlats($('#searchFlat').val(), $(this).attr('href'));
    });

    function fetchFlats(query = '', url = "{{ route('flats.index') }}") {
        $.ajax({
            url: url,
            type: 'GET',
            data: { search: query },
            success: function (data) {
                $('#flatTableContainer').html(data);
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
