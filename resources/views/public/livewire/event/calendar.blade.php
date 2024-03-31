<div id="calendar-container" wire:ignore>
    <div id="calendar" class="padding-1"></div>
</div>

@push('scripts')
    <!-- include moment and one of the moment-timezone builds -->
    <script nonce="{{ csp_nonce() }}" src="{{ url('/js/moment.js.min.2.29.4.js') }}"></script>
    <script nonce="{{ csp_nonce() }}" src="{{ url('/js/moment-timezone.min.5.40.js') }}"></script>

    <script nonce="{{ csp_nonce() }}" src="{{ url('/js/fullcalendar.6.1.7.min.js') }}"></script>
    <!-- the connector. must go AFTER moment-timezone -->
    <script nonce="{{ csp_nonce() }}" src="{{ url('/js/fullcalendar.moment-timezone.min.6.1.8.js') }}"></script>

    <script nonce="{{ csp_nonce() }}">
        document.addEventListener('livewire:load', function () {
            // Translations for the calendar
            var hu = {
                code: 'hu',
                week: {
                    dow: 1,
                    doy: 4, // The week that contains Jan 4th is the first week of the year.
                },
                buttonText: {
                    prev: 'vissza',
                    next: 'előre',
                    today: 'ma',
                    year: 'Év',
                    month: 'Hónap',
                    week: 'Hét',
                    day: 'Nap',
                    list: 'Lista',
                },
                weekText: 'Hét',
                allDayText: 'Egész nap',
                moreLinkText: 'további',
                noEventsText: 'Nincs megjeleníthető esemény',
            };

            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                timeZone: 'UTC', // the default (unnecessary to specify)
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek'
                },
                locale: hu,
                allDaySlot: true,
                defaultAllDay: false,
                slotMinTime: '00:00:00',
                slotMaxTime: '24:00:00',
                firstDay: 1,
                fixedWeekCount: 5,
                showNonCurrentDates: true,
                nowIndicator: true,
                eventBackgroundColor: '#3F57B9',
                eventBorderColor: '#333',
                eventTimeFormat: {hour: 'numeric', minute: '2-digit', timeZoneName: 'short'},

                editable: false,
                selectable: false,

                eventClick: function (eventClickInfo) {
                @this.redirectToSingleEvent(eventClickInfo.event.extendedProps.slug);
                },

                eventDidMount: updateEventData

            });

            // Collection jsonified
            calendar.addEventSource( @json( $events ) )
            calendar.setOption('contentHeight', 600);
            calendar.render();


            function updateEventData(info) {
                var el = info.el;
                var event = info.event;
                var view = info.view;

                // inner flex container of the event
                const container = el.firstChild.firstChild;

                // get datetime values in the right timezone
                var startStr = event.startStr;
                var endStr = event.endStr;
                var tz = event.extendedProps.timezone;
                var startTime = moment.tz(startStr, tz);
                var endTime = moment.tz(endStr, tz);

                // month view
                if (view.type === 'dayGridMonth') {
                    // Used only for dot events (for multi-day events, the time is not shown
                    // This calculates the time in local timezone (defined in the timezone column in the db)
                    // Db contains the datetime values in UTC!
                    const eventTime = el.childNodes[1];
                    if (eventTime) {
                        eventTime.innerText = startTime.format('HH:mm z');
                    }

                  if (event.extendedProps.status === 'cancelled') {
                        const eventTitle = container.childNodes[1].firstChild;
                        eventTitle.innerText = @js( __('CANCELLED!')) +' ' + event.title
                    }

                }

                // week view
                if (view.type === 'timeGridWeek' && container && event.extendedProps && event.allDay === false) {
                    // the DOM structure is a bit different in this view
                    const eventTime = container.childNodes[0];

                    if (eventTime) {
                        eventTime.innerText = startTime.format('HH:mm') + ' - ' + endTime.format('HH:mm z');
                    }
                }
            }

        });
    </script>

@endpush
