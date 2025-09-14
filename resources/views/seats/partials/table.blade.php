<div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
    <table class="table align-middle table-hover table-striped">
        <thead class="table-light sticky-top" style="z-index: 1;">
            <tr>
                <th>Building</th>
                <th>Flat</th>
                <th>Room</th>
                <th>Seat Number</th>
                <th>Status</th>
                @canany(['edit seat','delete seat'])
                    <th>Actions</th>
                @endcanany
            </tr>
        </thead>
        <tbody>
            @forelse($seats as $seat)
            <tr>
                <td>{{ $seat->room->flat->floor->building->name ?? '-' }}</td>
                <td>{{ $seat->room->flat->name ?? '-' }}</td>
                <td>{{ $seat->room->name ?? '-' }}</td>
                <td>{{ $seat->seat_number }}</td>
                <td>
                    <span class="badge {{ $seat->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                        {{ ucfirst($seat->status) }}
                    </span>
                </td>
                @canany(['edit seat','delete seat'])
                <td>
                    <div class="gap-2">
                        @can('edit seat')
                        <a href="{{ route('seats.edit',$seat->id) }}" class="btn btn-primary rounded-circle btn-sm">
                            <i class="bi bi-pencil"></i>
                        </a>
                        @endcan
                        @can('delete seat')
                        <form action="{{ route('seats.destroy',$seat->id) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger rounded-circle btn-sm"
                                    onclick="return confirm('Delete this seat?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        @endcan
                    </div>
                </td>
                @endcanany
            </tr>
            @empty
            <tr><td colspan="6" class="text-center text-muted">No seats found</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $seats->links() }}
