@extends('layouts.app')  {{-- change to your layout file name --}}

@section('title', 'My Profile')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-person-circle"></i> My Profile
                </div>
                <div class="card-body">
                    
                    <!-- Profile Image -->
                    <div class="text-center mb-4">
                        <img id="preview" src="https://via.placeholder.com/120"
                             class="rounded-circle border border-3" width="120" height="120" alt="Profile Picture">
                        <div class="mt-2">
                            <input type="file" class="form-control w-50 mx-auto" id="profileImage" accept="image/*">
                        </div>
                    </div>

                    <!-- Profile Form -->
                    <form>
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" placeholder="Enter your name">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" placeholder="Enter your email">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">New Password 
                                <small class="text-muted">(leave blank if unchanged)</small>
                            </label>
                            <input type="password" class="form-control" placeholder="Enter new password">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" placeholder="Confirm new password">
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-success">
                                <i class="bi bi-save"></i> Save Changes
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
  // Preview uploaded image
  document.getElementById("profileImage").addEventListener("change", function(event) {
    const reader = new FileReader();
    reader.onload = function(){
      document.getElementById("preview").src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
  });
</script>
@endpush
