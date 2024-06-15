<?php

namespace Modules\Event\Interfaces\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Event\Models\Event;
use Modules\Event\Models\EventDetail;

interface EventRepositoryInterface
{
    /**
     * @return LengthAwarePaginator
     */
    public function getPaginatedEvents(): LengthAwarePaginator;


    /**
     * @param  string  $dateString
     * @return Collection
     */
    public function getEventsNewerThan(string $dateString): Collection;


    /**
     * @param  string  $dateString
     * @return LengthAwarePaginator
     */
    public function getPaginatedEventsNewerThan(string $dateString): LengthAwarePaginator;


    /**
     * @param  string  $dateString
     * @param  string  $city
     * @param  int  $organizerId
     * @param  string  $searchTerm
     * @return LengthAwarePaginator
     */
    public function filterEvents(string $dateString, string $city, int $organizerId, string $searchTerm): LengthAwarePaginator;


    /**
     * Gets the slug from the post title
     *
     * @param  array  $data
     * @return array
     */
    public function getSlugFromTitle(array $data): array;


    /**
     * Gets the slug from the post title
     *
     * @return string
     */
    public function generateUuid(): string;


    /**
     * @param  array  $data
     * @return Event
     */
    public function createEvent(array $data): Event;


    /**
     * @param  array  $data
     * @return bool
     */
    public function createEventDetail(array $data): bool;


    /**
     * @param  int  $eventId
     * @return Event
     */
    public function getEventById(int $eventId): Event;


    /**
     * @param  string  $slug
     * @return Event
     */
    public function getEventBySlug(string $slug): Event;


    /**
     * @param  int  $eventId
     * @return EventDetail
     */
    public function getEventDetailByEventId(int $eventId): EventDetail;


    /**
     * @param  Event  $event
     * @return array
     */
    public function getLocationAndOrganizerIds(Event $event): array;


    /**
     * @param  Event  $event
     * @param  array  $data
     * @return mixed
     */
    public function updateEvent(Event $event, array $data): mixed;


    /**
     * @param  EventDetail  $eventDetail
     * @param  array  $data
     * @return mixed
     */
    public function updateEventDetail(EventDetail $eventDetail, array $data): bool;


    /**
     * @param  Event  $event
     * @return mixed
     */
    public function deleteEvent(Event $event): mixed;

}
