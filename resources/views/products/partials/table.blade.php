<table class="table table-bordered table-striped align-middle">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Name</th>
            <th>Code</th>
            @canany(['edit product','delete product'])
            <th width="200">Actions</th>
            @endcanany
        </tr>
    </thead>
    <tbody>
        @forelse($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>
                    @if($product->image)
                        <img src="{{ asset('storage/'.$product->image) }}" width="60" height="60" class="rounded">
                    @else
                        <span class="text-muted">No Image</span>
                    @endif
                </td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->code ?? '-' }}</td>
                <td>
                    <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-warning">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>
                    <form action="{{ route('products.destroy', $product->id) }}" method="post" class="d-inline">
                        @csrf @method('delete')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this product?')">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="5" class="text-center text-muted">No products found</td></tr>
        @endforelse
    </tbody>
</table>

{{ $products->links() }}
