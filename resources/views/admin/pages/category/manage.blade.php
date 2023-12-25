@extends('admin.layouts.admin')

@section('head')
    <script src="{{ asset('/js/jquery.3.2.1.min.js') }}"></script>
    <script nonce="{{ csp_nonce() }}">
        const route_prefix = "/filemanager";
        const lfm = function (id, type, options, livewireImageCallback) {
            let button = document.getElementById(id);

            button.addEventListener('click', function () {
                var route_prefix = (options && options.prefix) ? options.prefix : '/laravel-filemanager';
                var target_input = document.getElementById(button.getAttribute('data-input'));
                var target_preview = document.getElementById(button.getAttribute('data-preview'));

                // laravel-filemanager window
                window.open(route_prefix + '?type=' + options.type || 'image', 'FileManager', 'width=900,height=600');

                // This will run when we click on the use button
                window.SetUrl = function (items) {
                    var file_path = items.map(function (item) {
                        return item.url;
                    }).join(',');

                    // set the value of the desired input to image url
                    target_input.value = file_path;

                    // update livewire property
                    // Reason: https://forum.laravel-livewire.com/t/data-binding-not-working-with-value-changed-by-js/989
                    livewireImageCallback(file_path)

                    // target_input.dispatchEvent(new Event('input'));

                    // Create forms needs an image preview
                    if (target_preview !== null) {

                        // clear previous preview
                        target_preview.innerHtml = '';

                        // set or change the preview image src
                        items.forEach(function (item) {
                            let img = document.createElement('img')
                            img.setAttribute('style', 'height: 5rem')
                            img.setAttribute('src', item.thumb_url)
                            target_preview.appendChild(img);
                        });

                        // trigger change event
                        target_preview.dispatchEvent(new Event('change'));
                    }
                };
            });
        };

    </script>
@endsection

@section('content')

    <main class="padding-1">
        <nav class="breadcrumb breadcrumb-left">
            <ol>
                <li>
                    <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
                </li>
                <li>
                    <i class="fa-solid fa-angle-right"></i>
                </li>
                <li>{{ __('Manage categories') }}</li>
            </ol>
        </nav>

        <h1 class="h3 margin-top-bottom-0">{{ __('Manage categories') }}</h1>

        <div class="main-content">

            <div class="padding-top-bottom-1">
                <!-- Create root category -->
                <livewire:admin.category.create-root title="{{ __('Add category') }}" :hasSmallButton="false">
                </livewire:admin.category.create-root>

            </div>

            <ul id="categories-tree" class="padding-left-right-0 margin-top-0 no-bullets">

                @foreach ($categories as $category)
                    <li>
                        <div
                            class="{{ $selectedCategory->id === $category->id ? 'flex active-category' : 'flex inactive-category' }}">

                            <div class="padding-0-5" style="

">
                                @if (count($category->categories) > 0)

                                    <span class="caret caret-down"></span>
                                @endif
                                <h2 class="fs-16 margin-top-bottom-0">
                                    <a class="underline" href="{{ route('category.selected', $category->id)}}">
                                        {{ $category->name }}
                                    </a>
                                </h2>
                            </div>

                            <div class="button-group padding-left-0-5 margin-bottom-0">
                                <!-- Update category -->
                                <livewire:admin.category.update :modalId="'m-update-' . $category->id"
                                                          :category="$category"
                                                          :hasSmallButton="false">
                                </livewire:admin.category.update>

                                <!-- Delete category -->
                                <livewire:admin.category.delete :modalId="'m-delete-' . $category->id"
                                                          :category="$category"
                                                          :hasSmallButton="false">
                                </livewire:admin.category.delete>

                                <!-- Create sub-category -->
                                <livewire:admin.category.create :modalId="'m-add-' . $category->id"
                                                          :category="$category"
                                                          :hasSmallButton="false">
                                </livewire:admin.category.create>
                            </div>

                        </div>

                        <ul class="no-bullets margin-top-bottom-0 padding-left-2 padding-right-0 nested active">
                            @foreach ($category->categories as $childCategory)
                                <x-admin::child-category-list :childCategory="$childCategory"
                                                             :selectedCategory="$selectedCategory">
                                </x-admin::child-category-list>
                            @endforeach
                        </ul>
                    </li>
                @endforeach

            </ul>


        </div>
    </main>
@endsection
