<?php

namespace Modules\Blog\Actions;

use Modules\Blog\Models\Post;

class UpdatePost
{

    /**
     * @param  Post  $post
     * @param  array  $validated
     * @param  array  $categoriesArray
     * @param  array  $tagsArray
     * @return void
     * @throws \Throwable
     */
    public function __invoke(Post $post, array $validated, array $categoriesArray, array $tagsArray): void
    {
        // update post
        $post->updateOrFail($validated);

        // synchronize post categories
        if ( ! empty($categoriesArray)) {
            $post->categories()->sync($categoriesArray);
        }

        // synchronize post categories
        if ( ! empty($tagsArray)) {
            $post->tags()->sync($tagsArray);
        }
    }
}

