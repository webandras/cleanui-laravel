<?php

namespace App\Livewire\Admin\Location;

use App\Interface\Repository\Clean\ModelRepositoryInterface;
use App\Models\Event\Location;
use App\Trait\Clean\InteractsWithBanner;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Create extends Component
{
    use InteractsWithBanner;
    use AuthorizesRequests;

    // used by blade / alpinejs
    public $modalId;
    public bool $isModalOpen;
    public bool $hasSmallButton;

    // inputs
    public string $name;
    public string $address;
    public string $city;
    public string $slug;
    public float $latitude;
    public float $longitude;

    protected array $rules = [
        'name' => 'required|string|min:1|max:255',
        'city' => 'required|string|min:1|max:255',
        'address' => 'required|string|min:1|max:255',
        'slug' => 'required|string|unique:locations',
        'latitude' => 'required|between:-90.00000000000000,90.00000000000000',
        'longitude' => 'required|between:-180.00000000000000,180.00000000000000',
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


    public function mount(string $modalId, bool $hasSmallButton = false)
    {
        $this->modalId = $modalId;
        $this->isModalOpen = false;
        $this->hasSmallButton = $hasSmallButton || false;

        $this->name = '';
        $this->address = '';
        $this->city = '';
        $this->slug = '';

    }


    public function render()
    {
        return view('admin.livewire.location.create');
    }


    public function createLocation()
    {
        $this->authorize('create', Location::class);

        // validate user input
        $this->validate();

        // save category, rollback transaction if fails
        DB::transaction(
            function () {
                $location = [];
                $location['name'] = $this->name;
                $location['address'] = $this->address;
                $location['city'] = $this->city;
                $location['slug'] = $this->slug;
                $location['latitude'] = $this->latitude;
                $location['longitude'] = $this->longitude;

                $this->modelRepository->createEntity('App\Models\Event\Location', $location);
            },
            2
        );

        $this->banner(__('New location successfully added.'));
        return redirect()->route('location.manage');
    }

}
