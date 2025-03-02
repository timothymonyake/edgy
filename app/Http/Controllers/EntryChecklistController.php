<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EntryChecklist;
use App\Models\Pair;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class EntryChecklistController extends Controller
{
    public function index() {
        return view('pages.entry_checklists');
    }

    public function getEntryChecklists(Request $request) {
        $entryChecklists = EntryChecklist::query();
        return DataTables::of($entryChecklists)
            ->addIndexColumn()
            ->addColumn('is_mandatory', fn($checklist) => $checklist->is_mandatory ? 'Yes' : 'No')
            ->addColumn('created_at', fn($checklist) => $checklist->created_at->format('D d M Y'))
            ->addColumn('action', function ($checklist) {
                return '<button class="btn btn-sm btn-warning edit-checklist" data-id="'.$checklist->id.'">Edit</button>
                        <button class="btn btn-sm btn-danger delete-checklist" data-id="'.$checklist->id.'">Delete</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request) {
        $request->validate(['title' => 'required', 'is_mandatory' => 'required|boolean']);
        EntryChecklist::create($request->all());
        return response()->json(['message' => 'Checklist item added successfully!', 'type' => 'success']);
    }

    public function update(Request $request, $id) {
        $checklist = EntryChecklist::findOrFail($id);
        $checklist->update($request->all());
        return response()->json(['message' => 'Checklist item updated successfully!', 'type' => 'success']);
    }

    public function destroy($id) {
        EntryChecklist::findOrFail($id)->delete();
        return response()->json(['message' => 'Checklist item deleted successfully!', 'type' => 'success']);
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
    public function show(EntryChecklist $entryChecklist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EntryChecklist $entryChecklist)
    {
        //
    }

}
