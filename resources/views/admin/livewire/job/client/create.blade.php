<article x-data="{
    isModalOpen: $wire.$entangle('isModalOpen', true)
}">

    <button @click="isModalOpen = true" class="primary">
        <i class="fa fa-plus"></i>{{ __('New client') }}
    </button>

    <x-global::form-modal
        trigger="isModalOpen"
        title="{{ __('Add Client') }}"
        id="{{ $modalId }}"
    >
        <form wire:submit="createClient">

            <fieldset>
                <!-- Name -->
                <label for="name">{{ __('Name') }}<span class="text-red">*</span></label>
                <input
                    wire:model="name"
                    type="text"
                    class="{{ $errors->has('name') ? 'border border-red' : '' }}"
                    name="name"
                >

                <div class="{{ $errors->has('name') ? 'error-message' : '' }}">
                    {{ $errors->has('name') ? $errors->first('name') : '' }}
                </div>


                <!-- Email -->
                <label for="address">{{ __('Address') }}<span class="text-red">*</span></label>
                <input
                    wire:model="address"
                    type="text"
                    class="{{ $errors->has('address') ? 'border border-red' : '' }}"
                    name="address"
                >

                <p class="{{ $errors->has('address') ? 'error-message' : '' }}">
                    {{ $errors->has('address') ? $errors->first('address') : '' }}
                </p>

                <!-- Role -->
                <label for="type">{{ __('Type') }}<span class="text-red">*</span></label>
                <select
                    wire:model="type"
                    class="{{ $errors->has('type') ? 'border border-red' : '' }}"
                    aria-label="{{ __("Select a client type") }}"
                    name="role"
                    id="role"
                >

                    <option selected>{{ __("Select the type") }}</option>

                    @foreach ($typesArray as $key => $value)
                        <option name="type" value="{{ $key }}">{{ $value }}</option>
                    @endforeach

                </select>

                <p class="{{ $errors->has('type') ? 'error-message' : '' }}">
                    {{ $errors->has('type') ? $errors->first('type') : '' }}
                </p>

            </fieldset>

            <fieldset>
                <!-- $contactPerson -->
                <label for="contactPerson">{{ __('Contact Person\'s name') }}</label>
                <input
                    wire:model="contactPerson"
                    type="text"
                    class="{{ $errors->has('contactPerson') ? 'border border-red' : '' }}"
                >

                <p class="{{ $errors->has('contactPerson') ? 'error-message' : '' }}">
                    {{ $errors->has('contactPerson') ? $errors->first('contactPerson') : '' }}
                </p>

                <!-- phoneNumber -->
                <label for="phoneNumber">{{ __('Phone number') }}</label>
                <input
                    wire:model="phoneNumber"
                    type="text"
                    class="{{ $errors->has('phoneNumber') ? 'border border-red' : '' }}"
                    name="phoneNumber"
                >

                <p class="{{ $errors->has('phoneNumber') ? 'error-message' : '' }}">
                    {{ $errors->has('phoneNumber') ? $errors->first('phoneNumber') : '' }}
                </p>

                <!-- $email -->
                <label for="email">{{ __('Email') }}</label>
                <input
                    wire:model="email"
                    type="email"
                    class="{{ $errors->has('email') ? 'border border-red' : '' }}"
                >

                <p class="{{ $errors->has('email') ? 'error-message' : '' }}">
                    {{ $errors->has('email') ? $errors->first('email') : '' }}
                </p>


                <!-- $taxNumber -->
                <label for="taxNumber">{{ __('Tax number') }}</label>
                <input
                    wire:model="taxNumber"
                    type="text"
                    class="{{ $errors->has('taxNumber') ? 'border border-red' : '' }}"
                >

                <p class="{{ $errors->has('taxNumber') ? 'error-message' : '' }}">
                    {{ $errors->has('taxNumber') ? $errors->first('taxNumber') : '' }}
                </p>

            </fieldset>


            <div class="actions">
                <button type="submit" class="primary">
                    <span wire:loading wire:target="createClient" class="animate-spin">&#9696;</span>
                    <span wire:loading.remove wire:target="createClient">
                        <i class="fa fa-floppy-disk" aria-hidden="true"></i>
                        {{ __('Save') }}
                    </span>
                </button>

                <button
                    type="button"
                    class="alt"
                    @click="isModalOpen = false"
                >
                    {{ __('Cancel') }}
                </button>
            </div>

        </form>

    </x-global::form-modal>
</article>
