<?php

namespace App\Http\Controllers;
use App\Models\Pair;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Models\Trade;
use App\Models\Account;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accounts = Account::all();
        return view('pages.dashboard', compact('accounts'));

    }

    public function stream()
    {
        $response = new StreamedResponse(function () {
            while (true) {
                $data = $this->fetchDashboardData();
                echo "data: " . json_encode($data) . "\n\n";
                ob_flush();
                flush();
                sleep(5); // Fetch updates every 5 seconds
            }
        });

        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('Cache-Control', 'no-cache');
        $response->headers->set('Connection', 'keep-alive');

        return $response;
    }

    private function fetchDashboardData()
    {
        $trades = Trade::latest()->take(10)->get();
        $accounts = Account::all();

        return [
            'balance' => $accounts->sum('balance'),
            'profit_loss' => $trades->sum('profit_loss'),
            'win_rate' => round(($trades->where('profit_loss', '>', 0)->count() / max(1, $trades->count())) * 100, 2),
            'rr_ratio' => $trades->avg('rr_ratio') ?? 0,
            'equity_curve' => [
                'labels' => $trades->pluck('created_at')->map(fn($date) => $date->format('Y-m-d'))->toArray(),
                'values' => $trades->pluck('profit_loss')->toArray(),
            ],
            'profit_loss_chart' => [
                'labels' => $trades->pluck('created_at')->map(fn($date) => $date->format('Y-m-d'))->toArray(),
                'values' => $trades->pluck('profit_loss')->toArray(),
            ],
            'trades' => $trades
        ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
