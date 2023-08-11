<?php

namespace Database\Seeders;

use App\Models\Backend\Attendance;
use App\Models\Backend\Calendar;
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

        $today = Carbon::today();
        $month = Calendar::where('first_day', '<=', $today)
            ->where('last_day', '>=', $today)
            ->first();
        $start_date = Carbon::parse($month->first_day);

        for ($date = $start_date; $date->lt($today); $date->addDay()) {
            if (in_array($date->toDateString(), explode(',', $month->public_holidays))) {
            } else {
                $faker = Faker::create();
                $iterator = random_int(1, User::count());

                for ($i = 0; $i < $iterator; $i++) {

                    $customTimestamp = $date;

                    $attendances = Attendance::whereDate('created_at', $date)->get();

                    $userIds = User::whereNotIn('id', $attendances->pluck('user_id')->toArray())->pluck('id')->shuffle()->toArray();
                    $id = array_pop($userIds);
                    if ($id == null) {
                    } else {

                        $user_object = Attendance::create([
                            'user_id' => $id,
                            'day' => toBikramSambatDate($date),
                            'session_start' => str_pad(random_int(10, 11), 2, '0', STR_PAD_LEFT)  . ':' . str_pad(random_int(0, 59), 2, '0', STR_PAD_LEFT) . ':' . str_pad(random_int(0, 59), 2, '0', STR_PAD_LEFT),
                            'login_location' => $faker->city,
                            'created_at' => $customTimestamp,
                            'updated_at' => $customTimestamp,
                        ]);
                        $session_end = str_pad(random_int(17, 19), 2, '0', STR_PAD_LEFT)  . ':' . str_pad(random_int(0, 59), 2, '0', STR_PAD_LEFT) . ':' . str_pad(random_int(0, 59), 2, '0', STR_PAD_LEFT);

                        $session_start = Carbon::parse($user_object->session_start);
                        $second_time = Carbon::parse($session_end);



                        $time_duration = $session_start->diff($second_time);
                        $time_duration = $time_duration->format('%H:%I:%S');

                        $task_report = [];
                        $task_count = random_int(0, 4);
                        if ($task_count == 0) {
                            $report_status = '';
                        } else {
                            for ($j = 0; $j < random_int(1, 4); $j++) {
                                $task_report[] = [
                                    "title" => $faker->sentence(random_int(5, 12)),
                                    "remarks" => $faker->sentence(random_int(5, 12))
                                ];
                            }
                            $report_status = 'pending';
                        }
                        $user_object->update([
                            'session_end' => $session_end,
                            'duration' => $time_duration,
                            'logout_location' => $faker->city,
                            "task_report" => $task_report,
                            'report_status' => $report_status
                        ]);
                    }
                }
            }
        }
    }
}
