@extends('admin.layouts.admin')

<script nonce="{{ csp_nonce() }}">
        /*
        * Need these global definitions to have multiple single image upload buttons on one page!
        **/
        // input
        let inputId = '';


        // set file link
        function fmSetLink($url) {
            let currentInput = document.getElementById(inputId)

            currentInput.value = $url;

            currentInput.dispatchEvent(new Event('input'))
        }

</script>

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
                            class="flex inactive-category">

                            <div class="padding-0-5 category-title">
                                @if (count($category->categories) > 0)
                                    <span class="caret"></span>
                                @endif
                                <h2 class="fs-16 margin-top-bottom-0">
                                    <a class="underline" href="#">
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

                        <ul class="no-bullets margin-top-bottom-0 padding-left-2 padding-right-0 nested">
                            @foreach ($category->categories as $childCategory)
                                <x-admin::child-category-list :childCategory="$childCategory">
                                </x-admin::child-category-list>
                            @endforeach
                        </ul>
                    </li>
                @endforeach

            </ul>


        </div>
    </main>
@endsection
