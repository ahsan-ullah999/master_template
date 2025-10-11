{{-- Summary Cards --}}
<div class="row g-3 mb-4">
    <div class="col-md-4">
        <div class="card shadow-lg border-0 rounded-4 text-center"
             style="background: linear-gradient(135deg, #e3f2fd, #bbdefb); border-radius: 18px;">
            <div class="card-body">
                <i class="bi bi-basket2 text-primary" style="font-size: 2rem;"></i>
                <h6 class="text-muted mt-2 mb-1">Total Orders</h6>
                <h3 class="fw-bold text-primary mb-0">{{ $summary['totalOrders'] ?? 0 }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-lg border-0 rounded-4 text-center"
             style="background: linear-gradient(135deg, #e8f5e9, #c8e6c9); border-radius: 18px;">
            <div class="card-body">
                <i class="bi bi-egg-fried text-warning" style="font-size: 2rem;"></i>
                <h6 class="text-muted mt-2 mb-1">Total Meals</h6>
                <h3 class="fw-bold text-success mb-0">{{ $summary['totalMeals'] ?? 0 }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card shadow-lg border-0 rounded-4 text-center"
             style="background: linear-gradient(135deg, #e1f5fe, #b3e5fc); border-radius: 18px;">
            <div class="card-body">
                <i class="bi bi-check2-circle text-info" style="font-size: 2rem;"></i>
                <h6 class="text-muted mt-2 mb-1">Delivered</h6>
                <h3 class="fw-bold text-info mb-0">{{ $summary['delivered'] ?? 0 }}</h3>
            </div>
        </div>
    </div>
</div>

{{-- Orders Table --}}
@if($orders->isEmpty())
    <div class="alert alert-warning text-center shadow-sm border-0 mt-3" style="border-radius: 12px;">
        <i class="bi bi-exclamation-circle me-2"></i> No orders found for the selected filters.
    </div>
@else
<div class="table-responsive shadow-lg rounded-4"
     style="overflow: hidden; border: none; background: rgba(255,255,255,0.9);">
    <table class="table table-hover align-middle mb-0" 
           style="border-collapse: separate; border-spacing: 0; font-size: 0.95rem;">
        <thead style="background: linear-gradient(135deg, #007bff, #6610f2); color: white;">
            <tr>
                <th class="py-3 ps-3"><i class="bi bi-hash"></i></th>
                <th><i class="bi bi-person-circle me-1"></i> Member</th>
                <th><i class="bi bi-calendar3 me-1"></i> Date</th>
                <th><i class="bi bi-clock me-1"></i> Slot</th>
                <th><i class="bi bi-basket2 me-1"></i> Meals</th>
                <th><i class="bi bi-activity me-1"></i> Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $i => $o)
            <tr style="transition: all 0.2s ease;" 
                onmouseover="this.style.backgroundColor='#f1f8ff'" 
                onmouseout="this.style.backgroundColor='white'">
                <td class="fw-bold text-dark">{{ $orders->firstItem() + $i }}</td>
                <td class="fw-semibold text-dark">{{ $o->member->name ?? '-' }}</td>
                <td class="text-muted">{{ \Carbon\Carbon::parse($o->order_date)->format('d M, Y') }}</td>
                <td><span class="badge bg-secondary-subtle text-dark px-3 py-2 rounded-pill">{{ $o->slot->name ?? '-' }}</span></td>
                <td class="fw-semibold text-success"><i class="bi bi-egg-fried me-1 text-warning"></i>{{ $o->routine->product_count ?? 0 }}</td>
                <td>
                    @if($o->status === 'delivered')
                        <span class="badge bg-success px-3 py-2 rounded-pill"><i class="bi bi-check2-circle me-1"></i>Delivered</span>
                    @elseif($o->status === 'ordered' || $o->status === 'pending')
                        <span class="badge bg-info text-dark px-3 py-2 rounded-pill"><i class="bi bi-hourglass-split me-1"></i>Pending</span>
                    @else
                        <span class="badge bg-danger px-3 py-2 rounded-pill"><i class="bi bi-x-circle me-1"></i>{{ ucfirst($o->status) }}</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- Pagination (Bootstrap 5) --}}
@if($orders->hasPages())
    <div class="mt-3 d-flex justify-content-end">
        {{ $orders->links('pagination::bootstrap-5') }}
    </div>
@endif

@endif
