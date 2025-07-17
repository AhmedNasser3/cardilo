<?php

namespace App\Http\Controllers\API;

use App\Models\api\SubCategory;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\SubCategoryService;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\Api\SubCategoryResource;
use App\Http\Requests\Api\StoreSubCategoryRequest;

class SubCategoryController extends Controller
{
    public function __construct(protected SubCategoryService $service) {}

    public function index()
    {
        $key = 'sub_categories_' . md5(json_encode(request()->all()));
        $subCategories = Cache::remember($key, 60, fn () => $this->service->listSubCategories());

        return SubCategoryResource::collection($subCategories);
    }

    public function store(StoreSubCategoryRequest $request)
    {
        try {
            $subCategory = $this->service->createSubCategory($request->toDTO());
            Cache::flush();

            return new SubCategoryResource($subCategory);

        } catch (\Throwable $e) {
            Log::error('Error creating subcategory: '.$e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'message' => 'Something went wrong',
                'error'   => $e->getMessage(),
            ], 500);
        }
    }

    public function update(StoreSubCategoryRequest $request, $id)
    {
        $subCategory = $this->service->updateSubCategory($id, $request->toDTO());
        Cache::flush();

        return new SubCategoryResource($subCategory);
    }

    public function destroy($id)
    {
        $subCategory = SubCategory::findOrFail($id);
        $subCategory->delete();
        Cache::flush();

        return response()->json(['message' => 'SubCategory soft deleted']);
    }

    public function trashed()
    {
        $trashed = SubCategory::onlyTrashed()->paginate(10);

        return SubCategoryResource::collection($trashed);
    }

    public function restore($id)
    {
        $subCategory = SubCategory::withTrashed()->findOrFail($id);
        $subCategory->restore();
        Cache::flush();

        return response()->json(['message' => 'SubCategory restored']);
    }

    public function show($id)
    {
        $subCategory = SubCategory::findOrFail($id);
        return new SubCategoryResource($subCategory);
    }
}