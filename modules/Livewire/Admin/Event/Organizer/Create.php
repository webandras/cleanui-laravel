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

class Create extends Component
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
    public string $facebook_url;


    /**
     * @var string
     */
    public string $slug;


    /**
     * @var array|string[]
     */
    protected array $rules = [
        'name' => 'required|string|min:1|max:255',
        'facebook_url' => 'required|string|min:1|max:255',
        'slug' => 'required|alpha_dash|unique:locations',
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
        $this->facebook_url = '';
        $this->slug = '';

    }


    /**
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.livewire.event.organizer.create');
    }


    /**
     * @return Redirector
     * @throws AuthorizationException
     */
    public function createOrganizer(): Redirector
    {
        $this->authorize('create', Organizer::class);

        // validate user input
        $this->validate();

        // save category, rollback transaction if fails
        DB::transaction(
            function () {
                $organizer = [];
                $organizer['name'] = $this->name;
                $organizer['slug'] = $this->slug;
                $organizer['facebook_url'] = $this->facebook_url;

                $this->modelRepository->createEntity('Event\Models\Organizer', $organizer);
            }
        );

        $this->banner(__('New organizer successfully added.'));
        return redirect()->route('organizer.manage');
    }

}
