<?php

namespace Database\Factories\Backend;

use App\Models\Backend\Attendance;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Backend\Attendance>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = Faker::create();

        $today = now();

        $userIds = User::pluck('id')->shuffle()->toArray();



        return [
            'user_id' => function () use ($userIds) {
                // Pop a user ID from the shuffled array to ensure uniqueness
                return array_pop($userIds);
            },
            'day' => toBikramSambatDate(now()),
            'session_start' => $faker->time,
            'location' => $faker->city
        ];
    }
}
