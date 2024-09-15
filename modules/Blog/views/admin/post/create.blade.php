@extends('admin.layouts.admin-nosidebar')

@section('head')
    <x-admin::head.tinymce-config/>
@endsection

@push('head-extra')
    <link href="{{ url('assets/tom-select/tom-select-2.2.2.css') }}" rel="stylesheet">
@endpush

@section('content')
    <main class="padding-1">
        <form action="{{ route('post.store') }}"
              method="POST"
              enctype="application/x-www-form-urlencoded"
              accept-charset="UTF-8"
              autocomplete="off"
        >
            @method("POST")
            @csrf

            <div class="row-padding margin-top-0">

                <div class="col s12 m8 l8 padding-right-1">

                    <a href="{{ route('post.manage') }}" class="button fs-14 primary alt margin-bottom-1">
                        <i class="fa-solid fa-angles-left"></i>
                        {{ __('Back') }}
                    </a>

                    <h1 class="margin-0 h2">
                        {{ __('Create new post') }}
                    </h1>

                    <x-global::validation-errors/>

                    <!-- Title -->
                    <div class="mb-5">
                        <label for="title" class="bold">{{ __('Post title') }}<span
                                class="text-red">*</span></label>
                        <input id="title"
                               class="{{ $errors->has('title') ? ' border border-red' : '' }}"
                               type="text"
                               name="title"
                               value="{{ old('title') ?? '' }}"
                               autofocus
                        />
                        <x-global::input-error for="title"/>
                    </div>

                    <!-- Slug -->
                    <div class="mb-5">
                        <label for="slug" class="bold">{{ __('Post slug') }}</label>
                        <input id="slug"
                               class="{{ $errors->has('slug') ? ' border border-red' : '' }}"
                               type="text"
                               name="slug"
                               value="{{ old('slug') ?? '' }}"
                               autofocus
                               placeholder="{{ __('(auto-generated from the title, or add a custom slug)') }}"
                        />
                        <x-global::input-error for="slug"/>
                    </div>

                    <!-- Post content / text editor -->
                    <div class="mb-5">
                        <label for="content" class="bold">{{ __('Body') }}<span class="text-red">*</span></label>
                        <div>
                                <textarea name="content" rows="5" id="content"
                                          class="{{ $errors->has('content') ? 'border border-red' : '' }}"
                                >{!! old('content') ?? '' !!}
                                </textarea>
                        </div>
                        <x-global::input-error for="content"/>
                    </div>

                </div>


                <div class="col s12 m4 l4">
                    <div>
                        <!-- Status -->
                        <label for="status" class="bold">{{ __('Status') }}<span class="text-red">*</span></label>
                        <select
                            class="{{ $errors->has('status') ? 'border border-red' : '' }}"
                            aria-label="{{ __("Select a post status") }}"
                            name="status"
                            id="status"
                        >

                            @foreach ($postStatuses as $key => $value)
                                @if($key === 'draft')
                                    <option selected name="status" value="{{ $key }}">{{ $value }}</option>
                                @else
                                    <option name="status" value="{{ $key }}">{{ $value }}</option>
                                @endif
                            @endforeach
                        </select>

                        <x-global::input-error for="status"/>

                    </div>

                    <div>
                        <button type="submit" class="primary">{{ __("Create") }}
                        </button>

                        <a href="{{ route('post.manage')}}"
                           class="button alt primary">{{ __('Cancel') }}</a>
                    </div>

                    <hr>

                    <!-- Excerpt -->
                    <div class="mb-5">
                        <label for="excerpt" class="bold">{{ __('Short article summary') }}</label>
                        <textarea id="excerpt"
                                  class="{{ $errors->has('excerpt') ? ' border border-red' : '' }}"
                                  name="excerpt"
                                  rows="5"
                                  autofocus
                        >{{ old('excerpt') ?? '' }}</textarea>

                        <x-global::input-error for="excerpt"/>
                    </div>

                    <hr>

                    <!-- Is post highlighted? -->
                    <div class="mb-5">
                        <label for="is_highlighted">{{ __('Is the post highlighted?') }}</label>

                        <input type="checkbox" id="is_highlighted" name="is_highlighted" value="1">

                        <x-global::input-error for="is_highlighted"/>
                    </div>

                    <hr>

                    <!-- Cover image -->
                    <div class="mb-5">
                        <label for="cover_image_url" class="bold">{{ __('Cover Image') }}</label>

                        <div class="flex flex-row flex-nowrap margin-top-1 margin-bottom-2">
                            <div>
                                <button id="lfm" class="button info margin-top-0">
                                    <i class="fa-solid fa-image"></i> {{ __('Choose') }}
                                </button>
                            </div>

                            <input id="cover_image_url"
                                   class="small-input {{ $errors->has('cover_image_url') ? ' border border-red' : '' }}"
                                   type="text"
                                   readonly
                                   name="cover_image_url"
                                   value="{{ old('cover_image_url') ?? '' }}"
                                   autofocus
                            />

                        </div>

                        <div id="holder" class="card card-4" style="width: fit-content"></div>
                        <x-global::input-error for="cover_image_url"/>
                    </div>

                    <hr>

                    <div>

                        <div class="mb-5">
                            <label for="categories"
                                   class="bold {{ $errors->has('categories') ? 'border border-red' : '' }}">
                                {{ __('Assign categories (optional)') }}
                            </label>

                            <select id="categories" name="categories[]" class="categories" multiple="multiple">
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>

                            <x-global::input-error for="cetegories"/>

                        </div>

                        <div class="mb-5">
                            <label for="tags" class="bold {{ $errors->has('tags') ? 'border border-red' : '' }}">
                                {{ __('Assign tags (optional)') }}
                            </label>
                            <select id="tags" name="tags[]" class="tags" multiple="multiple">
                                @foreach($tags as $tag)
                                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                @endforeach
                            </select>

                            <x-global::input-error for="tags"/>

                        </div>

                    </div>

                </div>
            </div>
        </form>
    </main>

@endsection


@push('scripts')
    <script src="{{ url('assets/jquery/jquery-3.7.1.js') }}"></script>
    <script src="{{ url('assets/switcher/jquery.simpleswitch.js') }}"></script>
    <script src="{{ url('assets/tom-select/tom-select-2.2.2.js') }}"></script>

    <script nonce="{{ csp_nonce() }}">
        document.addEventListener("DOMContentLoaded", function () {

            document.getElementById('lfm').addEventListener('click', (event) => {
                event.preventDefault();

                window.open('/file-manager/fm-button', 'fm', 'width=1400,height=800');
            });
        });

        // set file link
        function fmSetLink($url) {
            document.getElementById('cover_image_url').value = $url;
        }

        jQuery(document).ready(function ($) {
            // Switcher
            $('#is_highlighted').simpleSwitch();


            new TomSelect("#tags", {
                plugins: ['remove_button'],
            });

            new TomSelect("#categories", {
                plugins: ['remove_button'],
            });
        });
    </script>
    <script src="{{ url('/js/prism.js') }}" type="text/javascript"></script>
@endpush
