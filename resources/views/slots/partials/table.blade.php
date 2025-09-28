<div class="row">
    @forelse($slots as $slot)
        <div class="col-12 mb-3">
            <div class="card shadow-sm border-0">
                <div class="row g-0 align-items-center">

                    <!-- Slot Info -->
                    <div class="col-md-9 p-3">
                        <h5 class="fw-bold text-dark mb-1">{{ ($slot->name )}}</h5>
                        <p class="mb-1 text-bold">
                            <strong>Start:</strong> {{ $slot->start_time ?? '-' }} | 
                            <strong>End:</strong> {{ $slot->end_time ?? '-' }} | 
                            <strong>Cutoff:</strong> {{ $slot->order_cutoff_time ?? '-' }}
                        </p>
                        <p class="small text-muted">
                            <strong>Status:</strong> 
                            <span class="badge {{ $slot->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($slot->status) }}
                            </span>
                        </p>
                    </div>

                    <!-- Actions -->
                    <div class="col-md-3 text-end p-3">
                        @can('edit slot')
                        <a href="{{ route('slots.edit', $slot->id) }}" 
                           class="btn btn-sm btn-warning mb-1 w-100">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        @endcan

                        @can('delete slot')
                        <form id="deleteForm{{ $slot->id }}" action="{{ route('slots.destroy', $slot->id) }}" 
                              method="POST" class="d-inline w-100">
                            @csrf @method('DELETE')
                            <button type="button" class="btn btn-sm btn-danger w-100 btn-delete"
                                    data-form="#deleteForm{{ $slot->id }}">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </form>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="alert alert-secondary text-center">
                No slots found
            </div>
        </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="mt-3">
    {{ $slots->links() }}
</div>
