<aside>
    <header>
        <h3 class="text-white fs-18">{{ __('Welcome, ') . Auth()->user()->name }}</h3>
    </header>
    <div class="sidebar-content">

        <!-- Custom content goes here -->
        <?php if (isset($sidebar)) { ?>

        {{ $sidebar }}

        <?php } ?><!-- Custom content goes here END -->

        <div class="padding-top-bottom-1">
            <ul class="navbar-nav margin-top-bottom-0 padding-left-right-0 no-bullets">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li>
                        <h4 class="fs-14 margin-top-bottom-0-5 padding-left-1 text-gray-60">{{ 'Content' }}</h4>
                    </li>

                    <!-- Custom links -->
                    @role('super-administrator|administrator')

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('demo') ? 'active' : '' }}"
                           href="{{ route('demo') }}"
                        >
                            <i class="fa-solid fa-palette" aria-hidden="true"></i>{{ __('Demo Components') }}
                        </a>
                    </li>


                    <!-- Manage posts/articles link -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('post.manage') ? 'active' : '' }}"
                           href="{{ route('post.manage') }}"
                        >
                            <i class="fa-regular fa-newspaper"></i>{{ __('Manage Posts') }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('document.manage') ? 'active' : '' }}"
                           href="{{ route('document.manage') }}"
                        >
                            <i class="fa-solid fa-book"></i>{{ __('Manage Documentation') }}
                        </a>
                    </li>

                    <!-- Media library link -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('filemanager') ? 'active' : '' }}"
                           href="{{ route('filemanager') }}"
                        >
                            <i class="fa-solid fa-photo-film"></i>{{ __('Media Library') }}
                        </a>
                    </li>


                    <li>
                        <h4 class="fs-14 margin-bottom-0-5 margin-top-2 padding-left-1 text-gray-60">{{ 'Taxonomies' }}</h4>
                    </li>

                    <!-- Manage categories link -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('category.manage') ? 'active' : '' }}"
                           href="{{ route('category.manage') }}"
                        >
                            <i class="fa-solid fa-folder-open"></i>{{ __('Manage Categories') }}
                        </a>
                    </li>


                    <!-- Manage tags link -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('tag.manage') ? 'active' : '' }}"
                           href="{{ route('tag.manage') }}"
                        >
                            <i class="fa-solid fa-tags"></i>{{ __('Manage Tags') }}
                        </a>
                    </li>


                    <li>
                        <h4 class="fs-14 margin-bottom-0-5 margin-top-2 padding-left-1 text-gray-60">{{ 'Manage jobs calendar' }}</h4>
                    </li>

                    <!-- Jobs calendar link -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('job.calendar') ? 'active' : '' }}"
                           href="{{ route('job.calendar') }}"
                        >
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                            <span>{{ __('Manage Jobs') }}</span>
                        </a>
                    </li>

                    <!-- Manage workers link -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('worker.manage') ? 'active' : '' }}"
                           href="{{ route('worker.manage') }}"
                        >
                            <i class="fa-solid fa-person-digging" aria-hidden="true"></i>
                            <span>{{ __('Manage Workers') }}</span>
                        </a>
                    </li>

                    <!-- Manage clients link -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('client.manage') ? 'active' : '' }}"
                           href="{{ route('client.manage') }}"
                        >
                            <i class="fa fa-address-card" aria-hidden="true"></i>
                            <span>{{ __('Manage Clients') }}</span>
                        </a>
                    </li>

                    <!-- Get worked hours statistics link -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('job.statistics') ? 'active' : '' }}"
                           href="{{ route('job.statistics') }}"
                        >
                            <i class="fa fa-line-chart" aria-hidden="true"></i>
                            <span>{{ __('Statistics') }}</span>
                        </a>
                    </li>



                    @endrole

                    <li>
                        <h4 class="fs-14 margin-bottom-0-5 margin-top-2 padding-left-1 text-gray-60">{{ 'Users & Roles' }}</h4>
                    </li>
                    @role('super-administrator')
                    <!-- Manage users link -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('user.manage') ? 'active' : '' }}"
                           href="{{ route('user.manage') }}"
                        >
                            <i class="fa fa-users" aria-hidden="true"></i>{{ __('Manage Users') }}
                        </a>
                    </li>

                    <!-- Role/Permissions link -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('role-permission.manage') ? 'active' : '' }}"
                           href="{{ route('role-permission.manage') }}"
                        >
                            <i class="fa fa-lock" aria-hidden="true"></i><span>{{ __('Roles and Permissions') }}</span>
                        </a>
                    </li>
                    @endrole

                    <!-- Account link -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('user.account') ? 'active' : '' }}"
                           href="{{ route('user.account', auth()->id()) }}"
                        >
                            <i class="fa fa-user" aria-hidden="true"></i><span>{{ __('My Account') }}</span>
                        </a>
                    </li>

                    <!-- Custom links END -->
                    <li class="nav-item">
                        <a
                            id="logout-form-admin-sidebar-trigger"
                            class="nav-link"
                            href="{{ route('logout') }}"
                        >
                            <i class="fa fa-sign-out" aria-hidden="true"></i>{{ __('Logout') }}
                        </a>

                        <form
                            id="logout-form-admin-sidebar"
                            action="{{ route('logout') }}"
                            method="POST"
                            class="hide"
                        >
                            @csrf
                        </form>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</aside>
