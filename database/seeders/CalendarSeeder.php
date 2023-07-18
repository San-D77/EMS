<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Backend\Calendar;

class CalendarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $year = "2080";
        $months = [
            'Asar' => [
                "first_day" => "2023-06-16",
                "last_day" => "2023-07-16",
                "public_holidays" => "2023-06-17,2023-06-24,2023-07-01,2023-07-08,2023-07-15"
            ],
            'Shrawan' => [
                "first_day" => "2023-07-17",
                "last_day" => "2023-08-17",
                "public_holidays" => "2023-07-22,2023-07-29,2023-08-05,2023-08-12"
            ],
            'Bhadra' => [
                "first_day" => "2023-08-18",
                "last_day" => "2023-09-17",
                "public_holidays" => "2023-08-19,2023-08-26,2023-09-02,2023-09-09,2023-09-16"
            ],
            'Ashwin' => [
                "first_day" => "2023-09-18",
                "last_day" => "2023-10-17",
                "public_holidays" => "2023-09-23,2023-09-30,2023-10-07,2023-10-14"
            ],
            'Kartik' => [
                "first_day" => "2023-10-18",
                "last_day" => "2023-11-16",
                "public_holidays" => "2023-10-21,2023-10-28,2023-11-04,2023-11-11"
            ],
            'Mangshir' => [
                "first_day" => "2023-11-17",
                "last_day" => "2023-12-16",
                "public_holidays" => "2023-11-18,2023-11-25,2023-12-02,2023-12-09,2023-12-16"
            ],
            'Poush' => [
                "first_day" => "2023-12-17",
                "last_day" => "2024-01-14",
                "public_holidays" => "2023-12-23,2023-12-30,2024-01-06,2024-01-13"
            ],
            'Magh' => [
                "first_day" => "2024-01-15",
                "last_day" => "2024-02-12",
                "public_holidays" => "2024-01-20,2024-01-27,2024-02-03,2024-02-10"
            ],
            'Falgun' => [
                "first_day" => "2024-02-13",
                "last_day" => "2024-03-13",
                "public_holidays" => "2024-02-17,2024-02-24,2024-03-02,2024-03-09"
            ],
            'Chaitra' => [
                "first_day" => "2024-03-14",
                "last_day" => "2024-04-12",
                "public_holidays" => "2024-03-16,2024-03-23,2024-03-30,2024-04-06"
            ],
        ];
        foreach($months as $key => $month){
            $dateJson = [];
            foreach(explode(',',$month['public_holidays']) as $date){
                $dateJson[] = [
                    toBikramSambatDate($date, $year, $key, $month['first_day'],$month['last_day'])
                ];
            }
            Calendar::create([
                "year" => $year,
                "month" => $key,
                "first_day" => $month['first_day'],
                "last_day" => $month['last_day'],
                "public_holidays" => ($month['public_holidays']),
                "public_holidays_bs" => json_encode($dateJson)
            ]);
        }
    }
}
