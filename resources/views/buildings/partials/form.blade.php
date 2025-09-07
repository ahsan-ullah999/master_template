
<div class="card shadow-sm border-0 rounded-3">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Branch *</label>
                <select name="branch_id" class="form-select" required>
                    <option value="">Select Branch</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}" 
                            {{ old('branch_id',$building->branch_id ?? '') == $branch->id ? 'selected':'' }}>
                            {{ $branch->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Building Name *</label>
                <input type="text" name="name" value="{{ old('name',$building->name ?? '') }}" class="form-control" required>
            </div>
            <div class="col-md-12">
                <label class="form-label">Address</label>
                <input type="text" name="address" value="{{ old('address',$building->address ?? '') }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active" {{ old('status',$building->status ?? '')=='active'?'selected':'' }}>Active</option>
                    <option value="inactive" {{ old('status',$building->status ?? '')=='inactive'?'selected':'' }}>Inactive</option>
                </select>
            </div>
        </div>
    </div>
</div>

