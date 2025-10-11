@extends('layouts.app')
@section('title','Seats')
<x-navbar/>
@section('content')
<x-sidebar/>

<div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Seats List</h2>
        @can('create seat')
        <a href="{{ route('seats.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Add Seat
        </a>
        @endcan
    </div>

    <!--  Search & Filters -->
    <div class="row g-2 mb-3">
        <div class="col-md-3">
            <label class="form-label fw-semibold text-dark">
                <i class="bi bi-houses me-1"></i> Building
            </label>
            <select id="buildingFilter" class="form-select select2">
                <option value="">All Buildings</option>
                @foreach($buildings as $building)
                    <option value="{{ $building->id }}">{{ $building->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold text-dark">
                <i class="bi bi-door-open me-1"></i> Flat
            </label>
            <select id="flatFilter" class="form-select select2">
                <option value="">All Flats</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold text-dark">
                <i class="bi bi-person-workspace me-1"></i> Room
            </label>
            <select id="roomFilter" class="form-select select2">
                <option value="">All Rooms</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label fw-semibold text-dark">
                <i class="bi bi-search me-1"></i> Search
            </label>
            <input type="text" id="searchInput" class="form-control" placeholder="Search seats...">
        </div>
    </div>


    <!--  Table -->
    <div id="seatTable">
        @include('seats.partials.table', ['seats' => $seats])
    </div>
</div>

    @push('scripts')
        <script>
                $(document).ready(function () {
                    function fetchSeats(page = 1) {
                        $.ajax({
                            url: "{{ route('seats.index') }}?page=" + page,
                            type: "GET",
                            data: {
                                search: $('#searchInput').val(),
                                building_id: $('#buildingFilter').val(),
                                flat_id: $('#flatFilter').val(),
                                room_id: $('#roomFilter').val(),
                            },
                            success: function (data) {
                                $('#seatTable').html(data);
                            }
                        });
                    }

                    // 🔹 Building → Flats
                    $('#buildingFilter').on('change', function () {
                        let buildingId = $(this).val();
                        $('#flatFilter').html('<option value="">All Flats</option>');
                        $('#roomFilter').html('<option value="">All Rooms</option>');
                        
                        if (buildingId) {
                            $.get('/buildings/' + buildingId + '/flats', function (data) {
                                data.forEach(flat => {
                                    $('#flatFilter').append(`<option value="${flat.id}">${flat.name}</option>`);
                                });
                            });
                        }
                        fetchSeats(1);
                    });

                    // 🔹 Flat → Rooms
                    $('#flatFilter').on('change', function () {
                        let flatId = $(this).val();
                        $('#roomFilter').html('<option value="">All Rooms</option>');
                        
                        if (flatId) {
                            $.get('/flats/' + flatId + '/rooms', function (data) {
                                data.forEach(room => {
                                    $('#roomFilter').append(`<option value="${room.id}">${room.name}</option>`);
                                });
                            });
                        }
                        fetchSeats(1);
                    });

                    // 🔹 Room change
                    $('#roomFilter').on('change', function () {
                        fetchSeats(1);
                    });

                    // 🔹 Search with debounce (delay 300ms)
                    let searchTimer;
                    $('#searchInput').on('keyup', function () {
                        clearTimeout(searchTimer);
                        searchTimer = setTimeout(() => {
                            fetchSeats(1);
                        }, 300);
                    });

                    // 🔹 Pagination
                    $(document).on('click', '#seatTable .pagination a', function (e) {
                        e.preventDefault();
                        let page = $(this).attr('href').split('page=')[1];
                        fetchSeats(page);
                    });
                                           
                });
        </script>
    @endpush

@endsection
