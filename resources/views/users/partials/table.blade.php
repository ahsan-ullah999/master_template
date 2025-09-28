<table class="table table-hover align-middle">
    <thead class="table-light">
        <tr>
            <th>No.</th>
            <th>User</th>
            <th>Created</th>
            <th>Status</th>
            <th>Email</th>
            @canany(['edit user','delete user'])
                <th class="text-center" width="220">Actions</th>
            @endcanany
        </tr>
    </thead>
    <tbody>
        @forelse($users as $user)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <!-- User Info -->
                <td>
                    <div class="d-flex align-items-center">
                        <!-- Avatar (placeholder if no photo field) -->
                        {{-- <img src="https://bootdey.com/img/Content/avatar/avatar1.png" 
                             class="rounded-circle me-2" width="45" height="45" alt="avatar"> --}}
                        <div>
                            <div class="fw-bold">
                                {{ ucfirst(strtolower($user->name)) }}
                            </div>
                            <small class="text-muted">
                                {{ $user->roles->pluck('name')->implode(', ') ?: 'Member' }}
                            </small>
                        </div>
                    </div>
                </td>

                <!-- Created -->
                <td>
                    {{ \Carbon\Carbon::parse($user->create_at)->format('d M, Y') }}
                </td>

                <!-- Status -->
                <td>
                    @php
                        // example: active if has role, inactive otherwise
                        $status = $user->roles->isNotEmpty() ? 'Active' : 'Inactive';
                        $statusClass = $status == 'Active' ? 'success' : 'danger';
                    @endphp
                    <span class="badge bg-{{ $statusClass }}">{{ $status }}</span>
                </td>

                <!-- Email -->
                <td>
                    {{ $user->email }}
                </td>

                <!-- Actions -->
                @canany(['edit user','delete user'])
                <td class="text-center">
                    <div class="gap-2 justify-content-center">
                        @can('edit user')
                        <a href="{{ route('users.edit',$user->id) }}" 
                        class="btn btn-primary btn-sm "
                        title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        @endcan

                        @can('delete user')
                        <form id="deleteForm{{ $user->id }}" action="{{ route('users.destroy',$user->id) }}" 
                            method="POST" 
                            class="d-inline">
                            @csrf @method('DELETE')
                            <button type="button" class="btn btn-danger btn-delete btn-sm" data-form="#deleteForm{{ $user->id }}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        @endcan
                    </div>
                </td>
                @endcanany

            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center text-muted">No users found</td>
            </tr>
        @endforelse
    </tbody>
</table>

{{ $users->links() }}
