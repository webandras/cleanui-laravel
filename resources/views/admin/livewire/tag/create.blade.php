<div x-data="{
    isModalOpen: $wire.entangle('isModalOpen'),
    coverImage: $wire.entangle('cover_image_url'),
    isValidUrl: function(urlString) {
        try {
            return Boolean(new URL(urlString));
        }
        catch(e){
            return false;
        }
    }
}">

    @if ($hasSmallButton)
        <button @click="isModalOpen = true" class="primary" title="{{ __('New tag') }}">
            <i class="fa fa-plus"></i>
        </button>
    @else
        <button @click="isModalOpen = true" class="primary">
            <i class="fa fa-plus"></i>{{ __('New tag') }}
        </button>
    @endif

    <x-global::form-modal
        trigger="isModalOpen"
        title="{{ __('Add tag') }}"
        id="{{ $modalId }}"
    >
        <form wire:submit.prevent="createTag">

            <fieldset>
                <label for="name">{{ __('Tag name') }}<span class="text-red">*</span></label>
                <input
                    wire:model.defer="name"
                    type="text"
                    class="{{ $errors->has('name') ? 'border border-red' : '' }}"
                    name="name"
                    value=""
                >

                <div class="{{ $errors->has('name') ? 'error-message' : '' }}">
                    {{ $errors->has('name') ? $errors->first('name') : '' }}
                </div>


                <label for="slug">{{ __('Slug of the tag') }}<span class="text-red">*</span></label>
                <input
                    wire:model.defer="slug"
                    type="text"
                    class="{{ $errors->has('slug') ? 'border border-red' : '' }}"
                    name="slug"
                    value=""
                >

                <div class="{{ $errors->has('slug') ? 'error-message' : '' }}">
                    {{ $errors->has('slug') ? $errors->first('slug') : '' }}
                </div>


                <!-- Cover image -->
                <label for="cover_image_url">{{ __('Cover Image (optional)') }}</label>

                <template x-if="isValidUrl(coverImage)">
                    <div class="relative" style="width: fit-content">
                        <img x-bind:src="coverImage" alt="{{ __('Cover image') }}"
                             class="card card-4 margin-bottom-1 image-preview"/>
                        <button @click="coverImage = ''" class="close-button absolute topright margin-top-0-5 margin-right-0-5"><i
                                class="fa fa-trash-alt"></i></button>
                    </div>
                </template>

                <div class="flex flex-row flex-nowrap">
                    <div>
                        <a id="lfm-new-tag"
                           data-input="cover-image-url-new-tag"
                           class="button info margin-top-0"
                        >
                            <i class="fa-solid fa-image"></i> {{ __('Choose') }}
                        </a>
                    </div>

                    <input id="cover-image-url-new-tag"
                           class="small-input {{ $errors->has('cover_image_url') ? ' border border-red' : '' }}"
                           type="text"
                           readonly
                           wire:model="cover_image_url"
                           name="cover_image_url"
                    />

                </div>
                <x-global::input-error for="cover_image_url"/>

            </fieldset>

            <div class="actions">
                <button type="submit" class="primary">
                    <span wire:loading wire:target="createTag" class="animate-spin">&#9696;</span>
                    <span wire:loading.remove wire:target="createTag">{{ __('Create') }}</span>
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
</div>
