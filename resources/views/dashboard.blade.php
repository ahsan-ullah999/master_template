@extends('layouts.app')
@section('title', 'Dashboard')
<x-navbar/>

@section('content')
<x-sidebar/>

<div class="container-fluid mt-3">
    <h3 class="mb-4">Dashboard</h3>

    <!-- ========== FILTERS ========== -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form id="filterForm" class="row g-2 align-items-end">
                <div class="col-md-2">
                    <label class="form-label">Company</label>
                    <select name="company_id" id="company_id" class="form-select select2">
                        <option value="">All</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Branch</label>
                    <select name="branch_id" id="branch_id" class="form-select select2">
                        <option value="">All</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Building</label>
                    <select name="building_id" id="building_id" class="form-select select2">
                        <option value="">All</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Floor</label>
                    <select name="floor_id" id="floor_id" class="form-select select2">
                        <option value="">All</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Flat</label>
                    <select name="flat_id" id="flat_id" class="form-select select2">
                        <option value="">All</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Room</label>
                    <select name="room_id" id="room_id" class="form-select select2">
                        <option value="">All</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="button" id="applyFilter" class="btn btn-primary w-100">Apply</button>
                </div>
            </form>
        </div>
    </div>

    <!-- ========== STATS CARDS ========== -->
    <div class="app-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                <!--begin::Small Box Widget 3-->
                    <div class="small-box text-bg-warning">
                    <div class="inner">
                        <h3 id="totalMembers">0</h3>
                        <p>Total Members</p>
                    </div>
                    <svg
                        class="small-box-icon"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg"
                        aria-hidden="true"
                    >
                        <path
                        d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z"
                        ></path>
                    </svg>
                    <a
                        href="{{ route('members.index') }}"
                        class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover"
                    >
                        More info <i class="bi bi-link-45deg"></i>
                    </a>
                    </div>
                <!--end::Small Box Widget 3-->
              </div>
              <div class="col-lg-3 col-6">
                <!--begin::Small Box Widget 1-->
                <div class="small-box text-bg-primary">
                  <div class="inner">
                    <h3 id="lastDayOrders">0</h3>
                    <p>Last Day Orders</p>
                  </div>
                  <svg
                    class="small-box-icon"
                    fill="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true"
                  >
                    <path
                      d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z"
                    ></path>
                  </svg>
                  <a
                    href="{{ route('product_orders.index', ['order_date' => now()->subDay()->toDateString()]) }}"
                    class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover"
                  >
                    More info <i class="bi bi-link-45deg"></i>
                  </a>
                </div>
                <!--end::Small Box Widget 1-->
              </div>
              <div class="col-lg-3 col-6">
                <!--begin::Small Box Widget 2-->
                <div class="small-box text-bg-primary">
                  <div class="inner">
                    <h3 id="deliveredMeals">0</h3>
                    <p>Last Day Delivered Meals</p>
                  </div>
                  <svg
                    class="small-box-icon"
                    fill="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true"
                  >
                    <path
                      d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z"
                    ></path>
                  </svg>
                  <a href="{{ route('product_orders.index', [
                          'order_date' => now()->subDay()->toDateString(),
                          'status' => 'delivered'
                      ]) }}"
                    class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                      More info <i class="bi bi-link-45deg"></i>
                  </a>
                </div>
                <!--end::Small Box Widget 2-->
              </div>
              <div class="col-lg-3 col-6">
                <!--begin::Small Box Widget 2-->
                <div class="small-box text-bg-success">
                  <div class="inner">
                    <h3  id="daysMeal">0</h3>
                    <p>Todays Meals</p>
                  </div>
                  <svg
                    class="small-box-icon"
                    fill="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true"
                  >
                    <path
                      d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z"
                    ></path>
                  </svg>
                 {{-- Today’s Meals --}}
                  <a href="{{ route('routines.index', ['date' => now()->toDateString()]) }}"
                    class="small-box-footer link-light">
                    More info <i class="bi bi-link-45deg"></i>
                  </a>
                </div>
                <!--end::Small Box Widget 2-->
              </div>
              <div class="col-lg-3 col-6">
                <!--begin::Small Box Widget 2-->
                <div class="small-box text-bg-success">
                  <div class="inner">
                    <h3  id="nextDayMeal">0</h3>
                    <p>Next Day Meal</p>
                  </div>
                  <svg
                    class="small-box-icon"
                    fill="currentColor"
                    viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg"
                    aria-hidden="true"
                  >
                    <path
                      d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z"
                    ></path>
                  </svg>
                  {{-- Next Day Meals --}}
                  <a href="{{ route('routines.index', ['date' => now()->addDay()->toDateString()]) }}"
                    class="small-box-footer link-light">
                    More info <i class="bi bi-link-45deg"></i>
                  </a>
                </div>
                <!--end::Small Box Widget 2-->
              </div>
                <!--end::Small Box Widget 1-->
              </div>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $('.select2').select2({ width: '100%', allowClear: true });

    // ================= Dependent dropdowns =================
    $('#company_id').on('change', function() {
        let companyId = $(this).val();
        $('#branch_id').html('<option value="">All</option>');
        if (companyId) {
            $.get("{{ url('members/deps/branches') }}/" + companyId, function(data) {
                data.forEach(branch => {
                    $('#branch_id').append(`<option value="${branch.id}">${branch.name}</option>`);
                });
            });
        }
    });

    $('#branch_id').on('change', function() {
        let id = $(this).val();
        $('#building_id').html('<option value="">All</option>');
        if (id) {
            $.get("{{ url('members/deps/buildings') }}/" + id, function(data) {
                data.forEach(item => {
                    $('#building_id').append(`<option value="${item.id}">${item.name}</option>`);
                });
            });
        }
    });

    $('#building_id').on('change', function() {
        let id = $(this).val();
        $('#floor_id').html('<option value="">All</option>');
        if (id) {
            $.get("{{ url('members/deps/floors') }}/" + id, function(data) {
                data.forEach(item => {
                    $('#floor_id').append(`<option value="${item.id}">${item.name}</option>`);
                });
            });
        }
    });

    $('#floor_id').on('change', function() {
        let id = $(this).val();
        $('#flat_id').html('<option value="">All</option>');
        if (id) {
            $.get("{{ url('members/deps/flats') }}/" + id, function(data) {
                data.forEach(item => {
                    $('#flat_id').append(`<option value="${item.id}">${item.name}</option>`);
                });
            });
        }
    });

    $('#flat_id').on('change', function() {
        let id = $(this).val();
        $('#room_id').html('<option value="">All</option>');
        if (id) {
            $.get("{{ url('members/deps/rooms') }}/" + id, function(data) {
                data.forEach(item => {
                    $('#room_id').append(`<option value="${item.id}">${item.name}</option>`);
                });
            });
        }
    });

    // ================= Stats Loader =================
    function loadStats() {
        $.ajax({
            url: "{{ route('dashboard.stats') }}",
            data: $('#filterForm').serialize(),
            success: function (data) {
                $('#totalMembers').text(data.totalMembers);
                $('#todaysMeals').text(data.todaysMeals);
                $('#nextDayMeals').text(data.nextDayMeals);
                $('#lastDayOrders').text(data.lastDayOrders);
                $('#deliveredMeals').text(data.deliveredMeals);
            }

        });
    }

    // On button click
    $('#applyFilter').on('click', function () {
        loadStats();
    });

    // 🔹 Load stats immediately on page load
    loadStats();
});
</script>
@endpush

