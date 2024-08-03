<?php

namespace Modules\Livewire\Admin\Event\Organizer;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Modules\Clean\Interfaces\Repositories\ModelRepositoryInterface;
use Modules\Clean\Traits\InteractsWithBanner;
use Modules\Event\Models\Organizer;

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
    public string $facebook_url;


    /**
     * @var string
     */
    public string $slug;


    /**
     * @var int
     */
    public int $organizerId;


    /**
     * @var Organizer
     */
    public Organizer $organizer;


    /**
     * @var array|string[]
     */
    protected array $rules = [
        'name' => 'required|string|min:1|max:255',
        'facebook_url' => 'required|string|min:10|max:255',
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
     * @param  Organizer  $organizer
     * @param  bool  $hasSmallButton
     * @return void
     */
    public function mount(string $modalId, Organizer $organizer, bool $hasSmallButton = false): void
    {
        $this->modalId = $modalId;
        $this->isModalOpen = false;
        $this->hasSmallButton = $hasSmallButton || false;

        $this->organizer = $organizer;
        $this->organizerId = $organizer->id;
        $this->name = $this->organizer->name;
        $this->facebook_url = $this->organizer->facebook_url;
        $this->slug = $this->organizer->slug;
    }


    /**
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.livewire.event.organizer.edit');
    }


    /**
     * @return Redirector
     * @throws AuthorizationException
     */
    public function updateOrganizer(): Redirector
    {
        $this->authorize('update', [Organizer::class, $this->organizer]);

        $this->rules['slug'] = ['required', 'max:255', Rule::unique('organizers')->ignore($this->organizerId, 'id')];

        // validate user input
        $this->validate();

        // save category, rollback transaction if fails
        DB::transaction(
            function () {
                $this->modelRepository->updateEntity($this->organizer, [
                    'name' => $this->name,
                    'facebook_url' => $this->facebook_url,
                    'slug' => $this->slug,
                ]);
            }
        );

        $this->banner(__('Organizer successfully updated.'));
        return redirect()->route('organizer.manage');
    }
}
