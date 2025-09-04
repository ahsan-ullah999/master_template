
<div class="card p-4 shadow rounded">
    <div class="row g-3">
        {{-- Company Name --}}
        <div class="col-md-4">
            <label class="form-label fw-bold">Company Name *</label>
            <input type="text" name="name" class="form-control" 
                   value="{{ old('name', $company->name ?? '') }}" required>
        </div>

        {{-- Email --}}
        <div class="col-md-4">
            <label class="form-label fw-bold">Email *</label>
            <input type="email" name="email" class="form-control" 
                   value="{{ old('email', $company->email ?? '') }}" required>
        </div>
        {{-- Email --}}
        <div class="col-md-4">
            <label class="form-label fw-bold">Address *</label>
            <input type="text" name="address" class="form-control" 
                   value="{{ old('address', $company->address ?? '') }}" required>
        </div>

        {{-- Business Code --}}
        <div class="col-md-4">
            <label class="form-label fw-bold">Business Code</label>
            <input type="text" name="business_code" class="form-control" 
                   value="{{ old('business_code', $company->business_code ?? '') }}">
        </div>

        {{-- Start Date --}}
        <div class="col-md-4">
            <label class="form-label fw-bold">Start Date *</label>
            <input type="date" name="start_date" class="form-control" 
                   value="{{ old('start_date', $company->start_date ?? '') }}" required>
        </div>

        {{-- Financial Year Start Month --}}
        <div class="col-md-4">
            <label class="form-label fw-bold">Financial Year Start Month</label>
            <select name="financial_year_start_month" class="form-select">
                <option value="">-- Select Month --</option>
                @foreach(['January','February','March','April','May','June','July','August','September','October','November','December'] as $month)
                    <option value="{{ $month }}" {{ old('financial_year_start_month', $company->financial_year_start_month ?? '') == $month ? 'selected' : '' }}>{{ $month }}</option>
                @endforeach
            </select>
        </div>

        {{-- Time Zone --}}
        <div class="col-md-4">
            <label class="form-label fw-bold">Time Zone</label>
            <select name="time_zone" class="form-select">
                <option value="">-- Select Time Zone --</option>
                @foreach(['Asia/Dhaka','Europe/London','America/New_York','Africa/Cairo','MiddleEast/Dubai'] as $zone)
                    <option value="{{ $zone }}" {{ old('time_zone', $company->time_zone ?? '') == $zone ? 'selected' : '' }}>{{ $zone }}</option>
                @endforeach
            </select>
        </div>

        {{-- Currency Precision --}}
        <div class="col-md-4">
            <label class="form-label fw-bold">Currency Precision</label>
            <select name="currency_precision" class="form-select">
                <option value="">-- Select --</option>
                @for($i=0; $i<5; $i++)
                    <option value="{{ $i }}" {{ old('currency_precision', $company->currency_precision ?? '') == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </div>

        {{-- Quantity Precision --}}
        <div class="col-md-4">
            <label class="form-label fw-bold">Quantity Precision</label>
            <select name="quantity_precision" class="form-select">
                <option value="">-- Select --</option>
                @for($i=0; $i<5; $i++)
                    <option value="{{ $i }}" {{ old('quantity_precision', $company->quantity_precision ?? '') == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </div>

        {{-- Currency --}}
        <div class="col-md-4">
            <label class="form-label fw-bold">Currency</label>
            <select name="currency" class="form-select">
                <option value="">-- Select Currency --</option>
                @foreach(['BDT','RUPI','DOLLAR'] as $cur)
                    <option value="{{ $cur }}" {{ old('currency', $company->currency ?? '') == $cur ? 'selected' : '' }}>{{ $cur }}</option>
                @endforeach
            </select>
        </div>

        {{-- Contact --}}
        <div class="col-md-4">
            <label class="form-label fw-bold">Contact Number *</label>
            <input type="text" name="contact_number" class="form-control" 
                   value="{{ old('contact_number', $company->contact_number ?? '') }}" required>
        </div>
        <div class="col-md-4">
            <label class="form-label fw-bold">Alternate Contact Number</label>
            <input type="text" name="alternate_contact_number" class="form-control" 
                   value="{{ old('alternate_contact_number', $company->alternate_contact_number ?? '') }}">
        </div>

        {{-- Website --}}
        <div class="col-md-4">
            <label class="form-label fw-bold">Website</label>
            <input type="text" name="website" class="form-control" 
                   value="{{ old('website', $company->website ?? '') }}">
        </div>
        {{-- branch --}}
        <div class="col-md-4">
            <label class="form-label fw-bold">Branch *</label>
            <input type="text" name="branch" class="form-control" 
                   value="{{ old('branch', $company->branch ?? '') }}">
        </div>

        
        {{-- Country --}}
        <div class="col-md-4">
            <label class="form-label fw-bold">Country</label>
            <select name="country" id="country" class="form-select select2">
                <option value="">-- Select Country --</option>
                @foreach(['Bangladesh','India','USA','UK','Canada'] as $c)
                    <option value="{{ $c }}" {{ old('country', $company->country ?? '') == $c ? 'selected' : '' }}>{{ $c }}</option>
                @endforeach
            </select>
        </div>

    {{-- District --}}
    <div class="col-md-4">
        <label class="form-label fw-bold">District</label>
        <select name="district" id="district" class="form-select select2">
            <option value="">-- Select District --</option>
            @foreach(['Dhaka','Chattogram','Rajshahi','Sylhet','Khulna'] as $d)
                <option value="{{ $d }}" {{ old('district', $company->district ?? '') == $d ? 'selected' : '' }}>{{ $d }}</option>
            @endforeach
        </select>
    </div>

        {{-- Upazila --}}
        <div class="col-md-4">
            <label class="form-label fw-bold">Upazila</label>
            <select name="upazila" id="upazila" class="form-select select2">
                <option value="">-- Select Upazila --</option>
                @foreach(['Savar','Gazipur','Narayanganj','Comilla','Rangpur'] as $u)
                    <option value="{{ $u }}" {{ old('upazila', $company->upazila ?? '') == $u ? 'selected' : '' }}>{{ $u }}</option>
                @endforeach
            </select>
        </div>


        {{-- Zip Code --}}
        <div class="col-md-4">
            <label class="form-label fw-bold">Zip Code</label>
            <input type="text" name="zip_code" class="form-control" 
                   value="{{ old('zip_code', $company->zip_code ?? '') }}">
        </div>

        {{-- Landmark --}}
        <div class="col-md-4">
            <label class="form-label fw-bold">Landmark</label>
            <input type="text" name="landmark" class="form-control" 
                   value="{{ old('landmark', $company->landmark ?? '') }}">
        </div>

        {{-- Off Days --}}
        <div class="col-md-4">
            <label class="form-label fw-bold">Off Days</label>
            <input type="text" name="off_days" class="form-control" 
                   value="{{ old('off_days', $company->off_days ?? '') }}">
        </div>

        {{-- Leave Approval Structure --}}
        <div class="col-md-4">
            <label class="form-label fw-bold">Leave Approval Structure</label>
            <select name="leave_approval_structure" class="form-select">
                <option value="">-- Select --</option>
                <option value="1">Structure 1</option>
                <option value="2">Structure 2</option>
                <option value="3">Structure 3</option>
            </select>
        </div>

        {{-- Attendance Approval --}}
        <div class="col-md-4">
            <label class="form-label fw-bold">Attendance Approval</label>
            <select name="attendance_approval" class="form-select">
                <option value="">-- Select --</option>
                <option value="1">Approval 1</option>
                <option value="2">Approval 2</option>
                <option value="3">Approval 3</option>
            </select>
        </div>

        {{-- Probation Period --}}
        <div class="col-md-4">
            <label class="form-label fw-bold">Probation Period</label>
            <input type="text" name="probation_period" class="form-control" 
                   value="{{ old('probation_period', $company->probation_period ?? '') }}">
        </div>

        {{-- Service Age --}}
        <div class="col-md-4">
            <label class="form-label fw-bold">Service Age</label>
            <input type="text" name="service_age" class="form-control" 
                   value="{{ old('service_age', $company->service_age ?? '') }}">
        </div>
            <div class="col-md-4">
                    <label  class="form-label fw-bold">Status *</label>
                    <select name="status" class="form-select" required>
                        <option value="active" {{ old('status', $company->status ?? '') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $company->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

        {{-- Logo Upload --}}
        <div class="col-md-4">
            <label class="form-label fw-bold">Upload Logo</label>
            <input type="file" name="logo" id="logoInput" class="form-control" accept="image/*">

            {{-- Preview --}}
            <div class="mt-2">
                <img id="logoPreview" 
                     src="{{ !empty($company->logo) ? asset('storage/'.$company->logo) : '' }}" 
                     class="img-thumbnail" width="100" 
                     style="{{ empty($company->logo) ? 'display:none;' : '' }}">
            </div>
        </div>
    </div>
</div>

{{-- JS for live preview --}}
@push('scripts')
<script>
document.getElementById('logoInput').addEventListener('change', function(e){
    const [file] = this.files;
    if(file){
        const preview = document.getElementById('logoPreview');
        preview.src = URL.createObjectURL(file);
        preview.style.display = "block";
    }
});
</script>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            placeholder: "select",
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endpush


