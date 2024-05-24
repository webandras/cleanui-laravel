<div x-data="{
    isModalOpen: $wire.$entangle('isModalOpen', true)
}">

    <x-global::form-modal trigger="isModalOpen" title="{{ __('Are you sure you want to delete?') }}"
                          id="{{ $modalId }}">
        <form wire:submit="deleteDocument">
            <h2 class="h3">{{ $title }}</h2>
            <hr>
            <label for="postId" class="sr-only">{{ __('Document Id') }}</label>
            <input wire:model="documentId"
                   disabled
                   type="number"
                   class="hidden"
                   name="documentId"
                   id="documentId"
            >

            <div class="actions">
                <button type="submit" class="danger">
                    <span wire:loading wire:target="deleteDocument" class="animate-spin">&#9696;</span>
                    <span wire:loading.remove wire:target="deleteDocument">{{ __('Delete') }}</span>
                </button>
                <button type="button" class="danger alt" @click="isModalOpen = false">
                    {{ __('Cancel') }}
                </button>
            </div>
        </form>

    </x-global::form-modal>
</div>
