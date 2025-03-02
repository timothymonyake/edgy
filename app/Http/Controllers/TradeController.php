<?php
namespace App\Http\Controllers;

use App\Models\Trade;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use App\Models\TradingPlan;
use Illuminate\Support\Facades\Auth;

class TradeController extends Controller
{
    public function index() {
        return view('pages.trades', ['title' => 'Trades']);
    }

    public function getAllTrades() {
        return Trade::with(['account', 'pair', 'killZone', 'tradingPlan'])->get();
    }

    public function getTrades(Request $request) {
        $trades = $this->getAllTrades();
        if ($request->has('draw')) {
            return DataTables::of($trades)
                ->addIndexColumn()
                ->addColumn('created_at', fn($trade) => $trade->created_at->format('D d M Y'))
                ->addColumn('action', fn($trade) => '<button onclick="editTrade('.$trade->id.')">Edit</button> <button onclick="deleteTrade('.$trade->id.')">Delete</button>')
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function store(Request $request) {
        $request->validate([
            'account_id' => 'required',
            'pair_id' => 'required',
            'lot_size' => 'required|numeric',
            'entry_price' => 'required|numeric',
            'exit_price' => 'required|numeric',
            'profit_loss' => 'required|numeric',
            'status' => 'required',
        ]);

        Trade::create($request->all());
        return response()->json(['message' => 'Trade added successfully!', 'type' => 'success']);
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
