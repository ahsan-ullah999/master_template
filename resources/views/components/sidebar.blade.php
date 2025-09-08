      <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
        <!--begin::Sidebar Brand-->
        <div class="sidebar-brand">
          <!--begin::Brand Link-->
          {{-- <a href="{{ route('companies.index') }}" class="brand-link">
              <!--begin::Brand Image-->
              @if($appCompany && $appCompany->logo)
                  <img src="{{ asset('storage/'.$appCompany->logo) }}" 
                      alt="{{ $appCompany->name }}" 
                      class="brand-image opacity-75 shadow" />
              @else
                  <img src="{{ asset('adminlte/dist/assets/img/AdminLTELogo.png') }}" 
                      alt="Default Logo" 
                      class="brand-image opacity-75 shadow" />
              @endif
              <!--end::Brand Image-->

              <!--begin::Brand Text-->
              <span class="brand-text fw-bold">
                  {{ $appCompany->name ?? 'My Company' }}
              </span>
              <!--end::Brand Text-->
          </a> --}}

          <a href="{{ route('home') }}" class="brand-link">
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
                <a href="{{route('dashboard')}}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-speedometer text-warning"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
              </li>
              <!--begin::Business Menu-->
              <li class="nav-item {{ request()->routeIs('companies.*','branches.*','buildings.*','floors.*','flats.*','rooms.*','seats.*') ? 'menu-open' : '' }}">
                  <a href="#" class="nav-link {{ request()->routeIs('companies.*','branches.*','buildings.*','floors.*','flats.*','rooms.*','seats.*') ? 'active' : '' }}">
                      <i class="nav-icon bi bi-building text-primary"></i>
                      <p>
                          Business
                          <i class="nav-arrow bi bi-chevron-right"></i>
                      </p>
                  </a>

                  <ul class="nav nav-treeview">
                      @can('view company')
                      <li class="nav-item">
                          <a href="{{ route('companies.index') }}" 
                            class="nav-link {{ request()->routeIs('companies.*') ? 'active' : '' }}">
                              <i class="nav-icon bi bi-globe2 text-success"></i>
                              <p>Company</p>
                          </a>
                      </li>
                      @endcan

                      @can('view branch')
                      <li class="nav-item">
                          <a href="{{ route('branches.index') }}" 
                            class="nav-link {{ request()->routeIs('branches.*') ? 'active' : '' }}">
                              <i class="nav-icon bi bi-diagram-3 text-warning"></i>
                              <p>Branch</p>
                          </a>
                      </li>
                      @endcan

                      <!-- Building Section -->
                      <li class="nav-item {{ request()->routeIs('buildings.*','floors.*','flats.*','rooms.*','seats.*') ? 'menu-open' : '' }}">
                        @can('view building')
                          <a href="{{ route('buildings.index') }}" 
                            class="nav-link {{ request()->routeIs('buildings.*','floors.*','flats.*','rooms.*','seats.*') ? 'active' : '' }}">
                              <i class="nav-icon bi bi-house-door text-info"></i>
                              <p>
                                  Building
                                  <i class="nav-arrow bi bi-chevron-right"></i>
                              </p>
                          </a>
                        @endcan

                          <ul class="nav nav-treeview ms-3">
                            @can('view floor')
                              <li class="nav-item">
                                  <a href="{{ route('floors.index') }}" 
                                    class="nav-link {{ request()->routeIs('floors.*') ? 'active' : '' }}">
                                      <i class="bi bi-layers text-danger"></i>
                                      <p>Floor</p>
                                  </a>
                              </li>
                            @endcan
                            @can('view flat')
                              <li class="nav-item">
                                  <a href="{{ route('flats.index') }}" 
                                    class="nav-link {{ request()->routeIs('flats.*') ? 'active' : '' }}">
                                      <i class="bi bi-house text-success"></i>
                                      <p>Flat</p>
                                  </a>
                              </li>
                            @endcan  
                            @can('view room')
                              <li class="nav-item">
                                  <a href="{{ route('rooms.index') }}" 
                                    class="nav-link {{ request()->routeIs('rooms.*') ? 'active' : '' }}">
                                      <i class="bi bi-door-open text-primary"></i>
                                      <p>Room</p>
                                  </a>
                              </li>
                            @endcan  
                            @can('view seat')
                              <li class="nav-item">
                                  <a href="{{ route('seats.index') }}" 
                                    class="nav-link {{ request()->routeIs('seats.*') ? 'active' : '' }}">
                                      <i class="bi bi-circle text-success"></i>
                                      <p>Seat</p>
                                  </a>
                              </li>
                            @endcan                                
                          </ul>
                      </li>
                  </ul>
              </li>

              @can('view user')
                  <li class="nav-item">           
                    <a href="{{route('users.index')}}" class="nav-link {{ request()->routeIs('users.index') ? 'active' : '' }}">
                      <i class="bi bi-person text-primary"></i>
                      <p>User</p>
                    </a>
                  </li>
              @endcan


              @can('view permission')
                    <li class="nav-item">                    
                      <a href="{{route('permissions.index')}}" class="nav-link {{ request()->routeIs('permissions.index') ? 'active' : '' }}">
                        <i class="bi bi-key text-danger"></i>
                        <p>Permissions</p>
                      </a>
                    </li>
              @endcan
              @can('view role')
                    <li class="nav-item">                      
                      <a href="{{route('roles.index')}}" class="nav-link {{ request()->routeIs('roles.index') ? 'active' : '' }}">
                        <i class="bi bi-shield-lock text-danger"></i>
                        <p>Roles</p>
                      </a>
                    </li>
              @endcan
              @can('view product')
                    <li class="nav-item">                      
                      <a href="{{route('products.index')}}" class="nav-link {{ request()->routeIs('products.index') ? 'active' : '' }}">
                        <i class="bi bi-cart-fill text-success"></i>
                        <p>Product</p>
                      </a>
                    </li>
              @endcan



              {{-- <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-clipboard-fill"></i>
                  <p>
                    Layout Options
                    <span class="nav-badge badge text-bg-secondary me-3">6</span>
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="./layout/unfixed-sidebar.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Default Sidebar</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./layout/fixed-sidebar.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Fixed Sidebar</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./layout/fixed-header.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Fixed Header</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./layout/fixed-footer.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Fixed Footer</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./layout/fixed-complete.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Fixed Complete</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./layout/layout-custom-area.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Layout <small>+ Custom Area </small></p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./layout/sidebar-mini.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Sidebar Mini</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./layout/collapsed-sidebar.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Sidebar Mini <small>+ Collapsed</small></p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./layout/logo-switch.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Sidebar Mini <small>+ Logo Switch</small></p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./layout/layout-rtl.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Layout RTL</p>
                    </a>
                  </li>
                </ul>
              </li> --}}
              {{-- <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-tree-fill"></i>
                  <p>
                    UI Elements
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="./UI/general.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>General</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./UI/icons.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Icons</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./UI/timeline.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Timeline</p>
                    </a>
                  </li>
                </ul>
              </li> --}}
              {{-- <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-pencil-square"></i>
                  <p>
                    Forms
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="./forms/general.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>General Elements</p>
                    </a>
                  </li>
                </ul>
              </li> --}}
              {{-- <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-table"></i>
                  <p>
                    Tables
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="./tables/simple.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Simple Tables</p>
                    </a>
                  </li>
                </ul>
              </li> --}}
              {{-- <li class="nav-header">EXAMPLES</li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-box-arrow-in-right"></i>
                  <p>
                    Auth
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a> --}}
                {{-- <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon bi bi-box-arrow-in-right"></i>
                      <p>
                        Version 1
                        <i class="nav-arrow bi bi-chevron-right"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="./examples/login.html" class="nav-link">
                          <i class="nav-icon bi bi-circle"></i>
                          <p>Login</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="./examples/register.html" class="nav-link">
                          <i class="nav-icon bi bi-circle"></i>
                          <p>Register</p>
                        </a>
                      </li>
                    </ul>
                  </li> --}}
                  {{-- <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon bi bi-box-arrow-in-right"></i>
                      <p>
                        Version 2
                        <i class="nav-arrow bi bi-chevron-right"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="./examples/login-v2.html" class="nav-link">
                          <i class="nav-icon bi bi-circle"></i>
                          <p>Login</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="./examples/register-v2.html" class="nav-link">
                          <i class="nav-icon bi bi-circle"></i>
                          <p>Register</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a href="./examples/lockscreen.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Lockscreen</p>
                    </a>
                  </li>
                </ul>
              </li> --}}
              {{-- <li class="nav-header">DOCUMENTATIONS</li>
              <li class="nav-item">
                <a href="./docs/introduction.html" class="nav-link">
                  <i class="nav-icon bi bi-download"></i>
                  <p>Installation</p>
                </a>
              </li> --}}
              {{-- <li class="nav-item">
                <a href="./docs/layout.html" class="nav-link">
                  <i class="nav-icon bi bi-grip-horizontal"></i>
                  <p>Layout</p>
                </a>
              </li> --}}
              {{-- <li class="nav-item">
                <a href="./docs/color-mode.html" class="nav-link">
                  <i class="nav-icon bi bi-star-half"></i>
                  <p>Color Mode</p>
                </a>
              </li> --}}
              {{-- <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-ui-checks-grid"></i>
                  <p>
                    Components
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="./docs/components/main-header.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Main Header</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="./docs/components/main-sidebar.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Main Sidebar</p>
                    </a>
                  </li>
                </ul>
              </li> --}}
              {{-- <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-filetype-js"></i>
                  <p>
                    Javascript
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="./docs/javascript/treeview.html" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Treeview</p>
                    </a>
                  </li>
                </ul>
              </li> --}}
              {{-- <li class="nav-item">
                <a href="./docs/browser-support.html" class="nav-link">
                  <i class="nav-icon bi bi-browser-edge"></i>
                  <p>Browser Support</p>
                </a>
              </li> --}}
              {{-- <li class="nav-item">
                <a href="./docs/how-to-contribute.html" class="nav-link">
                  <i class="nav-icon bi bi-hand-thumbs-up-fill"></i>
                  <p>How To Contribute</p>
                </a>
              </li> --}}
              {{-- <li class="nav-item">
                <a href="./docs/faq.html" class="nav-link">
                  <i class="nav-icon bi bi-question-circle-fill"></i>
                  <p>FAQ</p>
                </a>
              </li> --}}
              {{-- <li class="nav-item">
                <a href="./docs/license.html" class="nav-link">
                  <i class="nav-icon bi bi-patch-check-fill"></i>
                  <p>License</p>
                </a>
              </li> --}}
              {{-- <li class="nav-header">MULTI LEVEL EXAMPLE</li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-circle-fill"></i>
                  <p>Level 1</p>
                </a>
              </li> --}}
              {{-- <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-circle-fill"></i>
                  <p>
                    Level 1
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Level 2</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>
                        Level 2
                        <i class="nav-arrow bi bi-chevron-right"></i>
                      </p>
                    </a>
                    <ul class="nav nav-treeview">
                      <li class="nav-item">
                        <a href="#" class="nav-link">
                          <i class="nav-icon bi bi-record-circle-fill"></i>
                          <p>Level 3</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="#" class="nav-link">
                          <i class="nav-icon bi bi-record-circle-fill"></i>
                          <p>Level 3</p>
                        </a>
                      </li>
                      <li class="nav-item">
                        <a href="#" class="nav-link">
                          <i class="nav-icon bi bi-record-circle-fill"></i>
                          <p>Level 3</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="nav-item">
                    <a href="#" class="nav-link">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Level 2</p>
                    </a>
                  </li>
                </ul>
              </li> --}}
              {{-- <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-circle-fill"></i>
                  <p>Level 1</p>
                </a>
              </li> --}}
              {{-- <li class="nav-header">LABELS</li>
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-circle text-danger"></i>
                  <p class="text">Important</p>
                </a>
              </li> --}}
              {{-- <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-circle text-warning"></i>
                  <p>Warning</p>
                </a>
              </li> --}}
              {{-- <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="nav-icon bi bi-circle text-info"></i>
                  <p>Informational</p>
                </a>
              </li> --}}
            </ul>
            <!--end::Sidebar Menu-->
          </nav>
        </div>
        <!--end::Sidebar Wrapper-->
      </aside>