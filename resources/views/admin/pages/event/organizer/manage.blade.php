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
                <li>{{ __('Manage Organizers') }}</li>
            </ol>
        </nav>

        <h1 class="h3 margin-top-bottom-0">{{ __('Manage Organizers') }}</h1>

        <div class="main-content">

            <!-- Create new user -->
            <livewire:admin.event.organizer.create title="{{ __('New organizer') }}"
                                       :hasSmallButton="false"
                                       :modalId="'m-create-organizer'">
            </livewire:admin.event.organizer.create>

            <table>
                <thead>
                <tr class="fs-14">
                    <th>{{ __('Name') }}</th>
                    <th>{{ __('Slug') }}</th>
                    <th>{{ __('Facebook Url') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($organizers as $organizer)
                    <tr>
                        <td><b>{{ $organizer->name }}</b></td>
                        <td class="fs-14">{{ $organizer->slug }}</td>
                        <td class="fs-14" style="word-break: break-word;">{{ $organizer->facebook_url }}</td>

                        <td>
                            <div class="flex flex-row">

                                @if(auth()->user()->hasRoles('super-administrator|administrator') )

                                    <!-- Delete tag -->
                                    <livewire:admin.event.organizer.delete title="{{ __('Delete organizer') }}"
                                                               :organizer="$organizer"
                                                               :hasSmallButton="false"
                                                               :modalId="'m-delete-organizer-' . $organizer->id"
                                    >
                                    </livewire:admin.event.organizer.delete>

                                    <!-- Update tag -->
                                    <livewire:admin.event.organizer.edit title="{{ __('Edit organizer') }}"
                                                             :organizer="$organizer"
                                                             :hasSmallButton="false"
                                                             :modalId="'m-edit-organizer-' . $organizer->id"
                                    >
                                    </livewire:admin.event.organizer.edit>
                                @endif
                            </div>

                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>

            @if (isset($organizers))
                {{ $organizers->links('global.components.pagination') }}
            @endif

        </div>
    </main>
@endsection
