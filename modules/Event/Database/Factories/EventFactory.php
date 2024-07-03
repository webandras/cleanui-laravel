<?php

namespace Modules\Event\Database\Factories;

use DateInterval;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Event\Models\Event;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Event\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Event::class;


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('tomorrow', '+1 month');
        $dayOffset = $this->faker->numberBetween(0, 4);
        $hourOffset = $this->faker->numberBetween(4, 6);
        $end = clone $start;


        if ($dayOffset < 1) {
            $end->add(DateInterval::createFromDateString($hourOffset.' hours'));
        }
        else {
            $end->add(DateInterval::createFromDateString(($dayOffset === 1 ? '1 day + ' : $dayOffset . 'days + ').$hourOffset.' hours'));
        }


        return [
            'location_id' => $this->faker->numberBetween(1, 5),
            'organizer_id' => $this->faker->numberBetween(1, 5),
            'title' => $this->faker->words(3, true),
            'slug' => $this->faker->slug,
            'description' => $this->faker->randomHtml(),
            'start' => $start,
            'end' => $end,
            'timezone' => $this->faker->randomElement(['Europe/Budapest', 'Europe/Lisbon']),
            'allDay' => $dayOffset === 0 ? 0 : 1,
            'status' => $this->faker->randomElement(['posted', 'cancelled']),
        ];
    }
}
