
<div class="card shadow-sm border-0 rounded-3">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Floor *</label>
                <select name="floor_id" class="form-select" required>
                    <option value="">Select floor</option>
                    @foreach($floors as $floor)
                        <option value="{{ $floor->id }}" 
                            {{ old('floor_id',$flat->floor_id ?? '') == $floor->id ? 'selected':'' }}>
                            {{ $floor->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Flat Name *</label>
                <input type="text" name="name" value="{{ old('name',$flat->name ?? '') }}" class="form-control" required>
            </div>
            <div class="col-md-12">
                <label class="form-label">Flat Number *</label>
                <input type="text" name="flat_number" value="{{ old('flat_number',$flat->flat_number ?? '') }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active" {{ old('status',$flat->status ?? '')=='active'?'selected':'' }}>Active</option>
                    <option value="inactive" {{ old('status',$flat->status ?? '')=='inactive'?'selected':'' }}>Inactive</option>
                </select>
            </div>
        </div>
    </div>
</div>

