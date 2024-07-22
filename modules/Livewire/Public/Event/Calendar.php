<?php

namespace Modules\Livewire\Public\Event;

use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Application;
use Livewire\Component;
use Modules\Event\Models\Event;

class Calendar extends Component
{
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
        $this->events = Event::newerThan($lastMonth->toDateString());

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
