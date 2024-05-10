<?php

namespace App\Http\Controllers\Admin\Clean;

use App\Http\Controllers\Controller;
use App\Http\Requests\Clean\DocumentStoreRequest;
use App\Http\Requests\Clean\DocumentUpdateRequest;
use App\Interface\Repository\Clean\DocumentRepositoryInterface;
use App\Models\Clean\Document;
use App\Trait\Clean\InteractsWithBanner;
use App\Trait\Clean\UserPermissions;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Throwable;

class DocumentController extends Controller
{
    use InteractsWithBanner, UserPermissions;


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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(): \Illuminate\Foundation\Application|View|Factory|Application
    {
        $this->authorize('viewAny', Document::class);

        return view('admin.pages.document.manage')->with([
            'userPermissions' => $this->getUserPermissions()
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create(): View|Factory|Application
    {
        return view('admin.pages.document.create')->with([
            'documentStatuses' => Document::getDocumentStatuses(),
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  DocumentStoreRequest  $request
     * @return RedirectResponse
     */
    public function store(DocumentStoreRequest $request): RedirectResponse
    {
        $data = $request->all();
        $data = Document::getSlugFromTitle($data);
        $data['order'] = Document::max('order') + 1;


        DB::transaction(
            function () use ($data) {
                $this->documentRepository->createDocument($data);
            }, 2);

        $this->banner(__('New doc is added.'));
        return redirect()->route('document.manage');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  Document  $document
     *
     * @return Application|Factory|View
     */
    public function edit(Document $document): View|Factory|Application
    {
        return view('admin.pages.document.edit')->with([
            'document' => $document,
            'documentStatuses' => Document::getDocumentStatuses(),
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  DocumentUpdateRequest  $request
     * @param  Document  $document
     *
     * @return RedirectResponse
     * @throws Throwable
     */
    public function update(DocumentUpdateRequest $request, Document $document): RedirectResponse
    {
        $this->authorize('update', [Document::class, $document]);

        $data = $request->all();
        $data = Document::getSlugFromTitle($data);


        DB::transaction(
            function () use ($document, $data) {
                $this->documentRepository->updateDocument($document, $data);
            }, 2);


        $this->banner(__('Successfully updated the document'));
        return redirect()->route('document.manage');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  Document  $document
     *
     * @return RedirectResponse
     * @throws Throwable
     */
    public function destroy(Document $document): RedirectResponse
    {
        $this->authorize('delete', Document::class);

        $oldTitle = htmlentities($document->title);

        $this->documentRepository->deleteDocument($document);

        $this->banner(__('":title" successfully deleted!', ['title' => $oldTitle]));
        return redirect()->route('document.manage');
    }
}
