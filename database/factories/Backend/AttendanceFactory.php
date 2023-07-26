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




        return [
            'user_id' => function(){
                $today = now();

                $attendances = Attendance::all();

                $userIds = User::whereNotIn('id',$attendances->pluck('user_id'))->pluck('id')->toArray();
                return array_pop($userIds);
            },
            'day' => toBikramSambatDate(now()),
            'session_start' => str_pad( random_int(9,11), 2, '0', STR_PAD_LEFT)  .':'.str_pad( random_int(0,59), 2, '0', STR_PAD_LEFT).':'.str_pad( random_int(0,59), 2, '0', STR_PAD_LEFT),
            'location' => $faker->city
        ];
    }
}
