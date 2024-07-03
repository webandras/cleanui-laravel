<?php

namespace Modules\Livewire\Admin\Event;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Modules\Clean\Traits\InteractsWithBanner;
use Modules\Event\Interfaces\Repositories\EventRepositoryInterface;
use Modules\Event\Models\Event;

class Delete extends Component
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
     * @var int
     */
    public int $eventId;


    /**
     * @var string
     */
    public string $title;


    /**
     * @var Event
     */
    public Event $event;


    /**
     * @var array|string[]
     */
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
    public function boot(EventRepositoryInterface $eventRepository): void
    {
        $this->eventRepository = $eventRepository;
    }


    /**
     * @param  string  $modalId
     * @param  Event  $event
     * @param  bool  $hasSmallButton
     * @return void
     */
    public function mount(string $modalId, Event $event, bool $hasSmallButton = false): void
    {
        $this->modalId = $modalId;
        $this->isModalOpen = false;
        $this->hasSmallButton = $hasSmallButton;
        $this->event = $event;
        $this->eventId = $event->id;
        $this->title = $event->title;
    }


    /**
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.livewire.event.delete');
    }


    /**
     * @return Redirector
     * @throws AuthorizationException
     */
    public function deleteEvent(): Redirector
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
