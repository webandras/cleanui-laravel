<?php

namespace Modules\Clean\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Trait\Clean\InteractsWithBanner;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Modules\Clean\Interfaces\Repositories\DocumentRepositoryInterface;
use Modules\Clean\Models\Document;

class DocumentationController extends Controller
{
    use InteractsWithBanner;


    /**
     * @var DocumentRepositoryInterface
     */
    private DocumentRepositoryInterface $documentRepository;


    /**
     * @param  DocumentRepositoryInterface  $documentRepository
     */
    public function __construct(DocumentRepositoryInterface $documentRepository)
    {
        $this->documentRepository = $documentRepository;
    }


    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function index(): \Illuminate\Foundation\Application|View|Factory|Application
    {
        return view('public.pages.document.index')->with([
            'documents' => $this->documentRepository->getPublishedDocuments(),
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $slug
     * @return Application|Factory|View
     */
    public function show(string $slug): View|Factory|Application
    {
        $currentDocument = $this->documentRepository->getDocumentBySlug($slug);
        $currentOrder = $currentDocument->order;

        $nextDocument = Document::where('order', '<', $currentOrder)
            ->where('status', '=', 'published')
            ->orderbyDesc('order')
            ->first();

        // Needs ascending order (because of greater than condition)
        $previousDocument = Document::where('order', '>', $currentOrder)
            ->where('status', '=', 'published')
            ->orderby('order', 'ASC')
            ->first();


        return view('public.pages.document.show')->with([
            'currentDocument' => $currentDocument,
            'nextDocument' => $nextDocument,
            'previousDocument' => $previousDocument,
            'documents' => $this->documentRepository->getPublishedDocuments(),
        ]);
    }


}
