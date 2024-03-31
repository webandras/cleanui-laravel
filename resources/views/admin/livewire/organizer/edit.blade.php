<div x-data="{ isModalOpen: $wire.entangle('isModalOpen') }">

    @if ($hasSmallButton)
        <button @click="isModalOpen = true" class="info margin-top-0" title="{{ __('Edit organizer') }}">
            <i class="fa fa-plus"></i>
        </button>
    @else
        <button @click="isModalOpen = true" class="info margin-top-0">
            <i class="fa fa-pencil" aria-hidden="true"></i>{{ __('Edit') }}
        </button>
    @endif

    <x-global::form-modal
        trigger="isModalOpen"
        title="{{ __('Edit organizer') }}"
        id="{{ $modalId }}"
    >
        <form wire:submit.prevent="updateOrganizer">
            <h2 class="h3">{{ $name }}</h2>
            <hr class="divider">

            <fieldset>

                <!-- Name -->
                <label for="name">{{ __('Organizer name') }}<span class="text-red">*</span></label>
                <input wire:model.defer="name"
                       type="text"
                       class="{{ $errors->has('name') ? 'border border-red' : '' }}"
                       name="name"
                       autofocus
                >

                <div
                    class="{{ $errors->has('name') ? 'error-message' : '' }}">
                    {{ $errors->has('name') ? $errors->first('name') : '' }}
                </div>


                <!-- Slug -->
                <label for="slug">{{ __('Slug') }}<span class="text-red">*</span></label>
                <input wire:model.defer="slug"
                       type="text"
                       class="{{ $errors->has('slug') ? 'border border-red' : '' }}"
                       name="slug"
                >

                <div
                    class="{{ $errors->has('slug') ? 'error-message' : '' }}">
                    {{ $errors->has('slug') ? $errors->first('slug') : '' }}
                </div>

                <!-- Facebook url -->
                <label for="facebook_url">{{ __('Facebook URL') }}<span class="text-red">*</span></label>
                <input wire:model.defer="facebook_url"
                       type="url"
                       class="{{ $errors->has('facebook_url') ? 'border border-red' : '' }}"
                       name="facebook_url"
                >

                <div
                    class="{{ $errors->has('facebook_url') ? 'error-message' : '' }}">
                    {{ $errors->has('facebook_url') ? $errors->first('facebook_url') : '' }}
                </div>

            </fieldset>

            <div class="actions">
                <button type="submit" class="primary">
                    <span wire:loading wire:target="updateOrganizer" class="animate-spin">&#9696;</span>
                    <span wire:loading.remove wire:target="updateOrganizer">{{ __('Update') }}</span>
                </button>
                <button type="button" class="primary alt" @click="isModalOpen = false">
                    {{ __('Cancel') }}
                </button>
            </div>
        </form>

    </x-global::form-modal>
</div>
