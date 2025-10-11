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
                <a href="{{route('dashboard')}}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                  <i class="nav-icon bi bi-speedometer text-white"></i>
                  <p>
                    Dashboard
                  </p>
                </a>
              </li>
              <!--begin::Business Menu-->
              <li class="nav-item {{ request()->routeIs('companies.*','branches.*','buildings.*','floors.*','flats.*','rooms.*','seats.*') ? 'menu-open' : '' }}">
                  <a href="#" class="nav-link {{ request()->routeIs('companies.*','branches.*','buildings.*','floors.*','flats.*','rooms.*','seats.*') ? 'active' : '' }}">
                      <i class="nav-icon bi bi-hospital  text-white"></i>
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
                              <i class="nav-icon bi bi-globe2 text-white"></i>
                              <p>Company</p>
                          </a>
                      </li>
                      @endcan

                      @can('view branch')
                      <li class="nav-item">
                          <a href="{{ route('branches.index') }}" 
                            class="nav-link {{ request()->routeIs('branches.*') ? 'active' : '' }}">
                              <i class="nav-icon bi bi-diagram-3 text-white"></i>
                              <p>Branch</p>
                          </a>
                      </li>
                      @endcan

                      <!-- Building Section -->
                      <li class="nav-item {{ request()->routeIs('buildings.*','floors.*','flats.*','rooms.*','seats.*') ? 'menu-open' : '' }}">
                        @can('view building')
                          <a href="{{ route('buildings.index') }}" 
                            class="nav-link {{ request()->routeIs('buildings.*','floors.*','flats.*','rooms.*','seats.*') ? 'active' : '' }}">
                              <i class="nav-icon bi bi-building text-white"></i>
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
                                      <i class="bi bi-layers text-white"></i>
                                      <p>Floor</p>
                                  </a>
                              </li>
                            @endcan
                            @can('view flat')
                              <li class="nav-item">
                                  <a href="{{ route('flats.index') }}" 
                                    class="nav-link {{ request()->routeIs('flats.*') ? 'active' : '' }}">
                                      <i class="bi bi-house text-white"></i>
                                      <p>Flat</p>
                                  </a>
                              </li>
                            @endcan  
                            @can('view room')
                              <li class="nav-item">
                                  <a href="{{ route('rooms.index') }}" 
                                    class="nav-link {{ request()->routeIs('rooms.*') ? 'active' : '' }}">
                                      <i class="bi bi-door-open text-white"></i>
                                      <p>Room</p>
                                  </a>
                              </li>
                            @endcan  
                            @can('view seat')
                              <li class="nav-item">
                                  <a href="{{ route('seats.index') }}" 
                                    class="nav-link {{ request()->routeIs('seats.*') ? 'active' : '' }}">
                                      <i class="bi bi-star text-white"></i>
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
                    <a href="{{route('users.index')}}" class="nav-link {{ request()->routeIs('users.index','users.create','users.edit') ? 'active' : '' }}">
                      <i class="bi bi-person text-white mt-1"></i>
                      <p>User</p>
                    </a>
                  </li>
              @endcan
                  <li class="nav-item">           
                    <a href="{{route('members.index')}}" class="nav-link {{ request()->routeIs('members.index','members.create','members.edit') ? 'active' : '' }}">
                      <i class="bi bi-person-vcard text-white mt-1"></i>
                      <p>Member</p>
                    </a>
                  </li>

              @can('view permission')
                    <li class="nav-item">                    
                      <a href="{{route('permissions.index')}}" class="nav-link {{ request()->routeIs('permissions.index','permissions.create','permissions.edit') ? 'active' : '' }}">
                        <i class="bi bi-key text-white mt-1"></i>
                        <p>Permissions</p>
                      </a>
                    </li>
              @endcan
              @can('view role')
                    <li class="nav-item">                      
                      <a href="{{route('roles.index')}}" class="nav-link {{ request()->routeIs('roles.index','roles.create','roles.edit') ? 'active' : '' }}">
                        <i class="bi bi-shield-lock text-white mt-1"></i>
                        <p>Roles</p>
                      </a>
                    </li>
              @endcan
              @can('view product')
                    <li class="nav-item">                      
                      <a href="{{route('products.index')}}" class="nav-link {{ request()->routeIs('products.index','products.create','products.edit') ? 'active' : '' }}">
                        <i class="bi bi-cart-fill text-white mt-1"></i>
                        <p>Product</p>
                      </a>
                    </li>
              @endcan

                    <li class="nav-item">                      
                      <a href="{{route('slots.index')}}" class="nav-link {{ request()->routeIs('slots.index') ? 'active' : '' }}">
                        <i class="bi bi-alarm text-white mt-1"></i>
                        <p>Slots</p>
                      </a>
                    </li>

                    <li class="nav-item">                      
                      <a href="{{route('routines.index')}}" class="nav-link {{ request()->routeIs('routines.index') ? 'active' : '' }}">
                        <i class="bi bi-journal-text text-white mt-1"></i>
                        <p>Routines</p>
                      </a>
                    </li>
                    
                    <li class="nav-item">                      
                      <a href="{{route('product_orders.index')}}" class="nav-link {{ request()->routeIs('product_orders.index') ? 'active' : '' }}">
                        <i class="bi bi-box-seam text-white mt-1"></i>
                        <p>Meal-Orders</p>
                      </a>
                    </li>
                    <li class="nav-item">                      
                      <a href="{{route('product-discounts.index')}}" class="nav-link {{ request()->routeIs('product-discounts.index') ? 'active' : '' }}">
                        <i class="bi bi-tag-fill text-white mt-1"></i>
                        <p>Meal-Discount</p>
                      </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('reports.index') }}" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                            <i class="bi bi-clipboard-data mt-1"></i>
                            <p>Reports</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('notices.index') }}" class="nav-link {{ request()->routeIs('notices.*') ? 'active' : '' }}">
                            <i class="bi-megaphone-fill mt-1"></i>
                            <p>Notice</p>
                        </a>
                    </li>




              
            </ul>
            <!--end::Sidebar Menu-->
          </nav>
        </div>
        <!--end::Sidebar Wrapper-->
      </aside>