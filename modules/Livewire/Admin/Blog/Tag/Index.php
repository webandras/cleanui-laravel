<?php

namespace Modules\Livewire\Admin\Blog\Tag;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Auth\Models\User;
use Modules\Blog\Models\Tag;
use Modules\Clean\Interfaces\Repositories\ModelRepositoryInterface;
use Modules\Clean\Traits\InteractsWithBanner;
use Modules\Livewire\Admin\Blog\Tag\Trait\Reactive;

class Index extends Component
{
    use InteractsWithBanner;
    use AuthorizesRequests;
    use WithPagination;
    use Reactive;


    /**
     * @var ModelRepositoryInterface
     */
    private ModelRepositoryInterface $tagRepository;


    /**
     * @var
     */
    protected $tags;


    /**
     * @var
     */
    protected $archivedTags = null;


    /**
     * Custom pagination pageName parameter
     * @var string
     */
    public string $pageName = 'page';


    /**
     * @var User|Authenticatable|null
     */
    protected User|Authenticatable|null $user;


    /**
     * @var string
     */
    public string $filterKeyword = '';


    /**
     * @var bool
     */
    private bool $filterOn = false;


    /**
     * @var string[]
     */
    protected $listeners = [
        'listUpdated',
        'restoredTagsAdded',
    ];


    /**
     * @var array
     */
    public array $selectedIds = [];


    /**
     * State of the archive tags modal
     * @var bool
     */
    public bool $isArchiveConfirmOpen = false;


    /**
     * @param  ModelRepositoryInterface  $tagRepository
     *
     * @return void
     */
    public function boot(ModelRepositoryInterface $tagRepository): void
    {
        $this->tagRepository = $tagRepository;
    }


    /**
     * @return void
     * @throws \Exception
     */
    public function mount(): void
    {
        $this->tags         = null;
        $this->archivedTags = null;
        $this->selectedIds  = [];
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
     */
    public function render(): Factory|View|Application|\Illuminate\Contracts\Foundation\Application
    {
        if ($this->filterOn !== true) {
            $this->tags = $this->tagRepository->paginateEntities('Blog\Models\Tag', Tag::RECORDS_PER_PAGE, 'page');
        }

        return view('admin.livewire.blog.tag.index')->with([
            'tags' => $this->tags,
        ]);
    }


    /**
     * @return void
     * @throws \Exception
     */
    public function initialize(): void
    {
//        $this->tags = $this->tagRepository->paginateEntities('Blog\Models\Tag', Tag::RECORDS_PER_PAGE, 'page');
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
     * @return void
     * @throws \Exception
     */
    public function restoredTagsAdded(): void
    {
        $this->initialize();
    }


    /**
     * @return void
     * @throws \Exception
     */
    public function resetFilters(): void
    {
        $this->resetPage();
        $this->filterOn      = false;
        $this->filterKeyword = '';
        $this->selectedIds  = [];
        $this->initialize();
    }


    /**
     * @throws \Exception
     */
    public function filterTags(): void
    {
        $this->resetPage();

        $this->tags        = $this->getFilteredPaginatedTags($this->filterKeyword);
        $this->selectedIds = [];
        $this->filterOn    = true;
    }


    /**
     * @param  string  $keyword
     *
     * @return LengthAwarePaginator
     */
    public function getFilteredPaginatedTags(string $keyword): LengthAwarePaginator
    {
        /* has the search keyword in name */
        if ($keyword !== '') {
            $q = Tag::where('name', 'LIKE', '%'.$keyword.'%');
        } else {
            return Tag::paginate(Tag::RECORDS_PER_PAGE);
        }

        return $q->orderBy('id', 'desc')
                 ->paginate(Tag::RECORDS_PER_PAGE);
    }


    /**
     * Archive selected tags
     *
     * @return void
     * @throws AuthorizationException
     * @throws \Exception
     */
    public function archiveTags(): void
    {
        $count = sizeof($this->selectedIds);
        $ids   = $this->selectedIds;
        $tag   = Tag::first();
        $this->authorize('restore', [Tag::class, $tag]);

        $this->tagRepository->deleteSelectedEntities('Blog\Models\Tag', $ids);
        $this->toggleArchiveModal();
        $this->banner(__($count.' tags archived.'));
        $this->initialize();
        $this->triggerOnAlert();

        // Notify archive to receive new archived tag(s)
        $this->dispatch('archivedTagsAdded');
        $this->selectedIds = [];
    }


    /**
     * Open/close archive tags modal
     *
     * @return void
     */
    public function toggleArchiveModal(): void
    {
        $this->isArchiveConfirmOpen = ! $this->isArchiveConfirmOpen;
    }

}
