<?php

namespace App\Http\Livewire\Admin\Organizer;

use App\Interface\Repository\Clean\ModelRepositoryInterface;
use App\Models\Event\Organizer;
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
    public string $facebook_url;
    public string $slug;

    public int $organizerId;
    public Organizer $organizer;

    protected array $rules = [
        'name' => 'required|string|min:1|max:255',
        'facebook_url' => 'required|string|min:10|max:255',
        'slug' => 'required|string|unique:locations',
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


    public function mount(string $modalId, Organizer $organizer, bool $hasSmallButton = false)
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


    public function render()
    {
        return view('admin.livewire.organizer.edit');
    }


    public function updateOrganizer()
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
            },
            2
        );

        $this->banner(__('Organizer successfully updated.'));
        return redirect()->route('organizer.manage');
    }
}
