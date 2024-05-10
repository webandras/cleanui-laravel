<?php

namespace App\Repository\Event;

use App\Interface\Entities\Event\EventInterface;
use App\Interface\Repository\Event\EventRepositoryInterface;
use App\Models\Event\Event;
use App\Models\Event\EventDetail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;


class EventRepository implements EventRepositoryInterface
{

    /**
     * @return LengthAwarePaginator
     */
    public function getPaginatedEvents(): LengthAwarePaginator
    {
        return Event::with(['event_detail'])
            ->orderBy('start', 'desc')
            ->paginate(EventInterface::POST_PER_PAGE);
    }


    /**
     * @param  string  $dateString
     * @return Collection
     */
    public function getEventsNewerThan(string $dateString): Collection
    {
        return Event::whereDate('start', '>', $dateString)
            ->with(['event_detail'])
            ->with([
                'location' => function ($query) {
                    $query->withTrashed();
                }
            ])
            ->with([
                'organizer' => function ($query) {
                    $query->withTrashed();
                }
            ])
            ->get();
    }


    /**
     * @param  string  $dateString
     * @return LengthAwarePaginator
     */
    public function getPaginatedEventsNewerThan(string $dateString): LengthAwarePaginator
    {
        return Event::whereDate('start', '>', $dateString)
            ->with(['event_detail'])
            ->with([
                'location' => function ($query) {
                    $query->withTrashed();
                }
            ])
            ->with([
                'organizer' => function ($query) {
                    $query->withTrashed();
                }
            ])
            ->orderBy('start', 'asc')
            ->paginate(EventInterface::POST_PER_PAGE);
    }


    /**
     * @param  string  $dateString
     * @param  string  $city
     * @param  int  $organizerId
     * @param  string  $searchTerm
     * @return LengthAwarePaginator
     */
    public function filterEvents(
        string $dateString,
        string $city,
        int $organizerId,
        string $searchTerm
    ): LengthAwarePaginator {
        $q = Event::with(['event_detail', 'location', 'organizer'])
            ->whereDate('start', '>', $dateString);

        if ($city !== '') {
            $q->whereHas('location', function ($q) use ($city) {
                $q->where('city', '=', $city);
            });
        }

        if ($organizerId > 0) {
            $q->whereHas('organizer', function ($q) use ($organizerId) {
                $q->where('id', '=', $organizerId);
            });
        }

        if ($searchTerm !== '') {
            $lowercase = '\'"'.mb_strtolower($searchTerm).'"\'';
            $uppercase = '\'"'.mb_strtolower($searchTerm).'"\'';
            $q->whereRaw("MATCH (title, description) AGAINST (? IN BOOLEAN MODE)", [$lowercase], 'and');
            $q->whereRaw("MATCH (title, description) AGAINST (? IN BOOLEAN MODE)", [$uppercase], 'and');
        }

        return $q->orderBy('start', 'asc')
            ->paginate(EventInterface::POST_PER_PAGE);
    }


    /**
     * Gets the slug from the post title
     *
     * @param  array  $data
     * @return array
     */
    public function getSlugFromTitle(array $data): array
    {
        if (!isset($data['slug']) || $data['slug'] === '') {
            $data['slug'] = Str::slug($data['title']);
        }

        return $data;
    }


    /**
     * @return string
     */
    public function generateUuid(): string
    {
        return Str::uuid()->toString();
    }


    /**
     * @param  array  $data
     * @return Event
     */
    public function createEvent(array $data): Event
    {
        return Event::create($data);
    }


    /**
     * @param  array  $data
     * @return bool
     * @throws Throwable
     */
    public function createEventDetail(array $data): bool
    {
        $newEventDetail = new EventDetail($data);
        return $newEventDetail->saveOrFail();
    }


    /**
     * @param  int  $eventId
     * @return Event
     */
    public function getEventById(int $eventId): Event
    {
        return Event::where('id', '=', $eventId)
            ->with('event_detail')
            ->with([
                'location' => function ($query) {
                    $query->withTrashed();
                }
            ])
            ->with([
                'organizer' => function ($query) {
                    $query->withTrashed();
                }
            ])
            ->firstOrFail();
    }


    /**
     * @param  string  $slug
     * @return Event
     */
    public function getEventBySlug(string $slug): Event
    {
        return Event::where('slug', '=', strip_tags($slug))
            ->with('event_detail')
            ->with([
                'location' => function ($query) {
                    $query->withTrashed();
                }
            ])
            ->with([
                'organizer' => function ($query) {
                    $query->withTrashed();
                }
            ])
            ->firstOrFail();
    }


    /**
     * @param  int  $eventId
     * @return EventDetail
     */
    public function getEventDetailByEventId(int $eventId): EventDetail
    {
        return EventDetail::where('id', '=', $eventId)->firstOrFail();
    }


    /**
     * @param  Event  $event
     * @return array
     */
    public function getLocationAndOrganizerIds(Event $event): array
    {
        if (!isset($event->location) || !isset($event->organizer)) {
            $ids = DB::table('events')
                ->where('id', '=', $event->id)
                ->get(['location_id', 'organizer_id']);

            $organizerId = $ids[0]->organizer_id;
            $locationId = $ids[0]->location_id;
        } else {
            $organizerId = $event->organizer->id;
            $locationId = $event->location->id;
        }

        return [
            'organizerId' => $organizerId,
            'locationId' => $locationId,
        ];
    }


    /**
     * @param  Event  $event
     * @param  array  $data
     * @return mixed
     * @throws Throwable
     */
    public function updateEvent(Event $event, array $data): mixed
    {
        return $event->updateOrFail($data);
    }


    /**
     * @param  EventDetail  $eventDetail
     * @param  array  $data
     * @return bool
     * @throws Throwable
     */
    public function updateEventDetail(EventDetail $eventDetail, array $data): bool
    {
        return $eventDetail->updateOrFail($data);
    }


    /**
     * @param  Event  $event
     * @return mixed
     * @throws Throwable
     */
    public function deleteEvent(Event $event): mixed
    {
        return $event->deleteOrFail();
    }
}
