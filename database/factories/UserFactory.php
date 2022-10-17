<?php

namespace Database\Factories;

use Faker\Provider\Person;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        /** @var string $gender */
        $gender = $this->faker->randomElement([Person::GENDER_MALE, Person::GENDER_FEMALE]);
        /** @var $firstName $firstName */
        $firstName = $this->faker->firstName($gender);
        /** @var $lastName $lastName */
        $lastName = $this->faker->lastName($gender);
        /** @var $pseudonym $pseudonym */
        $pseudonym = Str::slug(sprintf('%s-%s-%s', mb_strtolower($firstName), mb_strtolower($lastName), time()));

        return [
            'first_name' => $firstName,
            'last_name'  => $lastName,
            'middle_name' => $this->faker->middleName($gender),
            'pseudonym' => $pseudonym,
            'email_verified_at' => now(),
            'password' => bcrypt('secret'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
