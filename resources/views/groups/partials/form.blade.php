<div class="container py-4">
    <div class="row g-4">

        <!-- 🌟 GROUP INFORMATION CARD -->
        <div class="col-lg-8 mx-auto">
            <div class="card shadow border-0" style="border-radius:16px;">
                <div class="card-header text-white fw-bold" 
                    style="background:linear-gradient(90deg,#4a00e0,#8e2de2);border-radius:16px 16px 0 0;">
                    <i class="bi bi-people-fill me-2"></i> Group Information
                </div>

                <div class="card-body p-4" style="background:#fafafa;border-radius:0 0 16px 16px;">
                    <div class="row g-3">
                        <!-- Group Name -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">Group Name *</label>
                            <input type="text" name="name" class="form-control shadow-sm" 
                                value="{{ old('name', $group->name ?? '') }}" required>
                        </div>

                        <!-- Email -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">Email *</label>
                            <input type="email" name="email" class="form-control shadow-sm" 
                                value="{{ old('email', $group->email ?? '') }}" required>
                        </div>

                        <!-- Contact -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">Contact Number *</label>
                            <input type="text" name="contact_number" class="form-control shadow-sm" 
                                value="{{ old('contact_number', $group->contact_number ?? '') }}" required>
                        </div>

                        <!-- Address -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold text-secondary">Address *</label>
                            <input type="text" name="address" class="form-control shadow-sm" 
                                value="{{ old('address', $group->address ?? '') }}" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 🖼️ IMAGE UPLOAD CARD -->
        <div class="col-lg-8 mx-auto">
            <div class="card shadow border-0" style="border-radius:16px;">
                <div class="card-header text-white fw-bold" 
                    style="background:linear-gradient(90deg,#11998e,#38ef7d);border-radius:16px 16px 0 0;">
                    <i class="bi bi-image-fill me-2"></i> Upload Images
                </div>

                <div class="card-body p-4" style="background:#fdfdfd;border-radius:0 0 16px 16px;">
                    <div class="row g-4">

                        <!-- Logo Upload -->
                        <div class="col-md-6 text-center">
                            <label class="form-label fw-semibold text-secondary d-block mb-2">Upload Logo</label>
                            <div class="preview-box mx-auto p-3 rounded shadow-sm" 
                                style="background:#f5f5f5;border:2px dashed #ccc;width:180px;height:180px;display:flex;align-items:center;justify-content:center;">
                                <img id="logoPreview" 
                                    src="{{ !empty($group->logo) ? asset('storage/'.$group->logo) : '' }}" 
                                    class="img-fluid rounded" 
                                    style="max-height:160px;{{ empty($group->logo) ? 'display:none;' : '' }}">
                                <i id="logoIcon" class="bi bi-image text-muted fs-1" 
                                    style="{{ !empty($group->logo) ? 'display:none;' : '' }}"></i>
                            </div>
                            <input type="file" name="logo" id="logoInput" 
                                class="form-control mt-3 shadow-sm" accept="image/*">
                        </div>

                        <!-- Login Background Upload -->
                        <div class="col-md-6 text-center">
                            <label class="form-label fw-semibold text-secondary d-block mb-2">Login Background</label>
                            <div class="preview-box mx-auto p-3 rounded shadow-sm" 
                                style="background:#f5f5f5;border:2px dashed #ccc;width:180px;height:180px;display:flex;align-items:center;justify-content:center;">
                                <img id="bgPreview" 
                                    src="{{ !empty($group->login_background) ? asset('storage/'.$group->login_background) : '' }}" 
                                    class="img-fluid rounded" 
                                    style="max-height:160px;{{ empty($group->login_background) ? 'display:none;' : '' }}">
                                <i id="bgIcon" class="bi bi-image text-muted fs-1" 
                                    style="{{ !empty($group->login_background) ? 'display:none;' : '' }}"></i>
                            </div>
                            <input type="file" name="login_background" id="bgInput" 
                                class="form-control mt-3 shadow-sm" accept="image/*">
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- ✅ JS for Live Preview -->
<script>
document.getElementById('logoInput').addEventListener('change', function(e){
    const [file] = this.files;
    if(file){
        const preview = document.getElementById('logoPreview');
        const icon = document.getElementById('logoIcon');
        preview.src = URL.createObjectURL(file);
        preview.style.display = "block";
        icon.style.display = "none";
    }
});

document.getElementById('bgInput').addEventListener('change', function(e){
    const [file] = this.files;
    if(file){
        const preview = document.getElementById('bgPreview');
        const icon = document.getElementById('bgIcon');
        preview.src = URL.createObjectURL(file);
        preview.style.display = "block";
        icon.style.display = "none";
    }
});
</script>
