<?php

namespace Modules\Livewire\Admin\Blog\Post;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Modules\Blog\Interfaces\Repositories\PostRepositoryInterface;
use Modules\Blog\Models\Post;
use Modules\Clean\Traits\InteractsWithBanner;

class Delete extends Component
{
    use InteractsWithBanner;
    use AuthorizesRequests;


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
    public int $postId;


    /**
     * @var string
     */
    public string $title;


    /**
     * @var Post
     */
    public Post $post;


    /**
     * @var array|string[]
     */
    protected array $rules = [
        'postId' => 'required|int|min:1',
    ];


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
     * @param  string  $modalId
     * @param  Post  $post
     * @param  bool  $hasSmallButton
     * @return void
     */
    public function mount(string $modalId, Post $post, bool $hasSmallButton = false): void
    {
        $this->modalId = $modalId;
        $this->isModalOpen = false;
        $this->hasSmallButton = $hasSmallButton;
        $this->post = $post;
        $this->postId = $post->id;
        $this->title = $post->title;
    }


    /**
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.livewire.blog.post.delete');
    }


    /**
     * @return Redirector
     * @throws AuthorizationException
     */
    public function deletePost(): Redirector
    {
        $this->authorize('delete', [Post::class, $this->post]);

        // validate user input
        $this->validate();

        // save category, rollback transaction if fails
        DB::transaction(
            function () {
                $this->postRepository->deletePost($this->post);
            },
            2
        );

        $this->banner(__('Post successfully deleted'));
        return redirect()->route('post.manage');
    }
}
