<section class="event-list-widget">
    <section x-data="{ show: false }" class="margin-bottom-2 event-list-widget--container" x-cloak>
        <button @click="show = !show"
                class="button alt primary left-align event-list-widget--search-button">{{ __('Search events') }}<i
                class="fa-solid margin-left-0-5" :class="show ? 'fa-chevron-up': 'fa-chevron-down'"></i>
        </button>
        <section x-show="show" class="accordion-item">

            <div class="row-padding margin-top-0 margin-bottom-0">
                <div class="col s12 m4 l4 margin-top-1">
                    <!-- Search Term -->
                    <label for="searchTerm" class="margin-top-0">{{ __('Search by keyword') }}</label>
                    <input id="searchTerm"
                           wire:model="searchTerm"
                           class="{{ $errors->has('searchTerm') ? ' border border-red' : '' }}"
                           type="search"
                           name="searchTerm"
                           placeholder="{{ __('Search for...') }}"
                    />
                    <p class="{{ $errors->has('searchTerm') ? 'error-message' : '' }}">
                        {{ $errors->has('searchTerm') ? $errors->first('searchTerm') : '' }}
                    </p>
                </div>

                <div class="col s12 m4 l4 margin-top-1">
                    <div>
                        <label for="city" class="margin-top-0">{{ __('Filter by city') }}</label>
                        <select
                            wire:model="city"
                            class="{{ $errors->has('city') ? 'border border-red' : '' }}"
                            name="city"
                        >
                            <option selected value="">{{ __("All cities") }}</option>
                            @foreach ($cities as $city)
                                <option value="{{ $city['city'] }}">
                                    {{ $city['city'] }}
                                </option>
                            @endforeach
                        </select>
                        <p class="{{ $errors->has('city') ? 'error-message' : '' }}">
                            {{ $errors->has('city') ? $errors->first('city') : '' }}
                        </p>
                    </div>
                </div>
                <div class="col s12 m4 l4 margin-top-1">

                    <label for="organizerId" class="margin-top-0">{{ __('Filter by organizer') }}
                    </label>
                    <select
                        wire:model="organizerId"
                        class="{{ $errors->has('organizerId') ? 'border border-red' : '' }}"
                        name="organizerId"
                    >
                        <option selected>{{ __("All") }}</option>
                        @foreach ($organizers as $organizer)
                            <option value="{{ $organizer['id'] }}">
                                {{ $organizer['name'] }}
                            </option>
                        @endforeach
                    </select>
                    <p class="{{ $errors->has('organizerId') ? 'error-message' : '' }}">
                        {{ $errors->has('organizerId') ? $errors->first('organizerId') : '' }}
                    </p>
                </div>
            </div>

            <div class="row-padding margin-top-1 margin-bottom-0">
                <div class="col s12 12 l12">
                    <div class="button-group">
                        <button wire:click="search"><i
                                class="fa-solid fa-magnifying-glass margin-right-0-5"></i>{{ __('Search') }}
                        </button>
                        <button wire:click="resetFilters"
                                class="reset-filters-button primary alt"><i
                                class="fa-solid fa-filter margin-right-0-5"></i>{{ __('Clear filters') }}</button>
                    </div>
                </div>


            </div>


        </section>
    </section>


    <section class="event-list-grid">
        @if(count($events) == 0)
            <p>{{ __('No events found for this query.') }}</p>
        @endif
        @isset($events)
            @foreach($events as $event)
                @php
                    $localTz = new \DateTimeZone($event->timezone ?? 'Europe/Budapest');

                    $startDate = new \DateTime($event->start, $utcTz);
                    $startDate = $startDate->setTimezone($localTz);
                    $startDateCarbon = Carbon\Carbon::parse($event->start, $utcTz)->setTimezone($localTz)->translatedFormat($dtFormat);
                    $startDateFormatted = $startDateCarbon;

                    $endDate = new \DateTime($event->end, $utcTz);
                    $endDate = $endDate->setTimezone($localTz);

                    if ($event->allDay == false) {
                        $endDateCarbon = Carbon\Carbon::parse($event->end, $utcTz)->setTimezone($localTz)->translatedFormat('H:i');
                    } else {
                        $endDateCarbon = Carbon\Carbon::parse($event->end, $utcTz)->setTimezone($localTz)->translatedFormat('M j. H:i');
                    }


                    $endDateFormatted = $endDateCarbon . ' ' . $endDate->format('T') . ' (' . $endDate->format('P') . ')';
                @endphp

                <style nonce="{{ csp_nonce() }}">
                    .event-image-grayscale {
                        filter: grayscale(60%)
                    }
                </style>


                <a href="{{ route('event.show', $event->slug) }}" class="no-underline event-item card white">
                    <figure class="relative cover-image-container">
                        @if($event->status === 'cancelled')
                            <span class="absolute bold fs-24 absolute-center z-2"
                            >
                                <strong class="event-cancelled">{{ __('CANCELLED!') }}</strong>
                            </span>
                        @endif
                        <img
                            class="round-top event-item-image {{ $event->status === 'cancelled' ? 'event-image-grayscale' : '' }}"
                            src="{{ asset($event->event_detail?->cover_image_url) ?? asset('/images/placeholder.png') }}"
                            alt="{{ $event->title }}">
                    </figure>
                    <article class="padding-1">
                        <h2 class="margin-top-0 margin-bottom-0-5 fs-22 {{ $event->status === 'cancelled' ? 'text-gray-60 strikethrough' : '' }}">{{ $event->status === 'cancelled' ? __('CANCELLED!') : '' }} {{ $event->title }}</h2>

                        <div class="event-date-red text-danger fs-14 semibold margin-bottom-1">{{ $startDateFormatted }}
                            - {{ $endDateCarbon }} <small
                                class="fs-16">{{ $endDate->format('T') }}</small>
                        </div>

                        <section>
                            <small><i class="fa-solid fa-user margin-right-0-5"></i>{{ $event->organizer->name }}
                            </small><br>
                            <small><i
                                    class="fa-solid fa-location-dot margin-right-0-5"></i>{{ $event->location->city }}
                            </small>
                        </section>
                    </article>
                </a>
            @endforeach
        @endisset

    </section>

    @if (isset($events))
        {{ $events->links('global.components.pagination-livewire', [ 'pageName' => 'page']) }}
    @endif
</section>
