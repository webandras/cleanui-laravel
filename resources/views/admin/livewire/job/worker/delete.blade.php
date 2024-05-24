<div x-data="{
    isModalOpen: $wire.$entangle('isModalOpen', true)
}">

    @if ($hasSmallButton)
        <button @click="isModalOpen = true" class="danger margin-top-0" title="{{ __('Delete worker') }}">
            <i class="fa-solid fa-trash-can" aria-hidden="true"></i>
        </button>
    @else
        <button @click="isModalOpen = true" class="danger margin-top-0">
            <i class="fa-solid fa-trash-can" aria-hidden="true"></i>
            <span>{{ __('Delete') }}</span>
        </button>
    @endif

    <x-global::form-modal trigger="isModalOpen" title="{{ __('Are you sure you want to delete it?') }}"
                        id="{{ $modalId }}">
        <form wire:submit="deleteWorker">
            <h2 class="h3">{{ $name }}</h2>
            <hr>

            <input wire:model="workerId"
                   disabled
                   type="number"
                   class="hidden"
                   name="workerId"
                   value="{{ $workerId }}"
            >

            <div class="actions">
                <button type="submit" class="danger">
                    <span wire:loading wire:target="deleteWorker" class="animate-spin">&#9696;</span>
                    <span wire:loading.remove wire:target="deleteWorker">{{ __('Delete') }}</span>
                </button>
                <button type="button" class="danger alt" @click="isModalOpen = false">
                    {{ __('Cancel') }}
                </button>
            </div>
        </form>

    </x-global::form-modal>
</div>
