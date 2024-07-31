<?php

namespace Modules\Blog\Actions;

use Modules\Blog\Models\Post;

class CreatePost
{
    public function __invoke(array $validated, array $categoriesArray, array $tagsArray): void
    {
        $newPost = Post::query()->create($validated);

        // synchronize post categories
        if ( ! empty($categoriesArray)) {
            $newPost->categories()->sync($categoriesArray);
        }

        // synchronize post tags
        if ( ! empty($tagsArray)) {
            $newPost->tags()->sync($tagsArray);
        }
    }
}

