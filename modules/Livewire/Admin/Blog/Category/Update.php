<?php

namespace Modules\Livewire\Admin\Blog\Category;

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

class Update extends Component
{
    use InteractsWithBanner, AuthorizesRequests;

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
     * @var int
     */
    public int $categoryId;


    /**
     * @var Category
     */
    public Category $category;


    /**
     * @var array|string[]
     */
    protected array $rules = [
        'name' => 'required|string|min:1|max:255',
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
     * @param  Category  $category
     * @param  bool  $hasSmallButton
     * @return void
     */
    public function mount(string $modalId, Category $category, bool $hasSmallButton = false): void
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


    /**
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.livewire.blog.category.update');
    }


    /**
     * @return Redirector
     */
    public function updateCategory(): Redirector
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
                $this->category->updateOrFail([
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
