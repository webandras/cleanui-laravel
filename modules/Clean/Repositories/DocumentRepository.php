<?php

namespace Modules\Clean\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Clean\Interfaces\Entities\DocumentInterface;
use Modules\Clean\Interfaces\Repositories\DocumentRepositoryInterface;
use Modules\Clean\Models\Document;

class DocumentRepository implements DocumentRepositoryInterface
{

    public function createDocument(array $data): Document
    {
        return Document::create($data);
    }

    /**
     * @param string $slug
     * @return Document
     */
    public function getDocumentBySlug(string $slug): Document
    {
        return Document::where('slug', '=', strip_tags($slug))
            ->where('status', '=', 'published')
            ->firstOrFail();
    }


    /**
     * @param  Document  $document
     * @return bool
     * @throws \Throwable
     */
    public function deleteDocument(Document $document): bool
    {
        return $document->deleteOrFail();
    }


    /**
     * @param  Document $document
     * @param  array  $data
     * @return bool
     * @throws \Throwable
     */
    public function updateDocument(Document $document, array $data): bool
    {
        return $document->updateOrFail($data);
    }


    /**
     * @return Collection
     */
    public function getDocuments(): Collection
    {
        return Document::orderBy('order', 'ASC')->get();
    }


    /**
     * @return LengthAwarePaginator
     */
    public function getPaginatedDocuments(): LengthAwarePaginator
    {
        return Document::with('documents')
            ->orderBy('created_at', 'DESC')
            ->paginate(DocumentInterface::RECORDS_PER_PAGE)
            ->withQueryString();
    }


    /**
     * @return LengthAwarePaginator
     */
    public function getPaginatedPublishedDocuments(): LengthAwarePaginator
    {
        return Document::where('status', '=', 'published')
            ->with('documents')
            ->orderByDesc('created_at')
            ->paginate(DocumentInterface::RECORDS_PER_PAGE);
    }

    /**
     * @return Collection
     */
    public function getPublishedDocuments(): Collection
    {
        return Document::where('status', '=', 'published')
            ->orderBy('order', 'asc')
            ->get();
    }

}
