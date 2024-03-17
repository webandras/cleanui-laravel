<?php

namespace App\Http\Livewire\Admin\Clean\Document;

use App\Interface\Repository\Clean\DocumentRepositoryInterface;
use App\Models\Clean\Document;
use App\Trait\Clean\InteractsWithBanner;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Delete extends Component
{
    use InteractsWithBanner;
    use AuthorizesRequests;


    // used by blade / alpinejs
    public string $modalId;
    public bool $isModalOpen;


    public int $documentId;
    public string $title;
    public ?Document $document;


    protected array $rules = [
        'documentId' => 'required|int|min:1',
    ];


    protected $listeners = ['triggerDeleteDocument' => 'prepareDeletion'];


    /**
     * @param  Document  $document
     * @return void
     */
    public function prepareDeletion(Document $document): void
    {
        $this->isModalOpen = true;
        $this->document = $document;
        $this->documentId = $document->id;
        $this->title = $document->title;
    }


    /**
     * @var DocumentRepositoryInterface
     */
    private DocumentRepositoryInterface $documentRepository;


    /**
     * @param DocumentRepositoryInterface $documentRepository
     */
    public function boot(DocumentRepositoryInterface $documentRepository)
    {
        $this->documentRepository = $documentRepository;
    }


    /**
     * @param  string  $modalId
     * @return void
     */
    public function mount(string $modalId)
    {
        $this->modalId = $modalId;
        $this->isModalOpen = false;
        $this->document = null;
        $this->documentId = 0;
        $this->title = '';
    }

    public function initialize(): void
    {
        $this->isModalOpen = false;
        $this->document = null;
        $this->documentId = 0;
        $this->title = '';
    }


    public function render()
    {
        return view('admin.livewire.document.delete');
    }


    /**
     * @throws AuthorizationException
     */
    public function deleteDocument()
    {
        $this->authorize('delete', [Document::class, $this->document]);

        // validate user input
        $this->validate();

        // save category, rollback transaction if fails
        DB::transaction(
            function () {
                $this->documentRepository->deleteDocument($this->document);
            },
            1
        );

        $this->banner(__('Document successfully deleted'));
        $this->initialize();
        return redirect()->route('document.manage');
    }
}
