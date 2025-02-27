<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class LessonController extends Controller
{
    public function index() {
        return view('pages.lessons', ['title' => 'Lessons']);
    }

    public function getAllLessons() {
        return Lesson::with(['user', 'trade'])->get();
    }

    public function getLessons(Request $request) {
        $lessons = $this->getAllLessons();
        if ($request->has('draw')) {
            return DataTables::of($lessons)
                ->addIndexColumn()
                ->addColumn('created_at', fn($lesson) => $lesson->created_at->format('D d M Y'))
                ->addColumn('action', fn($lesson) => '<button onclick="deleteLesson('.$lesson->id.')">Delete</button>')
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'priority' => 'required|integer',
            'notion_link' => 'nullable|url',
        ]);

        Lesson::create($request->all());
        return response()->json(['message' => 'Lesson added successfully!', 'type' => 'success']);
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
    public function show(Lesson $lesson)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lesson $lesson)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lesson $lesson)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lesson $lesson)
    {
        //
    }
}
