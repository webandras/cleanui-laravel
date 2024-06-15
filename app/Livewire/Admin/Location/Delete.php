<?php

namespace App\Livewire\Admin\Location;

use App\Trait\Clean\InteractsWithBanner;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\Clean\Interfaces\Repositories\ModelRepositoryInterface;
use Modules\Event\Models\Location;

class Delete extends Component
{
    use InteractsWithBanner;
    use AuthorizesRequests;

    // used by blade / alpinejs
    public string $modalId;
    public bool $isModalOpen;
    public bool $hasSmallButton;

    // inputs
    public int $locationId;
    public string $name;
    public Location $location;

    protected array $rules = [
        'locationId' => 'required|int|min:1',
    ];


    /**
     * @var ModelRepositoryInterface
     */
    private ModelRepositoryInterface $modelRepository;


    /**
     * @param  ModelRepositoryInterface  $modelRepository
     */
    public function boot(ModelRepositoryInterface $modelRepository) {
        $this->modelRepository = $modelRepository;
    }


    public function mount(string $modalId, Location $location, bool $hasSmallButton = false)
    {
        $this->modalId = $modalId;
        $this->isModalOpen = false;
        $this->hasSmallButton = $hasSmallButton;
        $this->location = $location;
        $this->locationId = $location->id;
        $this->name = $location->name;
    }


    public function render()
    {
        return view('admin.livewire.location.delete');
    }


    public function deleteLocation()
    {
        $this->authorize('delete', [Location::class, $this->location]);

        // validate user input
        $this->validate();

        // save category, rollback transaction if fails
        DB::transaction(
            function () {
                $this->modelRepository->deleteEntity($this->location);
            },
            2
        );

        $this->banner(__('Location successfully deleted'));
        return redirect()->route('location.manage');
    }
}
