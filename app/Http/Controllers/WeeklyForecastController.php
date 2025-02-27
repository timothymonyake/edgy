<?php

namespace App\Http\Controllers;

use App\Models\WeeklyForecast;
use App\Models\Pair;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class WeeklyForecastController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $forecasts = $this->getAllForecasts();
        $forecast_count = $forecasts->orderBy('is_active','desc')
        ->whereYear('week_start', Carbon::now()->year)->get()->count();


        $show_seed_btn = $forecast_count > 50 ? false : true;

        $title = 'Weekly Forecasts';
        return view('pages.weekly_forecasts', compact('title','show_seed_btn'));
    }

    public function seedYearWeeks()
    {
        $year = Carbon::now()->year;
        $weeks = collect();
        $week = Carbon::now()->startOfYear();
        $week->startOfWeek();
        $week->addWeek();
        while ($week->year == $year) {
            $weeks->push($week->copy());
            $week->addWeek();
        }

        $weeks->each(function ($week) {
            $weekStart = $week->copy()->startOfWeek(Carbon::SUNDAY);
            $weekEnd = $week->copy()->endOfWeek(Carbon::SATURDAY);

            //,
            WeeklyForecast::create([
                'user_id' =>  1,//Auth::id(),
                'week_start' => $weekStart->format('Y-m-d'),
                'week_end' => $weekEnd->format('Y-m-d'),
                'is_active' => Carbon::now()->between($weekStart, $weekEnd), // Active only for the current week
                'economic_calendar_link' => 'https://www.forexfactory.com/calendar?week='.$weekStart->format('Md.Y'),
            ]);
        });
        return  redirect()->back()->with('success', 'Year weeks seeded successfully!');
    }

    public function getAllForecasts()
    {
        return WeeklyForecast::query();
    }

    public function getForecasts(Request $request)
    {
        $forecasts = $this->getAllForecasts();
        //=mar2.2025

        if ($request->has('draw')) {
            return DataTables::of($forecasts->orderBy('is_active','desc')->get())
                ->addIndexColumn()
                ->addColumn('week', fn($forecast) => $forecast->week_start . ' - ' . $forecast->week_end)
                ->addColumn('status', function ($forecast) {
                    return $forecast->is_active
                        ? '<span class="badge rounded-pill bg-success">ACTIVE</span>'
                        : '<span class="badge rounded-pill bg-danger">INACTIVE</span>';
                })
                ->addColumn('economic_calendar', function ($forecast) {
                    return $forecast->economic_calendar_link
                        ? '<a href="' . $forecast->economic_calendar_link . '" target="_blank">View</a>'
                        : 'N/A';
                })
                ->addColumn('action', function ($forecast) {
                    if($forecast->is_active){
                        return '<a href="' . route('weekly-forecasts.edit', $forecast->id) . '" class="btn btn-sm btn-primary">Edit</a>';
                    }
                })
                ->rawColumns(['action','status','economic_calendar'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'week_start' => 'required|date',
            'week_end' => 'required|date|after_or_equal:week_start',
            'market_bias' => 'required|string',
        ]);

        WeeklyForecast::create([
            'user_id' => Auth::id(),
            'week_start' => $request->week_start,
            'week_end' => $request->week_end,
            'market_bias' => $request->market_bias,
            'key_levels' => $request->key_levels,
            'news_events' => $request->news_events,
            'trade_ideas' => $request->trade_ideas,
            'notion_link' => $request->notion_link,
        ]);

        return response()->json(['message' => 'Weekly Forecast added successfully!', 'type' => 'success']);
    }

    /**
     * Display the specified resource.
     */
    public function show(WeeklyForecast $weeklyForecast)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WeeklyForecast $weeklyForecast)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WeeklyForecast $weeklyForecast)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WeeklyForecast $weeklyForecast)
    {
        //
    }
}
