@extends('public.layouts.event')

@section('seo')
    <x-public::meta
        :title="$event->title"
        :excerpt="$event->title"
        :coverImage="$event->event_detail->cover_image_url"
        :url="route('event.show', $event->slug)"
    ></x-public::meta>
@endsection

@push('head-extra')
    <link rel="stylesheet" href="{{ url('assets/leaflet-1.9.4/leaflet.css') }}"/>

    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="{{ url('assets/leaflet-1.9.4/leaflet.js') }}"></script>
@endpush

@section('content')

    @php
        $localTz = new \DateTimeZone($event->timezone ?? 'UTC');
        $utcTz = new \DateTimeZone("UTC");

        $startDate = new \DateTime($event->start, $utcTz);
        $startDate = $startDate->setTimezone($localTz);

        $startDateCarbon = Carbon\Carbon::parse($event->start, $utcTz)->setTimezone($localTz)->translatedFormat($dtFormat);
        $startDateFormatted = $startDateCarbon . ' ' . $startDate->format('T (O)');

        $endDate = new \DateTime($event->end, $utcTz);
        $endDate = $endDate->setTimezone($localTz);
        $endDateCarbon = Carbon\Carbon::parse($event->end, $utcTz)->setTimezone($localTz)->translatedFormat($dtFormat);
        $endDateFormatted = $endDateCarbon . ' ' . $endDate->format('T (O)');

        $bgLight = $event->backgroundColor !== '' ? $event->backgroundColor : '#3F57B9';
        $bgDark = $event->backgroundColorDark !== '' ? $event->backgroundColorDark : '#222222';
    @endphp

    <style nonce="{{ csp_nonce() }}">
        .event-image-bg-gradient {
            background: {{ $bgLight }};
            background: linear-gradient(180deg, {{ $bgLight }} 40%, {{ $bgDark }} 100%);
        }
    </style>


    <article class="event-container margin-top-0">
        <div class="relative event-cover-image-container event-image-bg-gradient">
            <div class="absolute topleft margin-left-2 margin-top-0-5 z-3">
                <a href="{{ route('event.index') }}" class="text-white fs-14 back-to-event-calendar-link">
                    <i class="fa-regular fa-calendar-days margin-right-0-5"></i>{{ __('Back to Events') }}</a>
            </div>

            @if($event->status === 'cancelled')
                <div class="absolute bold fs-36 absolute-center z-2"
                >
                    <div class="event-cancelled">{{ __('CANCELLED!') }}</div>
                </div>
            @endif

            <img src="{{ asset($event->event_detail->cover_image_url) ?? asset('/images/placeholder.png') }}"
                 alt="{{ $event->title }}"
                 class="event-cover-image {{ $event->status === 'cancelled' ? 'grayscale-60' : 'grayscale-0' }}"
            >
        </div>

        <div class="event-card card white relative z-3">

            <div class="absolute topleft card calendar-day">
                <div class="round-top calendar-day-header"></div>
                <div class="round-bottom flex calendar-day-body">
                    <strong class="fs-24">{{ $startDate->format('d') }}</strong>
                </div>
            </div>

            <div class="absolute topright facebook-icon-event">
                <a href="{{ $event->event_detail->facebook_url }}" title="{{ __('Go to the Facebook event') }}">
                    <img src="{{ url('/images/social/facebook-blue.png') }}" class="event-facebook-logo" alt="Facebook logo">
                </a>
            </div>

            <header class="event-card-header">
                <h1 class="text-left event-title margin-top-0 padding-top-0 h1 single-post-title {{ $event->status === 'cancelled' ? 'text-gray-60 strikethrough' : '' }}">{{ $event->status === 'cancelled' ? __('CANCELLED!') : '' }} {{ $event->title }}</h1>

                <div
                    class="event-dates semibold fs-18 text-red margin-top-bottom-0-5">
                    <span>{{ $startDateFormatted }}</span>
                    &nbsp;&mdash;&nbsp;
                    <span>{{ $endDateFormatted }}</span>

                </div>
                <h2 class="fs-16 event-subtitle text-gray-60 medium padding-top-bottom-0-5">
                    <i class="fa-solid fa-location-dot margin-right-0-5"></i>
                    {{ $event->organizer->name }}
                    &nbsp;|&nbsp; {{ $event->location->city }}</h2>
                <hr class="margin-top-bottom-0">
            </header>

            <div class="row-padding">
                <div class="col l8 m12 s12">

                    <main class="event-content-main">
                        <h3 class="margin-top-0-5 fs-18 uppercase text-gray-80 semibold">{{ __('Details:') }}</h3>
                        <nav>
                            <ul class="no-bullets padding-left-right-0 margin-top-0">
                                <li class="margin-bottom-0-5">
                                    <a href="{{ $event->organizer->facebook_url }}">
                                        <i class="fa-solid fa-user margin-right-0-5"></i>{{ $event->organizer->name }}</a> {{ __('(organizer)') }}
                                </li>
                                <li class="margin-bottom-0-5">
                                    <a href="{{ $event->event_detail->facebook_url }}" class="word-break">
                                        <i class="fa-brands fa-facebook margin-right-0-5"></i>{{ __('Facebook event link') }}</a>
                                </li>
                                @isset($event->event_detail->tickets_url)
                                    <li class="margin-bottom-0-5">
                                        <a href="{{ $event->event_detail->tickets_url }}"
                                           class="word-break">
                                            <i class="fa-solid fa-ticket margin-right-0-5"></i>{{ __('Buy tickets link') }}
                                        </a>
                                    </li>
                                @endisset

                                <li class="margin-bottom-0-5">
                                    <a title="{{ __('Google Map search') }}"
                                       href="{{ 'https://www.google.com/maps/search/?api=1&query=' . urlencode($event->location->address) }}"
                                       class="word-break">
                                        <i class="fa-solid fa-map margin-right-0-5"></i>{{ $event->location->name . ', ' . $event->location->address }}
                                    </a>
                                </li>
                            </ul>
                        </nav>

                        <hr class="divider">

                        <h3 class="margin-top-0-5 fs-18 uppercase text-gray-80 semibold">{{ __('Description:') }}</h3>
                        <div class="post-content">
                            {!! $event->description !!}
                        </div>
                    </main>

                </div>


                <div class="col l4 m12 s12">
                    <aside class="event-content-aside margin-left-right-1 padding-bottom-1-5">

                        @isset($event->event_detail->tickets_url)
                            <h3 class="margin-top-0 fs-18 uppercase text-gray-80 semibold">{{ __('Tickets:') }}</h3>

                            <a class="button primary button-large margin-top-0 {{ $event->status === 'cancelled' ? 'disabled' : '' }}" href="{{  $event->status !== 'cancelled' ? $event->event_detail->tickets_url : '#' }}">
                                <i class="fa-solid fa-ticket margin-right-0-5"></i>
                                {{ __('Buy tickets here') }}
                            </a>
                        @endisset


                        <h3 class="margin-top-2 fs-18 uppercase text-gray-80 semibold">{{ __('Map:') }}</h3>

                        <small>
                            <a href="https://www.openstreetmap.org/?mlat={{ $event->location->latitude }}&amp;mlon={{ $event->location->longitude }}#map=19/{{ $event->location->latitude }}/{{ $event->location->longitude }}">
                                {{ __('Bigger map') }}
                            </a>
                        </small><br/>

                        <div id="osm-map" class="osm-embed"></div>


                        <script nonce="{{ csp_nonce() }}">
                            const map = L.map('osm-map', {
                                scrollWheelZoom: false,
                                center: [{{ $event->location->latitude }}, {{ $event->location->longitude }}],
                                zoom: 16
                            });
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'}).addTo(map);
                            const marker1 = L.marker([{{ $event->location->latitude }}, {{ $event->location->longitude }}]).addTo(map);
                        </script>


                        <h4 class="margin-top-0-5 margin-bottom-0 fs-16">{{ $event->location->name }}</h4>
                        <small
                            class="fs-14 text-gray-60">{{ $event->location->latitude . ', ' . $event->location->longitude }}</small>
                    </aside>
                </div>

            </div>

        </div>

    </article>
@endsection

