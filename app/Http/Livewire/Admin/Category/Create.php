<?php

namespace App\Http\Livewire\Admin\Category;

use App\Interface\Repository\CategoryRepositoryInterface;
use App\Interface\Services\ImageServiceInterface;
use App\Models\Category;
use App\Support\InteractsWithBanner;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Create extends Component
{
    use InteractsWithBanner;
    use AuthorizesRequests;

    // used by blade / alpinejs
    public $modalId;
    public bool $isModalOpen;
    public bool $hasSmallButton;

    // inputs
    public string $name;
    public string $slug;
    public ?string $cover_image_url;
    public $category;
    public int $categoryId;

    protected array $rules = [
        'name' => 'required|string|min:1|max:255',
        'slug' => 'required|string|unique:categories',
        'cover_image_url' => 'nullable|string',
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
    public function boot(CategoryRepositoryInterface $categoryRepository, ImageServiceInterface $imageService)
    {
        $this->categoryRepository = $categoryRepository;
        $this->imageService = $imageService;
    }


    public function mount(string $modalId, $category, bool $hasSmallButton = false)
    {
        $this->modalId = $modalId;
        $this->isModalOpen = false;
        $this->hasSmallButton = $hasSmallButton || false;

        $this->name = '';
        $this->slug = '';
        $this->cover_image_url = '';
        $this->category = $category;
        $this->categoryId = $category->id;
    }


    public function render()
    {
        return view('admin.livewire.category.create');
    }

    public function createCategory()
    {
        $this->authorize('create', Category::class);

        // validate user input
        $this->validate();

        // save category, rollback transaction if fails
        DB::transaction(
            function () {
                $category = [];
                $category['name'] = $this->name;
                $category['slug'] = $this->slug;

                if (isset($this->cover_image_url)) {
                    $category['cover_image_url'] = $this->imageService->getImageAbsolutePath($this->cover_image_url);
                }

                $category['category_id'] = $this->categoryId;

                $this->categoryRepository->createCategory($category);
            },
            2
        );

        $this->banner(__('New subcategory successfully added.'));
        return redirect()->route('category.manage');
    }

    public function initialize() {
        $this->name = '';
        $this->cover_image_url = '';
    }
}
