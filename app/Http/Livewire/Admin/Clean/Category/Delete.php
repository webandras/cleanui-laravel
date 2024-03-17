<?php

namespace App\Http\Livewire\Admin\Clean\Category;

use App\Interface\Repository\Clean\CategoryRepositoryInterface;
use App\Models\Clean\Category;
use App\Trait\Clean\InteractsWithBanner;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Delete extends Component
{
    use InteractsWithBanner;
    use AuthorizesRequests;


    // used by blade / alpinejs
    public string $modalId;
    public bool $isModalOpen;
    public bool $hasSmallButton;


    // inputs
    public int $categoryId;
    public string $name;
    public Category $category;


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


    public function mount(string $modalId, $category, bool $hasSmallButton = false)
    {
        $this->modalId = $modalId;
        $this->isModalOpen = false;
        $this->hasSmallButton = $hasSmallButton;
        $this->category = $category;
        $this->categoryId = $category->id;
        $this->name = $category->name;
    }


    public function render()
    {
        return view('admin.livewire.category.delete');
    }


    public function deleteCategory()
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
