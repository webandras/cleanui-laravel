<?php

namespace Modules\Livewire\Admin\Blog\Document;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Modules\Blog\Interfaces\Repositories\DocumentRepositoryInterface;
use Modules\Blog\Models\Document;
use Modules\Clean\Traits\InteractsWithBanner;

class Delete extends Component
{
    use InteractsWithBanner;
    use AuthorizesRequests;


    // used by blade / alpinejs
    /**
     * @var string
     */
    public string $modalId;


    /**
     * @var bool
     */
    public bool $isModalOpen;


    /**
     * @var int
     */
    public int $documentId;


    /**
     * @var string
     */
    public string $title;


    /**
     * @var Document|null
     */
    public ?Document $document;


    /**
     * @var array|string[]
     */
    protected array $rules = [
        'documentId' => 'required|int|min:1',
    ];


    /**
     * @var string[]
     */
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
     * @param  DocumentRepositoryInterface  $documentRepository
     * @return void
     */
    public function boot(DocumentRepositoryInterface $documentRepository): void
    {
        $this->documentRepository = $documentRepository;
    }


    /**
     * @param  string  $modalId
     * @return void
     */
    public function mount(string $modalId): void
    {
        $this->modalId = $modalId;
        $this->isModalOpen = false;
        $this->document = null;
        $this->documentId = 0;
        $this->title = '';
    }


    /**
     * @return void
     */
    public function initialize(): void
    {
        $this->isModalOpen = false;
        $this->document = null;
        $this->documentId = 0;
        $this->title = '';
    }


    /**
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.livewire.blog.document.delete');
    }


    /**
     * @return Redirector
     * @throws AuthorizationException
     */
    public function deleteDocument(): Redirector
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
