<div x-data="{ isModalOpen: $wire.entangle('isModalOpen') }">

    @if ($hasSmallButton)
        <button @click="isModalOpen = true" class="primary" title="{{ __('New location') }}">
            <i class="fa fa-plus"></i>
        </button>
    @else
        <button @click="isModalOpen = true" class="primary">
            <i class="fa fa-plus"></i>{{ __('New location') }}
        </button>
    @endif

    <x-global::form-modal
        trigger="isModalOpen"
        title="{{ __('New location') }}"
        id="{{ $modalId }}"
    >
        <form wire:submit.prevent="createLocation">
            <fieldset>
                <!-- Name -->
                <label for="name">{{ __('Location name') }}<span class="text-red">*</span></label>
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

                <!-- City -->
                <label for="city">{{ __('City') }}<span class="text-red">*</span></label>
                <input wire:model.defer="city"
                       type="text"
                       class="{{ $errors->has('city') ? 'border border-red' : '' }}"
                       name="city"
                >

                <div
                    class="{{ $errors->has('city') ? 'error-message' : '' }}">
                    {{ $errors->has('city') ? $errors->first('city') : '' }}
                </div>


                <!-- Address -->
                <label for="address">{{ __('Address') }}<span class="text-red">*</span></label>
                <input wire:model.defer="address"
                       type="text"
                       class="{{ $errors->has('address') ? 'border border-red' : '' }}"
                       name="address"
                >

                <div
                    class="{{ $errors->has('address') ? 'error-message' : '' }}">
                    {{ $errors->has('address') ? $errors->first('address') : '' }}
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

                <div class="form-row">
                    <div class="col s6">
                        <!-- Latitude -->
                        <label for="latitude">{{ __('Latitude') }}<span class="text-red">*</span></label>
                        <input wire:model.defer="latitude"
                               type="text"
                               class="{{ $errors->has('latitude') ? 'border border-red' : '' }}"
                               name="latitude"
                        >

                        <div
                            class="{{ $errors->has('latitude') ? 'error-message' : '' }}">
                            {{ $errors->has('latitude') ? $errors->first('latitude') : '' }}
                        </div>
                    </div>
                    <div class="col s6">
                        <!-- Longitude -->
                        <label for="longitude">{{ __('Longitude') }}<span class="text-red">*</span></label>
                        <input wire:model.defer="longitude"
                               type="text"
                               class="{{ $errors->has('longitude') ? 'border border-red' : '' }}"
                               name="longitude"
                        >

                        <div
                            class="{{ $errors->has('longitude') ? 'error-message' : '' }}">
                            {{ $errors->has('longitude') ? $errors->first('longitude') : '' }}
                        </div>

                    </div>
                </div>
            </fieldset>

            <div class="actions">
                <button type="submit" class="primary">
                    <span wire:loading wire:target="createLocation" class="animate-spin">&#9696;</span>
                    <span wire:loading.remove wire:target="createLocation">{{ __('Update') }}</span>
                </button>
                <button type="button" class="primary alt" @click="isModalOpen = false">
                    {{ __('Cancel') }}
                </button>
            </div>
        </form>

    </x-global::form-modal>
</div>

