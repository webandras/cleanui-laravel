@extends('admin.layouts.admin')

@section('content')

    <main class="padding-1">
        <h1 class="h2 margin-top-0 text-center">{{ __('Dashboard') }}</h1>

        <div class="dashboard-content">

            @auth
                <ul class="dashboard-card-grid">
                    <!-- Custom links -->

                    @role('super-administrator|administrator')
                    <!-- Demo components link -->
                    <li class="card text-center glassmorphic">
                        <a class="card-link" href="{{ route('home') }}">
                            <i class="fa-regular fa-book" aria-hidden="true"></i>
                            {{ __('Demo Components') }}
                        </a>
                    </li>

                    <li class="card text-center glassmorphic">
                        <a class="card-link" href="{{ route('post.manage') }}">
                            <i class="fa-regular fa-book" aria-hidden="true"></i>
                            {{ __('Manage Posts') }}
                        </a>
                    </li>

                    <li class="card text-center glassmorphic">
                        <a class="card-link" href="{{ route('category.manage') }}">
                            <i class="fa-regular fa-book" aria-hidden="true"></i>
                            {{ __('Manage Categories') }}
                        </a>
                    </li>

                    <li class="card text-center glassmorphic">
                        <a class="card-link" href="{{ route('tag.manage') }}">
                            <i class="fa-regular fa-book" aria-hidden="true"></i>
                            {{ __('Manage Tags') }}
                        </a>
                    </li>


                    <li class="card text-center glassmorphic">
                        <a class="card-link" href="{{ route('filemanager') }}">
                            <i class="fa-solid fa-photo-film" aria-hidden="true"></i>
                            {{ __('Media Library') }}
                        </a>
                    </li>
                    @endrole

                    @role('super-administrator')
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
                    @endrole

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

