<?php

namespace App\Http\Controllers;

use App\Models\Pair;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class PairController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Pairs';
        return view('pages.pairs', compact('title'));
    }

    public function getAllPairs()
    {
        return Pair::query();
    }

    public function getPairs(Request $request)
    {
        $pairs = $this->getAllPairs();
        if ($request->has('draw')) {
            return DataTables::of($pairs->get())
                ->addIndexColumn()
                ->addColumn('created_at', function ($pair) {
                    return Carbon::parse($pair->created_at)->format('D d M Y');
                })
                ->addColumn('status', function ($pair) {
                    return $pair->is_active
                        ? '<span class="badge rounded-pill bg-success">ACTIVE</span>'
                        : '<span class="badge rounded-pill bg-danger">INACTIVE</span>';
                })
                ->addColumn('action', function ($pair) {
                    return '<div class="dropdown">
                            <a class="text-soft dropdown-toggle btn btn-icon btn-trigger" data-bs-toggle="dropdown" aria-expanded="false">
                                <em class="icon ni ni-more-h"></em>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-xs">
                                <ul class="link-list-plain">
                                    <li><a href="' . route('pairs.edit', $pair->id) . '">Edit</a></li>
                                    <li><a href="#" onclick="deletePair(' . $pair->id . ')">Remove</a></li>
                                </ul>
                            </div>
                        </div>';
                })
                ->rawColumns(['action', 'status','created_at'])
                ->make(true);
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:pairs|max:255',
        ]);

        if(Pair::create($request->all())){
            return response()->json([
                'message' => 'Pair added successfully!',
                'type' => 'success'
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pair $pair)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pair $pair)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pair $pair)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pair $pair)
    {
        //
    }
}
