<?php

namespace App\Http\Controllers;

use App\Models\KillZone;
use App\Models\Pair;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class KillZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Killzones';
        return view('pages.killzones', compact('title'));
    }

    public function getAllKillzones()
    {
        return Killzone::query();
    }

    public function getKillzones(Request $request)
    {
        $killzones = $this->getAllKillzones();
        if ($request->has('draw')) {
            return DataTables::of($killzones->get())
                ->addIndexColumn()
                ->addColumn('created_at', function ($killzone) {
                    return Carbon::parse($killzone->created_at)->format('D d M Y');
                })
                ->addColumn('status', function ($killzone) {
                    return $killzone->is_active
                        ? '<span class="badge rounded-pill bg-success">ACTIVE</span>'
                        : '<span class="badge rounded-pill bg-danger">INACTIVE</span>';
                })
                ->addColumn('action', function ($killzone) {
                    return '<div class="dropdown">
                            <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown">
                                <em class="icon ni ni-more-h"></em>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                <ul class="link-list-plain">
                                    <li><a href="' . route('killzones.edit', $killzone->id) . '">Edit</a></li>
                                    <li><a href="#" onclick="deleteKillzone(' . $killzone->id . ')">Remove</a></li>
                                </ul>
                            </div>
                        </div>';
                })
                ->rawColumns(['action', 'status', 'created_at'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:killzones|max:255',
        ]);

        if (Killzone::create($request->all())) {
            return response()->json([
                'message' => 'Killzone added successfully!',
                'type' => 'success'
            ]);
        }
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
    public function show(KillZone $killZone)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(KillZone $killZone)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, KillZone $killZone)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(KillZone $killZone)
    {
        //
    }
}
