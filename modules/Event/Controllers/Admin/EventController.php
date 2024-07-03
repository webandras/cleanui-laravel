<?php

namespace Modules\Event\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Modules\Auth\Traits\UserPermissions;
use Modules\Clean\Interfaces\Services\DateTimeServiceInterface;
use Modules\Clean\Interfaces\Services\ImageServiceInterface;
use Modules\Clean\Traits\InteractsWithBanner;
use Modules\Event\Interfaces\Entities\EventInterface;
use Modules\Event\Interfaces\Repositories\EventRepositoryInterface;
use Modules\Event\Models\Event;
use Modules\Event\Models\Location;
use Modules\Event\Models\Organizer;
use Modules\Event\Requests\StoreEventRequest;
use Modules\Event\Requests\UpdateEventRequest;
use Throwable;

class EventController extends Controller
{
    use InteractsWithBanner, UserPermissions;

    /**
     * @var ImageServiceInterface
     */
    private ImageServiceInterface $imageService;


    /**
     * @var DateTimeServiceInterface
     */
    private DateTimeServiceInterface $dateTimeService;


    /**
     * @var EventRepositoryInterface
     */
    private EventRepositoryInterface $eventRepository;


    /**
     * @param  ImageServiceInterface  $imageService
     * @param  DateTimeServiceInterface  $dateTimeService
     * @param  EventRepositoryInterface  $eventRepository
     */
    public function __construct(
        ImageServiceInterface $imageService,
        DateTimeServiceInterface $dateTimeService,
        EventRepositoryInterface $eventRepository
    ) {
        $this->imageService = $imageService;
        $this->dateTimeService = $dateTimeService;
        $this->eventRepository = $eventRepository;
    }


    /**
     * Display a listing of the resource.
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->authorize('viewAny', Event::class);

        $events = $this->eventRepository->getPaginatedEvents();

        return view('admin.pages.event.manage')->with([
            'events' => $events,
            'userPermissions' => $this->getUserPermissions()
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function create(): View|Factory|Application
    {
        $this->authorize('create', Event::class);

        $organizers = Organizer::orderBy('name', 'ASC')->get();
        $locations = Location::orderBy('city', 'ASC')->get();
        $timezoneIdentifiers = \DateTimeZone::listIdentifiers(\DateTimeZone::EUROPE);
        $statuses = Event::getStatuses();

        return view('admin.pages.event.create')->with([
            'organizers' => $organizers,
            'locations' => $locations,
            'timezoneIdentifiers' => $timezoneIdentifiers,
            'statuses' => $statuses,
            'userPermissions' => $this->getUserPermissions(),
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreEventRequest  $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function store(StoreEventRequest $request): RedirectResponse
    {
        $this->authorize('create', Event::class);

        $data = $request->all();

        $data = $this->eventRepository->getSlugFromTitle($data);
        $data = $this->dateTimeService->convertDateTimesToUTC($data, $data['timezone']);
        $data['cover_image_url'] = $this->imageService->getImageAbsolutePath($data['cover_image_url']);

        DB::transaction(
            function () use ($data) {

                // event details
                $details = [];
                // populate details if the props are set
                if (isset($data['cover_image_url'])) {
                    $details['cover_image_url'] = strip_tags($data['cover_image_url']);
                    unset($data['cover_image_url']);
                }

                if (isset($data['facebook_url'])) {
                    $details['facebook_url'] = strip_tags($data['facebook_url']);
                    unset($data['facebook_url']);
                }

                if (isset($data['tickets_url'])) {
                    $details['tickets_url'] = strip_tags($data['tickets_url']);
                    unset($data['tickets_url']);
                }

                // If not checked, the value should be 0 to be able to update this property
                if (!isset($data['allDay'])) {
                    $data['allDay'] = 0;
                }

                // create event
                $newEvent = $this->eventRepository->createEvent($data);
                $newEvent->save();
                $newEvent->refresh();


                // create event details
                if (!empty($details)) {
                    $details['event_id'] = $newEvent->id;

                    // we need to create a new EventDetail record
                    $this->eventRepository->createEventDetail($details);
                }


            }, 2);


        $this->banner(__('New event is added.'));
        return redirect()->route('event.manage');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  Event  $event
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function edit(Event $event): View|Factory|Application
    {
        $this->authorize('update', [Event::class, $event]);

        $organizers = Organizer::withTrashed()->orderBy('name', 'ASC')->get();
        $locations = Location::withTrashed()->orderBy('city', 'ASC')->get();
        $timezoneIdentifiers = \DateTimeZone::listIdentifiers(\DateTimeZone::EUROPE);
        $statuses = Event::getStatuses();

        $ids = $this->eventRepository->getLocationAndOrganizerIds($event);

        return view('admin.pages.event.edit')->with([
            'event' => $event,
            'organizers' => $organizers,
            'locations' => $locations,
            'organizerId' => $ids['organizerId'],
            'locationId' => $ids['locationId'],
            'timezoneIdentifiers' => $timezoneIdentifiers,
            'statuses' => $statuses,
            'userPermissions' => $this->getUserPermissions(),
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateEventRequest  $request
     * @param  Event  $event
     *
     * @return RedirectResponse
     * @throws Throwable
     */
    public function update(UpdateEventRequest $request, Event $event): RedirectResponse
    {
       $this->authorize('update', [Event::class, $event]);

        $rules = [
            'title' => ['required', 'max:255', 'string'],
            'slug' => ['required', 'alpha_dash', 'max:255', Rule::unique('events')->ignore($event->id, 'id')],
            'description' => ['required', 'string'],
            'start' => ['required', 'string'],
            'end' => ['required', 'string'],
            'timezone' => ['required', 'string'],
            'backgroundColor' => ['nullable', 'string', 'max:20'],
            'backgroundColorDark' => ['nullable', 'string', 'max:20'],
            'cover_image_url' => ['required', 'max:255', 'string'],
            'facebook_url' => ['required', 'string'],
            'tickets_url' => ['nullable', 'string'],
            'organizer_id' => ['required', 'int', 'min:1'],
            'location_id' => ['required', 'int', 'min:1'],
            'allDay' => ['nullable', 'boolean'],
            'status' => ['required', 'string', 'in:posted,cancelled'],
        ];

        $request->validate($rules);

        $data = $request->all();
        $data = $this->eventRepository->getSlugFromTitle($data);
        $data = $this->dateTimeService->convertDateTimesToUTC($data, $data['timezone']);
        $data['cover_image_url'] = $this->imageService->getImageAbsolutePath($data['cover_image_url']);


        DB::transaction(
            function () use ($event, $data) {
                // event details
                $details = [];
                // populate details if the props are set
                if (isset($data['cover_image_url'])) {
                    $details['cover_image_url'] = strip_tags($data['cover_image_url']);
                    unset($data['cover_image_url']);
                }

                if (isset($data['facebook_url'])) {
                    $details['facebook_url'] = strip_tags($data['facebook_url']);
                    unset($data['facebook_url']);
                }

                if (isset($data['tickets_url'])) {
                    $details['tickets_url'] = strip_tags($data['tickets_url']);
                    unset($data['tickets_url']);
                }

                // If not checked, the value should be 0 to be able to update this property
                if (!isset($data['allDay'])) {
                    $data['allDay'] = 0;
                }


                // update post
                $this->eventRepository->updateEvent($event, $data);

                // update event details (or create if not exists -> deleted from db by hand)
                if (!empty($details)) {
                    $eventDetail = $this->eventRepository->getEventDetailByEventId($event->id);

                    if ($eventDetail === null) {
                        $details['id'] = $event->id;

                        // we need to create a new EventDetail record
                        $this->eventRepository->createEventDetail($details);
                    } else {
                        $this->eventRepository->updateEventDetail($eventDetail, $details);
                    }
                }

            }, 2);


        $this->banner(__('Successfully updated the event'));
        return redirect()->route('event.manage');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  Event  $event
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function destroy(Event $event): RedirectResponse
    {
        $this->authorize('delete', Event::class);

        $oldTitle = htmlentities($event->title);
        $this->eventRepository->deleteEvent($event);

        $this->banner(__('":title" successfully deleted!', ['title' => $oldTitle]));
        return redirect()->route('event.manage');
    }
}
