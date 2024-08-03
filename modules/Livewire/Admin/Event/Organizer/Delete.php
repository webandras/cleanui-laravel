<?php

namespace Modules\Livewire\Admin\Event\Organizer;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Modules\Clean\Interfaces\Repositories\ModelRepositoryInterface;
use Modules\Clean\Traits\InteractsWithBanner;
use Modules\Event\Models\Organizer;

class Delete extends Component
{
    use InteractsWithBanner;
    use AuthorizesRequests;

    /**
     * @var string
     */
    public string $modalId;


    /**
     * @var bool
     */
    public bool $isModalOpen;


    /**
     * @var bool
     */
    public bool $hasSmallButton;


    /**
     * @var int
     */
    public int $organizerId;


    /**
     * @var string
     */
    public string $name;


    /**
     * @var Organizer
     */
    public Organizer $organizer;


    /**
     * @var array|string[]
     */
    protected array $rules = [
        'organizerId' => 'required|int|min:1',
    ];


    /**
     * @var ModelRepositoryInterface
     */
    private ModelRepositoryInterface $modelRepository;


    /**
     * @param  ModelRepositoryInterface  $modelRepository
     */
    public function boot(ModelRepositoryInterface $modelRepository): void
    {
        $this->modelRepository = $modelRepository;
    }


    /**
     * @param  string  $modalId
     * @param  Organizer  $organizer
     * @param  bool  $hasSmallButton
     * @return void
     */
    public function mount(string $modalId, Organizer $organizer, bool $hasSmallButton = false): void
    {
        $this->modalId = $modalId;
        $this->isModalOpen = false;
        $this->hasSmallButton = $hasSmallButton;
        $this->organizer = $organizer;
        $this->organizerId = $organizer->id;
        $this->name = $organizer->name;
    }


    /**
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.livewire.event.organizer.delete');
    }


    /**
     * @return Redirector
     * @throws AuthorizationException
     */
    public function deleteOrganizer(): Redirector
    {
        $this->authorize('delete', [Organizer::class, $this->organizer]);

        // validate user input
        $this->validate();

        // save category, rollback transaction if fails
        DB::transaction(
            function () {
                $this->modelRepository->deleteEntity($this->organizer);
            }
        );

        $this->banner(__('Organizer successfully deleted'));
        return redirect()->route('organizer.manage');
    }
}
