<div x-data="{
    isModalOpen: $wire.entangle('isModalOpen')
}">

    @if ($hasSmallButton)
        <button @click="isModalOpen = true" class="danger margin-top-0" title="{{ __('Archive') }}">
            <i class="fa-solid fa-trash-can" aria-hidden="true"></i>
        </button>
    @else
        <button @click="isModalOpen = true" class="danger margin-top-0">
            <i class="fa-solid fa-trash-can" aria-hidden="true"></i>
            <span>{{ __('Archive') }}</span>
        </button>
    @endif

    <x-global::form-modal trigger="isModalOpen" title="{{ __('Are you sure you want to archive it?') }}"
                          id="{{ $modalId }}">
        <form wire:submit.prevent="deleteTag">
            <h2 class="h3">{{ $name }}</h2>
            <hr class="divider">

            <label for="tagId" class="sr-only">{{ __('Tag Id') }}</label>
            <input wire:model.defer="tagId"
                   disabled
                   type="number"
                   class="hidden"
                   name="tagId"
                   id="tagId"
                   value="{{ $tagId }}"
            >

            <div class="actions">
                <button type="submit" class="danger">
                    <span wire:loading wire:target="deleteTag" class="animate-spin">&#9696;</span>
                    <span wire:loading.remove wire:target="deleteTag">{{ __('Archive') }}</span>
                </button>
                <button type="button" class="danger alt" @click="isModalOpen = false">
                    {{ __('Cancel') }}
                </button>
            </div>
        </form>

    </x-global::form-modal>
</div>
