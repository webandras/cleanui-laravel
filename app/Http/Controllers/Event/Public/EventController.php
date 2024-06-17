<?php

namespace App\Http\Controllers\Event\Public;

use App\Http\Controllers\Controller;
use App\Trait\Clean\HasLocalization;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Modules\Event\Interfaces\Repositories\EventRepositoryInterface;


class EventController extends Controller
{
    use HasLocalization;

    /**
     * @var EventRepositoryInterface
     */
    private EventRepositoryInterface $eventRepository;


    /**
     * @param  EventRepositoryInterface  $eventRepository
     */
    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }


    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('public.pages.event.index');
    }


    /**
     * Display an entity
     */
    public function show(string $slug): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('public.pages.event.show')->with([
            'event' => $this->eventRepository->getEventBySlug($slug),
            'dtFormat' => $this->getLocaleDateTimeFormat(),
            'utcTz' => new \DateTimeZone("UTC")
        ]);
    }


}
