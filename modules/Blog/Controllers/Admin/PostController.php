<?php

namespace Modules\Blog\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Traits\UserPermissions;
use Modules\Blog\Actions\CreatePost;
use Modules\Blog\Actions\UpdatePost;
use Modules\Blog\Enum\PostStatus;
use Modules\Blog\Models\Category;
use Modules\Blog\Models\Post;
use Modules\Blog\Models\Tag;
use Modules\Blog\Requests\StorePostRequest;
use Modules\Blog\Requests\UpdatePostRequest;
use Modules\Clean\Interfaces\Services\ImageServiceInterface;
use Modules\Clean\Traits\InteractsWithBanner;
use Throwable;

class PostController extends Controller
{
    use InteractsWithBanner, UserPermissions;

    /**
     * @var ImageServiceInterface
     */
    private ImageServiceInterface $imageService;


    /**
     * @param  ImageServiceInterface  $imageService
     */
    public function __construct(ImageServiceInterface $imageService)
    {
        $this->imageService = $imageService;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        $tags = Tag::all();

        return view('blog::admin.post.create')->with([
            'postStatuses' => PostStatus::options(),
            'categories' => Category::all(),
            'tags' => $tags,
            'userPermissions' => $this->getUserPermissions(),
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  StorePostRequest  $request
     * @param  CreatePost  $createPost
     * @return RedirectResponse
     */
    public function store(StorePostRequest $request, CreatePost $createPost): RedirectResponse
    {
        $validated = $request->validated();
        $validated = Post::getSlugFromTitle($validated);

        if (isset($validated['cover_image_url'])) {
            $validated['cover_image_url'] = $this->imageService->getImageAbsolutePath($validated['cover_image_url']);
        }

        $categoriesArray = $validated['categories'] ?? [];
        unset($validated['categories']);

        $tagsArray = $validated['tags'] ?? [];
        unset($validated['tags']);


        // If not checked, the value should be 0 to be able to update this property
        if ( ! isset($validated['is_highlighted'])) {
            $validated['is_highlighted'] = 0;
        }

        DB::transaction(function () use ($createPost, $validated, $categoriesArray, $tagsArray) {
            $createPost($validated, $categoriesArray, $tagsArray);
        });

        $this->banner(__('New post is added.'));
        return redirect()->route('post.manage');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  Post  $post
     *
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function edit(Post $post): View|Factory|Application
    {
        $this->authorize('update', [Post::class, $post]);

        $tags = Tag::all();
        $postCategoryIds = $post->categories()->get()->pluck(['id'])->toArray();
        $postTagIds = $post->tags()->get()->pluck(['id'])->toArray();

        return view('blog::admin.post.edit')->with([
            'post' => $post,
            'postStatuses' => PostStatus::options(),
            'categories' => Category::all(),
            'postCategoryIds' => $postCategoryIds,
            'tags' => $tags,
            'postTagIds' => $postTagIds,
            'userPermissions' => $this->getUserPermissions(),
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  UpdatePostRequest  $request
     * @param  Post  $post
     * @param  UpdatePost  $updatePost
     * @return RedirectResponse
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function update(UpdatePostRequest $request, Post $post, UpdatePost $updatePost): RedirectResponse
    {
        $this->authorize('update', [Post::class, $post]);

        $validated = $request->validated();
        $validated = Post::getSlugFromTitle($validated);

        if (isset($validated['cover_image_url'])) {
            $validated['cover_image_url'] = $this->imageService->getImageAbsolutePath($validated['cover_image_url']);
        }

        $categoriesArray = $validated['categories'] ?? [];
        if (empty($categoriesArray)) {
            unset($validated['categories']);
        }

        $tagsArray = $validated['tags'] ?? [];
        if (empty($tagsArray)) {
            unset($validated['tags']);
        }

        // If not checked, the value should be 0 to be able to update this property
        if ( ! isset($validated['is_highlighted'])) {
            $validated['is_highlighted'] = 0;
        }

        DB::transaction(function() use($updatePost, $post, $validated, $categoriesArray, $tagsArray) {
            $updatePost($post, $validated, $categoriesArray, $tagsArray);
        });

        $this->banner(__('Successfully updated the post'));
        return redirect()->route('post.manage');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  Post  $post
     *
     * @return RedirectResponse
     * @throws Throwable
     */
    public function destroy(Post $post): RedirectResponse
    {
        $this->authorize('delete', Post::class);

        $oldTitle = $post->title;
        $post->deleteOrFail();

        $this->banner(__('":title" successfully deleted!', ['title' => $oldTitle]));
        return redirect()->route('post.manage');
    }


    /**
     * Display a listing of the resource.
     * @throws AuthorizationException
     */
    public function index(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $this->authorize('viewAny', Post::class);

        $posts = Post::orderBy('created_at', 'DESC')
            ->paginate(Post::RECORDS_PER_PAGE)
            ->withQueryString();

        return view('blog::admin.post.manage')->with([
            'posts' => $posts,
            'postStatuses' => PostStatus::options(),
            'postStatusColors' => PostStatus::colors(),
            'userPermissions' => $this->getUserPermissions(),
        ]);
    }


}
