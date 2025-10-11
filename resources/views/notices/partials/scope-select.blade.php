@php
    $notice = $notice ?? new \App\Models\Notice();
@endphp

<div class="row g-3 mb-3">

    {{-- Company --}}
    <div class="col-md-3">
        <label class="form-label">Company*</label>
        <select name="company_id" id="company_id" class="form-select select2" required>
            <option value="">All Companies</option>
            @foreach($companies as $company)
                <option value="{{ $company->id }}" 
                    {{ old('company_id', $notice->company_id) == $company->id ? 'selected' : '' }}>
                    {{ $company->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Branch --}}
    <div class="col-md-3">
        <label class="form-label">Branch</label>
        <select name="branch_id" id="branch_id" class="form-select select2">
            <option value="">All Branches</option>
            @foreach($branches as $branch)
                <option value="{{ $branch->id }}" 
                    {{ old('branch_id', $notice->branch_id) == $branch->id ? 'selected' : '' }}>
                    {{ $branch->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Building --}}
    <div class="col-md-3">
        <label class="form-label">Building</label>
        <select name="building_id" id="building_id" class="form-select select2">
            <option value="">All Buildings</option>
            @foreach($buildings as $building)
                <option value="{{ $building->id }}" 
                    {{ old('building_id', $notice->building_id) == $building->id ? 'selected' : '' }}>
                    {{ $building->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Floor --}}
    <div class="col-md-3">
        <label class="form-label">Floor</label>
        <select name="floor_id" id="floor_id" class="form-select select2">
            <option value="">All Floors</option>
            @foreach($floors as $floor)
                <option value="{{ $floor->id }}" 
                    {{ old('floor_id', $notice->floor_id) == $floor->id ? 'selected' : '' }}>
                    {{ $floor->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Flat --}}
    <div class="col-md-3">
        <label class="form-label">Flat</label>
        <select name="flat_id" id="flat_id" class="form-select select2">
            <option value="">All Flats</option>
            @foreach($flats as $flat)
                <option value="{{ $flat->id }}" 
                    {{ old('flat_id', $notice->flat_id) == $flat->id ? 'selected' : '' }}>
                    {{ $flat->name }}
                </option>
            @endforeach
        </select>
    </div>

    {{-- Room --}}
    <div class="col-md-3">
        <label class="form-label">Room</label>
        <select name="room_id" id="room_id" class="form-select select2">
            <option value="">All Rooms</option>
            @foreach($rooms as $room)
                <option value="{{ $room->id }}" 
                    {{ old('room_id', $notice->room_id) == $room->id ? 'selected' : '' }}>
                    {{ $room->name }}
                </option>
            @endforeach
        </select>
    </div>

</div>
