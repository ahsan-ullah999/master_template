
<div class="card shadow-sm border-0 rounded-3">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Building *</label>
                <select name="building_id" class="form-select" required>
                    <option value="">Select building</option>
                    @foreach($buildings as $building)
                        <option value="{{ $building->id }}" 
                            {{ old('building_id',$floor->building_id ?? '') == $building->id ? 'selected':'' }}>
                            {{ $building->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Floor Name *</label>
                <input type="text" name="name" value="{{ old('name',$floor->name ?? '') }}" class="form-control" required>
            </div>
            <div class="col-md-12">
                <label class="form-label">Floor Number *</label>
                <input type="text" name="number" value="{{ old('number',$floor->number ?? '') }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active" {{ old('status',$floor->status ?? '')=='active'?'selected':'' }}>Active</option>
                    <option value="inactive" {{ old('status',$floor->status ?? '')=='inactive'?'selected':'' }}>Inactive</option>
                </select>
            </div>
        </div>
    </div>
</div>

