<?php

namespace Modules\Event\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Traits\UserPermissions;
use Modules\Clean\Interfaces\Services\DateTimeServiceInterface;
use Modules\Clean\Interfaces\Services\ImageServiceInterface;
use Modules\Clean\Traits\InteractsWithBanner;
use Modules\Event\Enum\EventStatus;
use Modules\Event\Models\Event;
use Modules\Event\Models\EventDetail;
use Modules\Event\Models\Location;
use Modules\Event\Models\Organizer;
use Modules\Event\Requests\StoreEventRequest;
use Modules\Event\Requests\UpdateEventRequest;
use Modules\Event\Traits\EventTrait;
use Throwable;

class EventController extends Controller
{
    use InteractsWithBanner, UserPermissions, EventTrait;

    /**
     * @var ImageServiceInterface
     */
    private ImageServiceInterface $imageService;


    /**
     * @var DateTimeServiceInterface
     */
    private DateTimeServiceInterface $dateTimeService;


    /**
     * @param  ImageServiceInterface  $imageService
     * @param  DateTimeServiceInterface  $dateTimeService
     */
    public function __construct(
        ImageServiceInterface $imageService,
        DateTimeServiceInterface $dateTimeService,
    ) {
        $this->imageService = $imageService;
        $this->dateTimeService = $dateTimeService;
    }


    /**
     * Display a listing of the resource.
     * @throws AuthorizationException
     */
    public function index(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $this->authorize('viewAny', Event::class);

        $events = Event::with(['event_detail'])
            ->orderBy('start', 'desc')
            ->paginate(Event::POST_PER_PAGE);

        return view('event::admin.event.manage')->with([
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
        $statuses = EventStatus::options();

        return view('event::admin.event.create')->with([
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

        $data = $request->validated();
        $data = $this->addSlugFromTitle($data);
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
                $newEvent = Event::create($data);
                $newEvent->save();
                $newEvent->refresh();

                // create event details
                if (!empty($details)) {
                    $details['event_id'] = $newEvent->id;

                    // we need to create a new EventDetail record
                    $newEventDetail = new EventDetail($details);
                    $newEventDetail->saveOrFail();
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
        $statuses = EventStatus::options();

        $ids = $this->getLocationAndOrganizerIds($event);

        return view('event::admin.event.edit')->with([
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

        $data = $request->validated();
        $data = $this->addSlugFromTitle($data);
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

                // update event
                $event->updateOrFail($data);

                // update event details (or create if not exists -> deleted from db by hand)
                if (!empty($details)) {
                    $eventDetail = EventDetail::where('event_id', '=', $event->id)->firstOrFail();

                    if ($eventDetail === null) {
                        $details['id'] = $event->id;

                        // create a new EventDetail record
                        $newEventDetail = new EventDetail($details);
                        $newEventDetail->saveOrFail();
                    } else {
                        $eventDetail->updateOrFail($details);
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

        $oldTitle = $event->title;
        $event->deleteOrFail();

        $this->banner(__('":title" successfully deleted!', ['title' => $oldTitle]));
        return redirect()->route('event.manage');
    }
}
