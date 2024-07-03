<?php

namespace Modules\Livewire\Public\Event;

use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Application;
use Livewire\Component;
use Modules\Event\Interfaces\Repositories\EventRepositoryInterface;

class Calendar extends Component
{
    // Event list as collection
    /**
     * @var Collection
     */
    public Collection $events;


    /**
     * @var array
     */
    public array $timezoneIdentifiers;


    /**
     * @var string
     */
    public string $timezone;


    /**
     * @var EventRepositoryInterface
     */
    private EventRepositoryInterface $eventRepository;


    /**
     * @param  EventRepositoryInterface  $eventRepository
     * @return void
     */
    public function boot(EventRepositoryInterface $eventRepository): void
    {
        $this->eventRepository = $eventRepository;
    }


    /**
     * @return void
     */
    public function mount(): void
    {
        $this->timezoneIdentifiers = \DateTimeZone::listIdentifiers(\DateTimeZone::EUROPE);
        $this->timezone = session('timezone') ?? 'Europe/Budapest';
    }


    /**
     * @return void
     */
    public function updatedTimezone(): void
    {
        session(['timezone' => $this->timezone]);
        redirect()->route('event.index');
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
     */
    public function render(): Factory|View|Application|\Illuminate\Contracts\Foundation\Application
    {
        $lastMonth = Carbon::now()->startOfMonth()->subMonths(3);
        $this->events = $this->eventRepository->getEventsNewerThan($lastMonth->toDateString());

        return view('public.livewire.event.calendar');
    }


    /**
     * @param  string  $slug
     * @return void
     */
    public function redirectToSingleEvent(string $slug): void
    {
        redirect()->route('event.show', $slug);
    }
}
