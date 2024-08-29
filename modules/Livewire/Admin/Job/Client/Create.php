<?php

namespace Modules\Livewire\Admin\Job\Client;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Features\SupportRedirects\Redirector;
use Modules\Clean\Traits\InteractsWithBanner;
use Modules\Job\Actions\Client\CreateClient;
use Modules\Job\Enums\ClientType;
use Modules\Job\Models\Client;


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
     * @var string
     */
    public string $name;


    /**
     * @var string
     */
    public string $address;


    /**
     * @var string
     */
    public string $type;


    /**
     * @var array
     */
    public array $typesArray;


    /**
     * @var string|null
     */
    public ?string $contactPerson;


    /**
     * @var string|null
     */
    public ?string $phoneNumber;


    /**
     * @var string|null
     */
    public ?string $email;


    /**
     * @var string|null
     */
    public ?string $taxNumber;


    /**
     * @var array|array[]
     */
    protected array $rules = [
        'name' => ['required', 'string', 'max:255', 'unique:clients'],
        'address' => ['required', 'string', 'max:255'],
        'type' => ['required', 'string', 'in:company,private person'],

        'contactPerson' => ['nullable', 'string', 'max:255'],
        'phoneNumber' => ['nullable', 'string', 'max:255'],
        'email' => ['nullable', 'email', 'max:255'],
        'taxNumber' => ['nullable', 'string', 'max:255'],
    ];


    /**
     * @return void
     */
    public function mount(): void
    {
        $this->modalId = 'm-new-client';
        $this->isModalOpen = false;

        $this->name = '';
        $this->address = '';
        $this->type = '';

        $this->contactPerson = null;
        $this->phoneNumber = null;
        $this->email = null;
        $this->taxNumber = null;

        $this->typesArray = ClientType::options();
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
     */
    public function render(): Factory|View|Application|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.livewire.job.client.create');
    }


    /**
     * @param  CreateClient  $createClient
     * @return Redirector
     * @throws AuthorizationException
     */
    public function createClient(CreateClient $createClient): Redirector
    {
        $this->authorize('create', Client::class);

        // validate user input
        $this->validate();

        DB::transaction(
            function () use ($createClient) {

                $details = [];
                // populate details if the props are set
                if (isset($this->contactPerson)) {
                    $details['contact_person'] = strip_tags($this->contactPerson);
                }

                if (isset($this->phoneNumber)) {
                    $details['phone_number'] = strip_tags($this->phoneNumber);
                }

                if (isset($this->email)) {
                    $details['email'] = strip_tags($this->email);
                }

                if (isset($this->taxNumber)) {
                    $details['tax_number'] = strip_tags($this->taxNumber);
                }

                $clientData = [
                    'name' => strip_tags($this->name),
                    'address' => strip_tags($this->address),
                    'type' => strip_tags($this->type),
                ];

                $createClient($clientData, $details);
            }
        );

        $this->banner(__('Successfully created the client ":name"!', ['name' => strip_tags($this->name)]));
        return redirect()->route('client.manage');
    }

}
