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
}"
>

    @if ($hasSmallButton)
        <button @click="isModalOpen = true" class="success alt" title="{{ __('Subcategory') }}">
            <i class="fa fa-plus"></i>
        </button>
    @else
        <button @click="isModalOpen = true" class="success alt">
            <i class="fa fa-plus"></i>{{ __('Subcategory') }}
        </button>
    @endif

    <x-global::form-modal
        trigger="isModalOpen"
        title="{{ __('Add subcategory') }}"
        id="{{ $modalId }}"
    >
        <form wire:submit="createCategory">

            <fieldset>
                <label for="name">{{ __('Subcategory name') }}<span class="text-red">*</span></label>
                <input
                    wire:model="name"
                    type="text"
                    class="{{ $errors->has('name') ? 'border border-red' : '' }}"
                    name="name"
                    id="name"
                >
                <x-global::input-error for="name"/>


                <label for="slug">{{ __('Subcategory slug') }}<span class="text-red">*</span></label>
                <input
                    wire:model="slug"
                    type="text"
                    class="{{ $errors->has('slug') ? 'border border-red' : '' }}"
                    name="slug"
                    id="slug"
                >
                <x-global::input-error for="slug"/>


            </fieldset>

            <label for="categoryId" class="sr-only">{{ __('Category Id') }}</label>
            <input
                wire:model="categoryId"
                disabled
                type="number"
                class="hidden"
                name="categoryId"
                id="categoryId"
            >

            <!-- Cover image -->
            <label for="cover_image_url">{{ __('Cover Image') }}</label>

            <template x-if="isValidUrl(coverImage)">
                <div class="relative fit-content">
                    <img x-bind:src="coverImage" alt="{{ __('Cover image') }}"
                         class="card card-4 margin-bottom-1 image-preview"/>
                    <button @click="coverImage = ''"
                            class="close-button absolute topright margin-top-0-5 margin-right-0-5"><i
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

                <label for="cover-image-url-new-{{$categoryId}}" class="sr-only">{{ __('Cover image') }}</label>
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
            document.addEventListener('livewire:init', function () {

                document.addEventListener("DOMContentLoaded", function () {
                    document.getElementById('lfm-new-{{ $categoryId }}').addEventListener('click', (event) => {
                        event.preventDefault();
                        inputId = 'cover-image-url-new-{{$categoryId}}';
                        window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
                    });
                });
            });
        </script>

    </x-global::form-modal>
</article>
