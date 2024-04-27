<article x-data="{
    isModalOpen: $wire.$entangle('isModalOpen', true),
    coverImage: $wire.$entangle('cover_image_url', true),
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
        <button @click="isModalOpen = true" class="primary button margin-top-0"
                title="{{ __('New category') }}">
            <i class="fa fa-plus" aria-hidden="true"></i>
        </button>
    @else
        <button @click="isModalOpen = true" class="primary button margin-top-0">
            <i class="fa fa-plus" aria-hidden="true"></i>
            {{ __('New category') }}
        </button>
    @endif

    <x-global::form-modal trigger="isModalOpen" title="{{ $title }}" id="{{ $modalId }}">
        <form wire:submit="createCategory">

            <fieldset>
                <label for="name">{{ __('Category name') }}<span class="text-red">*</span></label>
                <input wire:model="name"
                       type="text"
                       class="{{ $errors->has('name') ? 'border border-red' : '' }}"
                       name="name"
                       id="name"
                >
                <x-global::input-error for="name"/>


                <label for="slug">{{ __('Category slug') }}<span class="text-red">*</span></label>
                <input wire:model="slug"
                       type="text"
                       class="{{ $errors->has('slug') ? 'border border-red' : '' }}"
                       name="slug"
                       id="slug"
                >
                <x-global::input-error for="slug"/>


                <!-- Cover image -->
                <label for="cover_image_url">{{ __('Cover Image (optional)') }}</label>

                <template x-if="isValidUrl(coverImage)">
                    <div class="relative fit-content">
                        <img x-bind:src="coverImage" alt="{{ __('Cover image') }}"
                             class="card card-4 margin-bottom-1 image-preview"/>
                        <button @click="coverImage = ''"
                                class="close-button absolute topright margin-top-0-5 margin-right-0-5"><i
                                class="fa fa-trash-alt"></i></button>
                    </div>
                </template>

                <div class="flex flex-row flex-nowrap">
                    <div>
                        <a id="lfm-new-root"
                           data-input="cover-image-url-new-root"
                           class="button info margin-top-0"
                        >
                            <i class="fa-solid fa-image"></i> {{ __('Choose') }}
                        </a>
                    </div>

                    <label for="cover-image-url-new-root" class="sr-only">{{ __('Cover image url') }}</label>
                    <input id="cover-image-url-new-root"
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
                    <span wire:loading wire:target="createCategory" class="animate-spin">&#9696;</span>
                    <span wire:loading.remove wire:target="createCategory">{{ __('Create') }}</span>
                </button>
                <button type="button"
                        class="alt primary"
                        wire:click="initialize"
                        @click="isModalOpen = false"
                >
                    {{ __('Cancel') }}
                </button>
            </div>
        </form>

        <script nonce="{{ csp_nonce() }}">
            document.addEventListener('livewire:init', function () {

                document.addEventListener("DOMContentLoaded", function () {
                    document.getElementById('lfm-new-root').addEventListener('click', (event) => {
                        event.preventDefault();
                        inputId = 'cover-image-url-new-root';
                        window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
                    });
                });

            });
        </script>

    </x-global::form-modal>
</article>
