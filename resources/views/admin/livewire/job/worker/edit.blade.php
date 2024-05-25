<article x-data="{
    isModalOpen: $wire.$entangle('isModalOpen', true)
}">

    @if ($hasSmallButton)
        <button @click="isModalOpen = true" class="success margin-top-0" title="{{ __('Edit Worker') }}">
            <i class="fa fa-pencil"></i>
        </button>
    @else
        <button @click="isModalOpen = true" class="success margin-top-0">
            <i class="fa fa-pencil"></i>{{ __('Edit') }}
        </button>
    @endif

    <x-global::form-modal
        trigger="isModalOpen"
        title="{{ __('Edit Worker') }}"
        id="{{ $modalId }}"
    >
        <form wire:submit="updateWorker">

            <fieldset>
                <!-- Name -->
                <label for="name">{{ __('Name') }}<span class="text-red">*</span></label>
                <input
                    wire:model="name"
                    type="text"
                    class="{{ $errors->has('name') ? 'border border-red' : '' }}"
                    name="name"
                >

                <p class="{{ $errors->has('name') ? 'error-message' : '' }}">
                    {{ $errors->has('name') ? $errors->first('name') : '' }}
                </p>


                <!-- Email -->
                <label for="email">{{ __('Email') }}</label>
                <input
                    wire:model="email"
                    type="email"
                    name="name"
                >

                <p class="{{ $errors->has('email') ? 'error-message' : '' }}">
                    {{ $errors->has('email') ? $errors->first('email') : '' }}
                </p>


                <!-- Phone number -->
                <label for="phone">{{ __('Phone number') }}</label>
                <input
                    wire:model="phone"
                    type="text"
                    class="{{ $errors->has('phone') ? 'border border-red' : '' }}"
                    name="phone"
                >

                <p class="{{ $errors->has('phone') ? 'error-message' : '' }}">
                    {{ $errors->has('phone') ? $errors->first('phone') : '' }}
                </p>

                <hr>

                <!-- Bank Account Name -->
                <label for="bankAccountName">{{ __('Bank account name') }}</label>
                <input
                    wire:model="bankAccountName"
                    type="text"
                    class="{{ $errors->has('bankAccountName') ? 'border border-red' : '' }}"
                    name="bankAccountName"
                >

                <p class="{{ $errors->has('bankAccountName') ? 'error-message' : '' }}">
                    {{ $errors->has('bankAccountName') ? $errors->first('bankAccountName') : '' }}
                </p>


                <!-- Bank Account Number -->
                <label for="bankAccountNumber">{{ __('Bank account number') }}</label>
                <input
                    wire:model="bankAccountNumber"
                    type="text"
                    class="{{ $errors->has('bankAccountNumber') ? 'border border-red' : '' }}"
                    name="bankAccountNumber"
                >

                <p class="{{ $errors->has('bankAccountNumber') ? 'error-message' : '' }}">
                    {{ $errors->has('bankAccountNumber') ? $errors->first('bankAccountNumber') : '' }}
                </p>

            </fieldset>


            <div class="actions">
                <button type="submit" class="primary">
                    <span wire:loading wire:target="updateUser" class="animate-spin">&#9696;</span>
                    <span wire:loading.remove wire:target="updateUser">
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

