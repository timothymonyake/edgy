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

    public function getPropFirms(Request $request) {
        $propFirms = PropFirm::query();
        return DataTables::of($propFirms)
            ->addIndexColumn()
            ->addColumn('created_at', fn($firm) => $firm->created_at->format('D d M Y'))
            ->addColumn('action', function ($firm) {
                return '<button class="btn btn-sm btn-warning edit-prop-firm" data-id="'.$firm->id.'">Edit</button>
                        <button class="btn btn-sm btn-danger delete-prop-firm" data-id="'.$firm->id.'">Delete</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|unique:prop_firms,name',
            'website_url' => 'required|url',
        ]);

        PropFirm::create($request->all());
        return response()->json(['message' => 'Prop Firm added successfully!', 'type' => 'success']);
    }

    public function update(Request $request, $id) {
        $firm = PropFirm::findOrFail($id);
        $firm->update($request->all());
        return response()->json(['message' => 'Prop Firm updated successfully!', 'type' => 'success']);
    }

    public function destroy($id) {
        PropFirm::findOrFail($id)->delete();
        return response()->json(['message' => 'Prop Firm deleted successfully!', 'type' => 'success']);
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

  
}
