<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreSubCategoryRequest;
use App\Http\Resources\Api\SubCategoryResource;
use App\Models\api\SubCategory;
use App\Services\SubCategoryService;
use App\DTOs\SubCategoryDTO;
use Illuminate\Support\Facades\Cache;

class SubCategoryController extends Controller
{
    public function __construct(protected SubCategoryService $service) {}

    public function index()
    {
        $data = Cache::remember('sub_categories', 60, fn () =>
            SubCategory::with(['category:id,name', 'user:id,name'])
                ->orderBy('set_order')
                ->get()
        );

        return SubCategoryResource::collection($data);
    }
    public function trashed()
    {
        $trashed = $this->service->getTrashed();

        return SubCategoryResource::collection($trashed);
    }

    public function store(StoreSubCategoryRequest $request)
    {
        $dto = SubCategoryDTO::fromArray($request->validated());
        $subCategory = $this->service->create($dto);
        Cache::flush();

        return new SubCategoryResource($subCategory);
    }

    public function update(StoreSubCategoryRequest $request, SubCategory $subCategory)
    {
        $dto = SubCategoryDTO::fromArray($request->validated());
        $subCategory = $this->service->update($subCategory, $dto);
        Cache::flush();

        return new SubCategoryResource($subCategory);
    }

    public function destroy(SubCategory $subCategory)
    {
        $this->service->delete($subCategory);
        Cache::flush();

        return response()->json(['message' => 'SubCategory soft deleted']);
    }

    public function restore($id)
    {
        $this->service->restore($id);
        Cache::flush();

        return response()->json(['message' => 'SubCategory restored']);
    }

    public function moveUp(SubCategory $subCategory) { return $this->move($subCategory, 'up'); }
    public function moveDown(SubCategory $subCategory) { return $this->move($subCategory, 'down'); }

    protected function move(SubCategory $subCategory, string $direction)
    {
        $result = $this->service->move($subCategory, $direction);
        if (!$result) return response()->json(['message' => 'Cannot move further'], 400);

        Cache::flush();
        return response()->json(['message' => 'Order updated']);
    }

    public function show(SubCategory $subCategory)
    {
        return new SubCategoryResource($subCategory);
    }
}
