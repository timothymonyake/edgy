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
        $title = 'Weekly Forecasts';
        return view('pages.weekly_forecasts', compact('title'));
    }

    public function getAllForecasts()
    {
        return WeeklyForecast::query();
    }

    public function getForecasts(Request $request)
    {
        $forecasts = $this->getAllForecasts();

        if ($request->has('draw')) {
            return DataTables::of($forecasts->get())
                ->addIndexColumn()
                ->addColumn('week', fn($forecast) => $forecast->week_start . ' - ' . $forecast->week_end)
                ->addColumn('status', fn($forecast) => $forecast->market_bias)
                ->addColumn('action', fn($forecast) => '
                    <a href="' . route('weekly_forecasts.edit', $forecast->id) . '" class="btn btn-sm btn-warning">Edit</a>
                    <button onclick="deleteForecast(' . $forecast->id . ')" class="btn btn-sm btn-danger">Delete</button>
                ')
                ->rawColumns(['action'])
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
