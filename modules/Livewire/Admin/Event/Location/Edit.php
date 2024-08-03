<?php

namespace Modules\Livewire\Admin\Event\Location;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Modules\Clean\Interfaces\ModelServiceInterface;
use Modules\Clean\Traits\InteractsWithBanner;
use Modules\Event\Models\Location;

class Edit extends Component
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
     * @var string
     */
    public string $name;


    /**
     * @var string
     */
    public string $address;


    /**
     * @var string
     */
    public string $city;


    /**
     * @var string
     */
    public string $slug;


    /**
     * @var float
     */
    public float $latitude;


    /**
     * @var float
     */
    public float $longitude;


    /**
     * @var int
     */
    public int $locationId;


    /**
     * @var Location
     */
    public Location $location;


    /**
     * @var array|string[]
     */
    protected array $rules = [
        'name' => 'required|string|min:1|max:255',
        'city' => 'required|string|min:1|max:255',
        'address' => 'required|string|min:1|max:255',
        'slug' => 'required|alpha_dash|unique:locations',
        'latitude' => 'required|between:-90.00000000000000,90.00000000000000',
        'longitude' => 'required|between:-180.00000000000000,180.00000000000000',
    ];


    /**
     * @var ModelServiceInterface
     */
    private ModelServiceInterface $modelRepository;


    /**
     * @param  ModelServiceInterface  $modelRepository
     */
    public function boot(ModelServiceInterface $modelRepository): void
    {
        $this->modelRepository = $modelRepository;
    }


    /**
     * @param  string  $modalId
     * @param  Location  $location
     * @param  bool  $hasSmallButton
     * @return void
     */
    public function mount(string $modalId, Location $location, bool $hasSmallButton = false): void
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


    /**
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.livewire.event.location.edit');
    }


    /**
     * @return Redirector
     * @throws AuthorizationException
     */
    public function updateLocation(): Redirector
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
            }
        );

        $this->banner(__('Location successfully updated.'));
        return redirect()->route('location.manage');
    }
}
