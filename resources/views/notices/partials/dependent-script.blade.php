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