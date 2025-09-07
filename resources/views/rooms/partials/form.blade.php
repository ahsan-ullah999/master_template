
<div class="card shadow-sm border-0 rounded-3">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Flat *</label>
                <select name="flat_id" class="form-select" required>
                    <option value="">Select flat</option>
                    @foreach($flats as $flat)
                        <option value="{{ $flat->id }}" 
                            {{ old('flat_id',$room->flat_id ?? '') == $flat->id ? 'selected':'' }}>
                            {{ $flat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Room Name *</label>
                <input type="text" name="name" value="{{ old('name',$room->name ?? '') }}" class="form-control" required>
            </div>
            <div class="col-md-12">
                <label class="form-label">Room Number *</label>
                <input type="text" name="room_number" value="{{ old('room_number',$room->room_number ?? '') }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active" {{ old('status',$room->status ?? '')=='active'?'selected':'' }}>Active</option>
                    <option value="inactive" {{ old('status',$room->status ?? '')=='inactive'?'selected':'' }}>Inactive</option>
                </select>
            </div>
        </div>
    </div>
</div>

