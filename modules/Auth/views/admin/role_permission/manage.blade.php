@extends('admin.layouts.admin')

@push('head-extra')
    <link href="{{ url('assets/tom-select/tom-select-2.2.2.css') }}" rel="stylesheet">
@endpush

@section('content')

    <main class="padding-1">
        <nav class="breadcrumb breadcrumb-left">
            <ol>
                <li>
                    <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
                </li>
                <li>
                    <i class="fa-solid fa-angle-right"></i>
                </li>
                <li>{{ __('Manage Roles and Permissions') }}</li>
            </ol>
        </nav>

        <div class="main-content">

            @php
                $activeTab = session('flash.activeTab') ?? 'Roles';
            @endphp

            <div x-data="tabsData( @js($activeTab) )" class="border border-40 round">

                <div class="bar roles-permissions-bar">
                    <a id="RolesTrigger"
                       href="#"
                       role="button"
                       aria-label="{{ __('Roles tab') }}"
                       class="bar-item tab-switcher"
                       @click="switchTab('Roles')"
                       :class="{'tab-switcher-active': tabId === 'Roles'}"
                    >
                        {{ __('Roles') }}
                    </a>

                    <a id="PermissionsTrigger"
                       href="#"
                       role="button"
                       aria-label="{{ __('Permissions tab') }}"
                       class="bar-item tab-switcher"
                       @click="switchTab('Permissions')"
                       :class="{'tab-switcher-active': tabId === 'Permissions'}"
                    >
                        {{ __('Permissions') }}
                    </a>
                </div>

                <div id="Roles" class="box tabs animate-opacity">

                    <h1 class="h3">{{ __('Manage roles') }}</h1>

                    <!-- Create role -->
                    <livewire:admin.auth.role.create title="{{ __('New role') }}"
                                                     :permissions="$permissions"
                                                     :hasSmallButton="false"
                                                     :modalId="'m-create-role'"
                    >
                    </livewire:admin.auth.role.create>

                    <table>
                        <thead>
                        <tr class="fs-14">
                            <th>{{ __('Role') }}</th>
                            <th>{{ __('Slug') }}</th>
                            <th>{{ __('Permissions') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td><strong>{{ $role->name }}</strong></td>
                                <td class="italic">{{ $role->slug }}</td>
                                <td class="fs-12">
                                    @if($role->permissions->count() > 0)
                                        @foreach($role->permissions as $rolePermission)
                                            <span
                                                class="badge gray-60 margin-bottom-0-5">{{ $rolePermission->name }}</span>
                                        @endforeach
                                    @else
                                        <p class="text-gray-60">{{__('No associated permissions.')}}</p>
                                    @endif
                                </td>
                                <td>
                                    <div class="flex flex-row">
                                        <!-- Delete role -->
                                        <livewire:admin.auth.role.delete title="{{ __('Delete role') }}"
                                                                         :role="$role"
                                                                         :hasSmallButton="false"
                                                                         :modalId="'m-delete-role-' . $role->id"
                                        >
                                        </livewire:admin.auth.role.delete>

                                        <!-- Update role -->
                                        <livewire:admin.auth.role.edit title="{{ __('Edit role') }}"
                                                                       :role="$role"
                                                                       :permissions="$permissions"
                                                                       :hasSmallButton="false"
                                                                       :modalId="'m-edit-role-' . $role->id"
                                        >
                                        </livewire:admin.auth.role.edit>

                                    </div>

                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>

                <div id="Permissions" class="box tabs animate-opacity">

                    <div x-data="{}" x-cloak>
                        <h1 class="h3">{{ __('Manage permissions') }}</h1>

                        <!-- Create role -->
                        <livewire:admin.auth.permission.create title="{{ __('New permission') }}" :roles="$roles"
                                                               :hasSmallButton="false"
                                                               :modalId="'m-create-permission'">
                        </livewire:admin.auth.permission.create>

                        <table>
                            <thead>
                            <tr class="fs-14">
                                <th>{{ __('Permission') }}</th>
                                <th>{{ __('Slug') }}</th>
                                <th>{{ __('Roles') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($permissions as $permission)
                                <tr>
                                    <td><b>{{ $permission->name }}</b></td>
                                    <td class="italic">{{ $permission->slug }}</td>
                                    <td class="fs-12">
                                        @if($permission->roles->count() > 0)
                                            @foreach($permission->roles as $permissionRole)
                                                <span
                                                    class="badge gray-60 margin-bottom-0-5">{{ $permissionRole->name }}</span>
                                            @endforeach
                                        @else
                                            <p class="text-gray-60">{{__('No associated roles.')}}</p>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="flex flex-row">
                                            <!-- Delete role -->
                                            <livewire:admin.auth.permission.delete title="{{ __('Delete permission') }}"
                                                                                   :permission="$permission"
                                                                                   :hasSmallButton="false"
                                                                                   :modalId="'m-delete-permission-' . $permission->id"
                                            >
                                            </livewire:admin.auth.permission.delete>

                                            <!-- Update role -->
                                            <livewire:admin.auth.permission.edit title="{{ __('Edit permission') }}"
                                                                                 :permission="$permission"
                                                                                 :roles="$roles"
                                                                                 :hasSmallButton="false"
                                                                                 :modalId="'m-edit-permission-' . $permission->id"
                                            >
                                            </livewire:admin.auth.permission.edit>

                                        </div>

                                    </td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>


                </div>
            </div>


        </div>
    </main>
@endsection

@push('scripts')
    <script src="{{ url('assets/tom-select/tom-select-2.2.2.js') }}"></script>
@endpush
