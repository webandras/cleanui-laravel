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
use Modules\Livewire\Admin\Clean\Tag\Trait\Reactive;

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
     * @param  Tag  $tag
     * @param  string  $modalId
     *
     * @return void
     */
    public function mount(Tag $tag, string $modalId): void
    {
        $this->modalId = $modalId;
        $this->tag = $tag;
    }


    /**
     * @param  ArchiveEntityServiceInterface  $archiveEntityService
     *
     * @return void
     */
    public function boot(ArchiveEntityServiceInterface $archiveEntityService): void
    {
        $this->archiveEntityService = $archiveEntityService;
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
     */
    public function render(): Factory|View|Application|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.livewire.blog.tag.restore');
    }


    /**
     * Restores one tag
     *
     * @return void
     * @throws AuthorizationException
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

        $this->banner(__('"'.$this->tag->name.'" tag successfully restored.'));
        $this->initialize();
        $this->rerenderList();
        $this->triggerOnAlert();

        // Notify index to receive restored tag(s)
        $this->dispatch('restoredTagsAdded');
    }
}
