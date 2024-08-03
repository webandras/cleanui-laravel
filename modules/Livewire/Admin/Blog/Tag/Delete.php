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
use Modules\Clean\Traits\InteractsWithBanner;
use Modules\Livewire\Admin\Blog\Tag\Trait\Reactive;

class Delete extends Component
{
    use InteractsWithBanner;
    use AuthorizesRequests;
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
        return view('admin.livewire.blog.tag.delete');
    }


    /**
     * Soft-deletes (archives) one tag
     * Maybe rename the method to archiveTag?
     *
     * @return void
     * @throws AuthorizationException
     */
    public function deleteTag(): void
    {
        $this->authorize('delete', [Tag::class, $this->tag]);

        // validate user input
        $this->validate();

        // save category, rollback transaction if fails
        DB::transaction(
            function () {
                $this->tag->deleteOrFail();
            }
        );

        $this->banner(__('Tag successfully archived'));
        $this->closeModal();
        $this->rerenderList();
        $this->triggerOnAlert();

        // Notify archive to receive new archived tag(s)
        $this->dispatch('archivedTagsAdded');

    }
}
