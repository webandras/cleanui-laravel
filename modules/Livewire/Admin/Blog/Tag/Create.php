<?php

namespace Modules\Livewire\Admin\Blog\Tag;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Blog\Models\Tag;
use Modules\Clean\Interfaces\ImageServiceInterface;
use Modules\Clean\Interfaces\ModelServiceInterface;
use Modules\Clean\Traits\InteractsWithBanner;
use Modules\Livewire\Admin\Blog\Tag\Trait\Reactive;

class Create extends Component
{
    use InteractsWithBanner, AuthorizesRequests, WithFileUploads, Reactive;

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
     * @var int
     */
    public int $iteration = 0;


    /**
     * @var string|null
     */
    public ?string $cover_image_url = '';


    /**
     * @var
     */
    public $cover_image;


    /**
     * @var array|string[]
     */
    protected array $rules = [
        'name' => 'required|string|min:1|max:255',
        'slug' => 'required|alpha_dash|unique:tags',
        'cover_image_url' => 'nullable|string',
        'cover_image' => 'nullable|image|max:2048',
    ];


    /**
     * @var ModelServiceInterface
     */
    private ModelServiceInterface $tagRepository;


    /**
     * @var ImageServiceInterface
     */
    private ImageServiceInterface $imageService;


    /**
     * @param  ModelServiceInterface  $tagRepository
     * @param  ImageServiceInterface  $imageService
     * @return void
     */
    public function boot(ModelServiceInterface $tagRepository, ImageServiceInterface $imageService): void
    {
        $this->tagRepository = $tagRepository;
        $this->imageService = $imageService;
    }


    /**
     * @param  string  $modalId
     * @param  bool  $hasSmallButton
     * @return void
     */
    public function mount(string $modalId, bool $hasSmallButton = false): void
    {
        $this->modalId = $modalId;
        $this->isModalOpen = false;
        $this->hasSmallButton = $hasSmallButton;

        $this->initialize();
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
     */
    public function render(): Factory|View|Application|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.livewire.blog.tag.create');
    }


    /**
     * Creates one tag
     *
     * @return void
     * @throws AuthorizationException
     */
    public function createTag(): void
    {
        $this->authorize('create', Tag::class);

        // validate user input
        $this->validate();

        // save category, rollback transaction if fails
        DB::transaction(
            function () {
                $tag = [];
                $tag['name'] = $this->name;
                $tag['slug'] = $this->slug;

                if (isset($this->cover_image)) {
                    $this->cover_image_url = $this->cover_image->store('images');
                    $tag['cover_image_url'] = '/storage/'.$this->cover_image_url;
                }

                $this->tagRepository->createEntity('Blog\Models\Tag', $tag);
            }
        );

        $this->banner(__('New tag successfully added.'));
        $this->initialize();
        $this->rerenderList();
        $this->triggerOnAlert();
    }

}
