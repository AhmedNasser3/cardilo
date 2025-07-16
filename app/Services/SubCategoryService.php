<?php

namespace App\Services;

use App\DTOs\SubCategoryDTO;
use App\Models\api\SubCategory;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SubCategoryService
{
    public function listSubCategories(): LengthAwarePaginator
    {
        return SubCategory::query()
            ->with(['user', 'category'])
            ->when(request('is_active'), fn($q) =>
                $q->where('is_active', request('is_active'))
            )
            ->when(request('search'), fn($q) =>
                $q->where('name', 'like', '%' . request('search') . '%')
            )
            ->orderBy('set_order')
            ->paginate(15);
    }

    public function createSubCategory(SubCategoryDTO $dto): SubCategory
    {
        $data = $this->prepareData($dto);
        return SubCategory::create($data);
    }

    public function updateSubCategory(string $id, SubCategoryDTO $dto): SubCategory
    {
        $subCategory = SubCategory::findOrFail($id);
        $data = $this->prepareData($dto);
        $subCategory->update($data);

        return $subCategory;
    }

    protected function prepareData(SubCategoryDTO $dto): array
    {
        $data = [
            'name'         => $dto->name,
            'slug'         => $dto->slug,
            'description'  => $dto->description,
            'metadata'     => $dto->metadata,
            'set_order'    => $dto->set_order,
            'category_id'  => $dto->category_id,
            'user_id'      => $dto->user_id,
            'is_active'    => $dto->is_active,
            'publish_at'   => $dto->publish_at,
            'approved_at'  => $dto->approved_at,
        ];

        if ($dto->image) {
            $data['image'] = $dto->image->store('sub_categories', 'public');
        }

        return $data;
    }
}