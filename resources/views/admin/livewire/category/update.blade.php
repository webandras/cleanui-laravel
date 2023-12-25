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
}"
>

    @if ($hasSmallButton)
        <button @click="isModalOpen = true" class="info" title="{{ __('Edit category') }}">
            <i class="fa fa-pencil" aria-hidden="true"></i>
        </button>
    @else
        <button @click="isModalOpen = true" class="info">
            <i class="fa fa-pencil" aria-hidden="true"></i>
            <span>{{ __('Edit') }}</span>
        </button>
    @endif

    <x-global::form-modal
        trigger="isModalOpen"
        title="{{ __('Edit category') }}"
        id="{{ $modalId }}"
    >
        <form wire:submit.prevent="updateCategory">
            <h2 class="h3">{{ $name }}</h2>
            <hr class="divider">

            <fieldset>
                <label for="name">{{ __('Category name') }}<span class="text-red">*</span></label>
                <input wire:model.defer="name"
                       type="text"
                       class="{{ $errors->has('name') ? 'border border-red' : '' }}"
                       name="name"
                >

                <div
                    class="{{ $errors->has('name') ? 'error-message' : '' }}">
                    {{ $errors->has('name') ? $errors->first('name') : '' }}
                </div>

                <label for="slug">{{ __('Category slug') }}<span class="text-red">*</span></label>
                <input wire:model.defer="slug"
                       type="text"
                       class="{{ $errors->has('slug') ? 'border border-red' : '' }}"
                       name="name"
                >
                <div
                    class="{{ $errors->has('slug') ? 'error-message' : '' }}">
                    {{ $errors->has('slug') ? $errors->first('slug') : '' }}
                </div>


                <!-- Cover Image Url -->
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
                        <a id="lfm-{{ $category->id }}"
                           data-input="cover-image-url-{{ $category->id }}"
                           class="button info margin-top-0 fs-14">
                            <i class="fa-solid fa-image"></i> {{ __('Choose') }}
                        </a>
                    </div>


                    <input
                        id="cover-image-url-{{ $category->id }}"
                        class="small-input {{ $errors->has('cover_image_url') ? ' border border-red' : '' }}"
                        type="text"
                        readonly
                        wire:model.lazy="cover_image_url"
                        name="cover_image_url"
                    />

                </div>

                <x-global::input-error for="cover_image_url"/>

            </fieldset>

            <div class="actions">
                <button type="submit" class="primary">
                    <span wire:loading wire:target="updateCategory" class="animate-spin">&#9696;</span>
                    <span wire:loading.remove wire:target="updateCategory">{{ __('Update') }}</span>
                </button>
                <button type="button"
                        class="primary alt"
                        @click="isModalOpen = false"
                >
                    {{ __('Cancel') }}
                </button>
            </div>
        </form>

        <script nonce="{{ csp_nonce() }}">
            document.addEventListener('livewire:load', function () {
                // trigger input value change by JS. Livewire only updates the property on keyboard input event!
                lfm(
                    'lfm-{{ $category->id }}',
                    'image',
                    {
                        type: 'image',
                        prefix: route_prefix
                    },
                    function (file_path) {
                        // trigger input value change by JS. Livewire only updates the property on keyboard input event!
                    @this.cover_image_url
                        = file_path;
                    });
            });
        </script>

    </x-global::form-modal>
</div>
