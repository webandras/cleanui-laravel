<?php

namespace Modules\Event\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Event\Models\Event;

trait EventTrait
{

    /**
     * Gets the slug from the post title
     *
     * @param  array  $data
     * @return array
     */
    public function addSlugFromTitle(array $data): array
    {
        if (!isset($data['slug']) || $data['slug'] === '') {
            $data['slug'] = Str::slug($data['title']);
        }
        return $data;
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
}
