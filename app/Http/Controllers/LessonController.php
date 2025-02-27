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

    public function getLessons(Request $request) {
        $lessons = Lesson::query();
        return DataTables::of($lessons)
            ->addIndexColumn()
            ->addColumn('created_at', fn($lesson) => $lesson->created_at->format('D d M Y'))
            ->addColumn('action', function ($lesson) {
                return '<button class="btn btn-sm btn-warning edit-lesson" data-id="'.$lesson->id.'">Edit</button>
                        <button class="btn btn-sm btn-danger delete-lesson" data-id="'.$lesson->id.'">Delete</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required',
            'priority' => 'required|string',
            'notion_link' => 'nullable|url',
        ]);

        $lesson = new Lesson();
        $lesson->user_id = 1;//auth()->id();
        $lesson->trade_id = $request->trade_id;
        $lesson->title = $request->title;
        $lesson->description = $request->description;
        $lesson->priority = $request->priority;
        $lesson->notion_link = $request->notion_link;
        $lesson->save();

        return response()->json(['message' => 'Lesson added successfully!', 'type' => 'success']);
    }

    public function update(Request $request, $id) {
        $lesson = Lesson::findOrFail($id);
        $lesson->update($request->all());
        return response()->json(['message' => 'Lesson updated successfully!', 'type' => 'success']);
    }

    public function destroy($id) {
        Lesson::findOrFail($id)->delete();
        return response()->json(['message' => 'Lesson deleted successfully!', 'type' => 'success']);
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

}
