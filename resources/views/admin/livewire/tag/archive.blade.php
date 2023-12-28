<div x-data="{}" x-cloak>
    <form wire:submit.prevent="filterTags">
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
                    <span wire:loading.remove wire:target="filterTags">{{ __('Filter') }}</span>
                </button>

                <button
                    type="button"
                    class="alt primary fs-14"
                    wire:click="resetFilters()"
                >
                    {{ __('Reset filters') }}
                </button>
            </div>

            <div class="actions margin-left-auto">
                <button type="button" {{ empty($selectedIds) ? 'disabled' : '' }}  wire:click="toggleRestoreModal"
                        class="info fs-14">
                    {{ __('Restore selected') }}
                </button>

                <button type="button" {{ empty($selectedIds) ? 'disabled' : '' }}  wire:click="toggleDestroyModal"
                        class="danger fs-14">
                    {{ __('Destroy selected') }}
                </button>


                <div x-data="{isModalOpen: $wire.entangle('isRestoreConfirmOpen')}">
                    <x-global::modal
                        trigger="isModalOpen"
                        title="{{ __('Restore tag(s)?') }}"
                        :id="'restore-confirm-modal'"
                    >
                        <button type="button" {{ empty($selectedIds) ? 'disabled' : '' }}  wire:click="restoreTags"
                                class="info fs-14">
                            <span wire:loading wire:target="restoreTags" class="animate-spin">&#9696;</span>
                            <span wire:loading.remove wire:target="restoreTags">{{ __('Restore selected') }}</span>
                        </button>
                    </x-global::modal>
                </div>

                <div x-data="{isModalOpen: $wire.entangle('isDestroyConfirmOpen')}">

                    <x-global::modal
                        trigger="isModalOpen"
                        title="{{ __('Restore tag(s)?') }}"
                        :id="'destroy-confirm-modal'"
                    >
                        <button type="button" {{ empty($selectedIds) ? 'disabled' : '' }} wire:click="destroyTags"
                                class="danger fs-14">
                            <span wire:loading wire:target="destroyTags" class="animate-spin">&#9696;</span>
                            <span wire:loading.remove wire:target="destroyTags">{{ __('Destroy selected') }}</span>
                        </button>
                    </x-global::modal>
                </div>
            </div>

        </div>
    </form>

    @php $archivedTagsCount = $archivedTags->total(); @endphp
    <p class="italic fs-14">{{ __('Number of results: ') }}<span
            class="text-green bold">{{ $archivedTagsCount }}</span></p>

    @if($archivedTagsCount > 0)

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
            @foreach($archivedTags as $tag)
                <tr>
                    <td><input type="checkbox" value="{{ $tag->id }}" wire:model="selectedIds" name="selectedIds"></td>
                    <td><b>{{ $tag->name }}</b><br><small>Archived at: {{ $tag->deleted_at }}</small></td>
                    <td class="italic">{{ $tag->slug }}</td>
                    <td>
                        <div class="flex flex-row">

                            @if(auth()->user()->hasRoles('super-administrator|administrator') )
                                <!-- Restore tag -->
                                <livewire:admin.tag.restore :tag="$tag" :modalId="'m-restore-tag-'.$tag->id"
                                                            :wire:key="'restore-'.$tag->id">
                                </livewire:admin.tag.restore>

                                <!-- Destroy tag -->
                                <livewire:admin.tag.destroy title="{{ __('Delete') }}" :tag="$tag"
                                                            :wire:key="'destroy-'.$tag->id"
                                                            :modalId="'m-destroy-tag-' . $tag->id">
                                </livewire:admin.tag.destroy>
                            @endif
                        </div>

                    </td>

                </tr>
            @endforeach
            </tbody>
        </table>
        <div>
            {!! $archivedTags->links('global.components.pagination-livewire', ['pageName' => 'archive']) !!}
        </div>
    @else
        <p class="alert info fs-14">{{ __('No archived tags found.')  }}</p>
    @endif
</div>
