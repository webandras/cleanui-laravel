<?php

namespace App\Livewire\Admin\Job\Worker;

use App\Trait\Clean\InteractsWithBanner;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Modules\Job\Models\Worker;

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
    public int $workerId;


    /**
     * @var Worker
     */
    private Worker $user;


    /**
     * @var string
     */
    public string $name;


    /**
     * @var array|string[]
     */
    protected array $rules = [
        'workerId' => 'required|int|min:1',
    ];


    /**
     * @param  string  $modalId
     * @param $worker
     * @param  bool  $hasSmallButton
     * @return void
     */
    public function mount(string $modalId, $worker, bool $hasSmallButton = false)
    {
        $this->modalId = $modalId;
        $this->isModalOpen = false;
        $this->hasSmallButton = $hasSmallButton;
        $this->workerId = $worker->id;
        $this->name = $worker->name;
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function render()
    {
        return view('admin.livewire.job.worker.delete');
    }


    /**
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function deleteWorker()
    {
        $worker = Worker::findOrFail($this->workerId);

        $this->authorize('delete', [Worker::class, $worker]);

        // validate user input
        $this->validate();

        // save category, rollback transaction if fails
        DB::transaction(
            function () use ($worker) {
                $worker->delete();
            },
            2
        );


        $this->banner(__('The worker with the name ":name" was successfully deleted.',
            ['name' => htmlspecialchars($this->name)]));
        return redirect()->route('worker.manage');
    }
}
