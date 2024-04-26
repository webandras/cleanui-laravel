<?php

namespace Database\Factories\Job;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job\ClientDetail>
 */
class ClientDetailFactory extends Factory
{
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
