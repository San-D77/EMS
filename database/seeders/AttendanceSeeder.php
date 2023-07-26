<?php

namespace Database\Seeders;

use App\Models\Backend\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Factories\Backend\AttendanceFactory;
use Faker\Factory as Faker;

class AttendanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        for ($i = 0; $i < random_int(1, User::count()); $i++) {
            $today = Carbon::today();

            $attendances = Attendance::whereDate('created_at', $today)->get();

            $userIds = User::whereNotIn('id', $attendances->pluck('user_id'))->pluck('id')->shuffle()->toArray();

            Attendance::create([
                'user_id' => array_pop($userIds),
                'day' => toBikramSambatDate($today),
                'session_start' => str_pad(random_int(9, 11), 2, '0', STR_PAD_LEFT)  . ':' . str_pad(random_int(0, 59), 2, '0', STR_PAD_LEFT) . ':' . str_pad(random_int(0, 59), 2, '0', STR_PAD_LEFT),
                'location' => $faker->city
            ]);
        }

        // $attendances = Attendance::whereDate('created_at', Carbon::yesterday())->get();
        // foreach ($attendances as $attendance) {

        //     $session_end = str_pad(random_int(5, 7), 2, '0', STR_PAD_LEFT)  . ':' . str_pad(random_int(0, 59), 2, '0', STR_PAD_LEFT) . ':' . str_pad(random_int(0, 59), 2, '0', STR_PAD_LEFT);

        //     $session_start = $attendance->session_start;

        //     $session_start = Carbon::parse($session_start);
        //     $second_time = Carbon::parse($session_end);


        //     $time_duration = $session_start->diff($second_time);
        //     $time_duration = $time_duration->format('%H:%I:%S');

        //     $attendance->update([
        //         'session_end' => $session_end,
        //         'duration' => $time_duration,
        //         "task_report" => [
        //             [
        //                 "title"=>$faker->sentence(random_int(5,12)),
        //                 "remarks" =>$faker->sentence(random_int(5,12))
        //             ],
        //             [
        //                 "title" => $faker->sentence(random_int(5,12)),
        //                 "remarks" => $faker->sentence(random_int(5,12))
        //             ]
        //         ],
        //         'report_status' => "pending"
        //     ]);
        // }

    }
}
