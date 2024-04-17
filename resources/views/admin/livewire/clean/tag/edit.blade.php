<div x-data="{
        isUploading: false,
        progress: 0,
        isModalOpen: $wire.$entangle('isModalOpen', true)
    }"
     x-on:livewire-upload-start="isUploading = true"
     x-on:livewire-upload-finish="isUploading = false"
     x-on:livewire-upload-error="isUploading = false"
     x-on:livewire-upload-progress="progress = $event.detail.progress"
>

    @if ($hasSmallButton)
        <button @click="isModalOpen = true" class="info margin-top-0" title="{{ __('Edit tag') }}">
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
        title="{{ __('Edit tag') }}"
        id="{{ $modalId }}"
    >
        <form wire:submit="updateTag">
            <h2 class="h3">{{ $name }}</h2>
            <hr class="divider">

            <fieldset>
                <label for="name">{{ __('Tag name') }}<span class="text-red">*</span></label>
                <input wire:model="name"
                       type="text"
                       class="{{ $errors->has('name') ? 'border border-red' : '' }}"
                       name="name"
                       id="name"
                >
                <x-global::input-error for="name"/>


                <label for="slug">{{ __('Slug') }}<span class="text-red">*</span></label>
                <input wire:model="slug"
                       type="text"
                       class="{{ $errors->has('slug') ? 'border border-red' : '' }}"
                       name="slug"
                       id="slug"
                >
                <x-global::input-error for="slug"/>


                <!-- Cover Image Url -->
                <label for="cover_image_url">{{ __('Cover Image (optional)') }}</label>

                @if (isset($cover_image))
                    <div class="relative" style="width: fit-content">
                        <small>Photo Preview:</small>
                        <img src="{{ $cover_image->temporaryUrl() }}" alt="{{ __('Photo Preview:') }}"
                             class="card card-4 margin-bottom-1 image-preview"/>
                    </div>
                @else
                    @if (isset($cover_image_url) && $cover_image_url !== '')
                        <div class="relative" style="width: fit-content">
                            <img src="{{ $cover_image_url }}" alt="{{ __('Cover image') }}"
                                 class="card card-4 margin-bottom-1 image-preview"/>
                        </div>
                    @endif
                @endif

                <input
                    id="cover-image-upload-{{ $iteration }}"
                    class="{{ $errors->has('cover_image') ? ' border border-red' : '' }}"
                    type="file"
                    wire:model="cover_image"
                    name="cover_image"
                />

                <div wire:loading wire:target="cover_image">Uploading...</div>

                <!-- Progress Bar -->
                <div x-show="isUploading">
                    <div class="gray-20 margin-bottom-top-0-5">
                        <div class="box green" x-bind:value="progress" style="width:1%; height: 22px"
                             :style="{ width: (progress + '%') }"
                             x-text="progress">0
                        </div>
                    </div>
                </div>

                <x-global::input-error for="cover_image"/>

            </fieldset>

            <div class="actions">
                <button type="submit" class="primary">
                    <span wire:loading wire:target="updateTag" class="animate-spin">&#9696;</span>
                    <span wire:loading.remove wire:target="updateTag">{{ __('Update') }}</span>
                </button>
                <button type="button" class="primary alt" wire:click="initialize">
                    {{ __('Cancel') }}
                </button>
            </div>
        </form>

    </x-global::form-modal>
</div>
