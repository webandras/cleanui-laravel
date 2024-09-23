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
                <li>{{ __('Manage Events') }}</li>
            </ol>
        </nav>

        <h1 class="h3 margin-top-bottom-0">{{ __('Manage Events') }}</h1>

        <div class="main-content">

            <!-- Create new event -->
            <a href="{{ route('event.create') }}"
               class="primary button"
               title="{{ __('Create new event') }}">
                <i class="fa fa-plus" aria-hidden="true"></i>
                {{ __('New event') }}
            </a>


            <table>
                <thead>
                <tr class="fs-14">
                    <th>#</th>
                    <th>{{ __('Title (slug, links)') }}</th>
                    <th>{{ __('Start') }}</th>
                    <th>{{ __('End') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $index = 1;
                    $currentPage = $events->currentPage()
                @endphp
                @foreach($events as $event)
                    <tr>
                        <td>
                            @if($currentPage > 1)
                                {{ ($currentPage - 1) * $events->perPage() + $index++ }}.
                            @else
                                {{ $index++ }}.
                            @endif
                        </td>
                        <td>
                            <h2 class="padding-right-0-5 h4 margin-top-bottom-0">
                                {{ $event->title }}
                            </h2>
                            <small>/{{ $event->slug }}</small>

                            @isset ($event->event_detail->cover_image_url)
                                <img
                                    src="{{ asset($event->event_detail?->cover_image_url) ?? asset('/images/placeholder.png') }}"
                                    alt="{{__('Cover image preview') }}"
                                    class="hover-opacity border margin-bottom-0-5" width="140px">
                            @endisset
                        </td>

                        @php
                            $localTz = new \DateTimeZone($event->timezone);
                            $utcTz = new \DateTimeZone("UTC");

                            $startDate = new \DateTime($event->start, $utcTz);
                            $startDate = $startDate->setTimezone($localTz);

                            $endDate = new \DateTime($event->end, $utcTz);
                            $endDate = $endDate->setTimezone($localTz);

                        @endphp

                        <td>
                            {{ $startDate->format("Y-m-d H:i T") }}
                        </td>
                        <td>
                            {{ $endDate->format("Y-m-d H:i T") }}
                        </td>

                        <td>
                            <div class="flex flex-row">

                                @if(auth()->user()->hasRoles('super-administrator|administrator') )

                                    <!-- View post -->
                                    <a href="{{ route('event.show', $event->slug) }}"
                                       target="_blank"
                                       title="View event"
                                       class="button success margin-top-0"
                                    >
                                        <i class="fa-solid fa-eye"></i>
                                        {{ __('View') }}
                                    </a>

                                    <!-- Edit post -->
                                    <a href="{{ route('event.edit', $event->id) }}"
                                       class="button info margin-top-0"
                                       title="{{ __('Edit event') }}">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                        {{ __('Edit') }}
                                    </a>


                                    <!-- Delete post -->
                                    <livewire:admin.event.delete title="{{ __('Delete event') }}"
                                                                 :event="$event"
                                                                 :hasSmallButton="false"
                                                                 :modalId="'m-delete-event-' . $event->id"
                                    >
                                    </livewire:admin.event.delete>
                                @endif
                            </div>

                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>

            @if (isset($events))
                {{ $events->links('global.components.pagination', ['pageName' => 'page']) }}
            @endif

        </div>
    </main>
@endsection
