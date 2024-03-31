<?php

namespace App\Http\Livewire\Public\Event;

use App\Interface\Repository\Event\EventRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class Calendar extends Component
{
    // Event list as collection
    public Collection $events;

    public array $timezoneIdentifiers;
    public string $timezone;


    /**
     * @var EventRepositoryInterface
     */
    private EventRepositoryInterface $eventRepository;


    /**
     * @param  EventRepositoryInterface  $eventRepository
     */
    public function boot(EventRepositoryInterface $eventRepository) {
        $this->eventRepository = $eventRepository;
    }


    public function mount() {
        $this->timezoneIdentifiers = \DateTimeZone::listIdentifiers(\DateTimeZone::EUROPE);
        $this->timezone = session('timezone') ?? 'Europe/Budapest';
    }

    // the updated* method follows your variable name and is camel-cased, in this sample, 'foo'
    public function updatedTimezone(): void
    {
        session(['timezone' => $this->timezone]);
        redirect()->route('event.index');
    }


    public function render()
    {
        $lastMonth = Carbon::now()->startOfMonth()->subMonths(3);
        $this->events = $this->eventRepository->getEventsNewerThan($lastMonth->toDateString());

        return view('public.livewire.event.calendar');
    }


    public function redirectToSingleEvent(string $slug) {
        redirect()->route('event.show', $slug);
    }
}
