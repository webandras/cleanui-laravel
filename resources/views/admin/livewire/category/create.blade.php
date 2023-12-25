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
        <button @click="isModalOpen = true" class="success alt" title="{{ __('New subcategory') }}">
            <i class="fa fa-plus"></i>
        </button>
    @else
        <button @click="isModalOpen = true" class="success alt">
            <i class="fa fa-plus"></i>{{ __('New subcategory') }}
        </button>
    @endif

    <x-global::form-modal
        trigger="isModalOpen"
        title="{{ __('Add subcategory') }}"
        id="{{ $modalId }}"
    >
        <form wire:submit.prevent="createCategory">

            <fieldset>
                <label for="name">{{ __('Subcategory name') }}<span class="text-red">*</span></label>
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


                <label for="slug">{{ __('Subcategory slug') }}<span class="text-red">*</span></label>
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

            </fieldset>

            <input
                wire:model.defer="categoryId"
                disabled
                type="number"
                class="hidden"
                name="categoryId"
                value="{{ $categoryId }}"
            >

            <!-- Cover image -->

            <label for="cover_image_url">{{ __('Cover Image') }}</label>

            <template x-if="isValidUrl(coverImage)">
                <div class="relative" style="width: fit-content">
                    <img x-bind:src="coverImage" alt="{{ __('Cover image') }}"
                         class="card card-4 margin-bottom-1 image-preview"/>
                    <button @click="coverImage = ''" class="close-button absolute topright margin-top-0-5 margin-right-0-5"><i
                            class="fa fa-trash-alt"></i></button>
                </div>
            </template>

            <div class="flex flex-row flex-nowrap margin-bottom-1">
                <div>
                    <a id="lfm-new-{{$categoryId}}"
                       data-input="cover-image-url-new-{{$categoryId}}"
                       class="button info margin-top-0 fs-14"
                    >
                        <i class="fa-solid fa-image"></i> {{ __('Choose') }}
                    </a>
                </div>

                <input id="cover-image-url-new-{{$categoryId}}"
                       class="small-input {{ $errors->has('cover_image_url') ? ' border border-red' : '' }}"
                       type="text"
                       readonly
                       wire:model="cover_image_url"
                       name="cover_image_url"
                />
            </div>
            <x-global::input-error for="cover_image_url"/>


            <div class="actions">
                <button type="submit" class="primary">
                    <span wire:loading wire:target="createCategory" class="animate-spin">&#9696;</span>
                    <span wire:loading.remove wire:target="createCategory">{{ __('Create') }}</span>
                </button>

                <button
                    type="button"
                    class="primary alt"
                    wire:click="initialize"
                    @click="isModalOpen = false"
                >
                    {{ __('Cancel') }}
                </button>
            </div>

        </form>

        <script nonce="{{ csp_nonce() }}">
            document.addEventListener('livewire:load', function () {
                lfm(
                    'lfm-new-{{ $category->id }}',
                    'image',
                    {
                        type: 'image',
                        prefix: route_prefix
                    },
                    function (file_path) {
                        // trigger input value change by JS. Livewire only updates the property on keyboard input event!
                    @this.cover_image_url = file_path;
                    }
                );
            });
        </script>

    </x-global::form-modal>
</div>
