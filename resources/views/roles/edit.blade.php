@extends('layouts.app')
@section('title','Edit Role')
<x-navbar/>
@section('content')
<x-sidebar/>

<div class="content mt-4 px-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Edit Role</h3>
        <a href="{{ route('roles.index') }}" class="btn btn-dark">Back</a>
    </div>

    <form method="post" action="{{ route('roles.update',$role->id) }}" class="col-md-10">
        @csrf
        @method('PUT')

        <!-- Role Name -->
        <div class="mb-3">
            <label class="form-label fw-semibold">Role Name</label>
            <input type="text" name="name" value="{{ old('name',$role->name) }}" 
                   class="form-control @error('name') is-invalid @enderror">
            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Search -->
        <div class="mb-3">
            <input type="text" id="permissionSearch" class="form-control" placeholder="🔍 Search permissions...">
        </div>

        <!-- Permissions Grouped -->
        <div class="card shadow-sm border-0">
            <div class="card-body" style="max-height:400px; overflow-y:auto;">

                @php
                    // Group permissions by prefix (Dashboard, Employee, Roles, etc.)
                    $grouped = $permissions->groupBy(function($perm) {
                        return strtoupper(explode(' ', $perm->name)[0]); 
                    });
                @endphp

                @foreach($grouped as $group => $perms)
                    <div class="mb-3">
                        <h6 class="fw-bold text-uppercase text-primary">{{ $group }}</h6>
                        <div class="d-flex flex-wrap gap-2 permission-group">
                            @foreach($perms as $permission)
                                @php
                                    $checked = $haspermissions->contains($permission->name);
                                @endphp
                                <label class="btn btn-sm {{ $checked ? 'btn-info text-light' : 'btn-outline-secondary' }} permission-item">
                                    <input type="checkbox" name="permission[]" value="{{ $permission->name }}" 
                                           class="d-none"
                                           {{ $checked ? 'checked' : '' }}>
                                    {{ $permission->name }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                @endforeach

            </div>
        </div>

        <button class="btn btn-primary mt-3">Update Role</button>
    </form>
</div>

@push('scripts')
<script>
    // Toggle pill button style
    document.querySelectorAll('.permission-item input').forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            if(this.checked){
                this.parentNode.classList.remove('btn-outline-secondary');
                this.parentNode.classList.add('btn-info','text-light');
            } else {
                this.parentNode.classList.remove('btn-info','text-light');
                this.parentNode.classList.add('btn-outline-secondary');
            }
        });
    });

    // Search filter
    document.getElementById('permissionSearch').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        document.querySelectorAll('.permission-group .permission-item').forEach(function(item) {
            let text = item.textContent.toLowerCase();
            item.style.display = text.includes(filter) ? '' : 'none';
        });
    });
</script>
@endpush
@endsection
