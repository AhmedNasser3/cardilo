<?php

namespace App\Services;

use App\DTOs\CategoryDTO;
use App\Models\Frontend\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CategoryService
{
    public function listCategories(): LengthAwarePaginator
    {
        return Category::query()
            ->with(['user', 'children'])
            ->when(request('is_active'), fn($q) =>
                $q->where('is_active', request('is_active'))
            )
            ->when(request('search'), fn($q) =>
                $q->where('name', 'like', '%' . request('search') . '%')
            )
            ->orderBy('set_order')
            ->paginate(15);
    }

    public function createCategory(CategoryDTO $dto): Category
    {
        $data = $this->prepareData($dto);
        return Category::create($data);
    }

    public function updateCategory(string|int $id, CategoryDTO $dto): Category
    {
        $category = Category::findOrFail($id);
        $data = $this->prepareData($dto);
        $category->update($data);

        return $category;
    }

    protected function prepareData(CategoryDTO $dto): array
    {
        $data = [
            'name'        => $dto->name,
            'slug'        => $dto->slug,
            'description' => $dto->description,
            'metadata'    => $dto->metadata,
            'set_order'   => $dto->set_order,
            'parent_id'   => $dto->parent_id,
            'user_id'     => $dto->user_id,
            'is_active'   => $dto->is_active,
            'publish_at'  => $dto->publish_at,
            'approved_at' => $dto->approved_at,
        ];

        if ($dto->image) {
            $data['image'] = $dto->image->store('categories', 'public');
        }

        return $data;
    }
}