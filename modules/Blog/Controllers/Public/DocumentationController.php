<?php

namespace Modules\Blog\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Modules\Blog\Models\Document;
use Modules\Clean\Traits\InteractsWithBanner;

class DocumentationController extends Controller
{
    use InteractsWithBanner;

    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function index(): \Illuminate\Foundation\Application|View|Factory|Application
    {
        return view('blog::public.document.index')->with([
            'documents' => Document::publishedDocuments(),
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
        $currentDocument = Document::where('slug', '=', $slug)
            ->where('status', '=', 'published')
            ->firstOrFail();
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


        return view('blog::public.document.show')->with([
            'currentDocument' => $currentDocument,
            'nextDocument' => $nextDocument,
            'previousDocument' => $previousDocument,
            'documents' => Document::publishedDocuments(),
        ]);
    }


}
