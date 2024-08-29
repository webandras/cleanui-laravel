<?php

namespace Modules\Event\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Modules\Clean\Traits\HasLocalization;
use Modules\Event\Models\Event;


class EventController extends Controller
{
    use HasLocalization;

    /**
     * Display a listing of the resource.
     */
    public function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('event::public.event.index');
    }


    /**
     * Display an entity
     */
    public function show(string $slug): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('event::public.event.show')->with([
            'event' => Event::getBySlug($slug),
            'dtFormat' => $this->getLocaleDateTimeFormat(),
            'utcTz' => new \DateTimeZone("UTC")
        ]);
    }


}
