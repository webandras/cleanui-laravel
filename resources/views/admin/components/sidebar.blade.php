<aside>
    <header>
        <h3 class="text-white fs-18">{{ Auth()->user()->name }}</h3>
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
                    <!-- Custom links -->
                    @role('super-administrator|administrator')

                    <!-- Manage posts/articles link -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('post.manage') ? 'active' : '' }}"
                           href="{{ route('post.manage') }}"
                        >
                            <i class="fa-regular fa-newspaper"></i>{{ __('Manage posts') }}
                        </a>
                    </li>


                    <!-- Manage categories link -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('category.manage') ? 'active' : '' }}"
                           href="{{ route('category.manage') }}"
                        >
                            <i class="fa-solid fa-folder-open"></i>{{ __('Manage categories') }}
                        </a>
                    </li>


                    <!-- Manage tags link -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('tag.manage') ? 'active' : '' }}"
                           href="{{ route('tag.manage') }}"
                        >
                            <i class="fa-solid fa-tags"></i>{{ __('Manage tags') }}
                        </a>
                    </li>
                    @endrole

                    @role('super-administrator')
                    <!-- Manage users link -->
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('user.manage') ? 'active' : '' }}"
                           href="{{ route('user.manage') }}"
                        >
                            <i class="fa fa-users" aria-hidden="true"></i>{{ __('Manage users') }}
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
