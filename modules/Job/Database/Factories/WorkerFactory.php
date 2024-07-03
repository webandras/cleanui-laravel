<?php

namespace Modules\Job\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Job\Models\Worker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Event\Models\Event>
 */
class WorkerFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Worker::class;


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $bankAccountNumbers = [
            '33333333-11111111-77777777',
            '11111111-22222222-44444444',
            '55555555-77777777-99999999',
            '66666666-77777777-88578584',
            '55555555-46784688-35783573',
            '55555555-35735757-57879543',
            '12345678-98765432-23546798',
        ];

        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
            'bank_account_number' => $this->faker->randomElement($bankAccountNumbers),
        ];
    }
}
