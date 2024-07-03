<?php

namespace Modules\Blog\Interfaces\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Blog\Models\Document;

interface DocumentRepositoryInterface
{

    /**
     * @param array $data
     * @return Document
     */
    public function createDocument(array $data): Document;

    /**
     * @param string $slug
     * @return Document
     */
    public function getDocumentBySlug(string $slug): Document;


    /**
     * @param Document $document
     * @return bool
     */
    public function deleteDocument(Document $document): bool;


    /**
     * @param Document $document
     * @param array $data
     * @return mixed
     */
    public function updateDocument(Document $document, array $data): mixed;


    /**
     * @return Collection
     */
    public function getDocuments(): Collection;


    /**
     * @return LengthAwarePaginator
     */
    public function getPaginatedDocuments(): LengthAwarePaginator;


    /**
     * @return LengthAwarePaginator
     */
    public function getPaginatedPublishedDocuments(): LengthAwarePaginator;


    /**
     * @return Collection
     */
    public function getPublishedDocuments(): Collection;

}

