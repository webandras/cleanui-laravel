<?php

namespace App\Http\Livewire\Admin\Clean\Tag;

use App\Http\Livewire\Admin\Clean\Tag\Trait\Reactive;
use App\Interface\Services\Clean\ArchiveEntityServiceInterface;
use App\Models\Clean\Tag;
use App\Trait\Clean\InteractsWithBanner;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

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
     * @param ArchiveEntityServiceInterface $archiveEntityService
     */
    public function boot(ArchiveEntityServiceInterface $archiveEntityService)
    {
        $this->archiveEntityService = $archiveEntityService;
    }


    /**
     * @param string $modalId
     * @param Tag $tag
     * @param bool $hasSmallButton
     * @return void
     */
    public function mount(string $modalId, Tag $tag, bool $hasSmallButton = false)
    {
        $this->modalId = $modalId;
        $this->isModalOpen = false;
        $this->hasSmallButton = $hasSmallButton;
        $this->tag = $tag;
        $this->tagId = $tag->id;
        $this->name = $tag->name;
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        return view('admin.livewire.tag.destroy');
    }


    /**
     * Destroy (permanently delete) tag
     *
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
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
