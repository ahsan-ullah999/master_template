
    {{-- 🔹 Notices Table --}}
    <div class="card shadow rounded-4 border-0">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-primary text-center">
                    <tr>
                        <th style="width: 5%">No.</th>
                        <th style="width: 20%">Title</th>
                        <th style="width: 10%">Priority</th>
                        <th style="width: 35%">Scope</th>
                        <th style="width: 15%">Created</th>
                        <th style="width: 15%">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($notices as $i => $n)
                        <tr>
                            <td class="text-center fw-semibold">{{ $notices->firstItem() + $i }}</td>

                            <td class="fw-semibold text-dark">
                                <i class="bi bi-file-earmark-text-fill text-primary me-1"></i>
                                {{ $n->title }}
                            </td>

                            <td class="text-center">
                                <span class="badge px-3 py-2 
                                    @if($n->priority == 'high') bg-danger 
                                    @elseif($n->priority == 'urgent') bg-warning text-dark 
                                    @else bg-secondary @endif">
                                    {{ ucfirst($n->priority) }}
                                </span>
                            </td>

                            {{-- 🔹 Scope Column --}}
                            <td style="max-width: 500px;">
                                @php
                                    $scopeItems = [];
                                    if($n->company) $scopeItems[] = "Company: <strong>".$n->company->name."</strong>";
                                    if($n->branch) $scopeItems[] = "Branch: <strong>".$n->branch->name."</strong>";
                                    if($n->building) $scopeItems[] = "Building: <strong>".$n->building->name."</strong>";
                                    if($n->floor) $scopeItems[] = "Floor: <strong>".$n->floor->name."</strong>";
                                    if($n->flat) $scopeItems[] = "Flat: <strong>".$n->flat->name."</strong>";
                                    if($n->room) $scopeItems[] = "Room: <strong>".$n->room->name."</strong>";
                                    if($n->seat) $scopeItems[] = "Seat: <strong>".$n->seat->seat_number."</strong>";
                                @endphp

                                <div class="scope-wrapper small text-secondary">
                                    @if(count($scopeItems) > 3)
                                        <span class="scope-visible">
                                            {!! implode(' <span class="text-muted">›</span> ', array_slice($scopeItems, 0, 3)) !!}
                                        </span>
                                        <span class="scope-hidden d-none">
                                            <span class="text-muted">›</span>
                                            {!! implode(' <span class="text-muted">›</span> ', array_slice($scopeItems, 3)) !!}
                                        </span>
                                        <a href="#" class="toggle-scope ms-2" style="font-size: 12px; text-decoration: none; color: #0d6efd;">
                                            Show more
                                        </a>
                                    @else
                                        {!! implode(' <span class="text-muted">›</span> ', $scopeItems) ?: '<span class="text-muted">All</span>' !!}
                                    @endif
                                </div>
                            </td>

                            <td class="text-center">{{ $n->created_at->format('d M, Y') }}</td>

                            {{-- 🔹 Action Buttons --}}
                            <td class="text-center">
                                <a href="{{ route('notices.show',$n->id) }}" class="btn btn-sm btn-info me-1 shadow-sm">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('notices.edit',$n->id) }}" class="btn btn-sm btn-warning me-1 shadow-sm">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form id="deleteForm{{ $n->id }}" action="{{ route('notices.destroy',$n->id) }}" 
                                    method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm shadow-sm btn-delete" 
                                            data-form="#deleteForm{{ $n->id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">
                                <i class="bi bi-exclamation-circle"></i> No notices found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- 🔹 Pagination --}}
    <div class="mt-3">
        {{ $notices->links() }}
    </div>