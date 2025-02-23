<?php
namespace App\Http\Controllers;

use App\Models\Trade;
use Illuminate\Http\Request;

class TradeController extends Controller
{
    public function index()
    {
        $trades = Trade::with(['account', 'phase', 'pair', 'killZone', 'plan'])->get();
        return response()->json($trades);
    }

    public function store(Request $request)
    {
        $trade = Trade::create($request->validate([
            'account_id' => 'required|exists:accounts,id',
            'account_phase_id' => 'required|exists:account_phases,id',
            'pair_id' => 'required|exists:pairs,id',
            'kill_zone_id' => 'required|exists:kill_zones,id',
            'plan_id' => 'required|exists:trading_plans,id',
            'lot_size' => 'required|numeric',
            'entry_price' => 'required|numeric',
            'exit_price' => 'nullable|numeric',
            'profit_loss' => 'required|numeric',
            'is_weekly_plan_followed' => 'boolean',
            'is_checklist_followed' => 'boolean',
            'status' => 'required|in:pending,running,complete,annulled',
            'annulment_reason' => 'nullable|string',
            'annulment_screenshot' => 'nullable|string',
            'journal_link' => 'nullable|string',
        ]));

        return response()->json($trade, 201);
    }

    public function update(Request $request, Trade $trade)
    {
        $trade->update($request->all());
        return response()->json($trade);
    }

    public function destroy(Trade $trade)
    {
        $trade->delete();
        return response()->json(['message' => 'Trade deleted']);
    }
}
