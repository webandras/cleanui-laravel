<article x-data="{
    isModalOpen: $wire.$entangle('isModalOpen', true)
}">

    @if ($hasSmallButton)
        <button @click="isModalOpen = true" class="danger margin-top-0" title="{{ __('Delete') }}">
            <i class="fa-solid fa-trash-can" aria-hidden="true"></i>
        </button>
    @else
        <button @click="isModalOpen = true" class="danger margin-top-0">
            <i class="fa-solid fa-trash-can" aria-hidden="true"></i>
            <span>{{ __('Delete') }}</span>
        </button>
    @endif

    <x-global::form-modal trigger="isModalOpen" title="{{ __('Are you sure you want to delete?') }}"
                          id="{{ $modalId }}">
        <form wire:submit="deletePost">
            <h2 class="h3">{{ $title }}</h2>
            <hr class="divider">

            <label for="postId" class="sr-only">{{ __('Post Id') }}</label>
            <input wire:model="postId"
                   disabled
                   type="number"
                   class="hidden"
                   name="postId"
                   id="postId"
            >

            <div class="actions">
                <button type="submit" class="danger">
                    <span wire:loading wire:target="deletePost" class="animate-spin">&#9696;</span>
                    <span wire:loading.remove wire:target="deletePost">{{ __('Delete') }}</span>
                </button>
                <button type="button" class="danger alt" @click="isModalOpen = false">
                    {{ __('Cancel') }}
                </button>
            </div>
        </form>

    </x-global::form-modal>
</article>
