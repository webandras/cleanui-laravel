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

class Edit extends Component
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
    public string $email;


    /**
     * @var string
     */
    public string $phone;


    /**
     * @var Worker
     */
    public Worker $worker;


    /**
     * @var int
     */
    public int $workerId;


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
        'email' => ['nullable', 'email'],
        'phone' => ['nullable', 'string'],
        'bankAccountNumber' => ['nullable', 'string'],
        'bankAccountName' => ['nullable', 'string'],
    ];


    /**
     * @param  string  $modalId
     * @param  Worker  $worker
     * @param  bool  $hasSmallButton
     * @return void
     */
    public function mount(
        string $modalId,
        Worker $worker,
        bool $hasSmallButton = false
    ): void {
        $this->modalId = $modalId;
        $this->isModalOpen = false;
        $this->hasSmallButton = $hasSmallButton || false;

        $this->worker = $worker;
        $this->workerId = $this->worker->id;
        $this->name = $this->worker->name;
        $this->email = $this->worker->email ?? '';
        $this->phone = $this->worker->phone ?? '';
        $this->bankAccountNumber = $this->worker->bank_account_number ?? '';
        $this->bankAccountName = $this->worker->bank_account_name ?? '';

    }


    /**
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.livewire.job.worker.edit');
    }


    /**
     * @return Redirector
     * @throws AuthorizationException
     */
    public function updateWorker(): Redirector
    {
        $this->authorize('update', [Worker::class, $this->worker]);

        if ($this->email !== '') {
            $this->rules['email'] = 'nullable|email|unique:workers,email,'.$this->worker->id;
        }

        // validate user input
        $this->validate();

        DB::transaction(
            function () {
                $this->worker->update([
                    'name' => htmlspecialchars($this->name),
                    'email' => $this->email !== '' ? trim(htmlspecialchars($this->email)) : null,
                    'phone' => htmlspecialchars($this->phone),
                    'bank_account_number' => trim(htmlspecialchars($this->bankAccountNumber)),
                    'bank_account_name' => trim(htmlspecialchars($this->bankAccountName)),
                ]);
                $this->worker->save();
            },
            2
        );

        $this->banner(__('Successfully updated the worker ":name"!', ['name' => htmlspecialchars($this->name)]));
        return redirect()->route('worker.manage');
    }

}
