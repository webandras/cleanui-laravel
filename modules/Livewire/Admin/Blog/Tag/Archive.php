<?php

namespace Modules\Livewire\Admin\Blog\Tag;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Auth\Models\User;
use Modules\Blog\Models\Tag;
use Modules\Clean\Interfaces\ArchiveEntityServiceInterface;
use Modules\Clean\Traits\InteractsWithBanner;
use Modules\Livewire\Admin\Blog\Tag\Trait\Reactive;

class Archive extends Component
{
    use WithPagination, InteractsWithBanner, AuthorizesRequests, Reactive;

    /**
     * General service class for managing archives for any entities
     * @var ArchiveEntityServiceInterface
     */
    private ArchiveEntityServiceInterface $archiveEntityService;


    /**
     * All archived tags as paginated collection
     * @var
     */
    protected $archivedTags;


    /**
     * Custom pagination pageName parameter
     * @var string
     */
    public string $archiveName = 'archive';


    /**
     * User for authorization
     * @var User|Authenticatable|null
     */
    protected User|Authenticatable|null $user;


    /**
     * Keyword to search in tag name
     *
     * @var string
     */
    public string $filterKeyword = '';


    /**
     * Filtered tags are shown currently
     * @var bool
     */
    private bool $filterOn = false;


    /**
     * Event listeners
     * @var string[]
     */
    protected $listeners = [
        'listUpdated',
        'archivedTagsAdded'
    ];


    /**
     * Selected tags for checkboxes
     * @var array
     */
    public array $selectedIds = [];


    /**
     * State of the restore tags modal
     * @var bool
     */
    public bool $isRestoreConfirmOpen = false;


    /**
     * State of the destroy tags modal
     * @var bool
     */
    public bool $isDestroyConfirmOpen = false;


    /**
     * @param ArchiveEntityServiceInterface $archiveEntityService
     *
     * @return void
     */
    public function boot(ArchiveEntityServiceInterface $archiveEntityService): void
    {
        $this->archiveEntityService = $archiveEntityService;
    }


    /**
     * @return void
     * @throws \Exception
     */
    public function mount(): void
    {
        $this->archivedTags = null;
        $this->selectedIds = [];
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
     */
    public function render(): Factory|View|Application|\Illuminate\Contracts\Foundation\Application
    {
        if ($this->filterOn !== true) {
            $this->archivedTags = $this->archiveEntityService->paginateTrashedEntities('Blog\Models\Tag', Tag::RECORDS_PER_PAGE, 'archive');
        }

        return view('admin.livewire.blog.tag.archive')->with([
            'archivedTags' => $this->archivedTags,
        ]);
    }


    /**
     * @return void
     * @throws \Exception
     */
    public function listUpdated(): void
    {
        $this->resetFilters();
        $this->dispatch('$refresh')->self();
    }


    /**
     * "Receive" archived tags from index
     *
     * @return void
     * @throws \Exception
     */
    public function archivedTagsAdded(): void
    {
        $this->initialize();
    }


    /**
     * Clear all filter properties, reload collection
     *
     * @return void
     * @throws \Exception
     */
    public function resetFilters(): void
    {
        $this->resetPage('archive'); // custom pagination page query parameter name
        $this->filterOn = false;
        $this->filterKeyword = '';
        $this->selectedIds = [];
        $this->initialize();
    }


    /**
     * Get filtered tags collection
     *
     * @throws \Exception
     */
    public function filterTags(): void
    {
        $this->resetPage('archive');
        $this->archivedTags = $this->archiveEntityService->paginateFilteredTrashedEntities('Blog\Models\Tag', Tag::RECORDS_PER_PAGE, 'name', $this->filterKeyword, 'archive');
        $this->filterOn = true;
    }


    /**
     * Restore selected tags permanently
     *
     * @return void
     * @throws AuthorizationException
     * @throws \Exception
     */
    public function restoreTags(): void
    {
        $count = sizeof($this->selectedIds);
        $tag = Tag::first();
        $this->authorize('restore', [Tag::class, $tag]);

        $this->archiveEntityService->restoreSelectedTrashedEntities('Blog\Models\Tag', $this->selectedIds);
        $this->toggleRestoreModal();
        $this->banner(__($count . ' tags successfully restored from archive.'));
        $this->initialize();
        $this->triggerOnAlert();

        // Notify index to receive restored tag(s)
        $this->dispatch('restoredTagsAdded');
    }


    /**
     * Destroys selected tags permanently
     *
     * @return void
     * @throws AuthorizationException
     * @throws \Exception
     */
    public function destroyTags(): void
    {
        $count = sizeof($this->selectedIds);
        $ids = $this->selectedIds;
        $tag = Tag::first();
        $this->authorize('forceDelete', [Tag::class, $tag]);

        $this->archiveEntityService->destroySelectedTrashedEntities('Blog\Models\Tag', $ids);

        $this->toggleDestroyModal();
        $this->banner(__($count . ' tag(s) permanently deleted.'));
        $this->initialize();
        $this->triggerOnAlert();
        $this->selectedIds = [];
    }


    /**
     * Open/close restore tags modal
     *
     * @return void
     */
    public function toggleRestoreModal(): void
    {
        $this->isRestoreConfirmOpen = !$this->isRestoreConfirmOpen;
    }


    /**
     * Open/close destroy tags modal
     *
     * @return void
     */
    public function toggleDestroyModal(): void
    {
        $this->isDestroyConfirmOpen = !$this->isDestroyConfirmOpen;
    }
}
