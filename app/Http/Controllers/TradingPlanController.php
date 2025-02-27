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
        return view('pages.trading_plans', ['title' => 'Trading Plans']);
    }

    public function getAllTradingPlans() {
        return TradingPlan::query();
    }

    public function getTradingPlans(Request $request) {
        $tradingPlans = $this->getAllTradingPlans();
        if ($request->has('draw')) {
            return DataTables::of($tradingPlans->get())
                ->addIndexColumn()
                ->addColumn('created_at', fn($plan) => $plan->created_at->format('D d M Y'))
                ->addColumn('action', fn($plan) => '<button onclick="deletePlan('.$plan->id.')">Delete</button>')
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function store(Request $request) {
        $request->validate([
            'markets' => 'required',
            'timeframes' => 'required',
            'strategies' => 'required',
            'max_risk_per_trade' => 'required|numeric',
            'max_weekly_drawdown' => 'required|numeric',
        ]);

        TradingPlan::create($request->all());
        return response()->json(['message' => 'Trading Plan added successfully!', 'type' => 'success']);
    }
}
