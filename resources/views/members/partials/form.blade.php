<div class="card shadow-sm border-0 rounded-3 mb-3">
    <div class="card-body">
        <div class="row g-3">

            <!-- Company dropdown -->
            <div class="col-md-3">
                <label class="form-label">Company *</label>
                <select name="company_id" id="company_id" class="form-select">
                    <option value="">Select Company</option>
                    @foreach($companies as $company)
                        <option value="{{ $company->id }}" 
                            {{ old('company_id', $member->company_id ?? '') == $company->id ? 'selected' : '' }}>
                            {{ $company->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Branch dropdown -->
            <div class="col-md-3">
                <label class="form-label">Branch</label>
                <select name="branch_id" id="branch_id" class="form-select">
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}" 
                            {{ old('branch_id', $member->branch_id ?? '') == $branch->id ? 'selected' : '' }}>
                            {{ $branch->name }}
                        </option>
                    @endforeach                        
                </select>
            </div>

            <!-- Building dropdown -->
            <div class="col-md-3">
                <label class="form-label">Building</label>
                <select name="building_id" id="building_id" class="form-select">
                    @foreach ($buildings as $building)
                        <option value="{{ $building->id }}" 
                            {{ old('building_id', $member->building_id ?? '') == $building->id ? 'selected' : '' }}>
                            {{ $building->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Floor -->
            <div class="col-md-3">
                <label class="form-label">Floor</label>
                <select name="floor_id" id="floor_id" class="form-select">
                    @foreach ($floors as $floor)
                        <option value="{{ $floor->id }}" 
                            {{ old('floor_id', $member->floor_id ?? '') == $floor->id ? 'selected' : '' }}>
                            {{ $floor->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Flat -->
            <div class="col-md-3">
                <label class="form-label">Flat</label>
                <select name="flat_id" id="flat_id" class="form-select">
                    @foreach ($flats as $flat)
                        <option value="{{ $flat->id }}" 
                            {{ old('flat_id', $member->flat_id ?? '') == $flat->id ? 'selected' : '' }}>
                            {{ $flat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Room -->
            <div class="col-md-3">
                <label class="form-label">Room</label>
                <select name="room_id" id="room_id" class="form-select">
                    @foreach ($rooms as $room)
                        <option value="{{ $room->id }}" 
                            {{ old('room_id', $member->room_id ?? '') == $room->id ? 'selected' : '' }}>
                            {{ $room->name }}
                        </option>
                    @endforeach    
                </select>
            </div>

            <!-- Seat -->
            <div class="col-md-3">
                <label class="form-label">Seat</label>
                <select name="seat_id" id="seat_id" class="form-select">
                    
                    @foreach ($seats as $seat)
                        <option value="{{ $seat->id }}" 
                            {{ old('seat_id', $member->seat_id ?? '') == $seat->id ? 'selected' : '' }}>
                            {{ $seat->seat_number }}
                        </option>
                    @endforeach 
                </select>
            </div>

            <!-- Rental ID -->
            <div class="col-md-3">
                <label class="form-label">Rental ID</label>
                <input type="text" name="rental_id" value="{{ old('rental_id',$member->rental_id ?? '') }}" class="form-control">
            </div>

            <!-- Admission Date -->
            <div class="col-md-3">
                <label class="form-label">Admission Date</label>
                <input type="date" name="admission_date" value="{{ old('admission_date',$member->admission_date ?? '') }}" class="form-control">
            </div>

            <!-- Effective Date -->
            <div class="col-md-3">
                <label class="form-label">Effective Date</label>
                <input type="date" name="effective_date" value="{{ old('effective_date',$member->effective_date ?? '') }}" class="form-control">
            </div>
            <!-- Name -->
            <div class="col-md-3">
                <label class="form-label">Name *</label>
                <input type="text" name="name" value="{{ old('name',$member->name ?? '') }}" class="form-control @error('name') is-invalid @enderror">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <!-- Phone -->
            <div class="col-md-3">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" value="{{ old('phone',$member->phone ?? '') }}" class="form-control">
            </div>

            <!-- Email -->
            <div class="col-md-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" value="{{ old('email',$member->email ?? '') }}" class="form-control">
            </div>

            <!-- DOB -->
            <div class="col-md-3">
                <label class="form-label">Date of Birth</label>
                <input type="date" name="date_of_birth" value="{{ old('date_of_birth',$member->date_of_birth ?? '') }}" class="form-control">
            </div>

            <!-- NID -->
            <div class="col-md-3">
                <label class="form-label">National ID</label>
                <input type="text" name="national_id" value="{{ old('national_id',$member->national_id ?? '') }}" class="form-control">
            </div>

            <!-- Father -->
            <div class="col-md-3">
                <label class="form-label">Father's Name</label>
                <input type="text" name="father_name" value="{{ old('father_name',$member->father_name ?? '') }}" class="form-control">
            </div>

            <div class="col-md-3">
                <label class="form-label">Father's Contact</label>
                <input type="text" name="father_contact" value="{{ old('father_contact',$member->father_contact ?? '') }}" class="form-control">
            </div>

            <!-- Mother -->
            <div class="col-md-3">
                <label class="form-label">Mother's Name</label>
                <input type="text" name="mother_name" value="{{ old('mother_name',$member->mother_name ?? '') }}" class="form-control">
            </div>

            <!-- Blood -->
            <div class="col-md-3">
                <label class="form-label">Blood Group</label>
                <input type="text" name="blood_group" value="{{ old('blood_group',$member->blood_group ?? '') }}" class="form-control">
            </div>
            

            <!-- Address -->
            <div class="col-md-3">
                <label class="form-label">Permanent Address</label>
                <textarea name="permanent_address" class="form-control">{{ old('permanent_address',$member->permanent_address ?? '') }}</textarea>
            </div>
            <!-- Guardian -->
            <div class="col-md-3">
                <label class="form-label">Local Guardian Name</label>
                <input type="text" name="local_guardian_name" value="{{ old('local_guardian_name',$member->local_guardian_name ?? '') }}" class="form-control">
            </div>

            <div class="col-md-3">
                <label class="form-label">Relation</label>
                <input type="text" name="local_guardian_relation" value="{{ old('local_guardian_relation',$member->local_guardian_relation ?? '') }}" class="form-control">
            </div>

            <div class="col-md-3">
                <label class="form-label">Guardian Contact</label>
                <input type="text" name="local_guardian_contact" value="{{ old('local_guardian_contact',$member->local_guardian_contact ?? '') }}" class="form-control">
            </div>
                {{-- photo Upload --}}
            <div class="col-md-4">
                <label class="form-label ">Upload Photo</label>
                <input type="file" name="photo" id="photoInput" class="form-control" accept="image/*">

                {{-- Preview --}}
                <div class="mt-2">
                    <img id="photoPreview" 
                        src="{{ !empty($member->photo) ? asset('storage/'.$member->photo) : '' }}" 
                        class="rounded" width="100" 
                        style="{{ empty($member->photo) ? 'display:none;' : '' }}">
                </div>
            </div>
            

            <!-- Other fields stay unchanged ... -->
        </div>
    </div>
</div>
{{-- JS for live preview --}}
@push('scripts')
<script>
document.getElementById('photoInput').addEventListener('change', function(e){
    const [file] = this.files;
    if(file){
        const preview = document.getElementById('photoPreview');
        preview.src = URL.createObjectURL(file);
        preview.style.display = "block";
    }
});
</script>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // company -> branch
    $('#company_id').on('change', function() {
        let companyId = $(this).val();
        $('#branch_id').html('<option value="">Select Branch</option>');
        $('#building_id, #floor_id, #flat_id, #room_id, #seat_id').html('<option value="">Select</option>');
        if (companyId) {
            $.get("{{ url('members/deps/branches') }}/" + companyId, function(data) {
                data.forEach(branch => {
                    $('#branch_id').append(`<option value="${branch.id}">${branch.name}</option>`);
                });
            });
        }
    });

    // branch -> building
    $('#branch_id').on('change', function() {
        let branchId = $(this).val();
        $('#building_id').html('<option value="">Select Building</option>');
        $('#floor_id, #flat_id, #room_id, #seat_id').html('<option value="">Select</option>');
        if (branchId) {
            $.get("{{ url('members/deps/buildings') }}/" + branchId, function(data) {
                data.forEach(building => {
                    $('#building_id').append(`<option value="${building.id}">${building.name}</option>`);
                });
            });
        }
    });

    // building -> floor
    $('#building_id').on('change', function() {
        let buildingId = $(this).val();
        $('#floor_id').html('<option value="">Select Floor</option>');
        $('#flat_id, #room_id, #seat_id').html('<option value="">Select</option>');
        if (buildingId) {
            $.get("{{ url('members/deps/floors') }}/" + buildingId, function(data) {
                data.forEach(floor => {
                    $('#floor_id').append(`<option value="${floor.id}">${floor.name}</option>`);
                });
            });
        }
    });

    // floor -> flat
    $('#floor_id').on('change', function() {
        let floorId = $(this).val();
        $('#flat_id').html('<option value="">Select Flat</option>');
        $('#room_id, #seat_id').html('<option value="">Select</option>');
        if (floorId) {
            $.get("{{ url('members/deps/flats') }}/" + floorId, function(data) {
                data.forEach(flat => {
                    $('#flat_id').append(`<option value="${flat.id}">${flat.name}</option>`);
                });
            });
        }
    });

    // flat -> room
    $('#flat_id').on('change', function() {
        let flatId = $(this).val();
        $('#room_id').html('<option value="">Select Room</option>');
        $('#seat_id').html('<option value="">Select</option>');
        if (flatId) {
            $.get("{{ url('members/deps/rooms') }}/" + flatId, function(data) {
                data.forEach(room => {
                    $('#room_id').append(`<option value="${room.id}">${room.name}</option>`);
                });
            });
        }
    });

    // room -> seat
    $('#room_id').on('change', function() {
        let roomId = $(this).val();
        $('#seat_id').html('<option value="">Select Seat</option>');
        if (roomId) {
            $.get("{{ url('members/deps/seats') }}/" + roomId, function(data) {
                data.forEach(seat => {
                    $('#seat_id').append(`<option value="${seat.id}">${seat.seat_number}</option>`);
                });
            });
        }
    });
});
</script>
@endpush
