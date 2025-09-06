<div class="card p-4 shadow rounded">
    <div class="row g-3">
        {{-- Select Company --}}
        <div class="col-md-4">
            <label class="form-label fw-bold">Company *</label>
            <select name="company_id" class="form-select" required>
                <option value="">-- Select Company --</option>
                @foreach($companies as $company)
                    <option value="{{ $company->id }}" 
                        {{ old('company_id', $branch->company_id ?? '') == $company->id ? 'selected' : '' }}>
                        {{ $company->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Branch Name --}}
        <div class="col-md-4">
            <label class="form-label fw-bold">Branch Name *</label>
            <input type="text" name="name" class="form-control"
                   value="{{ old('name', $branch->name ?? '') }}" required>
        </div>

        {{-- Branch ID --}}
        <div class="col-md-4">
            <label class="form-label fw-bold">Branch ID</label>
            <input type="text" name="branch_id" class="form-control"
                   value="{{ old('branch_id', $branch->branch_id ?? '') }}">
        </div>

        {{-- Email --}}
        <div class="col-md-4">
            <label class="form-label fw-bold">Email *</label>
            <input type="email" name="email" class="form-control"
                   value="{{ old('email', $branch->email ?? '') }}" required>
        </div>

        {{-- Mobile --}}
        <div class="col-md-4">
            <label class="form-label fw-bold">Mobile *</label>
            <input type="text" name="mobile_number" class="form-control"
                   value="{{ old('mobile_number', $branch->mobile_number ?? '') }}" required>
        </div>

        {{-- Alternate Mobile --}}
        <div class="col-md-4">
            <label class="form-label fw-bold">Alternate Contact</label>
            <input type="text" name="alternate_contact_number" class="form-control"
                   value="{{ old('alternate_contact_number', $branch->alternate_contact_number ?? '') }}">
        </div>

        {{-- Website --}}
        <div class="col-md-4">
            <label class="form-label fw-bold">Website</label>
            <input type="text" name="website" class="form-control"
                   value="{{ old('website', $branch->website ?? '') }}">
        </div>

        {{-- Country --}}
        <div class="col-md-4">
            <label class="form-label fw-bold">Country *</label>
            <select name="country" class="form-select" required>
                <option value="">-- Select Country --</option>
                @foreach(['Bangladesh','India','USA','UK','Canada'] as $c)
                    <option value="{{ $c }}" {{ old('country', $branch->country ?? '') == $c ? 'selected' : '' }}>
                        {{ $c }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- District --}}
        <div class="col-md-4">
            <label class="form-label fw-bold">District *</label>
            <select name="district" class="form-select" required>
                <option value="">-- Select District --</option>
                @foreach(['Dhaka','Chattogram','Rajshahi','Sylhet','Khulna'] as $d)
                    <option value="{{ $d }}" {{ old('district', $branch->district ?? '') == $d ? 'selected' : '' }}>
                        {{ $d }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Upazila --}}
        <div class="col-md-4">
            <label class="form-label fw-bold">Upazila *</label>
            <select name="upazila" class="form-select" required>
                <option value="">-- Select Upazila --</option>
                @foreach(['Savar','Gazipur','Narayanganj','Comilla','Rangpur'] as $u)
                    <option value="{{ $u }}" {{ old('upazila', $branch->upazila ?? '') == $u ? 'selected' : '' }}>
                        {{ $u }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Zip Code --}}
        <div class="col-md-4">
            <label class="form-label fw-bold">Zip Code</label>
            <input type="text" name="zip_code" class="form-control"
                   value="{{ old('zip_code', $branch->zip_code ?? '') }}">
        </div>

        {{-- Landmark --}}
        <div class="col-md-4">
            <label class="form-label fw-bold">Landmark</label>
            <input type="text" name="landmark" class="form-control"
                   value="{{ old('landmark', $branch->landmark ?? '') }}">
        </div>

        {{-- Status --}}
        <div class="col-md-4">
            <label class="form-label fw-bold">Status *</label>
            <select name="status" class="form-select" required>
                <option value="active" {{ old('status', $branch->status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ old('status', $branch->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
    </div>
</div>
