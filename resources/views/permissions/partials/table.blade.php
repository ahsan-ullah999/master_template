<table class="table table-bordered">
    <thead>
        <tr>
            <th>#</th>
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
                <td>{{ $permission->id }}</td>
                <td>{{ $permission->name }}</td>
                <td>{{ \Carbon\Carbon::parse($permission->created_at)->format('d M, Y') }}</td>
                @canany(['edit permission','delete permission'])
                  <td>
                      @can('edit permission')
                        <a class="btn btn-sm btn-warning" href="{{ route('permissions.edit',$permission->id) }}">Edit</a>
                      @endcan

                      @can('delete permission')          
                        <form action="{{ route('permissions.destroy',$permission->id) }}" 
                              method="POST" 
                              class="d-inline"
                              onsubmit="return confirm('Are you sure you want to delete this permission?');">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-sm btn-danger">Delete</button>
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
