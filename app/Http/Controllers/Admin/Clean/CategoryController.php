<?php

namespace App\Http\Controllers\Admin\Clean;

use App\Http\Controllers\Controller;
use App\Interface\Repository\Clean\CategoryRepositoryInterface;
use App\Models\Clean\Category;
use App\Trait\Clean\InteractsWithBanner;
use App\Trait\Clean\UserPermissions;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use InteractsWithBanner, UserPermissions;

    private CategoryRepositoryInterface $categoryRepository;


    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }


    /**
     * Manage categories page
     *
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function index(): Application|Factory|View
    {
        $this->authorize('viewAny', Category::class);

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
            'userPermissions' => $this->getUserPermissions()
        ]);
    }

}
