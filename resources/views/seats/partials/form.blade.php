
<div class="card shadow-sm border-0 rounded-3">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Room *</label>
                <select name="room_id" class="form-select" required>
                    <option value="">Select room</option>
                    @foreach($rooms as $room)
                        <option value="{{ $room->id }}" 
                            {{ old('room_id',$seat->room_id ?? '') == $room->id ? 'selected':'' }}>
                            {{ $room->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Seat Number *</label>
                <input type="text" name="seat_number" value="{{ old('seat_number',$seat->seat_number ?? '') }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Description *</label>
                <input type="text" name="description" value="{{ old('description',$seat->description ?? '') }}" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active" {{ old('status',$seat->status ?? '')=='active'?'selected':'' }}>Active</option>
                    <option value="inactive" {{ old('status',$seat->status ?? '')=='inactive'?'selected':'' }}>Inactive</option>
                </select>
            </div>
        </div>
    </div>
</div>

