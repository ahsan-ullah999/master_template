      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">


          <a href="{{ route('home') }}" class="brand-link d-flex align-items-center justify-content-between">
              <!--begin::Brand Image-->
              <img
                src="{{ asset('adminlte/dist/assets/img/logo.png') }}"
                alt=""
                class="brand-image opacity-75 shadow"
              />
              <!--end::Brand Image-->

              <!--begin::Brand Text-->
              <span class="brand-text fw-light">Web-Xpress</span>
              <!--end::Brand Text-->

              <!--begin::Sidebar Toggle Button-->
              <button class="btn btn-outline-secondary btn-sm text-white ms-5" data-lte-toggle="sidebar" type="button" title="Toggle Sidebar">
                  <i class="bi bi-chevron-double-left"></i>
              </button>
              <!--end::Sidebar Toggle Button-->
          </a>

          <!--end::Brand Link-->
        </div>
        <!--end::Sidebar Brand-->
        <!--begin::Sidebar Wrapper-->
        <div class="sidebar-wrapper">
          <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul
              class="nav sidebar-menu flex-column"
              data-lte-toggle="treeview"
              role="navigation"
              aria-label="Main navigation"
              data-accordion="false"
              id="navigation"
            >
              <li class="nav-item ">
                <a href="{{route('member.dashboard')}}" class="nav-link {{ request()->routeIs('member.dashboard') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-speedometer text-white"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
              </li>

            </ul>
            <!--end::Sidebar Menu-->
          </nav>
        </div>
        <!--end::Sidebar Wrapper-->
      </aside>