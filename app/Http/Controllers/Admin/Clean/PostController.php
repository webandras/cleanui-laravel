<?php

namespace App\Http\Controllers\Admin\Clean;

use App\Http\Controllers\Controller;
use App\Http\Requests\Clean\StorePostRequest;
use App\Http\Requests\Clean\UpdatePostRequest;
use App\Interface\Repository\Clean\PostRepositoryInterface;
use App\Interface\Services\Clean\ImageServiceInterface;
use App\Models\Clean\Category;
use App\Models\Clean\Post;
use App\Models\Clean\Tag;
use App\Trait\Clean\InteractsWithBanner;
use App\Trait\Clean\UserPermissions;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Throwable;

class PostController extends Controller
{
    use InteractsWithBanner, UserPermissions;


    /**
     * @var PostRepositoryInterface
     */
    private PostRepositoryInterface $postRepository;


    /**
     * @var ImageServiceInterface
     */
    private ImageServiceInterface $imageService;


    /**
     * @param  ImageServiceInterface  $imageService
     * @param  PostRepositoryInterface  $postRepository
     */
    public function __construct(ImageServiceInterface $imageService, PostRepositoryInterface $postRepository)
    {
        $this->imageService = $imageService;
        $this->postRepository = $postRepository;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        $tags = Tag::all();

        return view('admin.pages.post.create')->with([
            'postStatuses' => Post::getPostStatuses(),
            'categories' => Category::all(),
            'tags' => $tags,
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
        $data = $request->all();
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
                $newPost = $this->postRepository->createPost($data);

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
     */
    public function edit(Post $post): View|Factory|Application
    {
        $tags = Tag::all();

        $postCategoryIds = $post->categories()->get()->pluck(['id'])->toArray();
        $postTagIds = $post->tags()->get()->pluck(['id'])->toArray();

        return view('admin.pages.post.edit')->with([
            'post' => $post,
            'postStatuses' => Post::getPostStatuses(),
            'categories' => Category::all(),
            'postCategoryIds' => $postCategoryIds,
            'tags' => $tags,
            'postTagIds' => $postTagIds,
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

        $data = $request->all();
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
                $this->postRepository->updatePost($post, $data);

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

        $oldTitle = htmlentities($post->title);

        $this->postRepository->deletePost($post);

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

        $posts = $this->postRepository->getPaginatedPosts();

        return view('admin.pages.post.manage')->with([
            'posts' => $posts,
            'postStatuses' => Post::getPostStatuses(),
            'postStatusColors' => Post::getPostStatusColors(),
            'userPermissions' => $this->getUserPermissions(),
        ]);
    }


}
