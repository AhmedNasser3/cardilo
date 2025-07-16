<?php

namespace App\Http\Controllers\API;

use App\Models\Frontend\Category;
use App\Services\CategoryService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\Api\CategoryResource;
use App\Http\Requests\Api\StoreCategoryRequest;

class CategoryController extends Controller
{
    public function __construct(protected CategoryService $service) {}

    public function index()
    {
        $key = 'categories_' . md5(json_encode(request()->all()));
        $categories = Cache::remember($key, 60, fn () => $this->service->listCategories());

        return CategoryResource::collection($categories);
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = $this->service->createCategory($request->toDTO());
        Cache::flush();

        return new CategoryResource($category);
    }

    public function update(StoreCategoryRequest $request, $id)
    {
        $category = $this->service->updateCategory($id, $request->toDTO());
        Cache::flush();

        return new CategoryResource($category);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        Cache::flush();

        return response()->json(['message' => 'Category soft deleted']);
    }

    public function trashed()
    {
        $trashed = Category::onlyTrashed()->paginate(10);

        return CategoryResource::collection($trashed);
    }

    public function restore($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $category->restore();
        Cache::flush();

        return response()->json(['message' => 'Category restored']);
    }
}