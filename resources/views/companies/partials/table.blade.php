    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark item-center">
            <tr>
                
                <th>Company<br>Name</th>
                <th>Company<br>Email</th>
                <th>Company<br>Address</th>
                <th>Company<br>Contact</th>
                <th>Status</th>
                <th>Company<br>Logo</th>
                @canany(['edit company', 'show company'],)
                <th>Actions</th>
                @endcanany
                
            </tr>
        </thead>
        <tbody>
            @foreach($companies as $company)
                <tr>
                    
                    <td>{{ $company->name }}</td>
                    <td>{{ $company->email }}</td>
                    <td>{{ $company->address }}</td>
                    <td>{{ $company->contact_number }}</td>
                    <td><span class="badge {{ $company->status == 'active' ? 'bg-success' : 'bg-secondary' }}">
                            {{ ucfirst($company->status) }}
                        </span></td>
                    <td>
                        @if($company->logo)
                            <img src="{{ asset('storage/'.$company->logo) }}" width="60">
                        @else
                            <span class="text-muted">No Logo</span>
                        @endif
                    </td>
                    @canany(['edit company', 'show company'])
                    <td>
                        @can('show company')
                        <a href="{{ route('companies.show', $company->id) }}" class="btn btn-sm btn-success">
                            <i class="bi bi-eye"></i> View
                        </a>
                        @endcan
                        @can('edit company')
                        <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-sm btn-info">
                            <i class="bi bi-pencil-square"></i> Edit
                        </a>
                        @endcan

                    </td>
                    @endcanany

                </tr>
            
            @endforeach
        </tbody>
    </table>
    {{ $companies->links() }}