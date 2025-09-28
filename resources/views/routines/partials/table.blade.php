<div class="row">
    @forelse($routines as $routine)
        <div class="col-12 mb-3">
            <div class="card shadow-sm border-0">
                <div class="row g-0 align-items-center">
                    <div class="col-md-8 p-3">
                        <h5 class="fw-bold mb-1">
                            {{ $routine->slot->name ?? 'No Slot' }}
                            @if($routine->items->count())
                                • @foreach($routine->items as $it)
                                    <span class="small badge bg-light text-dark me-1">{{ $it->product->name }}</span>
                                  @endforeach
                            @endif
                        </h5>
                        <p class="mb-1 text-muted">
                            <strong>Day:</strong> {{ $routine->dayName() }} |
                            <strong>Date:</strong> {{ $routine->date ?? '-' }} |
                            <strong>Building:</strong> {{ $routine->building->name ?? '-' }}
                        </p>
                        <p class="small text-muted">
                            <strong>Count:</strong> {{ $routine->product_count ?? $routine->items->count() }}
                        </p>
                    </div>                  
                    <div class="col-md-4 text-end p-3">
                        @can('view routine')
                            <a href="{{ route('routines.show', $routine->id) }}" class="btn btn-sm btn-outline-primary mb-1 w-100">
                            <i class="bi bi-eye"></i> View
                            </a>
                        @endcan
                        @can('edit routine')
                        <a href="{{ route('routines.edit', $routine->id) }}" class="btn btn-sm btn-warning w-100 mb-1">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        @endcan

                        @can('delete routine')
                        <form id="deleteForm{{ $routine->id }}" action="{{ route('routines.destroy',$routine->id) }}" method="POST" class="d-inline w-100">
                            @csrf @method('DELETE')
                            <button type="button" class="btn btn-sm btn-danger w-100 btn-delete" data-form="#deleteForm{{ $routine->id }}">
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
            <div class="alert alert-secondary text-center">No routines found</div>
        </div>
    @endforelse
</div>

<div class="mt-3">
    {{ $routines->links() }}
</div>
