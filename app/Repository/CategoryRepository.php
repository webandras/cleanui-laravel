<?php

namespace App\Repository;

use App\Interface\Repository\CategoryRepositoryInterface;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;


class CategoryRepository implements CategoryRepositoryInterface
{

    /**
     * @return Collection
     */
    public function getRootCategories(): Collection
    {
        return Category::whereNull('category_id')
            ->with(['categories'])
            ->orderBy('name', 'ASC')
            ->get();
    }


    /**
     * @param  int  $parentCategoryId
     * @return Category
     */
    public function getCategoryById(int $parentCategoryId): Category
    {
        return Category::where('id', $parentCategoryId)->firstOrFail();
    }


    /**
     * @param  array  $data
     * @return Category
     */
    public function createCategory(array $data): Category
    {
        return Category::create($data);
    }


    /**
     * @param  Category  $category
     * @param  array  $data
     * @return bool|null
     * @throws \Throwable
     */
    public function updateCategory(Category $category, array $data): bool|null
    {
        return $category->updateOrFail($data);
    }


    /**
     * @param  Category  $category
     * @return bool|null
     */
    public function deleteTag(Category $category): bool|null
    {
        return $category->delete();
    }
}
