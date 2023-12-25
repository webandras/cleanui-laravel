<li>
    <div class="{{ $selectedCategory->id === $childCategory->id ? 'flex active-category' : 'flex inactive-category' }}">

        <div class="padding-0-5">
            @if (count($childCategory->categories) > 0)
                <span class="caret caret-down"></span>
            @endif
            <h3 class="fs-16 margin-top-bottom-0">
                <a href="{{ route('category.selected', $childCategory->id)}}">
                    {{ $childCategory->name }}
                </a>
            </h3>
        </div>

        <div class="button-group padding-left-0-5 margin-bottom-0">
            <!-- Update category -->
            <livewire:admin.category.update :modalId="'m-update-' . $childCategory->id"
                                      :category="$childCategory"
                                      :hasSmallButton="false">
            </livewire:admin.category.update>

            <!-- Delete category -->
            <livewire:admin.category.delete :modalId="'m-delete-' . $childCategory->id"
                                      :category="$childCategory"
                                      :hasSmallButton="false">
            </livewire:admin.category.delete>

            <!-- Create sub-category -->
            <livewire:admin.category.create :modalId="'m-add-' . $childCategory->id"
                                      :category="$childCategory"
                                      :hasSmallButton="false">
            </livewire:admin.category.create>
        </div>

    </div>


    <ul class="no-bullets padding-left-1-5 margin-top-0 margin-bottom-0 padding-bottom-0-5 padding-right-0 nested active">
        @if (count($childCategory->categories) > 0)
            @foreach ($childCategory->categories as $childCategory)
                <x-admin::child-category-list :childCategory="$childCategory"
                                       :selectedCategory="$selectedCategory"></x-admin::child-category-list>
            @endforeach
        @endif
    </ul>
</li>
