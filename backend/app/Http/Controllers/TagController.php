<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::where('user_id', auth()->id())
            ->latest()
            ->get();

        return response()->json($tags);
    }

    public function store(Request $request)
    {
        /* Authorization: Only allow if user is authenticated */
        if (!auth()->check()) {
            return response()->json(['message' => 'You do not have permission to create a tag'], 401);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'required|string|max:7',
        ]);

        $tag = Tag::create([
            'name' => $request->name,
            'color' => $request->color,
            'task_id' => $request->task_id,
            'user_id' => auth()->id(),
        ]);

        return response()->json(['tag' => $tag, 'message' => 'Tag created successfully'], 201);
    }

    public function destroy(Tag $tag)
    {
        /* Authorization: Only allow if user is authenticated */
        if (!auth()->check()) {
            return response()->json(['message' => 'You do not have permission to create a tag'], 401);
        }

        $tag->delete();
        return response()->json(['message' => 'Tag deleted successfully'], 200);
    }
}
