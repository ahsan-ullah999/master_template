@extends('layouts.app')
@section('title', 'Member Dashboard')
<x-m_navbar/>
@section('content')
<x-m_sidebar/>

<div class="container py-4">

    {{-- 🔹 Company Branding + Clock --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-primary">
                <i class="bi bi-building"></i> {{ $shortProfile['company'] ?? 'My Company' }}
            </h4>
            <p class="text-muted mb-0"><b>Branch: </b>{{ $shortProfile['branch'] ?? '' }}</p>
            <p class="text-muted mb-0"><b>Building: </b>{{ $shortProfile['building'] ?? '' }}</p>
        </div>
        <div class="text-end">
            <h5 id="clock" class="text-dark fw-semibold">{{ $time }}</h5>
            <p class="text-muted small">{{ $formattedDate }}</p>
        </div>
    </div>

    {{-- 🔹 Personal Info --}}
    <div class="card shadow-sm mb-4 border-0 rounded-4">
        <div class="card-body">
            <h5 class="text-primary mb-3"><i class="bi bi-person-circle"></i> My Details</h5>
            <div class="row text-secondary">
                <div class="col-md-4"><strong>Name:</strong> {{ $shortProfile['name'] }}</div>
                <div class="col-md-4"><strong>Phone:</strong> {{ $shortProfile['phone'] }}</div>
                <div class="col-md-4"><strong>Email:</strong> {{ $shortProfile['email'] }}</div>
                <div class="col-md-4 mt-2"><strong>Seat:</strong> {{ $shortProfile['seat'] }}</div>

            </div>
        </div>
    </div>

{{-- 🔹 Meal Routines (Multiple Slots) --}}
<div class="card shadow-sm mb-4 border-0 rounded-4">
    <div class="card-body">
        <h5 class="text-primary mb-3"><i class="bi bi-calendar-event"></i> Today’s Meal Routines</h5>

        @if($routines->count())
            @foreach($routines as $routine)
                <div class="border rounded-3 p-3 mb-3 bg-light">
                    <h6 class="fw-semibold text-dark mb-1">
                        🍽️ {{ $routine->slot->name ?? 'Unnamed Slot' }}
                    </h6>
                    <p class="small text-muted mb-2">
                        <strong>Time:</strong>
                        {{ $routine->slot->start_time ?? '-' }} → {{ $routine->slot->end_time ?? '-' }}
                        <br>
                        <strong>Order Cutoff:</strong> {{ $routine->slot->order_cutoff_time ?? '-' }}
                    </p>

                    @if($routine->notes)
                        <p class="mb-2 text-secondary"><strong>Notes:</strong> {{ $routine->notes }}</p>
                    @endif

                    @if($routine->items->count())
                        <ul class="list-group">
                            @foreach($routine->items as $item)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        {{ $item->product->name ?? 'Unnamed Product' }}
                                        @if($item->alternative)
                                            <small class="text-muted">(Alt: {{ $item->alternative->name }})</small>
                                        @endif
                                    </div>
                                    @if($item->is_optional)
                                        <span class="badge bg-info text-dark">Optional</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted small mt-2">No items in this routine.</p>
                    @endif
                </div>
            @endforeach
        @else
            <p class="text-muted">No meal routines available for today.</p>
        @endif
    </div>
</div>



    {{-- 🔹 Today’s Meal Orders --}}
    <div class="card shadow-sm mb-4 border-0 rounded-4">
        <div class="card-body">
            <h5 class="text-primary mb-3"><i class="bi bi-basket"></i> Today’s Meal Orders</h5>
            @if($todayOrders->count())
                <ul class="list-group">
                    @foreach($todayOrders as $order)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ $order->routine->slot_id->name ?? 'Meal' }}</span>
                            <span class="badge bg-success">{{ ucfirst($order->status) }}</span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted">No orders today.</p>
            @endif
        </div>
    </div>

    {{-- 🔹 Notice Board (Current Month) --}}
    <div class="card shadow-sm mb-4 border-0 rounded-4">
        <div class="card-body">
            <h5 class="text-primary mb-3"><i class="bi bi-megaphone-fill"></i> Notice Board</h5>
            @if($notices->count())
                <ul class="list-group">
                    @foreach($notices as $notice)
                        <li class="list-group-item">
                            <strong>{{ $notice->title }}</strong>
                            <p class="small text-muted mb-0">{{ Str::limit($notice->details, 100) }}</p>
                            <small class="text-secondary">{{ $notice->created_at->format('d M, Y') }}</small>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-muted">No notices this month.</p>
            @endif
        </div>
    </div>

    {{-- 🔹 Developer’s Idea Section --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body">
            <h6 class="text-primary"><i class="bi bi-lightbulb-fill"></i> Developer’s Note</h6>
            <p class="text-muted small mb-0">
                “Keep your meals ordered on time to enjoy the best service. 
                For any issues, contact admin support directly.”
            </p>
        </div>
    </div>

</div>

<script>
    // ⏰ Live Clock Update
    setInterval(() => {
        const now = new Date();
        document.getElementById('clock').innerText =
            now.toLocaleTimeString([], {hour: '2-digit', minute: '2-digit', hour12: true});
    }, 60000);
</script>
@endsection

