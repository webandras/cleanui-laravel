<article x-data="{ isModalOpen: $wire.$entangle('isModalOpen', true) }">

    <button @click="isModalOpen = true" class="danger alt margin-top-0">
        <i class="fa-solid fa-trash-can" aria-hidden="true"></i>
        <span>{{ __('Delete permanently') }}</span>
    </button>

    <x-global::form-modal trigger="isModalOpen" title="{{ __('Are you sure you want to delete it permanently?') }}" id="{{ $modalId }}">
        <form wire:submit="destroyTag">
            <h2 class="h3">{{ $name }}</h2>
            <hr class="divider">

            <div class="actions">
                <button type="submit" class="danger">
                    <span wire:loading wire:target="destroyTag" class="animate-spin">&#9696;</span>
                    <span wire:loading.remove wire:target="destroyTag">{{ __('Delete permanently') }}</span>
                </button>
                <button type="button" class="danger alt" @click="isModalOpen = false">
                    {{ __('Cancel') }}
                </button>
            </div>
        </form>

    </x-global::form-modal>
</article>
