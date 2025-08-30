@extends('layouts.app')

@section('title', 'My Profile')
<x-navbar/>

@section('content')
<x-sidebar/>
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">

            @if(session('success'))
              <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @method('PUT')

            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-person-circle"></i> My Profile
                </div>
                <div class="card-body">
                    
                    <!-- Profile Image -->
                    <div class="text-center mb-4">
                        <img id="preview" 
                             src="{{ $user->profile_image ? asset('uploads/profile_images/'.$user->profile_image) : asset('adminlte/dist/assets/img/user2-160x160.jpg') }}"
                             class="rounded-circle border border-3" width="120" height="120" alt="Profile Picture">

                        <div class="mt-2">
                            <input type="file" name="profile_image" form="profileForm" 
                                   class="form-control w-50 mx-auto" id="profileImage" accept="image/*">
                        </div>
                    </div>

                    <!-- Profile Form -->
                    <form id="profileForm" method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name',$user->name) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email',$user->email) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">New Password 
                                <small class="text-muted">(leave blank if unchanged)</small>
                            </label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
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
