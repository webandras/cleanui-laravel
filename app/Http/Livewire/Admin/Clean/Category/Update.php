<?php

namespace App\Http\Livewire\Admin\Clean\Category;

use App\Interface\Repository\Clean\CategoryRepositoryInterface;
use App\Interface\Services\Clean\ImageServiceInterface;
use App\Models\Clean\Category;
use App\Trait\Clean\InteractsWithBanner;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Update extends Component
{
    use InteractsWithBanner, AuthorizesRequests;


    // used by blade / alpinejs
    public string $modalId;
    public bool $isModalOpen;
    public bool $hasSmallButton;


    // inputs
    public string $name;
    public string $slug;
    public ?string $cover_image_url;
    public int $categoryId;
    public Category $category;


    protected array $rules = [
        'name' => 'required|string|min:1|max:255',
        'categoryId' => 'required|int|min:1',
    ];


    /**
     * @var CategoryRepositoryInterface
     */
    private CategoryRepositoryInterface $categoryRepository;


    /**
     * @var ImageServiceInterface
     */
    private ImageServiceInterface $imageService;


    /**
     * @param  CategoryRepositoryInterface  $categoryRepository
     * @param  ImageServiceInterface  $imageService
     * @return void
     */
    public function boot(CategoryRepositoryInterface $categoryRepository, ImageServiceInterface $imageService): void
    {
        $this->categoryRepository = $categoryRepository;
        $this->imageService = $imageService;
    }


    public function mount(string $modalId, Category $category, bool $hasSmallButton = false)
    {
        $this->modalId = $modalId;
        $this->isModalOpen = false;
        $this->hasSmallButton = $hasSmallButton;
        $this->category = $category;
        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->cover_image_url = isset($category->cover_image_url) ? (config('app.url').$category->cover_image_url) : '';
        $this->categoryId = $category->id;
    }


    public function render()
    {
        return view('admin.livewire.category.update');
    }


    public function updateCategory()
    {
        if ($this->slug !== '') {
            $this->rules['slug'] = 'required|string|unique:categories,slug,'.$this->categoryId;
        }

        if ($this->cover_image_url !== '') {
            $this->rules['cover_image_url'] = 'required|string';
        }


        // validate user input
        $this->validate();

        // save category, rollback transaction if fails
        DB::transaction(
            function () {
                $this->categoryRepository->updateCategory($this->category, [
                    'name' => $this->name,
                    'slug' => $this->slug,
                    'cover_image_url' => $this->cover_image_url === '' ? null : $this->imageService->getImageAbsolutePath($this->cover_image_url),
                ]);
            },
            2
        );

        $this->banner(__('Category successfully updated.'));
        return redirect()->route('category.manage');
    }
}
