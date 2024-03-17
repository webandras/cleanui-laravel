<?php

namespace App\Http\Livewire\Admin\Clean\Document;

use App\Interface\Repository\Clean\DocumentRepositoryInterface;
use App\Models\Clean\Document;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Documents extends Component
{
    /**
     * @var DocumentRepositoryInterface
     */
    private DocumentRepositoryInterface $documentRepository;


    /**
     * @param  DocumentRepositoryInterface  $documentRepository
     */
    public function boot(DocumentRepositoryInterface $documentRepository)
    {
        $this->documentRepository = $documentRepository;
    }


    public function render()
    {
        return view('admin.livewire.document.documents')->with([
            'documents' => $this->documentRepository->getDocuments(),
            'documentStatuses' => Document::getDocumentStatuses(),
            'documentStatusColors' => Document::getDocumentStatusColors(),
        ]);
    }


    public function updateOrder($list): void
    {
        DB::transaction(function() use ($list) {
            foreach($list as $item) {
                Document::find($item['value'])->update(['order' => $item['order']]);
            }
        });

    }
}
