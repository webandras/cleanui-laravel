<?php

namespace App\Http\Controllers\Public\Clean;

use App\Http\Controllers\Controller;
use App\Interface\Entities\Clean\PostInterface;
use App\Interface\Repository\Clean\PostRepositoryInterface;
use App\Models\Clean\Category;
use App\Models\Clean\Post;
use App\Models\Clean\Tag;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;


class BlogController extends Controller
{

    /**
     * @var PostRepositoryInterface
     */
    private PostRepositoryInterface $postRepository;


    /**
     * @param  PostRepositoryInterface  $postRepository
     */
    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $newestPosts = Post::newestPosts();
        $highlightedPosts = Post::highlightedPosts();

        // Most popular categories
        $categories = Category::mostPopularCategories();


        return view('public.pages.blog.index')->with([
            'newestPosts' => $newestPosts,
            'categories' => $categories,
            'highlightedPosts' => $highlightedPosts,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @param  string  $slug
     *
     * @return Application|Factory|View
     */
    public function show(string $slug): View|Factory|Application
    {
        $post = $this->postRepository->getPostBySlug($slug);
        $posts = $this->postRepository->getPosts();

        $maxPostId = Post::orderByDesc('id')->limit(1)->pluck('id')[0];

        $neighbouringPosts = [];

        for ($i = 0; $i < $posts->count(); $i++) {
            if ($posts[$i]->id === $post->id) {

                if ($post->id === $maxPostId) {
                    $neighbouringPosts['previous'] = [
                        'slug' => $posts[$i - 1]->slug,
                        'title' => $posts[$i - 1]->title,
                    ];
                } elseif ($post->id === $posts[0]->id) {
                    $neighbouringPosts['next'] = [
                        'slug' => $posts[1]->slug,
                        'title' => $posts[1]->title,
                    ];
                } else {

                    $neighbouringPosts['next'] = [
                        'slug' => $posts[$i + 1]->slug,
                        'title' => $posts[$i + 1]->title,
                    ];

                    $neighbouringPosts['previous'] = [
                        'slug' => $posts[$i - 1]->slug,
                        'title' => $posts[$i - 1]->title,
                    ];
                }
            }
        }


        return view('public.pages.blog.show')->with([
            'post' => $post,
            'neighbouringPosts' => $neighbouringPosts,
        ]);
    }


    /**
     * @param  string  $slug
     * @return View|Factory|Application
     */
    public function category(string $slug): View|Factory|Application
    {

        $category = Category::where('slug', '=', strip_tags($slug))
            ->with('posts')
            ->first();


        $posts = $category->posts()->paginate(PostInterface::RECORDS_PER_PAGE);

        return view('public.pages.blog.category')->with([
            'category' => $category,
            'posts' => $posts,
        ]);

    }


    /**
     * @param  string  $slug
     * @return View|Factory|Application
     */
    public function tag(string $slug): View|Factory|Application
    {

        $tag = Tag::where('slug', '=', strip_tags($slug))
            ->with('posts')
            ->first();

        $posts = $tag->posts()->paginate(Post::RECORDS_PER_PAGE);

        return view('public.pages.blog.tag')->with([
            'tag' => $tag,
            'posts' => $posts,
        ]);

    }


}
