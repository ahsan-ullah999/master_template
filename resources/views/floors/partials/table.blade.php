
        <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
            <table class="table align-middle table-hover table-striped">
                <thead class="table-light sticky-top" style="z-index: 1;">
                    <tr>
                        <th>No.</th>
                        <th>Building</th>
                        <th>Floor Name</th>
                        <th>Number</th>
                        <th>Status</th>
                        @canany(['edit floor','delete floor'])
                            <th>Actions</th>
                        @endcanany
                    </tr>
                </thead>
                <tbody>
                    @forelse($floors as $floor)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $floor->building->name }}</td>
                        <td>{{ ucfirst(strtolower($floor->name)) }}</td>
                        <td>{{ $floor->number }}</td>
                        <td>
                            <span class="badge {{ $floor->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($floor->status) }}
                            </span>
                        </td>
                        @canany(['edit floor','delete floor'])
                        <td>
                            <div class="gap-2">
                                @can('edit floor')
                                <a href="{{ route('floors.edit',$floor->id) }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                @endcan
                                @can('delete floor')
                                <form id="deleteForm{{ $floor->id }}" action="{{ route('floors.destroy',$floor->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm btn-delete" data-form="#deleteForm{{ $floor->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                        @endcanany
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center text-muted">No floors found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $floors->links() }}