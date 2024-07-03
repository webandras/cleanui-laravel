<?php

namespace Modules\Livewire\Admin\Blog\Category;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Modules\Blog\Interfaces\Repositories\CategoryRepositoryInterface;
use Modules\Blog\Models\Category;
use Modules\Clean\Traits\InteractsWithBanner;

class Delete extends Component
{
    use InteractsWithBanner;
    use AuthorizesRequests;


    // used by blade / alpinejs
    /**
     * @var string
     */
    public string $modalId;


    /**
     * @var bool
     */
    public bool $isModalOpen;


    /**
     * @var bool
     */
    public bool $hasSmallButton;


    // inputs
    /**
     * @var int
     */
    public int $categoryId;


    /**
     * @var string
     */
    public string $name;


    /**
     * @var Category
     */
    public Category $category;


    /**
     * @var array|string[]
     */
    protected array $rules = [
        'categoryId' => 'required|int|min:1',
    ];


    /**
     * @var CategoryRepositoryInterface
     */
    private CategoryRepositoryInterface $categoryRepository;


    /**
     * @param  CategoryRepositoryInterface  $categoryRepository
     * @return void
     */
    public function boot(CategoryRepositoryInterface $categoryRepository): void
    {
        $this->categoryRepository = $categoryRepository;
    }


    /**
     * @param  string  $modalId
     * @param $category
     * @param  bool  $hasSmallButton
     * @return void
     */
    public function mount(string $modalId, $category, bool $hasSmallButton = false): void
    {
        $this->modalId = $modalId;
        $this->isModalOpen = false;
        $this->hasSmallButton = $hasSmallButton;
        $this->category = $category;
        $this->categoryId = $category->id;
        $this->name = $category->name;
    }


    /**
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.livewire.blog.category.delete');
    }


    /**
     * @return Redirector
     */
    public function deleteCategory(): Redirector
    {
        // validate user input
        $this->validate();

        // save category, rollback transaction if fails
        DB::transaction(
            function () {
                $this->categoryRepository->deleteTag($this->category);
            },
            2
        );

        $this->banner(__('Category successfully deleted.'));
        return redirect()->route('category.manage');
    }
}
