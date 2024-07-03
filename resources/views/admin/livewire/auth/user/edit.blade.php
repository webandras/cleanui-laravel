<article x-data="{
    isModalOpen: $wire.$entangle('isModalOpen', true)
}">

    @if ($hasSmallButton)
        <button @click="isModalOpen = true" class="info margin-top-0" title="{{ __('Edit User') }}">
            <i class="fa fa-pencil"></i>
        </button>
    @else
        <button @click="isModalOpen = true" class="info margin-top-0">
            <i class="fa fa-pencil"></i>{{ __('Edit') }}
        </button>
    @endif

    <x-global::form-modal
        trigger="isModalOpen"
        title="{{ __('Edit User') }}"
        id="{{ $modalId }}"
    >
        <form wire:submit="updateUser">

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
                <label for="email">{{ __('Email (can not be changed)') }}</label>
                <input
                    wire:model="email"
                    type="email"
                    name="email"
                    id="email"
                    readonly
                >
                <x-global::input-error for="email"/>


                <!-- Password -->
                <label for="password">{{ __('New Password (optional)') }}</label>
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
                    @if($role === null)
                        <option selected>{{ __("Select the role") }}</option>
                    @endif

                    @foreach ($rolesArray as $key => $value)
                        <option {{ $role === $key ? "selected": "" }} value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                </select>

                <x-global::input-error for="role"/>

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
                    class="alt primary"
                    @click="isModalOpen = false"
                >
                    {{ __('Cancel') }}
                </button>
            </div>

        </form>

    </x-global::form-modal>
</article>

