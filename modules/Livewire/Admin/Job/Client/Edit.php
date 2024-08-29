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
use Modules\Job\Actions\Client\UpdateClient;
use Modules\Job\Enums\ClientType;
use Modules\Job\Models\Client;


class Edit extends Component
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
     * @var Client
     */
    public Client $client;


    /**
     * @var int
     */
    public int $clientId;


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
    public ?string $contactPerson = null;


    /**
     * @var string|null
     */
    public ?string $phoneNumber = null;


    /**
     * @var string|null
     */
    public ?string $email = null;


    /**
     * @var string|null
     */
    public ?string $taxNumber = null;


    /**
     * @var array|array[]
     */
    protected array $rules = [
        'name' => ['required', 'string', 'max:255'],
        'address' => ['required', 'string', 'max:255'],
        'type' => ['required', 'in:company,private person'],

        'contactPerson' => ['nullable', 'string', 'max:255'],
        'phoneNumber' => ['nullable', 'string', 'max:255'],
        'email' => ['nullable', 'email', 'max:255'],
        'taxNumber' => ['nullable', 'string', 'max:255'],
    ];


    /**
     * @param  Client  $client
     * @return void
     */
    public function mount(Client $client): void
    {
        $this->modalId = '';
        $this->isModalOpen = false;

        $this->client = $client;

        $this->name = $this->client->name ?? '';
        $this->address = $this->client->address ?? '';
        $this->type = $this->client->type;

        $this->typesArray = ClientType::options();

        if ($this->client->client_detail !== null) {
            $this->contactPerson = $this->client->client_detail->contact_person ?? null;
            $this->phoneNumber = $this->client->client_detail->phone_number ?? null;
            $this->email = $this->client->client_detail->email ?? null;
            $this->taxNumber = $this->client->client_detail->tax_number ?? null;
        }
    }


    /**
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
     */
    public function render(): Factory|View|Application|\Illuminate\Contracts\Foundation\Application
    {
        return view('admin.livewire.job.client.edit');
    }


    /**
     * @param  UpdateClient  $updateClient
     * @return Redirector
     * @throws AuthorizationException
     */
    public function updateClient(UpdateClient $updateClient): Redirector
    {
        $this->authorize('update', [Client::class, $this->client]);

        // validate user input
        $this->validate();

        DB::transaction(
            function () use ($updateClient) {

                $client = [
                    'name' => strip_tags(trim($this->name)),
                    'address' => strip_tags(trim($this->address)),
                    'type' => strip_tags(trim($this->type)),
                ];

                $details = [];
                // populate details if we have user input
                if (isset($this->contactPerson)) {
                    $details['contact_person'] = strip_tags(trim($this->contactPerson));
                }

                if (isset($this->phoneNumber)) {
                    $details['phone_number'] = strip_tags(trim($this->phoneNumber));
                }

                if (isset($this->email)) {
                    $details['email'] = strip_tags(trim($this->email));
                }

                if (isset($this->taxNumber)) {
                    $details['tax_number'] = strip_tags(trim($this->taxNumber));
                }

                $updateClient($this->client, $client, $details, $this->client->client_detail_id);
            }
        );

        $this->banner(__('Successfully updated the client ":name"!', ['name' => strip_tags($this->name)]));
        return redirect()->route('client.manage');
    }

}
