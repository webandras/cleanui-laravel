<?php

namespace App\Http\Livewire\Admin\Clean\Post;

use App\Interface\Repository\Clean\PostRepositoryInterface;
use App\Models\Clean\Post;
use App\Trait\Clean\InteractsWithBanner;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Delete extends Component
{
    use InteractsWithBanner;
    use AuthorizesRequests;


    // used by blade / alpinejs
    public string $modalId;
    public bool $isModalOpen;
    public bool $hasSmallButton;


    // inputs
    public int $postId;
    public string $title;
    public Post $post;


    protected array $rules = [
        'postId' => 'required|int|min:1',
    ];


    /**
     * @var PostRepositoryInterface
     */
    private PostRepositoryInterface $postRepository;


    /**
     * @param  PostRepositoryInterface  $postRepository
     */
    public function boot(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }


    public function mount(string $modalId, Post $post, bool $hasSmallButton = false)
    {
        $this->modalId = $modalId;
        $this->isModalOpen = false;
        $this->hasSmallButton = $hasSmallButton;
        $this->post = $post;
        $this->postId = $post->id;
        $this->title = $post->title;
    }


    public function render()
    {
        return view('admin.livewire.clean.post.delete');
    }


    /**
     * @throws AuthorizationException
     */
    public function deletePost()
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
