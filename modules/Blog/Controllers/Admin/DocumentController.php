<?php

namespace Modules\Blog\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Modules\Auth\Traits\UserPermissions;
use Modules\Blog\Enum\PostStatus;
use Modules\Blog\Models\Document;
use Modules\Blog\Requests\DocumentStoreRequest;
use Modules\Blog\Requests\DocumentUpdateRequest;
use Modules\Clean\Traits\InteractsWithBanner;
use Throwable;

class DocumentController extends Controller
{
    use InteractsWithBanner, UserPermissions;

    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     * @throws AuthorizationException
     */
    public function index(): \Illuminate\Foundation\Application|View|Factory|Application
    {
        $this->authorize('viewAny', Document::class);

        return view('blog::admin.document.manage')->with([
            'userPermissions' => $this->getUserPermissions()
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function create(): View|Factory|Application
    {
        $this->authorize('create', Document::class);

        return view('blog::admin.document.create')->with([
            'documentStatuses' => PostStatus::options(),
            'userPermissions' => $this->getUserPermissions(),
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  DocumentStoreRequest  $request
     *
     * @return RedirectResponse
     * @throws AuthorizationException
     */
    public function store(DocumentStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Document::class);

        $data = $request->all();
        $data = Document::getSlugFromTitle($data);
        $data['order'] = Document::max('order') + 1;


        DB::transaction(
            function () use ($data) {
                Document::create($data);
            }, 2);

        $this->banner(__('New document is added.'));
        return redirect()->route('document.manage');
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  Document  $document
     *
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function edit(Document $document): View|Factory|Application
    {
        $this->authorize('update', [Document::class, $document]);

        return view('blog::admin.document.edit')->with([
            'document' => $document,
            'documentStatuses' => PostStatus::options(),
            'userPermissions' => $this->getUserPermissions(),
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

        $validated = $request->validated();
        $validated = Document::getSlugFromTitle($validated);

        dd($validated);

        $document->updateOrFail($validated);

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

        $oldTitle = $document->title;
        $document->deleteOrFail();

        $this->banner(__('":title" successfully deleted!', ['title' => $oldTitle]));
        return redirect()->route('document.manage');
    }
}
