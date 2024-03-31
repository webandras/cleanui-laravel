<?php

namespace App\Livewire\Admin\Event;

use App\Interface\Repository\Event\EventRepositoryInterface;
use App\Models\Event\Event;
use App\Trait\Clean\InteractsWithBanner;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Delete extends Component
{
    use InteractsWithBanner;
    use AuthorizesRequests;

    // used by blade / alpinejs
    public string $modalId;
    public bool $isModalOpen;
    public bool $hasSmallButton;

    // inputs
    public int $eventId;
    public string $title;
    public Event $event;

    protected array $rules = [
        'eventId' => 'required|int|min:1',
    ];


    /**
     * @var EventRepositoryInterface
     */
    private EventRepositoryInterface $eventRepository;


    /**
     * @param  EventRepositoryInterface  $eventRepository
     */
    public function boot(EventRepositoryInterface $eventRepository) {
        $this->eventRepository = $eventRepository;
    }


    public function mount(string $modalId, Event $event, bool $hasSmallButton = false)
    {
        $this->modalId = $modalId;
        $this->isModalOpen = false;
        $this->hasSmallButton = $hasSmallButton;
        $this->event = $event;
        $this->eventId = $event->id;
        $this->title = $event->title;
    }


    public function render()
    {
        return view('admin.livewire.event.delete');
    }


    /**
     * @throws AuthorizationException
     */
    public function deleteEvent()
    {
        $this->authorize('delete', [Event::class, $this->event]);

        // validate user input
        $this->validate();

        // save category, rollback transaction if fails
        DB::transaction(
            function () {
                $this->eventRepository->deleteEvent($this->event);
            },
            2
        );

        $this->banner(__('Event successfully deleted'));
        return redirect()->route('event.manage');
    }
}
