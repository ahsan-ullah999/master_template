<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Web-Xpress | Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body style="background: linear-gradient(135deg,#e3f2fd,#e8eaf6); min-height:100vh;
 display:flex; justify-content:center; align-items:center; font-family:'Source Sans 3',sans-serif;">
  
  <div class="card shadow-lg border-0" style="width:400px; border-radius:15px;">
    <div class="card-header text-center text-white fw-bold" style="background:linear-gradient(135deg,#adbecf,#747997); border-top-left-radius:15px; border-top-right-radius:15px; padding:1.2rem 0;">
      <h3 class="mb-0"><i class="bi bi-globe2 me-2"></i>Web-<span class="fw-light">Xpress</span></h3>
    </div>

    <div class="card-body px-4 py-4">
      <p class="text-center text-muted mb-4">Sign in to start your session</p>

      <!-- Success Message -->
      @if(session('success'))
        <div class="alert alert-success py-2">{{ session('success') }}</div>
      @endif

      <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div class="mb-3 position-relative">
          <label for="email" class="form-label fw-semibold text-secondary">Email</label>
          <div class="input-group">
            <input id="email" type="email" name="email" value="{{ old('email') }}" required 
                   class="form-control shadow-sm" placeholder="Enter email">
            <span class="input-group-text bg-light"><i class="bi bi-envelope text-primary"></i></span>
          </div>
          <x-input-error :messages="$errors->get('email')" class="text-danger small mt-1" />
        </div>

        <!-- Password -->
        <div class="mb-3 position-relative">
          <label for="password" class="form-label fw-semibold text-secondary">Password</label>
          <div class="input-group">
            <input id="password" type="password" name="password" required 
                   class="form-control shadow-sm" placeholder="Enter password">
            <span class="input-group-text bg-light"><i class="bi bi-lock-fill text-primary"></i></span>
          </div>
          <x-input-error :messages="$errors->get('password')" class="text-danger small mt-1" />
        </div>

        <!-- Remember + Forgot -->
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
            <label class="form-check-label small text-secondary" for="remember_me">Remember me</label>
          </div>
          @if (Route::has('password.request'))
          <a href="{{ route('password.request') }}" class="small text-decoration-none text-primary">Forgot password?</a>
          @endif
        </div>

        <!-- Login Button -->
        <button type="submit" class="btn btn-primary w-100 shadow-sm" style="border-radius:8px;">
          <i class="bi bi-box-arrow-in-right me-1"></i> Log In
        </button>
      </form>

      <!-- Divider -->
      <div class="text-center my-3 text-muted"><span>— OR —</span></div>

      <!-- Register -->
      <div class="text-center">
        <a href="{{ route('register') }}" class="text-decoration-none fw-semibold text-primary">
          <i class="bi bi-person-plus me-1"></i>Register a new membership
        </a>
      </div>
    </div>

    <div class="card-footer text-center text-muted small py-2" style="background:#f9f9f9; border-bottom-left-radius:15px; border-bottom-right-radius:15px;">
      © {{ date('Y') }} Web-Xpress. All rights reserved.
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
