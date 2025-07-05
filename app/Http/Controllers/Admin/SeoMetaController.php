<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Admin\SeoMeta;
use App\Http\Controllers\Controller;

class SeoMetaController extends Controller
{
    public function index()
    {
        $meta = SeoMeta::all();
        return response()->json([
            'status' => true,
            'data' => $meta
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'page' => 'required|unique:seo_meta,page',
            'title' => 'nullable',
            'description' => 'nullable',
            'keywords' => 'nullable',
            'canonical' => 'nullable',
            'og_title' => 'nullable',
            'og_description' => 'nullable',
            'og_image' => 'nullable',
            'twitter_title' => 'nullable',
            'twitter_description' => 'nullable',
            'twitter_image' => 'nullable',
        ]);

        $meta = SeoMeta::create($validated);

        return response()->json([
            'status' => true,
            'message' => 'SEO meta created successfully.',
            'data' => $meta
        ], 201);
    }

    public function show(SeoMeta $seoMeta)
    {
        return response()->json([
            'status' => true,
            'data' => $seoMeta
        ], 200);
    }

    public function update(Request $request, SeoMeta $seoMeta)
    {
        $validated = $request->validate([
            'page' => 'required|unique:seo_meta,page,' . $seoMeta->id,
            'title' => 'nullable',
            'description' => 'nullable',
            'keywords' => 'nullable',
            'canonical' => 'nullable',
            'og_title' => 'nullable',
            'og_description' => 'nullable',
            'og_image' => 'nullable',
            'twitter_title' => 'nullable',
            'twitter_description' => 'nullable',
            'twitter_image' => 'nullable',
        ]);

        $seoMeta->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'SEO meta updated successfully.',
            'data' => $seoMeta
        ], 200);
    }

    public function destroy(SeoMeta $seoMeta)
    {
        $seoMeta->delete();

        return response()->json([
            'status' => true,
            'message' => 'SEO meta deleted successfully.'
        ], 200);
    }
}