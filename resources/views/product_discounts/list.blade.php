@extends('layouts.app')
@section('title','Meal Discounts')
<x-navbar/>
@section('content')
<x-sidebar/>

<div class="container mt-3">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Meal Discounts</h2>
        @can('create discount')
            <a href="{{ route('product-discounts.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Add Discount
            </a>
        @endcan
        
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>No.</th>
                    <th>Min Count</th>
                    <th>Max Count</th>
                    <th>Minimum Subtotal</th>
                    <th>Discount</th>
                    <th>Status</th>
                    @canany(['edit discount', 'delete discount'])
                        <th>Actions</th>
                    @endcanany                 
                </tr>
            </thead>
            <tbody>
                @forelse($discounts as $discount)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $discount->min_count }}</td>
                    <td>{{ $discount->max_count ?? '∞' }}</td>
                    <td>{{ $discount->min_subtotal,2 }} tk</td>
                    <td>
                        @if($discount->discount_type === 'percent')
                            {{ number_format($discount->discount_amount, 2) }}%
                        @else
                            {{ number_format($discount->discount_amount, 2) }} Tk
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ $discount->active ? 'bg-success' : 'bg-secondary' }}">
                            {{ $discount->active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td>
                        @can('edit discount')
                            <a href="{{ route('product-discounts.edit', $discount->id) }}" class="btn btn-sm btn-primary">
                            <i class="bi bi-pencil-square"></i>
                            </a>
                        @endcan
                        @can('delete discount')
                            <form id="deleteForm{{ $discount->id }}" action="{{ route('product-discounts.destroy',$discount->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm btn-delete" data-form="#deleteForm{{ $discount->id }}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        @endcan
                        
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center text-muted">No discounts found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-3">
        {{ $discounts->links() }}
    </div>
</div>
@endsection
