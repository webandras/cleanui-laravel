<?php

namespace App\Livewire\Admin\Clean\Tag;

use App\Interface\Entities\Clean\TagInterface;
use App\Interface\Services\Clean\ArchiveEntityServiceInterface;
use App\Livewire\Admin\Clean\Tag\Trait\Reactive;
use App\Models\Clean\Tag;
use App\Models\Clean\User;
use App\Trait\Clean\InteractsWithBanner;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use Livewire\WithPagination;

class Archive extends Component
{
    use WithPagination;
    use InteractsWithBanner;
    use AuthorizesRequests;
    use Reactive;


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
     * @var User|\Illuminate\Contracts\Auth\Authenticatable|null
     */
    protected User|\Illuminate\Contracts\Auth\Authenticatable|null $user;


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
    public function boot(ArchiveEntityServiceInterface $archiveEntityService)
    {
        $this->archiveEntityService = $archiveEntityService;
    }


    /**
     * @return void
     * @throws \Exception
     */
    public function mount(): void
    {
        // $this->initialize();
        $this->archivedTags = null;
        $this->selectedIds = [];
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        if ($this->filterOn !== true) {
            $this->archivedTags = $this->archiveEntityService->paginateTrashedEntities('Tag', TagInterface::RECORDS_PER_PAGE, 'archive');
        }

        return view('admin.livewire.clean.tag.archive')->with([
            'archivedTags' => $this->archivedTags,
        ]);
    }


    /**
     *
     * @return void
     * @throws \Exception
     */
    public function initialize(): void
    {
        $this->archivedTags = $this->archiveEntityService->paginateTrashedEntities('Tag', TagInterface::RECORDS_PER_PAGE, 'archive');
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
        $this->archivedTags = $this->archiveEntityService->paginateFilteredTrashedEntities('Tag', TagInterface::RECORDS_PER_PAGE, 'name', $this->filterKeyword, 'archive');
        $this->filterOn = true;
    }


    /**
     * Restore selected tags permanently
     *
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function restoreTags(): void
    {
        $count = sizeof($this->selectedIds);
        $tag = Tag::first();
        $this->authorize('restore', [Tag::class, $tag]);

        $this->archiveEntityService->restoreSelectedTrashedEntities('Tag', $this->selectedIds);
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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Exception
     */
    public function destroyTags(): void
    {
        $count = sizeof($this->selectedIds);
        $ids = $this->selectedIds;
        $tag = Tag::first();
        $this->authorize('forceDelete', [Tag::class, $tag]);

        $this->archiveEntityService->destroySelectedTrashedEntities('Tag', $ids);

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
