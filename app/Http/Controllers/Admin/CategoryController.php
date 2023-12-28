<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interface\Repository\CategoryRepositoryInterface;
use App\Models\Category;
use App\Support\InteractsWithBanner;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use InteractsWithBanner;

    private CategoryRepositoryInterface $categoryRepository;


    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }


    /**
     * Manage categories page
     *
     * @return Application|Factory|View
     */
    public function index(): Application|Factory|View
    {
        $categories = $this->categoryRepository->getRootCategories();

        // the default is the first category
        $selectedCategory = $categories->first();

        $parentCategories = [];
        $parentCategoryId = $selectedCategory->category_id ?? null;

        while ($parentCategoryId !== null) {
            $currentCategory = $this->categoryRepository->getCategoryById($parentCategoryId);
            $parentCategories[$currentCategory->id] = $currentCategory->name;
            $parentCategoryId = $currentCategory->category_id ?? null;
        }

        return view('admin.pages.category.manage')->with([
            'categories' => $categories,
            'parentCategories' => array_reverse($parentCategories, true),
        ]);
    }


    /**
     * @param  Category  $category
     *
     * @return Factory|View|Application
     */
    public function getSelected(Category $category): Factory|View|Application
    {
        $categories = $this->categoryRepository->getRootCategories();

        $parentCategories = [];
        $parentCategoryId = $selectedCategory->category_id ?? null;
        while ($parentCategoryId !== null) {
            $currentCategory = $this->categoryRepository->getCategoryById($parentCategoryId);
            $parentCategories[$currentCategory->id] = $currentCategory->name;
            $parentCategoryId = $currentCategory->category_id ?? null;
        }

        return view('admin.pages.category.manage')->with([
            'categories' => $categories,
            'selectedCategory' => $category,
            'parentCategories' => array_reverse($parentCategories, true),
        ]);

    }

}
