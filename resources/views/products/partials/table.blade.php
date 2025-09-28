<div class="row">
    @forelse($products as $product)
        <div class="col-12 mb-3">
            <div class="card shadow-sm border-0">
                <div class="row g-0 align-items-center">
                    <!-- Product Image -->
                    <div class="col-md-3 text-center p-2">
                        @if($product->image)
                            <img src="{{ asset('storage/'.$product->image) }}" 
                                 class="img-fluid rounded" 
                                 style="max-height:150px; object-fit:cover;">
                        @else
                            <img src="https://via.placeholder.com/150" 
                                 class="img-fluid rounded" 
                                 alt="No image">
                        @endif
                    </div>

                    <!-- Product Info -->
                    <div class="col-md-6 p-3">
                        <h5 class="fw-bold text-dark mb-1">{{ $product->name }}</h5>
                        <p class="mb-1 text-muted">
                            <strong>Price:</strong> {{ $product->price ?? 'N/A' }}
                        </p>
                        <p class="mb-1 text-muted">
                            <strong>Code:</strong> {{ $product->code ?? 'N/A' }}
                        </p>
                        <p class="small text-muted">
                            <strong>Description:</strong> {{ $product->description ?? 'Some short description can go here (optional if you add description field).' }}                           
                        </p>
                    </div>

                    <!-- Actions -->
                    <div class="col-md-3 text-end p-3">
                        @can('edit product')
                        <a href="{{ route('products.edit', $product->id) }}" 
                           class="btn btn-sm btn-warning mb-1 w-100">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        @endcan
                        @can('delete product')
                        <form id="deleteForm{{ $product->id }}" action="{{ route('products.destroy', $product->id) }}" 
                              method="POST" class="d-inline w-100">
                            @csrf @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm btn-delete w-100" data-form="#deleteForm{{ $product->id }}">
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
                No products found
            </div>
        </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="mt-3">
    {{ $products->links() }}
</div>
