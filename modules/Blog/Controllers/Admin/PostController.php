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
use Modules\Blog\Interfaces\Entities\PostInterface;
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
            'postStatuses' => Post::getPostStatuses(),
            'categories' => Category::all(),
            'tags' => $tags,
            'userPermissions' => $this->getUserPermissions(),
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  StorePostRequest  $request
     * @return RedirectResponse
     */
    public function store(StorePostRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data = Post::getSlugFromTitle($data);

        if (isset($data['cover_image_url'])) {
            $data['cover_image_url'] = $this->imageService->getImageAbsolutePath($request->input('cover_image_url'));
        }

        $categoriesArray = $data['categories'] ?? [];
        unset($data['categories']);

        $tagsArray = $data['tags'] ?? [];
        unset($data['tags']);


        // If not checked, the value should be 0 to be able to update this property
        if (!isset($data['is_highlighted'])) {
            $data['is_highlighted'] = 0;
        }


        DB::transaction(
            function () use ($data, $categoriesArray, $tagsArray) {
                $newPost = Post::create($data);

                // synchronize post categories
                if (!empty($categoriesArray)) {
                    $newPost->categories()->sync($categoriesArray);
                }

                // synchronize post tags
                if (!empty($tagsArray)) {
                    $newPost->tags()->sync($tagsArray);
                }

            }, 2);


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
            'postStatuses' => Post::getPostStatuses(),
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
     *
     * @return RedirectResponse
     * @throws Throwable
     */
    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        $this->authorize('update', [Post::class, $post]);

        $data = $request->validated();
        $data = Post::getSlugFromTitle($data);
        if (isset($data['cover_image_url'])) {
            $data['cover_image_url'] = $this->imageService->getImageAbsolutePath($data['cover_image_url']);
        }

        $categoriesArray = $data['categories'] ?? [];
        if (empty($categoriesArray)) {
            unset($data['categories']);
        }

        $tagsArray = $data['tags'] ?? [];
        if (empty($tagsArray)) {
            unset($data['tags']);
        }

        // If not checked, the value should be 0 to be able to update this property
        if (!isset($data['is_highlighted'])) {
            $data['is_highlighted'] = 0;
        }


        DB::transaction(
            function () use ($post, $data, $categoriesArray, $tagsArray) {
                // update post
                $post->updateOrFail($data);

                // synchronize post categories
                if (!empty($categoriesArray)) {
                    $post->categories()->sync($categoriesArray);
                }

                // synchronize post categories
                if (!empty($tagsArray)) {
                    $post->tags()->sync($tagsArray);
                }

            }, 2);


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
            ->paginate(PostInterface::RECORDS_PER_PAGE)
            ->withQueryString();;

        return view('blog::admin.post.manage')->with([
            'posts' => $posts,
            'postStatuses' => Post::getPostStatuses(),
            'postStatusColors' => Post::getPostStatusColors(),
            'userPermissions' => $this->getUserPermissions(),
        ]);
    }


}
