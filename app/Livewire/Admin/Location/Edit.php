<?php

namespace App\Livewire\Admin\Location;

use App\Interface\Repository\Clean\ModelRepositoryInterface;
use App\Models\Event\Location;
use App\Trait\Clean\InteractsWithBanner;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Edit extends Component
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

    public int $locationId;
    public Location $location;

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


    public function mount(string $modalId, Location $location, bool $hasSmallButton = false)
    {
        $this->modalId = $modalId;
        $this->isModalOpen = false;
        $this->hasSmallButton = $hasSmallButton || false;

        $this->location = $location;
        $this->locationId = $location->id;
        $this->name = $this->location->name;
        $this->address = $this->location->address;
        $this->city = $this->location->city;
        $this->slug = $this->location->slug;
        $this->latitude = $this->location->latitude;
        $this->longitude = $this->location->longitude;
    }


    public function render()
    {
        return view('admin.livewire.location.edit');
    }


    public function updateLocation()
    {
        $this->authorize('update', [Location::class, $this->location]);

        $this->rules['slug'] = ['required', 'max:255', Rule::unique('locations')->ignore($this->locationId, 'id')];

        // validate user input
        $this->validate();

        // save category, rollback transaction if fails
        DB::transaction(
            function () {
                $this->modelRepository->updateEntity($this->location, [
                    'name' => $this->name,
                    'address' => $this->address,
                    'city' => $this->city,
                    'slug' => $this->slug,
                    'latitude' => $this->latitude,
                    'longitude' => $this->longitude,
                ]);
            },
            2
        );

        $this->banner(__('Location successfully updated.'));
        return redirect()->route('location.manage');
    }
}
