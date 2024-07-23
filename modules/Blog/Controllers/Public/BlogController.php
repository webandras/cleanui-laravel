<?php

namespace Modules\Blog\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Modules\Blog\Interfaces\Entities\PostInterface;
use Modules\Blog\Interfaces\Repositories\PostRepositoryInterface;
use Modules\Blog\Models\Category;
use Modules\Blog\Models\Post;
use Modules\Blog\Models\Tag;
use Modules\Clean\Traits\HasLocalization;


class BlogController extends Controller
{
    use HasLocalization;

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function index(): View|Factory|Application
    {
        $newestPosts = Post::newestPosts();
        $highlightedPosts = Post::highlightedPosts();
        $categories = Category::mostPopularCategories();

        return view('blog::public.blog.index')->with([
            'newestPosts' => $newestPosts,
            'categories' => $categories,
            'highlightedPosts' => $highlightedPosts,
            'dtFormat' => $this->getLocaleDateTimeFormat(),
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
        $post = Post::where('slug', '=', $slug)
            ->with('categories', 'tags')
            ->firstOrFail();

        $posts = Post::all();
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

        return view('blog::public.blog.show')->with([
            'post' => $post,
            'neighbouringPosts' => $neighbouringPosts,
            'dtFormat' => $this->getLocaleDateTimeFormat(),
        ]);
    }


    /**
     * @param  string  $slug
     * @return View|Factory|Application
     */
    public function category(string $slug): View|Factory|Application
    {
        $category = Category::where('slug', '=', $slug)
            ->with('posts')
            ->first();

        $posts = $category->posts()->paginate(PostInterface::RECORDS_PER_PAGE);

        return view('blog::public.blog.category')->with([
            'category' => $category,
            'posts' => $posts,
            'dtFormat' => $this->getLocaleDateTimeFormat(),
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

        return view('blog::public.blog.tag')->with([
            'tag' => $tag,
            'posts' => $posts,
            'dtFormat' => $this->getLocaleDateTimeFormat(),
        ]);

    }


}
