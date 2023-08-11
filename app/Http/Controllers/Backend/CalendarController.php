<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CalendarRequest;
use App\Models\Backend\Calendar;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        return view('admin.backend.pages.calendar.index', [
            'calendar' => Calendar::all(),
        ]);
    }
    public function create()
    {
        return view('admin.backend.pages.calendar.crud');
    }
    public function store(CalendarRequest $request)
    {

        $dateArray = explode(', ', ($request->validated('public_holidays')));
        $dateJson = [];
        foreach ($dateArray as $date) {
            $dateJson[] = [
                toBikramSambatDate($date, $request->validated('year'), $request->validated('month'), $request->validated('first_day'), $request->validated('last_day'))
            ];
        }
        $finalArray = array_merge($request->validated(), ['public_holidays_bs' => json_encode($dateJson)]);

        Calendar::create($finalArray);
        return redirect()->route('backend.calendar-index');
    }

    public function edit(Calendar $date)
    {
        return view('admin.backend.pages.calendar.crud', [
            'date' => $date
        ]);
    }

    public function update(CalendarRequest $request, Calendar $date)
    {
        $dateArray = explode(', ', ($request->validated('public_holidays')));
        $dateJson = [];
        foreach ($dateArray as $d) {
            $dateJson[] = [
                toBikramSambatDate($d, $request->validated('year'), $request->validated('month'), $request->validated('first_day'), $request->validated('last_day'))
            ];
        }
        $finalArray = array_merge($request->validated(), ['public_holidays_bs' => json_encode($dateJson)]);

        $date->update($finalArray);
        return back();
    }

    public function public_holiday_index()
    {
        return view('admin.backend.pages.calendar.public-holidays', [
            'public_holidays' => Calendar::all()
        ]);
    }
}
