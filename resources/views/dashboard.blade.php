@extends('layouts.app')
@section('title', 'Dashboard')
<x-navbar/>

@section('content')
<x-sidebar/>

<div class="container-fluid mt-3">
    <h3 class="mb-4">Dashboard</h3>


      <!-- ========== FILTERS (Enhanced with colorful body) ========== -->
      <div class="card shadow-lg border-0 mb-4" style="border-radius: 15px;">
          <!-- Card Header -->
          <div class="card-header fw-bold text-white" 
              style="background: linear-gradient(135deg, #007bff, #6610f2); border-radius: 15px 15px 0 0;">
              <i class="bi bi-funnel-fill me-2"></i> Search Filters
          </div>

          <!-- Card Body with soft background -->
          <div class="card-body" 
              style="background: linear-gradient(145deg, #f8f9fa, #eef2f7); border-radius: 0 0 15px 15px;">

              <form id="filterForm" class="row g-3 align-items-end">

                  <!-- Company -->
                  <div class="col-md-2">
                      <label class="form-label fw-semibold text-primary">
                          <i class="bi bi-building me-1"></i> Company
                      </label>
                      <select name="company_id" id="company_id" 
                              class="form-select shadow-sm border-primary" 
                              style="background-color:#e9f3ff; border-radius:10px;">
                          <option value="">All</option>
                          @foreach($companies as $company)
                              <option value="{{ $company->id }}">{{ $company->name }}</option>
                          @endforeach
                      </select>
                  </div>

                  <!-- Branch -->
                  <div class="col-md-2">
                      <label class="form-label fw-semibold text-info">
                          <i class="bi bi-diagram-3 me-1"></i> Branch
                      </label>
                      <select name="branch_id" id="branch_id" 
                              class="form-select shadow-sm border-info" 
                              style="background-color:#e9f9ff; border-radius:10px;">
                          <option value="">All</option>
                      </select>
                  </div>

                  <!-- Building -->
                  <div class="col-md-2">
                      <label class="form-label fw-semibold text-success">
                          <i class="bi bi-houses me-1"></i> Building
                      </label>
                      <select name="building_id" id="building_id" 
                              class="form-select shadow-sm border-success" 
                              style="background-color:#eaffea; border-radius:10px;">
                          <option value="">All</option>
                      </select>
                  </div>

                  <!-- Floor -->
                  <div class="col-md-2">
                      <label class="form-label fw-semibold text-warning">
                          <i class="bi bi-layers me-1"></i> Floor
                      </label>
                      <select name="floor_id" id="floor_id" 
                              class="form-select shadow-sm border-warning" 
                              style="background-color:#fff8e5; border-radius:10px;">
                          <option value="">All</option>
                      </select>
                  </div>

                  <!-- Flat -->
                  <div class="col-md-2">
                      <label class="form-label fw-semibold text-danger">
                          <i class="bi bi-door-open me-1"></i> Flat
                      </label>
                      <select name="flat_id" id="flat_id" 
                              class="form-select shadow-sm border-danger" 
                              style="background-color:#ffeaea; border-radius:10px;">
                          <option value="">All</option>
                      </select>
                  </div>

                  <!-- Room -->
                  <div class="col-md-2">
                      <label class="form-label fw-semibold text-dark">
                          <i class="bi bi-person-workspace me-1"></i> Room
                      </label>
                      <select name="room_id" id="room_id" 
                              class="form-select shadow-sm border-dark" 
                              style="background-color:#f2f2f2; border-radius:10px;">
                          <option value="">All</option>
                      </select>
                  </div>

                  <!-- Apply Button -->
                  <div class="col-md-2 text-end">
                      <button type="button" id="applyFilter" 
                              class="btn btn-gradient w-100 fw-bold shadow-sm" 
                              style="border-radius: 12px;
                                    background: linear-gradient(135deg, #007bff, #6610f2);
                                    color:white;">
                          <i class="bi bi-search me-1"></i> Apply
                      </button>
                  </div>
              </form>
          </div>
      </div>


      <!-- ========== STATS CARDS (Redesigned) ========== -->
      <div class="app-content">
        <div class="container-fluid">
          <div class="row g-3">

            <!-- Total Members -->
            <div class="col-lg-4 col-md-6">
              <div class="card shadow-lg border-0 h-100" 
                  style="border-radius: 18px; background: linear-gradient(135deg, #fceabb, #f8b500); color:#2c2c2c;">
                <div class="card-body d-flex align-items-center justify-content-between p-4">
                  <div>
                    <h2 class="display-6 fw-bold mb-1" id="totalMembers">0</h2>
                    <p class="mb-0 fw-semibold">Total Members</p>
                  </div>
                  <div class="rounded-circle d-flex align-items-center justify-content-center"
                      style="width:60px;height:60px;background:rgba(255,255,255,0.4);">
                    <i class="bi bi-person-circle fs-2"></i>
                  </div>
                </div>
                <a href="{{ route('members.index') }}" 
                  class="card-footer text-center small text-dark fw-semibold text-decoration-none py-2"
                  style="background: rgba(255,255,255,0.3); border-top: none; border-radius: 0 0 18px 18px;">
                  More info <i class="bi bi-arrow-right-circle-fill ms-1"></i>
                </a>
              </div>
            </div>

            <!-- Last Day Orders -->
            <div class="col-lg-4 col-md-6">
              <div class="card shadow-lg border-0 h-100" 
                  style="border-radius: 18px; background: linear-gradient(135deg, #1e3c72, #2a5298); color:white;">
                <div class="card-body d-flex align-items-center justify-content-between p-4">
                  <div>
                    <h2 class="display-6 fw-bold mb-1" id="lastDayOrders">0</h2>
                    <p class="mb-0 fw-semibold">Last Day Orders</p>
                  </div>
                  <div class="rounded-circle d-flex align-items-center justify-content-center"
                      style="width:60px;height:60px;background:rgba(255,255,255,0.25);">
                    <i class="bi bi-basket fs-2"></i>
                  </div>
                </div>
                <a href="{{ route('product_orders.index', ['order_date' => now()->subDay()->toDateString()]) }}" 
                  class="card-footer text-center small text-white fw-semibold text-decoration-none py-2"
                  style="background: rgba(255,255,255,0.2); border-top: none; border-radius: 0 0 18px 18px;">
                  More info <i class="bi bi-arrow-right-circle-fill ms-1"></i>
                </a>
              </div>
            </div>

            <!-- Delivered Meals -->
            <div class="col-lg-4 col-md-6">
              <div class="card shadow-lg border-0 h-100" 
                  style="border-radius: 18px; background: linear-gradient(135deg, #11998e, #38ef7d); color:white;">
                <div class="card-body d-flex align-items-center justify-content-between p-4">
                  <div>
                    <h2 class="display-6 fw-bold mb-1" id="deliveredMeals">0</h2>
                    <p class="mb-0 fw-semibold">Last Day Delivered Meals</p>
                  </div>
                  <div class="rounded-circle d-flex align-items-center justify-content-center"
                      style="width:60px;height:60px;background:rgba(255,255,255,0.25);">
                    <i class="bi bi-check-circle fs-2"></i>
                  </div>
                </div>
                <a href="{{ route('product_orders.index', [
                                    'order_date' => now()->subDay()->toDateString(),
                                    'status' => 'delivered'
                                ]) }}" 
                  class="card-footer text-center small text-white fw-semibold text-decoration-none py-2"
                  style="background: rgba(255,255,255,0.2); border-top: none; border-radius: 0 0 18px 18px;">
                  More info <i class="bi bi-arrow-right-circle-fill ms-1"></i>
                </a>
              </div>
            </div>

          </div>
        </div>
      </div>

    <div class="row mt-4" id="routineCards">

          {{-- Today's Meals --}}
          <div class="col-lg-6 mb-3">
              <div class="card shadow-lg border-0 h-100" style="border-radius: 18px; overflow: hidden;">
                  <div class="card-header d-flex justify-content-between align-items-center text-white"
                      style="background: linear-gradient(135deg, #198754, #28a745); padding: 1rem 1.2rem; border: none;">
                      <h5 class="mb-0 fw-bold"><i class="bi bi-calendar-check me-2"></i>Today's Meals</h5>
                      <span class="badge bg-light text-dark px-3 py-2" style="font-size: 0.85rem;">
                          {{ now()->toFormattedDateString() }}
                      </span>
                  </div>
                  <div class="card-body p-4" id="todayMealsBody">
                      <div class="text-center text-muted">
                          <i class="bi bi-hourglass-split fs-3 d-block mb-2"></i>
                          <p class="mb-0">Loading...</p>
                      </div>
                  </div>
                  <div class="card-footer bg-light text-center small text-muted" style="border-top: 1px solid #eee;">
                      <i class="bi bi-info-circle me-1"></i> Updated automatically
                  </div>
              </div>
          </div>

          {{-- Next Day Meals --}}
          <div class="col-lg-6 mb-3">
              <div class="card shadow-lg border-0 h-100" style="border-radius: 18px; overflow: hidden;">
                  <div class="card-header d-flex justify-content-between align-items-center text-white"
                      style="background: linear-gradient(135deg, #0d6efd, #1d4ed8); padding: 1rem 1.2rem; border: none;">
                      <h5 class="mb-0 fw-bold"><i class="bi bi-calendar-event me-2"></i>Next Day Meals</h5>
                      <span class="badge bg-light text-dark px-3 py-2" style="font-size: 0.85rem;">
                          {{ now()->addDay()->toFormattedDateString() }}
                      </span>
                  </div>
                  <div class="card-body p-4" id="nextMealsBody">
                      <div class="text-center text-muted">
                          <i class="bi bi-hourglass-split fs-3 d-block mb-2"></i>
                          <p class="mb-0">Loading...</p>
                      </div>
                  </div>
                  <div class="card-footer bg-light text-center small text-muted" style="border-top: 1px solid #eee;">
                      <i class="bi bi-info-circle me-1"></i> Updated automatically
                  </div>
              </div>
          </div>
    </div>


    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-lg border-0" style="border-radius: 18px; overflow: hidden;">

                <!-- Card Header -->
                <div class="card-header d-flex justify-content-between align-items-center text-white"
                    style="background: linear-gradient(135deg, #65a1fc, #032557); padding: 1rem 1.2rem; border: none;">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-building me-2"></i> Registered Companies
                    </h5>
                    <span class="badge bg-light text-dark px-3 py-2 shadow-sm" style="font-size: 0.85rem; border-radius: 12px;">
                        Total: {{ $companies->count() }}
                    </span>
                </div>

                <!-- Card Body -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle mb-0">
                            <thead class="text-white" style="background: linear-gradient(135deg, #6c757d, #495057);">
                                <tr>
                                    <th class="py-3 ps-4">SL.</th>
                                    <th class="py-3">Company Name</th>
                                    <th class="py-3">Business Code</th>
                                    <th class="py-3">Email</th>
                                    <th class="py-3 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($companies as $index => $company)
                                <tr>
                                    <td class="py-3 ps-4 fw-semibold text-muted">{{ $index + 1 }}</td>
                                    <td class="py-3 fw-bold text-dark">
                                        <i class="bi bi-building-check text-primary me-1"></i>
                                        {{ $company->name }}
                                    </td>
                                    <td class="py-3 text-secondary">{{ $company->business_code }}</td>
                                    <td class="py-3">
                                        <i class="bi bi-envelope-at text-success me-1"></i>
                                        {{ $company->email }}
                                    </td>
                                    <td class="py-3 text-center">
                                        <a href="{{ route('companies.show', $company) }}" 
                                        class="btn btn-sm btn-outline-primary shadow-sm rounded-pill px-3">
                                            <i class="bi bi-eye-fill me-1"></i> View
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="bi bi-exclamation-triangle text-warning me-1"></i> No companies found.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
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

    // ================= Routine Meals Loader (Today + Next Day) =================
    function loadRoutineMeals() {
        $.ajax({
            url: "{{ route('dashboard.routineMeals') }}",
            success: function (data) {
                const renderMeals = (meals, containerId) => {
                    const container = $(`#${containerId}`);
                    if (!meals.length) {
                        container.html(`<p class="text-muted mb-0">No meals available.</p>`);
                        return;
                    }
                    let html = `<div class="list-group">`;
                    meals.forEach(r => {
                        html += `
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>${r.slot ? r.slot.name : 'Unknown Slot'}</strong><br>
                                    <small class="text-muted">Count: ${r.product_count ?? '-'}</small>
                                </div>
                                <a href="/routines/${r.id}" class="btn btn-sm btn-primary">View</a>
                            </div>
                        `;
                    });
                    html += `</div>`;
                    container.html(html);
                };

                renderMeals(data.today, 'todayMealsBody');
                renderMeals(data.tomorrow, 'nextMealsBody');
            },
            error: function () {
                $('#todayMealsBody').html('<p class="text-danger">Error loading meals.</p>');
                $('#nextMealsBody').html('<p class="text-danger">Error loading meals.</p>');
            }
        });
    }

    // ================= Event Bindings =================
    $('#applyFilter').on('click', function () {
        loadStats();
    });

    // 🔹 Load everything immediately on page load
    loadStats();
    loadRoutineMeals();
});
</script>
@endpush


