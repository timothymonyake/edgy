<?php

namespace App\Http\Controllers;

use App\Models\Phase;
use App\Models\Pair;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;


class PhaseController extends Controller
{
    public function index()
    {
        return view('pages.phases', ['title' => 'Phases']);
    }

    public function getAllPhases()
    {
        return Phase::query();
    }

    public function getPhases(Request $request)
    {
        $phases = $this->getAllPhases();
        if ($request->has('draw')) {
            return DataTables::of($phases->get())
                ->addIndexColumn()
                ->addColumn('created_at', fn($phase) => $phase->created_at->format('D d M Y'))
                ->addColumn('action', fn($phase) => '<button onclick="editPhase(' . $phase->id . ')">Edit</button> <button onclick="deletePhase(' . $phase->id . ')">Delete</button>')
                ->rawColumns(['action'])
                ->make(true);
        } else {
            $search_term = $request->q ?? null;

            $phases = Phase::select("id", "name")
                ->when($search_term, function ($query) use ($search_term) {
                    $query->where('name', 'LIKE', "%{$search_term}%");
                })
                ->orderBy('name', 'asc')
                ->get();

            $data = $phases->map(fn($phase) => [
                'id' => $phase->id,
                'name' => strtoupper($phase->name)
            ]);

            return response()->json($data);
        }
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        Phase::create($request->all());
        return response()->json(['message' => 'Phase added successfully!', 'type' => 'success']);
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required']);
        $phase = Phase::findOrFail($id);
        $phase->update($request->all());
        return response()->json(['message' => 'Phase updated successfully!', 'type' => 'success']);
    }

    public function destroy($id)
    {
        Phase::destroy($id);
        return response()->json(['message' => 'Phase deleted successfully!', 'type' => 'success']);
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
    public function show(Phase $phase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Phase $phase)
    {
        //
    }
}
