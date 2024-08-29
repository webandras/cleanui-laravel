<?php

namespace Modules\Livewire\Admin\Job\Worker;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Modules\Clean\Traits\InteractsWithBanner;
use Modules\Job\Models\Worker;

class Create extends Component
{
    use InteractsWithBanner, AuthorizesRequests;

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
    public string $email;


    /**
     * @var string
     */
    public string $phone;


    /**
     * @var string
     */
    public string $bankAccountNumber;


    /**
     * @var string
     */
    public string $bankAccountName;


    /**
     * @var array|array[]
     */
    protected array $rules = [
        'name' => ['required', 'string', 'max:255'],
        'email' => ['nullable', 'email', 'max:255', 'unique:workers'],
        'phone' => ['nullable', 'string'],
        'bankAccountNumber' => ['nullable', 'string'],
        'bankAccountName' => ['nullable', 'string'],
    ];


    /**
     * @param  bool  $hasSmallButton
     * @return void
     */
    public function mount(bool $hasSmallButton = false): void
    {
        $this->modalId = 'm-new-worker';
        $this->isModalOpen = false;
        $this->hasSmallButton = $hasSmallButton || false;

        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->bankAccountNumber = '';
        $this->bankAccountName = '';
    }


    /**
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.livewire.job.worker.create');
    }


    /**
     * @return Redirector
     * @throws AuthorizationException
     */
    public function createWorker(): Redirector
    {
        $this->authorize('create', Worker::class);

        // validate user input
        $this->validate();

        DB::transaction(
            function () {
                $newWorker = Worker::create([
                    'name' => htmlspecialchars($this->name),
                    'email' => $this->email !== '' ? trim(htmlspecialchars($this->email)) : null,
                    'phone' => htmlspecialchars($this->phone),
                    'bank_account_number' => trim(htmlspecialchars($this->bankAccountNumber)),
                    'bank_account_name' => trim(htmlspecialchars($this->bankAccountName)),
                ]);

                $newWorker->save();
            }
        );

        $this->banner(__('Successfully created the worker ":name"!', ['name' => htmlspecialchars($this->name)]));
        return redirect()->route('worker.manage');
    }

}
