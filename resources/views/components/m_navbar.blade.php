<nav class="app-header navbar navbar-expand bg-body">
    <div class="container-fluid">
        <!-- ======= Left Navbar Links ======= -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                    <i class="bi bi-list"></i>
                </a>
            </li>
            <li class="nav-item d-none d-md-block">
                <a href="{{ route('home') }}" 
                   class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                   Home
                </a>
            </li>
        </ul>

        <!-- ======= Right Navbar Links ======= -->
        <ul class="navbar-nav ms-auto">

            <!-- 🔍 Search -->
            <li class="nav-item">
                <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                    <i class="bi bi-search"></i>
                </a>
            </li>

            <!-- ⛶ Fullscreen -->
            <li class="nav-item">
                <a class="nav-link" href="#" data-lte-toggle="fullscreen">
                    <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i>
                    <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none"></i>
                </a>
            </li>

            <!-- 👤 User Dropdown -->
            <li class="nav-item dropdown user-menu">
                @php
                    $user = Auth::user();
                    $photo = $user->member && $user->member->photo
                        ? asset('storage/' . $user->member->photo)
                        : asset('adminlte/dist/assets/img/user2-160x160.jpg');
                @endphp

                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="{{ $photo }}" class="user-image rounded-circle shadow" alt="User Image">
                    <span class="d-none d-md-inline">
                    <span class="d-none d-md-inline">
                        {{ auth()->user()->name }} 
                        ({{ ucfirst(auth()->user()->type) }})
                    </span>
                </a>

                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <!-- User Info Header -->
                    <li class="user-header text-bg-primary">
                        <img src="{{ $photo }}" class="user-image rounded-circle shadow" alt="User Image">
                        <p>
                            {{ auth()->user()->name }} - {{ ucfirst(auth()->user()->type) }}
                            <small>
                                Member since: {{ auth()->user()->created_at->format('d M, Y') }}
                            </small>
                        </p>
                    </li>

                    <!-- Menu Footer-->
                    <li class="user-footer">
                        

                        <form action="{{ route('member.logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" 
                                    class="btn btn-danger btn-flat float-end text-white mt-3">
                                <i class="bi bi-box-arrow-right"></i> Sign out
                            </button>
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
