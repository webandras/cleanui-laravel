<?php

namespace App\Livewire\Admin\Organizer;

use App\Trait\Clean\InteractsWithBanner;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\Clean\Interfaces\Repositories\ModelRepositoryInterface;
use Modules\Event\Models\Organizer;

class Delete extends Component
{
    use InteractsWithBanner;
    use AuthorizesRequests;

    // used by blade / alpinejs
    public string $modalId;
    public bool $isModalOpen;
    public bool $hasSmallButton;

    // inputs
    public int $organizerId;
    public string $name;
    public Organizer $organizer;

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
    public function boot(ModelRepositoryInterface $modelRepository)
    {
        $this->modelRepository = $modelRepository;
    }


    public function mount(string $modalId, Organizer $organizer, bool $hasSmallButton = false)
    {
        $this->modalId = $modalId;
        $this->isModalOpen = false;
        $this->hasSmallButton = $hasSmallButton;
        $this->organizer = $organizer;
        $this->organizerId = $organizer->id;
        $this->name = $organizer->name;
    }


    public function render()
    {
        return view('admin.livewire.organizer.delete');
    }


    public function deleteOrganizer()
    {
        $this->authorize('delete', [Organizer::class, $this->organizer]);

        // validate user input
        $this->validate();

        // save category, rollback transaction if fails
        DB::transaction(
            function () {
                $this->modelRepository->deleteEntity($this->organizer);
            },
            2
        );

        $this->banner(__('Organizer successfully deleted'));
        return redirect()->route('organizer.manage');
    }
}
