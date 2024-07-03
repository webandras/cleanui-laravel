<article x-data="{ isModalOpen: $wire.$entangle('isModalOpen', true) }">

    @if ($hasSmallButton)
        <button @click="isModalOpen = true" class="info margin-top-0" title="{{ __('Edit location') }}">
            <i class="fa fa-pencil" aria-hidden="true"></i>
        </button>
    @else
        <button @click="isModalOpen = true" class="info margin-top-0">
            <i class="fa fa-pencil" aria-hidden="true"></i>
            <span>{{ __('Edit') }}</span>
        </button>
    @endif

    <x-global::form-modal
        trigger="isModalOpen"
        title="{{ __('Edit location') }}"
        id="{{ $modalId }}"
    >
        <form wire:submit="updateLocation">
            <fieldset>
                <!-- Name -->
                <label for="name">{{ __('Location name') }}<span class="text-red">*</span></label>
                <input wire:model="name"
                       type="text"
                       class="{{ $errors->has('name') ? 'border border-red' : '' }}"
                       name="name"
                       autofocus
                >
                <p class="{{ $errors->has('name') ? 'error-message' : '' }}">
                    {{ $errors->has('name') ? $errors->first('name') : '' }}
                </p>

                <!-- City -->
                <label for="city">{{ __('City') }}<span class="text-red">*</span></label>
                <input wire:model="city"
                       type="text"
                       class="{{ $errors->has('city') ? 'border border-red' : '' }}"
                       name="city"
                >

                <p class="{{ $errors->has('city') ? 'error-message' : '' }}">
                    {{ $errors->has('city') ? $errors->first('city') : '' }}
                </p>


                <!-- Address -->
                <label for="address">{{ __('Address') }}<span class="text-red">*</span></label>
                <input wire:model="address"
                       type="text"
                       class="{{ $errors->has('address') ? 'border border-red' : '' }}"
                       name="address"
                >

                <p class="{{ $errors->has('address') ? 'error-message' : '' }}">
                    {{ $errors->has('address') ? $errors->first('address') : '' }}
                </p>


                <!-- Slug -->
                <label for="slug">{{ __('Slug') }}<span class="text-red">*</span></label>
                <input wire:model="slug"
                       type="text"
                       class="{{ $errors->has('slug') ? 'border border-red' : '' }}"
                       name="slug"
                >

                <p class="{{ $errors->has('slug') ? 'error-message' : '' }}">
                    {{ $errors->has('slug') ? $errors->first('slug') : '' }}
                </p>


                <div class="form-row">
                    <div class="col s6">
                        <!-- Latitude -->
                        <label for="latitude">{{ __('Latitude') }}<span class="text-red">*</span></label>
                        <input wire:model="latitude"
                               type="text"
                               class="{{ $errors->has('latitude') ? 'border border-red' : '' }}"
                               name="latitude"
                        >

                        <p class="{{ $errors->has('latitude') ? 'error-message' : '' }}">
                            {{ $errors->has('latitude') ? $errors->first('latitude') : '' }}
                        </p>
                    </div>
                    <div class="col s6">
                        <!-- Logitude -->
                        <label for="longitude">{{ __('Longitude') }}<span class="text-red">*</span></label>
                        <input wire:model="longitude"
                               type="text"
                               class="{{ $errors->has('longitude') ? 'border border-red' : '' }}"
                               name="longitude"
                        >
                        <p class="{{ $errors->has('longitude') ? 'error-message' : '' }}">
                            {{ $errors->has('longitude') ? $errors->first('longitude') : '' }}
                        </p>

                    </div>
                </div>

            </fieldset>

            <div class="actions">
                <button type="submit" class="primary">
                    <span wire:loading wire:target="updateLocation" class="animate-spin">&#9696;</span>
                    <span wire:loading.remove wire:target="updateLocation">{{ __('Update') }}</span>
                </button>
                <button type="button" class="primary alt" @click="isModalOpen = false">
                    {{ __('Cancel') }}
                </button>
            </div>
        </form>

    </x-global::form-modal>
</article>
