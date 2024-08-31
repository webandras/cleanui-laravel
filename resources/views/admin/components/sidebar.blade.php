<article class="sidebar">
    <header>
        <h3 class="text-white fs-18">{{ __('Welcome, ') . Auth()->user()->name }}</h3>
    </header>
    <section class="sidebar-content">

        <!-- Custom content goes here -->
        <?php if (isset($sidebar)) { ?>

        {{ $sidebar }}

        <?php } ?><!-- Custom content goes here END -->

        <ul class="navbar-nav margin-top-bottom-0 padding-left-right-0 no-bullets padding-top-bottom-1">
            @guest
                <!-- Authentication Links -->
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
                <!-- Authentication Links END -->
            @else
                <li>
                    <h4 class="fs-16 margin-top-bottom-0-5 padding-left-1 text-gray-60">{{ __('Content') }}</h4>
                </li>


                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('demo') ? 'active' : '' }}"
                       href="{{ route('demo') }}"
                    >
                        <i class="fa-solid fa-palette" aria-hidden="true"></i>{{ __('Demo Components') }}
                    </a>
                </li>

                @if(in_array('manage-posts', $userPermissions))
                    <!-- Manage posts/articles link -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('post.manage') ? 'active' : '' }}"
                           href="{{ route('post.manage') }}"
                        >
                            <i class="fa-regular fa-newspaper"></i>{{ __('Manage Posts') }}
                        </a>
                    </li>
                    <!-- Manage posts/articles link END -->
                @endif

                @if(in_array('manage-documents', $userPermissions))
                    <!-- Media documents link -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('document.manage') ? 'active' : '' }}"
                           href="{{ route('document.manage') }}"
                        >
                            <i class="fa-solid fa-book"></i>{{ __('Manage Documentation') }}
                        </a>
                    </li>
                    <!-- Media documents link END -->
                @endif

                @if(in_array('manage-media', $userPermissions))
                    <!-- Media library link -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('filemanager') ? 'active' : '' }}"
                           href="{{ route('filemanager') }}"
                        >
                            <i class="fa-solid fa-photo-film"></i>{{ __('Media Library') }}
                        </a>
                    </li>
                    <!-- Media library link END -->
                @endif


                @if(in_array('manage-categories', $userPermissions) || in_array('manage-tags', $userPermissions))
                    <li>
                        <h4 class="fs-16 margin-bottom-0-5 margin-top-2 padding-left-1 text-gray-60">{{ __('Taxonomies') }}</h4>
                    </li>
                @endif

                @if(in_array('manage-categories', $userPermissions))
                    <!-- Manage categories link -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('category.manage') ? 'active' : '' }}"
                           href="{{ route('category.manage') }}"
                        >
                            <i class="fa-solid fa-folder-open"></i>{{ __('Manage Categories') }}
                        </a>
                    </li>
                    <!-- Manage categories link END -->
                @endif

                @if(in_array('manage-tags', $userPermissions))
                    <!-- Manage tags link -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('tag.manage') ? 'active' : '' }}"
                           href="{{ route('tag.manage') }}"
                        >
                            <i class="fa-solid fa-tags"></i>{{ __('Manage Tags') }}
                        </a>
                    </li>
                    <!-- Manage tags link END -->
                @endif


                @if(in_array('manage-events', $userPermissions))
                    <li>
                        <h4 class="fs-16 margin-bottom-0-5 margin-top-2 padding-left-1 text-gray-60">{{ __('Manage Events') }}</h4>
                    </li>

                    <!-- Manage events -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('event.manage') ? 'active' : '' }}"
                           href="{{ route('event.manage') }}"
                        >
                            <i class="fa-solid fa-calendar-days"></i>{{ __('Manage Events') }}
                        </a>
                    </li>
                    <!-- Manage events END -->

                    <!-- Manage organizers -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('organizer.manage') ? 'active' : '' }}"
                           href="{{ route('organizer.manage') }}"
                        >
                            <i class="fa-solid fa-users"></i>{{ __('Manage Organizers') }}
                        </a>
                    </li>
                    <!-- Manage organizers END -->

                    <!-- Manage locations -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('location.manage') ? 'active' : '' }}"
                           href="{{ route('location.manage') }}"
                        >
                            <i class="fa-solid fa-location-dot"></i>{{ __('Manage Locations') }}
                        </a>
                    </li>
                    <!-- Manage locations END -->
                @endif


                @if(in_array('manage-jobs', $userPermissions))
                    <li>
                        <h4 class="fs-16 margin-bottom-0-5 margin-top-2 padding-left-1 text-gray-60">{{ __('Manage Jobs Calendar') }}</h4>
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
                    <!-- Jobs calendar link END -->

                    <!-- Manage workers link -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('worker.manage') ? 'active' : '' }}"
                           href="{{ route('worker.manage') }}"
                        >
                            <i class="fa-solid fa-person-digging" aria-hidden="true"></i>
                            <span>{{ __('Manage Workers') }}</span>
                        </a>
                    </li>
                    <!-- Manage workers link END -->

                    <!-- Manage clients link -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('client.manage') ? 'active' : '' }}"
                           href="{{ route('client.manage') }}"
                        >
                            <i class="fa fa-address-card" aria-hidden="true"></i>
                            <span>{{ __('Manage Clients') }}</span>
                        </a>
                    </li>
                    <!-- Manage clients link END -->

                    <!-- Get worked hours statistics link -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('job.statistics') ? 'active' : '' }}"
                           href="{{ route('job.statistics') }}"
                        >
                            <i class="fa fa-line-chart" aria-hidden="true"></i>
                            <span>{{ __('Statistics') }}</span>
                        </a>
                    </li>
                    <!-- Get worked hours statistics link END -->
                @endif


                @if(in_array('manage-users', $userPermissions) || in_array('manage-roles', $userPermissions) || in_array('manage-permissions', $userPermissions))
                    <li>
                        <h4 class="fs-16 margin-bottom-0-5 margin-top-2 padding-left-1 text-gray-60">{{ __('Users & Roles') }}</h4>
                    </li>
                @endif

                @if(in_array('manage-users', $userPermissions))
                    <!-- Manage users link -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('user.manage') ? 'active' : '' }}"
                           href="{{ route('user.manage') }}"
                        >
                            <i class="fa fa-users" aria-hidden="true"></i>{{ __('Manage Users') }}
                        </a>
                    </li>
                    <!-- Manage users link END -->
                @endif

                @if(in_array('manage-roles', $userPermissions) && in_array('manage-permissions', $userPermissions) )
                    <!-- Role/Permissions link -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('role-permission.manage') ? 'active' : '' }}"
                           href="{{ route('role-permission.manage') }}"
                        >
                            <i class="fa fa-lock"
                               aria-hidden="true"></i><span>{{ __('Roles and Permissions') }}</span>
                        </a>
                    </li>
                    <!-- Role/Permissions link END -->
                @endif


                @if(in_array('manage-account', $userPermissions))

                    <li>
                        <h4 class="fs-16 margin-bottom-0-5 margin-top-2 padding-left-1 text-gray-60">{{ __('Account') }}</h4>
                    </li>


                    <!-- Account link -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('user.account') ? 'active' : '' }}"
                           href="{{ route('user.account', auth()->id()) }}"
                        >
                            <i class="fa fa-user" aria-hidden="true"></i><span>{{ __('My Account') }}</span>
                        </a>
                    </li>
                    <!-- Account link END -->

                    <!-- Logout -->
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
                    <!-- Logout END -->
                @endif

            @endguest
        </ul>
    </section>
</article>
