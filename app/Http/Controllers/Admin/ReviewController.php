<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::withTrashed()->with(['user', 'blog'])->latest();

        if ($request->has('status')) {
            if ($request->status === 'deleted') {
                $query->onlyTrashed();
            } elseif ($request->status === 'active') {
                $query->whereNull('deleted_at');
            }
        }

        $reviews = $query->paginate(10);

        return response()->json($reviews);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'blog_id' => 'required|exists:blogs,id',
            'rating'  => 'required|integer|between:1,5',
            'content' => 'required|string',
        ]);

        $review = Review::create($validated);

        return response()->json($review, 201);
    }

    public function show(Review $review)
    {
        $review->load(['user', 'blog']);
        return response()->json($review);
    }

    public function update(Request $request, Review $review)
    {
        $validated = $request->validate([
            'rating'  => 'sometimes|integer|between:1,5',
            'content' => 'sometimes|string',
        ]);

        $review->update($validated);

        return response()->json($review);
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return response()->json(null, 204);
    }
}