<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Web-Xpress | Register</title>

    <!-- Bootstrap + Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet" />
  </head>

  <body style="background: linear-gradient(135deg,#e3f2fd,#e8eaf6); min-height:100vh; display:flex; align-items:center; justify-content:center; font-family:'Source Sans 3',sans-serif;">
    
    <div class="card shadow-lg border-0" style="width: 400px; border-radius:12px;">
      <div class="card-header text-center text-white fw-bold" style="background:linear-gradient(135deg,#adbecf,#747997); border-top-left-radius:15px; border-top-right-radius:15px; padding:1.2rem 0;">
        <h3 class="mb-0"><i class="bi bi-globe2 me-2"></i>Web-<span class="fw-light">Xpress</span></h3>
      </div>
      <div class="card-body" style="padding: 2rem;">
        <p class="text-center text-muted mb-4" style="font-size:15px;">Register a new membership</p>

        <!-- Success Message -->
        @if(session('success'))
        <div class="alert alert-success text-center py-2" style="font-size:14px;">
          {{ session('success') }}
        </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
          @csrf

          <!-- Name -->
          <div class="input-group mb-3">
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="Full Name" class="form-control" style="border-radius:8px 0 0 8px;" />
            <span class="input-group-text" style="background-color:#f8f9fa; border-radius:0 8px 8px 0;"><i class="bi bi-person"></i></span>
          </div>
          <x-input-error :messages="$errors->get('name')" class="text-danger mb-2" />

          <!-- Email -->
          <div class="input-group mb-3">
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Email" class="form-control" style="border-radius:8px 0 0 8px;" />
            <span class="input-group-text" style="background-color:#f8f9fa; border-radius:0 8px 8px 0;"><i class="bi bi-envelope"></i></span>
          </div>
          <x-input-error :messages="$errors->get('email')" class="text-danger mb-2" />

          <!-- Password -->
          <div class="input-group mb-3">
            <input id="password" type="password" name="password" required autocomplete="new-password" placeholder="Password" class="form-control" style="border-radius:8px 0 0 8px;" />
            <span class="input-group-text" style="background-color:#f8f9fa; border-radius:0 8px 8px 0;"><i class="bi bi-lock-fill"></i></span>
          </div>
          <x-input-error :messages="$errors->get('password')" class="text-danger mb-2" />

          <!-- Confirm Password -->
          <div class="input-group mb-3">
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password" class="form-control" style="border-radius:8px 0 0 8px;" />
            <span class="input-group-text" style="background-color:#f8f9fa; border-radius:0 8px 8px 0;"><i class="bi bi-lock-fill"></i></span>
          </div>
          <x-input-error :messages="$errors->get('password_confirmation')" class="text-danger mb-2" />

          <!-- Terms -->
          <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" id="terms" required />
            <label class="form-check-label small" for="terms">I agree to the <a href="#" style="color:#007bff; text-decoration:none;">terms</a></label>
          </div>

          <!-- Register Button -->
          <button type="submit" class="btn btn-primary w-100" style="font-weight:600; border-radius:8px;">Register</button>
        </form>

        <div class="text-center mt-4">
          <p class="text-muted mb-2" style="font-size:14px;">- OR -</p>
          <p style="font-size:14px;">Already have an account? 
            <a href="{{ route('login') }}" style="color:#007bff; text-decoration:none;">Sign In</a>
          </p>
        </div>
      </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
