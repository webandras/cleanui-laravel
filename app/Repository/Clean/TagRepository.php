<?php

namespace App\Repository\Clean;

use App\Interface\Entities\Clean\TagInterface;
use App\Interface\Repository\Clean\TagRepositoryInterface;
use App\Models\Clean\Tag;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class TagRepository implements TagRepositoryInterface
{

    /**
     * @return LengthAwarePaginator
     */
    public function getPaginatedTags(): LengthAwarePaginator
    {
        return Tag::orderBy('created_at', 'DESC')
            ->paginate(TagInterface::RECORDS_PER_PAGE)
            ->withQueryString();
    }


    /**
     * @return Collection
     */
    public function getTags(): Collection
    {
        return Tag::all();
    }


    /**
     * @param  array  $data
     * @return Tag
     */
    public function createTag(array $data): Tag
    {
        return Tag::create($data);
    }


    /**
     * @param  Tag  $tag
     * @param  array  $data
     * @return bool|null
     * @throws \Throwable
     */
    public function updateTag(Tag $tag, array $data): bool|null
    {
        return $tag->updateOrFail($data);
    }


    /**
     * @param  Tag  $tag
     * @return bool|null
     */
    public function deleteTag(Tag $tag): bool|null
    {
        return $tag->delete();
    }
}
