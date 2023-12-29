<div>
    <div class="flex flex-row">

        <!-- Create new tag -->
        <livewire:admin.tag.create title="{{ __('New tag') }}"
                                   :hasSmallButton="false"
                                   :modalId="'m-create-tag'"
                                   :wire:key="'create-new-tag'">
        </livewire:admin.tag.create>

        <form wire:submit.prevent="filterTags" style="width: auto;">
            <div class="flex flex-row">
                <div>
                    <label for="filterKeyword" class="hidden bold fs-14">{{ __('Search keyword') }}</label>
                    <input id="filterKeyword"
                           wire:model.defer="filterKeyword"
                           name="filterKeyword"
                           placeholder="{{ __('Search keyword') }}"
                           class="fs-14 {{ $errors->has('filterKeyword') ? ' border border-red' : '' }}"
                           style="margin-top: 14px;"
                           type="text"
                    />

                    <div class="{{ $errors->has('filterKeyword') ? 'error-message' : '' }}">
                        {{ $errors->has('filterKeyword') ? $errors->first('filterKeyword') : '' }}
                    </div>
                </div>
                <div class="actions">
                    <button type="submit" class="primary fs-14">
                        <span wire:loading wire:target="filterTags" class="animate-spin">&#9696;</span>
                        <span wire:loading.remove wire:target="filterTags">{{ __('Filter!') }}</span>
                    </button>

                    <button
                        type="button"
                        class="alt primary fs-14"
                        wire:click="resetFilters()"
                    >
                        {{ __('Reset filters') }}
                    </button>
                </div>

            </div>
        </form>


        <div class="actions margin-left-auto">
            <button type="button" wire:click="toggleArchiveModal"
                    class="info fs-14">
                {{ __('Archive selected') }}
            </button>

            <div x-data="{isModalOpen: $wire.entangle('isArchiveConfirmOpen')}">
                <x-global::modal
                    trigger="isModalOpen"
                    title="{{ __('Archive tag(s)?') }}"
                    :id="'archive-confirm-modal'"
                >
                    <button type="button" wire:click="archiveTags"
                            class="info fs-14">
                        <span wire:loading wire:target="archiveTags" class="animate-spin">&#9696;</span>
                        <span wire:loading.remove wire:target="archiveTags">{{ __('Archive selected') }}</span>
                    </button>
                </x-global::modal>
            </div>
        </div>


    </div>

    @php
        $index = 1;
        $currentPage = $tags->currentPage();
        $count = $tags->total();
    @endphp

    <p class="italic fs-14">{{ __('Number of results: ') }}<span
            class="text-green bold">{{ $count }}</span></p>


    @if($count > 0)

        <table>
            <thead>
            <tr class="fs-14">
                <th>{{ __('Select') }}</th>
                <th>{{ __('Name') }}</th>
                <th>{{ __('Slug') }}</th>
                <th>{{ __('Actions') }}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($tags as $tag)
                <tr>
                    <td>
                        <label for="selectedIds" class="sr-only">{{ __('Select tag') }}</label>
                        <input type="checkbox" value="{{ $tag->id }}" wire:model.defer="selectedIds" name="selectedIds" id="selectedIds">
                    </td>
                    <td><b>{{ $tag->name }}</b><br><small>{{ $tag->created_at }}</small></td>
                    <td class="italic">{{ $tag->slug }}</td>
                    <td>
                        <div class="flex flex-row">

                            @if(auth()->user()->hasRoles('super-administrator|administrator') )
                                <!-- Delete tag -->
                                <livewire:admin.tag.delete title="{{ __('Delete tag') }}"
                                                           :tag="$tag"
                                                           :hasSmallButton="false"
                                                           :wire:key="'m-delete-tag-' . $tag->id"
                                                           :modalId="'m-delete-tag-' . $tag->id">
                                </livewire:admin.tag.delete>

                                <!-- Update tag -->
                                <livewire:admin.tag.edit title="{{ __('Edit tag') }}"
                                                         :tag="$tag"
                                                         :hasSmallButton="false"
                                                         :wire:key="'m-edit-tag-' . $tag->id"
                                                         :modalId="'m-edit-tag-' . $tag->id">
                                </livewire:admin.tag.edit>
                            @endif
                        </div>

                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>

        <div>
            {!! $tags->links('global.components.pagination-livewire', ['pageName' => 'page']) !!}
        </div>

    @else
        <p class="alert info fs-14">{{ __('No tags found for the query, or you don\'t have any tags yet. Please create one or reset the filters')  }}</p>
    @endif

</div>

