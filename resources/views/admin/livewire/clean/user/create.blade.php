<article x-data="{
    isModalOpen: $wire.$entangle('isModalOpen', true)
}">

    @if ($hasSmallButton)
        <button @click="isModalOpen = true" class="primary" title="{{ __('New User') }}">
            <i class="fa fa-plus"></i>
        </button>
    @else
        <button @click="isModalOpen = true" class="primary">
            <i class="fa fa-plus"></i>{{ __('New user') }}
        </button>
    @endif

    <x-global::form-modal
        trigger="isModalOpen"
        title="{{ __('Add User') }}"
        id="{{ $modalId }}"
    >
        <form wire:submit="createUser">

            <fieldset>
                <!-- Name -->
                <label for="name">{{ __('Name') }}<span class="text-red">*</span></label>
                <input
                    wire:model="name"
                    type="text"
                    class="{{ $errors->has('name') ? 'border border-red' : '' }}"
                    name="name"
                    id="name"
                >
                <x-global::input-error for="name"/>


                <!-- Email -->
                <label for="email">{{ __('Email') }}<span class="text-red">*</span></label>
                <input
                    wire:model="email"
                    type="email"
                    class="{{ $errors->has('email') ? 'border border-red' : '' }}"
                    name="email"
                    id="email"
                >
                <x-global::input-error for="email"/>


                <!-- Password -->
                <label for="password">{{ __('Password') }}<span class="text-red">*</span></label>
                <input
                    wire:model="password"
                    type="text"
                    class="{{ $errors->has('password') ? 'border border-red' : '' }}"
                    name="password"
                    id="password"
                >
                <x-global::input-error for="password"/>


                <!-- Role -->
                <label for="role">{{ __('Role') }}<span class="text-red">*</span></label>
                <select
                    wire:model="role"
                    class="{{ $errors->has('role') ? 'border border-red' : '' }}"
                    aria-label="{{ __("Select a role") }}"
                    name="role"
                    id="role"
                >
                    <option selected>{{ __("Select the role") }}</option>

                    @foreach ($rolesArray as $key => $value)
                        <option name="role" value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>

                <x-global::input-error for="role"/>

            </fieldset>


            <div class="actions">
                <button type="submit" class="primary">
                    <span wire:loading wire:target="createUser" class="animate-spin">&#9696;</span>
                    <span wire:loading.remove wire:target="createUser">
                        <i class="fa fa-floppy-disk" aria-hidden="true"></i>
                        {{ __('Save') }}
                    </span>
                </button>

                <button type="button"
                        class="alt primary"
                        @click="isModalOpen = false"
                >
                    {{ __('Cancel') }}
                </button>
            </div>

        </form>

    </x-global::form-modal>
</article>
