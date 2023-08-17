<?php

use Carbon\Carbon;
use App\Models\Backend\Calendar;
use Pusher\Pusher;

if (!function_exists('toGregorianDate')) {
    function toGregorianDate($year, $month, $day)
    {
        $carbonDate = Carbon::createFromDate($year, $month, $day, 'Asia/Kathmandu');
        $gregorianDate = $carbonDate->isoFormat('YYYY-MM-DD');

        return $gregorianDate;
    }
}

if (!function_exists('toBikramSambatDate')) {
    function toBikramSambatDate($date, $year = null, $month = null, $first_day = null, $last_day = null)
    {

        $foundDate = Calendar::whereDate('first_day', '<=', $date)
            ->whereDate('last_day', '>=', $date)
            ->first();

        $first_day = $foundDate ? $foundDate->first_day : $first_day;
        $last_day = $foundDate ? $foundDate->last_day : $last_day;

        $year = $foundDate ? $foundDate->year : $year;
        $month = $foundDate ? $foundDate->month : $month;

        $diffInDays = \Carbon\Carbon::parse($first_day)->diffInDays(\Carbon\Carbon::parse($date));

        return ucfirst($month) . " " . $diffInDays + 1 . ", " . $year;
    }
}

if (!function_exists('pusherTemplate')) {
    function pusherTemplate($channel, $event, $data)
    {
        $options = [
            'cluster' => env('PUSHER_APP_CLUSTER'),
            'useTLS' => true
        ];

        $pusher = new Pusher(
            env('PUSHER_APP_KEY'),
            env('PUSHER_APP_SECRET'),
            env('PUSHER_APP_ID'),
            $options
        );

        $pusher->trigger($channel, $event, $data);
    }
}
