<?php

namespace Modules\Livewire\Admin\Blog\Category;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Modules\Blog\Models\Category;
use Modules\Clean\Interfaces\Services\ImageServiceInterface;
use Modules\Clean\Traits\InteractsWithBanner;

class Create extends Component
{
    use InteractsWithBanner;
    use AuthorizesRequests;

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


    /**
     * @var string
     */
    public string $name;


    /**
     * @var string
     */
    public string $slug;


    /**
     * @var string|null
     */
    public ?string $cover_image_url;


    /**
     * @var
     */
    public $category;


    /**
     * @var int
     */
    public int $categoryId;


    /**
     * @var array|string[]
     */
    protected array $rules = [
        'name' => 'required|string|min:1|max:255',
        'slug' => 'required|alpha_dash|unique:categories',
        'cover_image_url' => 'nullable|string',
        'categoryId' => 'required|int|min:1',
    ];


    /**
     * @return string[]
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The :attribute is required.',
            'slug.required' => 'The :attribute is required.',
            'categoryId.required' => 'The :attribute is required.',
        ];
    }


    /**
     * @return array
     */
    public function validationAttributes(): array
    {
        return [
            'name' => __('name'),
            'slug' => __('slug'),
            'cover_image_url' => __('cover image url'),
            'categoryId' => __('category id'),
        ];
    }


    /**
     * @var ImageServiceInterface
     */
    private ImageServiceInterface $imageService;


    /**
     * @param  ImageServiceInterface  $imageService
     * @return void
     */
    public function boot(ImageServiceInterface $imageService): void
    {
        $this->imageService = $imageService;
    }


    /**
     * @param  string  $modalId
     * @param $category
     * @param  bool  $hasSmallButton
     *
     * @return void
     */
    public function mount(string $modalId, $category, bool $hasSmallButton = false): void
    {
        $this->modalId = $modalId;
        $this->isModalOpen = false;
        $this->hasSmallButton = $hasSmallButton;

        $this->name = '';
        $this->slug = '';
        //$this->cover_image_url = '';
        $this->category = $category;
        $this->categoryId = $category->id;
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
     */
    public function render(): Factory|View|Application|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.livewire.blog.category.create');
    }


    /**
     * @return Redirector
     * @throws AuthorizationException
     */
    public function createCategory(): Redirector
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

                if (isset($this->cover_image_url) && $this->cover_image_url !== '') {
                    $category['cover_image_url'] = $this->imageService->getImageAbsolutePath($this->cover_image_url);
                }

                $category['category_id'] = $this->categoryId;

                Category::create($category);
            },
            2
        );

        $this->banner(__('New subcategory successfully added.'));
        return redirect()->route('category.manage');
    }


    /**
     * @return void
     */
    public function initialize(): void
    {
        $this->name = '';
        $this->cover_image_url = '';
    }
}
