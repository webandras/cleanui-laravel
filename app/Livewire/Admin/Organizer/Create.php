<?php

namespace App\Livewire\Admin\Organizer;

use App\Interface\Repository\Clean\ModelRepositoryInterface;
use App\Models\Event\Organizer;
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
    public string $facebook_url;
    public string $slug;

    protected array $rules = [
        'name' => 'required|string|min:1|max:255',
        'facebook_url' => 'required|string|min:1|max:255',
        'slug' => 'required|string|unique:locations',
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


    public function mount(string $modalId, bool $hasSmallButton = false)
    {
        $this->modalId = $modalId;
        $this->isModalOpen = false;
        $this->hasSmallButton = $hasSmallButton || false;

        $this->name = '';
        $this->facebook_url = '';
        $this->slug = '';

    }


    public function render()
    {
        return view('admin.livewire.organizer.create');
    }


    public function createOrganizer()
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

                $this->modelRepository->createEntity('Event\Organizer', $organizer);
            },
            2
        );

        $this->banner(__('New organizer successfully added.'));
        return redirect()->route('organizer.manage');
    }

}
