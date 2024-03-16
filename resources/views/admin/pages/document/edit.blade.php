@extends('admin.layouts.admin-nosidebar')

@section('head')
    <x-admin::head.tinymce-config/>
@endsection


@section('content')
    <main class="padding-1" style="">

        <form action="{{ route('document.update', $document->id)}}"
              method="POST"
              enctype="multipart/form-data"
              accept-charset="UTF-8"
              autocomplete="off"
        >
            @method("PUT")
            @csrf

            <div class="row-padding margin-top-0">

                <div class="col s12 m12 l8" style="padding-right: 1em">

                    <a href="{{ route('document.manage') }}" class="button fs-14 primary alt margin-bottom-1">
                        <i class="fa-solid fa-angles-left"></i>
                        {{ __('Back') }}
                    </a>

                    <h1 class="margin-0 h2">
                        {{ $document->title }}
                    </h1>

                    <x-global::validation-errors/>


                    <!-- Title -->
                    <div class="mb-5">
                        <label for="title" class="bold">{{ __('Document title') }}<span
                                class="text-red">*</span></label>
                        <input id="title"
                               class="{{ $errors->has('title') ? ' border border-red' : '' }}"
                               type="text"
                               name="title"
                               value="{{ old('title') ?? $document->title }}"
                               autofocus
                        />
                        <x-global::input-error for="title"/>
                    </div>


                    <!-- Slug -->
                    <div class="mb-5">
                        <label for="slug" class="bold">{{ __('Document slug') }}<span class="text-red">*</span></label>
                        <input id="slug"
                               class="{{ $errors->has('slug') ? ' border border-red' : '' }}"
                               type="text"
                               name="slug"
                               value="{{ old('slug') ?? $document->slug }}"
                               autofocus
                               placeholder="{{ __('auto-generated from the title, or add a custom slug') }}"

                        />
                        <x-global::input-error for="slug"/>
                    </div>


                    <!-- Content -->
                    <div class="mb-5">
                        <label for="content" class="bold">{{ __('Content') }}<span class="text-red">*</span></label>
                        <div>
                                <textarea name="content" id="content" rows="5"
                                          class="{{ $errors->has('content') ? 'border border-red' : '' }}"
                                >
                                    {!! $document->content !!}
                                </textarea>
                        </div>

                        <x-global::input-error for="content"/>

                    </div>
                </div>


                <div class="col s12 m12 l4">

                    <div>
                        <!-- Status -->
                        <label for="status" class="bold">{{ __('Status') }}<span class="text-red">*</span></label>
                        <select
                            class="{{ $errors->has('status') ? 'border border-red' : '' }}"
                            aria-label="{{ __("Select a document status") }}"
                            name="status"
                            id="status"
                        >

                            @foreach ($documentStatuses as $key => $value)
                                @if($key === $document->status)
                                    <option selected name="status" value="{{ $key }}">{{ $value }}</option>
                                @else
                                    <option name="status" value="{{ $key }}">{{ $value }}</option>
                                @endif
                            @endforeach
                        </select>

                        <x-global::input-error for="status"/>

                    </div>

                    <div>
                        <button type="submit" class="primary">{{ __("Update document") }}
                        </button>

                        <a href="{{ route('document.manage')}}"
                           class="button alt primary">{{ __('Cancel') }}</a>
                    </div>

                    <hr>

                    <!-- Excerpt -->
                    <div class="mb-5">
                        <label for="excerpt" class="bold">{{ __('Excerpt') }}</label>
                        <textarea id="excerpt"
                                  class="{{ $errors->has('excerpt') ? ' border border-red' : '' }}"
                                  name="excerpt"
                                  rows="5"
                                  autofocus
                        >{{ old('excerpt') ?? $document->excerpt }}</textarea>

                        <x-global::input-error for="excerpt"/>
                    </div>
                </div>
            </div>

        </form>
    </main>

@endsection

@push('head-extra')
    <link href="{{ url('assets/tom-select/tom-select-2.2.2.css') }}" rel="stylesheet">
    <script src="{{ url('assets/jquery/jquery-3.7.1.js') }}"></script>
    <script src="{{ url('assets/switcher/jquery.simpleswitch.js') }}"></script>
    <script src="{{ url('assets/tom-select/tom-select-2.2.2.js') }}"></script>
@endpush
