<div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
    <table class="table align-middle table-hover table-striped">
        <thead class="table-light  sticky-top" style="z-index: 1;">
            <tr>
                <th>Company</th>
                <th>Contact</th>
                <th>Status</th>
                <th>Address</th>
                @canany(['edit company','show company'])
                    <th>Actions</th>
                @endcanany
            </tr>
        </thead>
        <tbody>
            @forelse($companies as $company)
            <tr>
                <!-- Company Info -->
                <td>
                    <div class="d-flex align-items-center">
                        <div class="me-3">
                            @if($company->logo)
                                <img src="{{ asset('storage/'.$company->logo) }}" 
                                     alt="{{ $company->name }}" 
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
                            <h6 class="mb-0">{{ $company->name }}</h6>
                            <small class="text-muted">{{ $company->email }}</small>
                        </div>
                    </div>
                </td>

                <!-- Contact -->
                <td>{{ $company->contact_number ?? '-' }}</td>

                <!-- Status -->
                <td>
                    <span class="badge {{ $company->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                        {{ ucfirst($company->status) }}
                    </span>
                </td>

                <!-- Address -->
                <td>{{ $company->address ?? '-' }}</td>

                <!-- Actions -->
                @canany(['edit company','show company'])
                <td class="text-center">
                    <div class="d-flex gap-2">
                        @can('show company')
                        <a href="{{ route('companies.show', $company->id) }}" 
                           class="btn btn-success rounded-circle" 
                           title="View">
                            <i class="bi bi-eye"></i>
                        </a>
                        @endcan
                        @can('edit company')
                        <a href="{{ route('companies.edit', $company->id) }}" 
                           class="btn btn-primary rounded-circle" 
                           title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        @endcan
                    </div>
                </td>
                @endcanany
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center text-muted">No companies found</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{ $companies->links() }}
