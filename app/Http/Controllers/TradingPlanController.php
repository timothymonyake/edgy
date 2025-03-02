<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use App\Models\TradingPlan;
use Illuminate\Support\Facades\Auth;

class TradingPlanController extends Controller {
    public function index() {
        return view('pages.trading_plans');
    }

    public function getTradingPlans(Request $request) {
        $tradingPlans = TradingPlan::with('user'); // Include user details if needed
        return DataTables::of($tradingPlans)
            ->addIndexColumn()
            ->addColumn('user', fn($plan) => $plan->user->name ?? 'N/A')
            ->addColumn('created_at', fn($plan) => $plan->created_at->format('D d M Y'))
            ->addColumn('action', function ($plan) {
                return '<button class="btn btn-sm btn-warning edit-plan" data-id="'.$plan->id.'">Edit</button>
                        <button class="btn btn-sm btn-danger delete-plan" data-id="'.$plan->id.'">Delete</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request) {
        $request->validate([
            'markets' => 'required',
            'timeframes' => 'required',
            'strategies' => 'required',
            'max_risk_per_trade' => 'required|numeric',
            'max_weekly_drawdown' => 'required|numeric',
        ]);

        $trading_plan = new TradingPlan();
        $trading_plan->markets = $request->markets;
        $trading_plan->timeframes = $request->timeframes;
        $trading_plan->strategies = $request->strategies;
        $trading_plan->max_risk_per_trade = $request->max_risk_per_trade;
        $trading_plan->max_weekly_drawdown = $request->max_weekly_drawdown;
        $trading_plan->user_id = 1;
        $trading_plan->save();


        return response()->json(['message' => 'Trading Plan added successfully!', 'type' => 'success']);
    }

    public function update(Request $request, $id) {
        $plan = TradingPlan::findOrFail($id);
        $plan->update($request->all());
        return response()->json(['message' => 'Trading Plan updated successfully!', 'type' => 'success']);
    }

    public function destroy($id) {
        TradingPlan::findOrFail($id)->delete();
        return response()->json(['message' => 'Trading Plan deleted successfully!', 'type' => 'success']);
    }
}
