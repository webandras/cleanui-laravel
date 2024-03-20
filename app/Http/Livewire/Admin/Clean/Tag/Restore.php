<?php

namespace App\Http\Livewire\Admin\Clean\Tag;

use App\Http\Livewire\Admin\Clean\Tag\Trait\Reactive;
use App\Interface\Services\Clean\ArchiveEntityServiceInterface;
use App\Models\Clean\Tag;
use App\Trait\Clean\InteractsWithBanner;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Restore extends Component
{
    use InteractsWithBanner;
    use AuthorizesRequests;
    use Reactive;


    /**
     * @var ArchiveEntityServiceInterface
     */
    private ArchiveEntityServiceInterface $archiveEntityService;


    /** Used by blade / alpinejs
     * @var string
     */
    public string $modalId;


    /** Tag model entity as input
     * @var Tag
     */
    public Tag $tag;


    /**
     * @param Tag $tag
     * @param string $modalId
     *
     * @return void
     */
    public function mount(Tag $tag, string $modalId)
    {
        $this->modalId = $modalId;
        $this->tag = $tag;
    }


    /**
     * @param ArchiveEntityServiceInterface $archiveEntityService
     *
     * @return void
     */
    public function boot(ArchiveEntityServiceInterface $archiveEntityService)
    {
        $this->archiveEntityService = $archiveEntityService;
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        return view('admin.livewire.clean.tag.restore');
    }


    /**
     * Restores one tag
     *
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function restoreTag(): void
    {
        $this->authorize('restore', [Tag::class, $this->tag]);

        // save, rollback transaction if fails
        DB::transaction(
            function () {
                $this->archiveEntityService->restoreTrashedEntity($this->tag);
            },
            2
        );

        $this->banner(__('"' . $this->tag->name . '" tag successfully restored.'));
        $this->initialize();
        $this->rerenderList();
        $this->triggerOnAlert();

        // Notify index to receive restored tag(s)
        $this->emit('restoredTagsAdded');
    }
}
