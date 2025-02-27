<?php

namespace App\Http\Controllers;

use App\Models\PropFirm;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use App\Models\TradingPlan;
use Illuminate\Support\Facades\Auth;

class PropFirmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {
        return view('pages.prop_firms', ['title' => 'Prop Firms']);
    }

    public function getAllPropFirms() {
        return PropFirm::query();
    }

    public function getPropFirms(Request $request) {
        $propFirms = $this->getAllPropFirms();
        if ($request->has('draw')) {
            return DataTables::of($propFirms->get())
                ->addIndexColumn()
                ->addColumn('created_at', fn($firm) => $firm->created_at->format('D d M Y'))
                ->addColumn('action', fn($firm) => '<button onclick="deleteFirm('.$firm->id.')">Delete</button>')
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'website_url' => 'nullable|url',
        ]);

        PropFirm::create($request->all());
        return response()->json(['message' => 'Prop Firm added successfully!', 'type' => 'success']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }


    /**
     * Display the specified resource.
     */
    public function show(PropFirm $propFirm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PropFirm $propFirm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PropFirm $propFirm)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PropFirm $propFirm)
    {
        //
    }
}
