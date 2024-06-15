<?php

namespace Modules\Clean\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Clean\Interfaces\Entities\PostInterface;
use Modules\Clean\Interfaces\Repositories\PostRepositoryInterface;
use Modules\Clean\Models\Post;

class PostRepository implements PostRepositoryInterface
{

    public function createPost(array $data): Post
    {
        return Post::create($data);
    }

    /**
     * @param  string  $slug
     * @return Post
     */
    public function getPostBySlug(string $slug): Post
    {
        return Post::where('slug', '=', strip_tags($slug))
            ->with('categories', 'tags')
            ->firstOrFail();
    }


    /**
     * @param  Post  $post
     * @return bool
     * @throws \Throwable
     */
    public function deletePost(Post $post): bool
    {
        return $post->deleteOrFail();
    }


    /**
     * @param  Post  $post
     * @param  array  $data
     * @return bool
     * @throws \Throwable
     */
    public function updatePost(Post $post, array $data): bool
    {
        return $post->updateOrFail($data);
    }


    /**
     * @return Collection
     */
    public function getPosts(): Collection
    {
        return Post::all();
    }


    /**
     * @return LengthAwarePaginator
     */
    public function getPaginatedPosts(): LengthAwarePaginator
    {
        return Post::orderBy('created_at', 'DESC')
            ->paginate(PostInterface::RECORDS_PER_PAGE)
            ->withQueryString();
    }


    /**
     * @return LengthAwarePaginator
     */
    public function getPaginatedPublishedPosts(): LengthAwarePaginator
    {
        return Post::where('status', '=', 'published')
            ->with('categories', 'tags')
            ->orderByDesc('created_at')
            ->paginate(PostInterface::RECORDS_PER_PAGE);
    }

}
