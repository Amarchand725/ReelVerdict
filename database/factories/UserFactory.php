<?php

namespace Database\Factories;

use App\Enum\GenderEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => (string) Str::uuid(),
            'status_id'    => null,
            'name'    => fake()->name(),
            'email' =>  fake()->unique()->safeEmail(),
            'avatar_id'    => null,
            'gender'    => fake()->randomElement(array_column(GenderEnum::cases(), 'value')),
            'dob'   => fake()->date(),
            'phone' => fake()->phoneNumber(),
            'two_factor'    => null,
            'notification'  => null,
            'password'  => 'user@321',
            'remember_token' => Str::random(10),
            'email_verified_at' => now(),
            'phone_verified_at' => now(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
