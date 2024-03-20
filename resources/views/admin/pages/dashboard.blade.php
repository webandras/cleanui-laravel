@extends('admin.layouts.admin')

@section('content')

    <main class="padding-1">
        <h1 class="h2 margin-top-0 text-center">{{ __('Dashboard') }}</h1>

        <div class="dashboard-content">

            @auth

                <h2 class="h4 margin-top-2 margin-bottom-0-5 text-center">{{ __('Contents & Taxonomies') }}</h2>

                <ul class="dashboard-card-grid">
                    <!-- Custom links -->

                    @role('super-administrator|administrator')
                    <!-- Demo components link -->
                    <li class="card text-center glassmorphic">
                        <a class="card-link" href="{{ route('demo') }}">
                            <i class="fa-solid fa-palette" aria-hidden="true"></i>
                            {{ __('Demo Components') }}
                        </a>
                    </li>

                    <li class="card text-center glassmorphic">
                        <a class="card-link" href="{{ route('post.manage') }}">
                            <i class="fa-regular fa-newspaper" aria-hidden="true"></i>
                            {{ __('Manage Posts') }}
                        </a>
                    </li>

                    <li class="card text-center glassmorphic">
                        <a class="card-link" href="{{ route('category.manage') }}">
                            <i class="fa-solid fa-folder-open" aria-hidden="true"></i>
                            {{ __('Manage Categories') }}
                        </a>
                    </li>

                    <li class="card text-center glassmorphic">
                        <a class="card-link" href="{{ route('tag.manage') }}">
                            <i class="fa-solid fa-tags" aria-hidden="true"></i>
                            {{ __('Manage Tags') }}
                        </a>
                    </li>


                    <li class="card text-center glassmorphic">
                        <a class="card-link" href="{{ route('filemanager') }}">
                            <i class="fa-solid fa-photo-film" aria-hidden="true"></i>
                            {{ __('Media Library') }}
                        </a>
                    </li>

                    <li class="card text-center glassmorphic">
                        <a class="card-link" href="{{ route('document.manage') }}">
                            <i class="fa-regular fa-book" aria-hidden="true"></i>
                            {{ __('Manage Documentation') }}
                        </a>
                    </li>
                    @endrole

                </ul>

                @role('super-administrator|administrator')
                <h2 class="h4 margin-top-2 text-center">{{ __('Job Calendar') }}</h2>

                <ul class="dashboard-card-grid">
                    <!-- Custom links -->

                    <!-- Job calendar link -->
                    <li class="card text-center glassmorphic">
                        <a class="card-link" href="{{ route('job.calendar') }}">
                            <i class="fa fa-calendar" aria-hidden="true"></i>
                            <span>{{ __('Manage Jobs') }}</span>
                        </a>
                    </li>

                    <!-- Manage workers link -->
                    <li class="card text-center glassmorphic">
                        <a class="card-link" href="{{ route('worker.manage') }}">
                            <i class="fa-solid fa-person-digging" aria-hidden="true"></i>
                            {{ __('Manage workers') }}
                        </a>
                    </li>

                    <!-- Manage clients link -->
                    <li class="card text-center glassmorphic">
                        <a class="card-link" href="{{ route('client.manage') }}">
                            <i class="fa fa-address-card" aria-hidden="true"></i>
                            <span>{{ __('Manage clients') }}</span>
                        </a>
                    </li>

                    <li class="card text-center glassmorphic">
                        <a href="{{ route('job.statistics') }}" class="card-link">
                            <i class="fa fa-line-chart" aria-hidden="true"></i>{{ __('Statistics') }}
                        </a>
                    </li>
                </ul>
                @endrole


                @role('super-administrator')
                <h2 class="h4 margin-top-2 text-center">{{ __('Users, Roles & Permissions') }}</h2>

                <ul class="dashboard-card-grid">
                    <!-- Custom links -->

                    <!-- Manage users link -->
                    <li class="card text-center glassmorphic">
                        <a class="card-link" href="{{ route('user.manage') }}">
                            <i class="fa fa-users" aria-hidden="true"></i>
                            {{ __('Manage Users') }}
                        </a>
                    </li>


                    <!-- Manage roles and permissions link -->
                    <li class="card text-center glassmorphic">
                        <a class="card-link" href="{{ route('role-permission.manage') }}">
                            <i class="fa fa-lock" aria-hidden="true"></i>
                            {{ __('Roles and Permissions') }}
                        </a>
                    </li>
                </ul>
                @endrole


                <h2 class="h4 margin-top-2 text-center">{{ __('Account') }}</h2>

                <ul class="dashboard-card-grid">
                    <!-- Custom links -->

                    <!-- Account link -->
                    <li class="card text-center glassmorphic">
                        <a class="card-link" href="{{ route('user.account', auth()->id()) }}">
                            <i class="fa fa-user" aria-hidden="true"></i>
                            <span>{{ __('My Account') }}</span>
                        </a>
                    </li>

                    <!-- Logout link -->
                    <li class="card text-center glassmorphic">
                        <a
                            id="logout-form-dashboard-trigger"
                            class="card-link"
                            href="#"
                            role="button"
                        >
                            <i class="fa fa-sign-out" aria-hidden="true"></i>
                            {{ __('Logout') }}
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
                </ul>

            @endauth
        </div>
    </main>
@endsection

