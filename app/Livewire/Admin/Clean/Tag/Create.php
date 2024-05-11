<?php

namespace App\Livewire\Admin\Clean\Tag;

use App\Interface\Repository\Clean\ModelRepositoryInterface;
use App\Interface\Services\Clean\ImageServiceInterface;
use App\Livewire\Admin\Clean\Tag\Trait\Reactive;
use App\Models\Clean\Tag;
use App\Trait\Clean\InteractsWithBanner;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class Create extends Component
{
    use InteractsWithBanner;
    use AuthorizesRequests;
    use WithFileUploads;
    use Reactive;


    // used by blade / alpinejs
    /**
     * @var
     */
    public $modalId;


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
        'slug' => 'required|string|unique:tags',
        'cover_image_url' => 'nullable|string',
        'cover_image' => 'nullable|image|max:2048',
    ];


    /**
     * @var ModelRepositoryInterface
     */
    private ModelRepositoryInterface $tagRepository;


    /**
     * @var ImageServiceInterface
     */
    private ImageServiceInterface $imageService;


    /**
     * @param ModelRepositoryInterface $tagRepository
     * @param ImageServiceInterface $imageService
     */
    public function boot(ModelRepositoryInterface $tagRepository, ImageServiceInterface $imageService)
    {
        $this->tagRepository = $tagRepository;
        $this->imageService = $imageService;
    }


    /**
     * @param string $modalId
     * @param bool $hasSmallButton
     * @return void
     */
    public function mount(string $modalId, bool $hasSmallButton = false)
    {
        $this->modalId = $modalId;
        $this->isModalOpen = false;
        $this->hasSmallButton = $hasSmallButton;

        $this->initialize();
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        return view('admin.livewire.clean.tag.create');
    }


    /**
     * Creates one tag
     *
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
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
                    $tag['cover_image_url'] = '/storage/' . $this->cover_image_url;
                }

                $this->tagRepository->createEntity('Clean\Tag', $tag);
            },
            2
        );

        $this->banner(__('New tag successfully added.'));
        $this->initialize();
        $this->rerenderList();
        $this->triggerOnAlert();
    }

}
