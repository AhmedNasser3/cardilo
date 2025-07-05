<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Blog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    /**
     * Display a listing of blogs.
     * Supports ?with_deleted=1 to include soft-deleted blogs.
     */
    public function index(Request $request)
    {
        if ($request->has('with_deleted') && $request->with_deleted) {
            return response()->json(Blog::withTrashed()->get());
        }

        return response()->json(Blog::all());
    }

    /**
     * Store a newly created blog.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'image' => 'required|string',
            'publisher' => 'required|string',
        ]);

        $blog = Blog::create($validated);

        return response()->json($blog, 201);
    }

    /**
     * Display the specified blog.
     */
    public function show($id)
    {
        $blog = Blog::withTrashed()->findOrFail($id);
        return response()->json($blog);
    }

    /**
     * Update the specified blog.
     */
    public function update(Request $request, $id)
    {
        $blog = Blog::withTrashed()->findOrFail($id);

        $validated = $request->validate([
            'title' => 'sometimes|string',
            'content' => 'sometimes|string',
            'image' => 'sometimes|string',
            'publisher' => 'sometimes|string',
        ]);

        $blog->update($validated);

        return response()->json($blog);
    }

    /**
     * Soft delete or force delete the specified blog.
     * Pass ?force=true to force delete permanently.
     */
    public function destroy(Request $request, $id)
    {
        $blog = Blog::withTrashed()->findOrFail($id);

        if ($request->has('force') && $request->force) {
            $blog->forceDelete();
            return response()->json(['message' => 'Blog permanently deleted']);
        }

        $blog->delete();
        return response()->json(['message' => 'Blog soft deleted successfully']);
    }

    /**
     * Restore a soft-deleted blog.
     */
    public function restore($id)
    {
        $blog = Blog::withTrashed()->findOrFail($id);

        if ($blog->trashed()) {
            $blog->restore();
            return response()->json(['message' => 'Blog restored successfully']);
        }

        return response()->json(['message' => 'Blog is not deleted'], 400);
    }
}