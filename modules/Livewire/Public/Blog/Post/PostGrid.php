<?php

namespace Modules\Livewire\Public\Blog\Post;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Component;
use Livewire\WithPagination;
use Modules\Blog\Interfaces\Repositories\PostRepositoryInterface;
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
     * @var PostRepositoryInterface
     */
    private PostRepositoryInterface $postRepository;


    /**
     * @param  PostRepositoryInterface  $postRepository
     * @return void
     */
    public function boot(PostRepositoryInterface $postRepository): void
    {
        $this->postRepository = $postRepository;
    }


    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function render(): Factory|View|\Illuminate\Foundation\Application|Application
    {
        $this->posts = $this->postRepository->getPaginatedPublishedPosts();

        $this->resetPage();

        return view('public.livewire.post.post-grid')->with([
            'posts'    => $this->posts,
            'dtFormat' => $this->getLocaleDateTimeFormat(),
        ]);
    }
}
