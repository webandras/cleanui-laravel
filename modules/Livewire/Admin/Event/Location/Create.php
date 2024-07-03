<?php

namespace Modules\Livewire\Admin\Event\Location;

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
use Modules\Event\Models\Location;

class Create extends Component
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
     * @var bool
     */
    public bool $hasSmallButton;


    // inputs
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
     * @param  bool  $hasSmallButton
     * @return void
     */
    public function mount(string $modalId, bool $hasSmallButton = false): void
    {
        $this->modalId = $modalId;
        $this->isModalOpen = false;
        $this->hasSmallButton = $hasSmallButton || false;

        $this->name = '';
        $this->address = '';
        $this->city = '';
        $this->slug = '';

    }


    /**
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.livewire.event.location.create');
    }


    /**
     * @return Redirector
     * @throws AuthorizationException
     */
    public function createLocation(): Redirector
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

                $this->modelRepository->createEntity('Event\Models\Location', $location);
            },
            2
        );

        $this->banner(__('New location successfully added.'));
        return redirect()->route('location.manage');
    }

}
