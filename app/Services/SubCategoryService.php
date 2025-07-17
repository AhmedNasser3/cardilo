<?php

namespace App\Services;

use App\DTOs\SubCategoryDTO;
use App\Models\api\SubCategory;

class SubCategoryService
{

     public function getTrashed()
    {
        return SubCategory::onlyTrashed()
            ->with(['category:id,name', 'user:id,name'])
            ->orderBy('set_order')
            ->get();
    }
    public function create(SubCategoryDTO $dto): SubCategory
    {
        $data = $this->prepareData($dto);

        // 🔷 هنا نحول category_id إلى int (أو null)
        $categoryId = $dto->category_id !== null ? (int) $dto->category_id : null;

        // الحصول على آخر ترتيب
        $data['set_order'] = $this->getNextOrder($categoryId);

        return SubCategory::create($data);
    }

    public function update(SubCategory $subCategory, SubCategoryDTO $dto): SubCategory
    {
        $data = $this->prepareData($dto);
        $subCategory->update($data);

        return $subCategory;
    }

    public function delete(SubCategory $subCategory): void
    {
        $subCategory->delete();
    }

    public function restore(string $id): SubCategory
    {
        $subCategory = SubCategory::withTrashed()->findOrFail($id);
        $subCategory->restore();

        return $subCategory;
    }

    public function move(SubCategory $subCategory, string $direction): bool
    {
        $neighbor = SubCategory::where('category_id', $subCategory->category_id)
            ->where('set_order', $direction === 'up' ? '<' : '>', $subCategory->set_order)
            ->orderBy('set_order', $direction === 'up' ? 'desc' : 'asc')
            ->first();

        if (!$neighbor) return false;

        [$subCategory->set_order, $neighbor->set_order] = [$neighbor->set_order, $subCategory->set_order];
        $subCategory->save();
        $neighbor->save();

        return true;
    }

    protected function prepareData(SubCategoryDTO $dto): array
    {
        $data = [
            'name'         => $dto->name,
            'slug'         => $dto->slug,
            'description'  => $dto->description,
            'metadata'     => $dto->metadata,
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

    protected function getNextOrder(?int $categoryId): int
    {
        return (SubCategory::where('category_id', $categoryId)->max('set_order') ?? 0) + 1;
    }
}
