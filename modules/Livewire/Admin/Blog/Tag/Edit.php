<?php

namespace Modules\Livewire\Admin\Blog\Tag;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Modules\Blog\Models\Tag;
use Modules\Clean\Interfaces\ImageServiceInterface;
use Modules\Clean\Interfaces\ModelServiceInterface;
use Modules\Clean\Traits\InteractsWithBanner;
use Modules\Livewire\Admin\Blog\Tag\Trait\Reactive;

class Edit extends Component
{
    use InteractsWithBanner;
    use AuthorizesRequests;
    use WithFileUploads;
    use Reactive;

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
     * @var int
     */
    public int $iteration = 0;


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
    public ?string $cover_image_url = '';


    /**
     * @var string|null
     */
    public ?string $cover_image_url_temp = '';


    /**
     * @var
     */
    public $cover_image = null;


    /**
     * @var int
     */
    public int $tagId;


    /**
     * @var Tag
     */
    public Tag $tag;


    /**
     * @var array|string[]
     */
    protected array $rules = [
        'name' => 'required|string|min:1|max:255',
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
     * @param  Tag  $tag
     * @param  bool  $hasSmallButton
     *
     * @return void
     */
    public function mount(string $modalId, Tag $tag, bool $hasSmallButton = false): void
    {
        $this->modalId = $modalId;
        $this->isModalOpen = false;
        $this->hasSmallButton = $hasSmallButton;
        $this->tag = $tag;
        $this->name = $tag->name;
        $this->slug = $tag->slug;
        $this->cover_image_url = isset($tag->cover_image_url) ? (config('app.url').$tag->cover_image_url) : '';
        $this->cover_image_url_temp = isset($tag->cover_image_url) ? $tag->cover_image_url : '';
        $this->tagId = $tag->id;

    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
     */
    public function render(): Factory|View|Application|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.livewire.blog.tag.edit');
    }


    /**
     * Updates one tag
     *
     * @return void
     * @throws AuthorizationException
     */
    public function updateTag(): void
    {
        $this->authorize('update', [Tag::class, $this->tag]);

        if ($this->slug !== '') {
            $this->rules['slug'] = 'required|string|unique:categories,slug,'.$this->tagId;
        }

        if ($this->cover_image_url !== '') {
            $this->rules['cover_image_url'] = 'required|string';
        }


        // validate user input
        $this->validate();

        // save category, rollback transaction if fails
        DB::transaction(
            function () {

                if (isset($this->cover_image)) {
                    $this->cover_image_url = $this->cover_image->store('public/images');
                    $this->cover_image_url = '/storage/'.str_replace('public', '', $this->cover_image_url);
                }

                // if no image is uploaded and url is set to empty string
                if ( ! isset($this->cover_image) && $this->cover_image_url === '') {
                    // Delete previous image
                    if ($this->cover_image_url_temp !== '') {
                        Storage::delete($this->cover_image_url_temp);
                    }
                }

                $this->tagRepository->updateEntity($this->tag, [
                    'name' => $this->name,
                    'slug' => $this->slug,
                    'cover_image_url' => $this->cover_image_url !== '' ? $this->cover_image_url : null,
                ]);
            }
        );

        $this->banner(__('Tag successfully updated.'));
        $this->initialize();
        $this->rerenderList();
        $this->triggerOnAlert();
    }
}
