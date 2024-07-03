<section>
    <ul wire:sortable="updateOrder" class="document__list no-bullets padding-left-right-0-5">
        @foreach ($documents as $document)
            <li wire:sortable.item="{{ $document->id }}" wire:key="document-{{ $document->id }}"
                class="document__list__item border round border-light margin-bottom-1 padding-left-right-1">
                <div class="flex flex-row document__list__item__container">
                    <div wire:sortable.handle class="document__list__item__container__content flex-row">
                        <div class="document__list__item__container__content__grip"><i
                                class="fa-solid fa-grip-vertical text-gray-40 margin-right-0-5"></i></div>
                        <div class="flex flex-column">
                            <h4 class="h5">{{ $document->title }} <span
                                    class="badge fs-10 medium {{ $documentStatusColors[$document->status] }}">{{ $documentStatuses[$document->status] }}</span>
                                <div class="fs-12 medium text-gray-60">{{ $document->created_at }}</div>
                            </h4>

                        </div>
                    </div>
                    <div class="button-group padding-top-bottom-1">
                        <!-- View document -->
                        <a href="{{ route('document.show', $document->slug) }}"
                           target="_blank"
                           title="View document"
                           class="button success margin-top-0"
                        >
                            <i class="fa-solid fa-eye"></i>
                            {{ __('View') }}
                        </a>

                        <!-- Edit document -->
                        <a href="{{ route('document.edit', $document->id) }}"
                           class="button info margin-top-0"
                           title="{{ __('Edit document') }}">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                            {{ __('Edit') }}
                        </a>

                        <!-- Delete document -->
                        <button wire:click="$dispatch('triggerDeleteDocument', { document: {{ $document->id }} })"
                                class="danger margin-top-0">
                            <i class="fa-solid fa-trash-can" aria-hidden="true"></i>
                            <span>{{ __('Delete') }}</span>
                        </button>
                    </div>
                </div>

            </li>
        @endforeach
    </ul>
</section>
