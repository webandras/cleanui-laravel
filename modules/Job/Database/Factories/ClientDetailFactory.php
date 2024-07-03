<?php

namespace Modules\Job\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Job\Models\ClientDetail;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Job\Models\ClientDetail>
 */
class ClientDetailFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = ClientDetail::class;


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $taxNumbers = [
            '82184287357864',
            '83463663577352',
            '84696786274674',
            '82191477536764',
            '82544665733575',
        ];

        return [
            'contact_person' => $this->faker->name(),
            'phone_number'   => $this->faker->phoneNumber(),
            'email'          => $this->faker->safeEmail(),
            'tax_number'     => $this->faker->randomElement($taxNumbers),
        ];
    }
}
