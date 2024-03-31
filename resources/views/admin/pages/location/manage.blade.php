@extends('admin.layouts.admin')

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
                <li>{{ __('Manage Locations') }}</li>
            </ol>
        </nav>

        <h1 class="h3 margin-top-bottom-0">{{ __('Manage locations') }}</h1>

        <div class="main-content">

            <!-- Create new user -->
            <livewire:admin.location.create title="{{ __('New location') }}"
                                      :hasSmallButton="false"
                                      :modalId="'m-create-location'">
            </livewire:admin.location.create>

            <table>
                <thead>
                <tr class="fs-14">
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Address') }}</th>

                    <th>{{ __('Coordinates') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($locations as $location)
                    <tr>
                        <td><b>{{ $location->name }}</b><br><span class="fs-12">{{ $location->city }}</span></td>
                        <td class="fs-14">{{ $location->address }}</td>

                        <td class="fs-14">
                            <i class="fa-solid fa-location-dot"></i>
                            {{ __('Latitude: ') . $location->latitude }}
                            <br>
                            {{ __('Longitude: ') . $location->longitude }}
                        </td>
                        <td>
                            <div class="flex flex-row">

                                @if(auth()->user()->hasRoles('super-administrator|administrator') )

                                    <!-- Delete tag -->
                                    <livewire:admin.location.delete title="{{ __('Delete location') }}"
                                                              :location="$location"
                                                              :hasSmallButton="false"
                                                              :modalId="'m-delete-location-' . $location->id"
                                    >
                                    </livewire:admin.location.delete>

                                    <!-- Update tag -->
                                    <livewire:admin.location.edit title="{{ __('Edit location') }}"
                                                            :location="$location"
                                                            :hasSmallButton="false"
                                                            :modalId="'m-edit-location-' . $location->id"
                                    >
                                    </livewire:admin.location.edit>
                                @endif
                            </div>

                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>

            @if (isset($locations))
                {{ $locations->links('global.components.pagination') }}
            @endif

        </div>
    </main>
@endsection
