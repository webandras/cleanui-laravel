<?php

namespace Modules\Livewire\Admin\Blog\Tag;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\Blog\Models\Tag;
use Modules\Clean\Interfaces\Services\ArchiveEntityServiceInterface;
use Modules\Clean\Traits\InteractsWithBanner;
use Modules\Livewire\Admin\Blog\Tag\Trait\Reactive;

class Destroy extends Component
{
    use InteractsWithBanner;
    use AuthorizesRequests;
    use Reactive;


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
    public int $tagId;


    /**
     * @var string
     */
    public string $name;


    /**
     * @var Tag
     */
    public Tag $tag;


    /**
     * @var array|string[]
     */
    protected array $rules = [
        'tagId' => 'required|int|min:1',
    ];


    /**
     * @var ArchiveEntityServiceInterface
     */
    private ArchiveEntityServiceInterface $archiveEntityService;


    /**
     * @param  ArchiveEntityServiceInterface  $archiveEntityService
     * @return void
     */
    public function boot(ArchiveEntityServiceInterface $archiveEntityService): void
    {
        $this->archiveEntityService = $archiveEntityService;
    }


    /**
     * @param  string  $modalId
     * @param  Tag  $tag
     * @param  bool  $hasSmallButton
     * @return void
     */
    public function mount(string $modalId, Tag $tag, bool $hasSmallButton = false): void
    {
        $this->modalId = $modalId;
        $this->isModalOpen = false;
        $this->hasSmallButton = $hasSmallButton;
        $this->tag = $tag;
        $this->tagId = $tag->id;
        $this->name = $tag->name;
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
     */
    public function render(): Factory|View|Application|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.livewire.blog.tag.destroy');
    }


    /**
     * Destroy (permanently delete) tag
     *
     * @return void
     * @throws AuthorizationException
     */
    public function destroyTag(): void
    {
        $this->authorize('forceDelete', [Tag::class, $this->tag]);

        // validate user input
        $this->validate();

        // save category, rollback transaction if fails
        DB::transaction(
            function () {
                $this->archiveEntityService->destroyEntity($this->tag);
            },
            2
        );

        $this->banner(__('Tag deleted permanently.'));
        $this->closeModal();
        $this->rerenderList();
        $this->triggerOnAlert();
    }
}
