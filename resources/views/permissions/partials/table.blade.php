<table class="table">
    <thead>
        <tr>
            <th>No.</th>
            <th>Name</th>
            <th>Created</th>
            @canany(['edit permission','delete permission'])
              <th>Actions</th>
            @endcanany
        </tr>
    </thead>
    <tbody>
        @forelse ($permissions as $permission)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ ucfirst(strtolower($permission->name )) }}</td>
                <td>{{ \Carbon\Carbon::parse($permission->created_at)->format('d M, Y') }}</td>
                @canany(['edit permission','delete permission'])
                  <td>
                      @can('edit permission')
                        <a class="btn btn-sm btn-primary" href="{{ route('permissions.edit',$permission->id) }}">
                            <i class="bi bi-pencil"></i>
                        </a>
                      @endcan

                      @can('delete permission')          
                        <form id="deleteForm{{ $permission->id }}" action="{{ route('permissions.destroy',$permission->id) }}" 
                              method="POST" 
                              class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button type="button" class="btn btn-danger btn-sm btn-delete" data-form="#deleteForm{{ $permission->id }}">
                            <i class="bi bi-trash"></i>
                          </button>
                        </form>
                      @endcan
                  </td>
                @endcanany
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center text-muted">No permissions found</td>
            </tr>
        @endforelse
    </tbody>
</table>
{{ $permissions->links() }}

{{-- Pagination --}}
{{-- @if ($permissions->hasPages())
    <div class="d-flex justify-content-center mt-3">
        {!! $permissions->links() !!}
    </div>
@endif --}}
