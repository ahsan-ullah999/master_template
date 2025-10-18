<div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
    <table class="table align-middle table-hover table-striped">
        <thead class="table-light  sticky-top" style="z-index: 1;">
            <tr>
                <th>Group</th>
                <th>Phone</th>
                <th>Address</th>
                {{-- @canany(['edit company','show company']) --}}
                <th>Actions</th>
                {{-- @endcanany --}}
            </tr>
        </thead>
        <tbody>
            @forelse($groups as $group)
            <tr>
                <!-- Company Info -->
                <td>
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            @if($group->logo)
                                <img src="{{ asset('storage/'.$group->logo) }}" 
                                     alt="{{ $group->name }}" 
                                     class="rounded" 
                                     width="50" height="50">
                            @else
                                <div class="rounded bg-secondary d-flex align-items-center justify-content-center"
                                     style="width:50px; height:50px;">
                                    <i class="bi bi-building text-white"></i>
                                </div>
                            @endif
                        </div>
                        <div>
                            <h6 class="mb-0">{{ ucfirst(strtolower($group->name)) }}</h6>
                            <small class="text-muted">{{ $group->email }}</small>
                        </div>
                    </div>
                </td>

                <!-- Contact -->
                <td>{{ $group->contact_number ?? '-' }}</td>



                <!-- Address -->
                <td>{{ $group->address ?? '-' }}</td>

                <!-- Actions -->
                {{-- @canany(['edit company','show company']) --}}
                <td class="text-center">
                    <div class="d-flex gap-2">
                        {{-- @can('show company') --}}
                        <a href="{{ route('groups.show', $group->id) }}" 
                           class="btn btn-success" 
                           title="View">
                            <i class="bi bi-eye"></i>
                        </a>
                        {{-- @endcan
                        @can('edit company') --}}
                        <a href="{{ route('groups.edit', $group->id) }}" 
                           class="btn btn-primary" 
                           title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        {{-- @endcan --}}
                    </div>
                </td>
                {{-- @endcanany --}}
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center text-muted">No groups found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $groups->links() }}
