<?php

namespace Database\Factories;

use App\Enums\GenderFlag;
use App\Enums\StatusFlag;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * Class UserFactory
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 * @package Database\Factories
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $email = fn_normalize_email($this->faker->unique()->safeEmail());
        $phone = fn_remove_special_characters_phone($this->faker->unique()->phoneNumber());
        return [
            'status'            => $this->faker->randomKey(StatusFlag::getDropdowns()),
            'username'          => $email,
            'password'          => 'password',
            'firstname'         => $this->faker->firstName(),
            'lastname'          => $this->faker->lastName(),
            'gender'            => $this->faker->randomKey(GenderFlag::getDropdowns()),
            'birthday'          => $this->faker->date('Y-m-d', '-20 years'),
            'phone'             => $phone,
            'phone_verified_at' => now(),
            'email'             => $email,
            'email_verified_at' => now(),
            'avatar'            => $this->faker->imageUrl(),
            'secret'            => Str::random(10),
            'remember_token'    => Str::random(10),
            'lang'              => $this->faker->randomKey(app_supported_locales()),
            'timezone'          => app_timezone(),
            'organization'      => $this->faker->company(),
            'department'        => $this->faker->jobTitle(),
            'position'          => $this->faker->jobTitle(),
            'address'           => $this->faker->address(),
            'city'              => $this->faker->city(),
            'country'           => $this->faker->country(),

        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function emailUnverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indicate that the model's phone number should be unverified.
     */
    public function phoneUnverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'phone_verified_at' => null,
        ]);
    }
}
