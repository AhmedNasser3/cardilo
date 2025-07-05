<?php

namespace App\Http\Controllers\Admin;


use App\Models\Admin\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BannerController extends Controller
{
    public function index()
    {
        return response()->json(Banner::all());
    }

    public function show($id)
    {
        $banner = Banner::findOrFail($id);
        return response()->json($banner);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'image' => 'required|string',
            'title' => 'required|string',
            'subtitle' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $banner = Banner::create($data);
        return response()->json($banner, 201);
    }

    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $data = $request->validate([
            'image' => 'sometimes|required|string',
            'title' => 'sometimes|required|string',
            'subtitle' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $banner->update($data);
        return response()->json($banner);
    }

    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->delete();
        return response()->json(['message' => 'Banner soft deleted']);
    }

public function trashed()
{
    return Banner::onlyTrashed()->get();
}


    public function restore($id)
    {
        $banner = Banner::withTrashed()->findOrFail($id);
        $banner->restore();
        return response()->json(['message' => 'Banner restored']);
    }
}
