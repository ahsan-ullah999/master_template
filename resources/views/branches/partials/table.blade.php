    {{-- Branches Table --}}
    <table class="table table-bordered table-rounded table-striped align-middle">
        <thead class="table-dark text-center">
            <tr>
                <th>Company</th>
                <th> Name</th>
                <th> Email</th>
                <th> ID</th>
                <th>Mobile</th>
                <th>Country</th>
                <th>District</th>
                <th>Upazila</th>
                <th>Status</th>
                @canany(['edit branch', 'deactivate branch'])
                    <th>Actions</th>
                @endcanany
                
            </tr>
        </thead>
        <tbody>
            @forelse($branches as $branch)
                 <tr class="{{ $branch->status == 'inactive' ? 'table-secondary bg-secondary text-muted' : '' }}">
                    <td>{{ $branch->company->name ?? 'N/A' }}</td>
                    <td>{{ $branch->name }}</td>
                    <td>{{ $branch->email }}</td>
                    <td>{{ $branch->branch_id }}</td>
                    <td>{{ $branch->mobile_number }}</td>
                    <td>{{ $branch->country }}</td>
                    <td>{{ $branch->district }}</td>
                    <td>{{ $branch->upazila }}</td>
                    <td>
                        <span class="badge {{ $branch->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                            {{ ucfirst($branch->status) }}
                        </span>
                    </td>
                    @canany(['edit branch', 'deactivate branch'])
                    <td class="text-nowrap">
                        <div class="d-inline gap-2">
                            @can('edit branch')
                            <a href="{{ $branch->status == 'active' ? route('branches.edit', $branch->id) : '#' }}"
                            class="btn btn-sm btn-primary {{ $branch->status == 'inactive' ? 'disabled' : '' }}">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>
                            @endcan
                            @can('deactivate branch')
                            <form action="{{ route('branches.toggleStatus', $branch->id) }}" method="POST" class="d-inline">
                                @csrf @method('PUT')
                                <button type="submit" class="btn btn-sm {{ $branch->status == 'active' ? 'btn-warning' : 'btn-secondary' }}">
                                    <i class="bi {{ $branch->status == 'active' ? 'bi-x-circle' : 'bi-check-circle' }}"></i>
                                    {{ $branch->status == 'active' ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                            @endcan

                        </div>
                    </td>
                    @endcanany
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center text-muted">No branches found</td>
                </tr>
            @endforelse
        </tbody>
    </table>
        {{-- Pagination --}}
    <div class="d-flex justify-content-center">
        {{ $branches->links() }}
    </div>