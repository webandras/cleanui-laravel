<?php

namespace Modules\Livewire\Public\Blog\Post;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Blog\Interfaces\Entities\PostInterface;
use Modules\Blog\Models\Post;
use Modules\Clean\Traits\HasLocalization;

class PostGrid extends Component
{
    use WithPagination, HasLocalization;


    /**
     * Event list collection
     * @var LengthAwarePaginator|null
     */
    protected ?LengthAwarePaginator $posts;


    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function render(): Factory|View|\Illuminate\Foundation\Application|Application
    {
        $this->posts = Post::where('status', '=', 'published')
            ->with('categories', 'tags')
            ->orderByDesc('created_at')
            ->paginate(PostInterface::RECORDS_PER_PAGE);;

        $this->resetPage();

        return view('public.livewire.post.post-grid')->with([
            'posts'    => $this->posts,
            'dtFormat' => $this->getLocaleDateTimeFormat(),
        ]);
    }
}
