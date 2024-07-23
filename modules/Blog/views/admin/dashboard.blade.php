@extends('admin.layouts.admin')

@section('content')

    <main class="padding-1">
        <h1 class="h2 margin-top-0 text-center">{{ __('Dashboard') }}</h1>

        <div class="dashboard-content">

            @auth
                <h2 class="h4 margin-top-2 margin-bottom-0-5 text-center">{{ __('Contents & Taxonomies') }}</h2>

                <ul class="dashboard-card-grid">
                    <!-- Demo components link -->
                    <li class="card text-center glassmorphic">
                        <a class="card-link" href="{{ route('demo') }}">
                            <i class="fa-solid fa-palette" aria-hidden="true"></i>{{ __('Demo Components') }}
                        </a>
                    </li>
                    <!-- Demo components link END -->


                    @if(in_array('manage-posts', $userPermissions))
                        <!-- Manage posts -->
                        <li class="card text-center glassmorphic">
                            <a class="card-link" href="{{ route('post.manage') }}">
                                <i class="fa-regular fa-newspaper" aria-hidden="true"></i>{{ __('Manage Posts') }}
                            </a>
                        </li>
                        <!-- Manage posts END -->
                    @endif

                    @if(in_array('manage-categories', $userPermissions))
                        <!-- Manage categories -->
                        <li class="card text-center glassmorphic">
                            <a class="card-link" href="{{ route('category.manage') }}">
                                <i class="fa-solid fa-folder-open" aria-hidden="true"></i>{{ __('Manage Categories') }}
                            </a>
                        </li>
                        <!-- Manage categories END -->
                    @endif

                    @if(in_array('manage-tags', $userPermissions))
                        <!-- Manage tags -->
                        <li class="card text-center glassmorphic">
                            <a class="card-link" href="{{ route('tag.manage') }}">
                                <i class="fa-solid fa-tags" aria-hidden="true"></i>{{ __('Manage Tags') }}
                            </a>
                        </li>
                        <!-- Manage tags END -->
                    @endif

                    @if(in_array('manage-media', $userPermissions))
                        <!-- Manage media -->
                        <li class="card text-center glassmorphic">
                            <a class="card-link" href="{{ route('filemanager') }}">
                                <i class="fa-solid fa-photo-film" aria-hidden="true"></i>{{ __('Media Library') }}
                            </a>
                        </li>
                        <!-- Manage media END -->
                    @endif

                    @if(in_array('manage-documents', $userPermissions))
                        <!-- Manage documents -->
                        <li class="card text-center glassmorphic">
                            <a class="card-link" href="{{ route('document.manage') }}">
                                <i class="fa-regular fa-book" aria-hidden="true"></i>{{ __('Manage Documentation') }}
                            </a>
                        </li>
                        <!-- Manage documents END -->
                    @endif
                </ul>


                @if(in_array('manage-events', $userPermissions))
                    <h2 class="h4 margin-top-2 text-center">{{ __('Manage Events') }}</h2>

                    <ul class="dashboard-card-grid">
                        <!-- Manage events -->
                        <li class="card text-center glassmorphic">
                            <a class="card-link" href="{{ route('event.manage') }}">
                                <i class="fa-solid fa-calendar-days" aria-hidden="true"></i>{{ __('Manage Events') }}
                            </a>
                        </li>
                        <!-- Manage events END -->

                        <!-- Manage organizers -->
                        <li class="card text-center glassmorphic">
                            <a class="card-link" href="{{ route('organizer.manage') }}">
                                <i class="fa-solid fa-users"
                                   aria-hidden="true"></i><span>{{ __('Manage Organizers') }}</span>
                            </a>
                        </li>
                        <!-- Manage organizers END -->

                        <!-- Manage locations -->
                        <li class="card text-center glassmorphic">
                            <a class="card-link" href="{{ route('location.manage') }}">
                                <i class="fa-solid fa-location-dot"
                                   aria-hidden="true"></i><span>{{ __('Manage Locations') }}</span>
                            </a>
                        </li>
                        <!-- Manage locations END -->
                    </ul>
                @endif


                @if(in_array('manage-jobs', $userPermissions))
                    <h2 class="h4 margin-top-2 text-center">{{ __('Job Calendar') }}</h2>

                    <ul class="dashboard-card-grid">
                        <!-- Job calendar link -->
                        <li class="card text-center glassmorphic">
                            <a class="card-link" href="{{ route('job.calendar') }}">
                                <i class="fa fa-calendar" aria-hidden="true"></i><span>{{ __('Manage Jobs') }}</span>
                            </a>
                        </li>
                        <!-- Job calendar link END -->

                        <!-- Manage workers link -->
                        <li class="card text-center glassmorphic">
                            <a class="card-link" href="{{ route('worker.manage') }}">
                                <i class="fa-solid fa-person-digging" aria-hidden="true"></i>{{ __('Manage workers') }}
                            </a>
                        </li>
                        <!-- Manage workers link END -->

                        <!-- Manage clients link -->
                        <li class="card text-center glassmorphic">
                            <a class="card-link" href="{{ route('client.manage') }}">
                                <i class="fa fa-address-card"
                                   aria-hidden="true"></i><span>{{ __('Manage clients') }}</span>
                            </a>
                        </li>
                        <!-- Manage clients link END -->

                        <!-- Manage statistics link -->
                        <li class="card text-center glassmorphic">
                            <a href="{{ route('job.statistics') }}" class="card-link">
                                <i class="fa fa-line-chart" aria-hidden="true"></i>{{ __('Statistics') }}
                            </a>
                        </li>
                        <!-- Manage statistics link END -->
                    </ul>
                @endif


                @if(in_array('manage-users', $userPermissions) && in_array('manage-roles', $userPermissions) && in_array('manage-permissions', $userPermissions))
                    <h2 class="h4 margin-top-2 text-center">{{ __('Users, Roles & Permissions') }}</h2>

                    <ul class="dashboard-card-grid">
                        @endif
                        @if(in_array('manage-users', $userPermissions))
                            <!-- Manage users link -->
                            <li class="card text-center glassmorphic">
                                <a class="card-link" href="{{ route('user.manage') }}">
                                    <i class="fa fa-users" aria-hidden="true"></i>{{ __('Manage Users') }}
                                </a>
                            </li>
                            <!-- Manage users link END -->
                        @endif

                        @if(in_array('manage-roles', $userPermissions) && in_array('manage-permissions', $userPermissions))
                            <!-- Manage roles and permissions link -->
                            <li class="card text-center glassmorphic">
                                <a class="card-link" href="{{ route('role-permission.manage') }}">
                                    <i class="fa fa-lock" aria-hidden="true"></i>{{ __('Roles and Permissions') }}
                                </a>
                            </li>
                            <!-- Manage roles and permissions link END -->
                        @endif
                        @if(in_array('manage-users', $userPermissions) && in_array('manage-roles', $userPermissions) && in_array('manage-permissions', $userPermissions))
                    </ul>
                @endif


                @if(in_array('manage-account', $userPermissions))
                    <h2 class="h4 margin-top-2 text-center">{{ __('Account') }}</h2>

                    <ul class="dashboard-card-grid">
                        <!-- Account link -->
                        <li class="card text-center glassmorphic">
                            <a class="card-link" href="{{ route('user.account', auth()->id()) }}">
                                <i class="fa fa-user" aria-hidden="true"></i><span>{{ __('My Account') }}</span>
                            </a>
                        </li>
                        <!-- Account link END -->

                        <!-- Logout link -->
                        <li class="card text-center glassmorphic">
                            <a
                                id="logout-form-dashboard-trigger"
                                class="card-link"
                                href="#"
                                role="button"
                            >
                                <i class="fa fa-sign-out" aria-hidden="true"></i>{{ __('Logout') }}
                            </a>
                            <form
                                id="logout-form-dashboard"
                                action="{{ route('logout') }}"
                                method="POST"
                                class="hide"
                            >
                                @csrf
                            </form>
                        </li>
                        <!-- Logout link END -->
                    </ul>
                @endif

            @endauth
        </div>
    </main>
@endsection

