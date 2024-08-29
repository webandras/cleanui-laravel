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
use Modules\Clean\Interfaces\ModelServiceInterface;
use Modules\Clean\Traits\InteractsWithBanner;
use Modules\Event\Models\Location;

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
    public int $locationId;


    /**
     * @var string
     */
    public string $name;


    /**
     * @var Location
     */
    public Location $location;


    /**
     * @var array|string[]
     */
    protected array $rules = [
        'locationId' => 'required|int|min:1',
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
        $this->hasSmallButton = $hasSmallButton;
        $this->location = $location;
        $this->locationId = $location->id;
        $this->name = $location->name;
    }


    /**
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.livewire.event.location.delete');
    }


    /**
     * @return Redirector
     * @throws AuthorizationException
     */
    public function deleteLocation(): Redirector
    {
        $this->authorize('delete', [Location::class, $this->location]);

        // validate user input
        $this->validate();

        // save category, rollback transaction if fails
        DB::transaction(
            function () {
                $this->modelRepository->deleteEntity($this->location);
            }
        );

        $this->banner(__('Location successfully deleted'));
        return redirect()->route('location.manage');
    }
}
