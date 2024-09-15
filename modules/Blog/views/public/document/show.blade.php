@extends('public.layouts.frontpage')

@section('seo')
    <x-public::meta
        :title="__('Documentation')"
        :excerpt="$currentDocument->excerpt ?? __('This is a demo documentation page description')"
        :url="route('document.show', $currentDocument->slug)"
    ></x-public::meta>
@endsection

@push('head-extra')
    <link href="{{ url('css/prism.css') }}" rel="stylesheet">
@endpush


@section('content')
    <div x-data="{ showToc: true}" x-cloak class="main-container container relative">

        <article x-show="showToc" x-transition class="toc round">
            <h2 class="h4">{{ __('Table of Contents') }}</h2>
            <ul class="fs-14 padding-right-left-0 no-bullets margin-top-0">
                <li><a href="{{ route('document.index') }}">{{ __('Get Started') }}</a></li>
                @foreach($documents as $document)
                    <li><a href="{{ route('document.show', $document->slug) }}"
                           class="{{ $currentDocument->slug === $document->slug ? 'active' : 'not-active' }}">{{ $document->title }}</a>
                    </li>
                @endforeach
            </ul>
        </article>

        <main class="content round padding-top-0">

            <div>
                <span @click="showToc = ! showToc" class="pointer absolute padding-0 topright margin-top-1-5 margin-right-1" role="button"
                      title="{{ __('Table of content') }}">
                <i :class="{'fa fa-expand' : !showToc,  'fa fa-compress' : showToc }" aria-hidden="true"></i>
                <span class="fs-12">{{ __('Table of content') }}</span>
                </span>

                <nav class="breadcrumb breadcrumb-left padding-top-3 fs-12">
                    <ol>
                        <li>
                            <a href="{{ route('document.index') }}">
                                <i class="fa fa-home" aria-hidden="true"></i>
                                {{ __('Documentation') }}
                            </a>
                        </li>
                        <li>
                            <i class="fa-solid fa-angle-right"></i>
                        </li>
                        <li>{{ $currentDocument->title }}</li>
                    </ol>
                </nav>
                <hr class="margin-0">

                <h1 class="text-left h1 margin-top-bottom-0-5"
                    style="text-align: left;">{{ $currentDocument->title }}</h1>
            </div>


            <p class="semibold text-gray-60 padding-bottom-2">{{ $currentDocument->excerpt }}</p>

            <div>
                {!! $currentDocument->content !!}
            </div>

            <hr class="">

            <div class="next-prev-navigation bar border border-20 margin-top-2 round">
                <a href="{{ isset($nextDocument) ? route('document.show', $nextDocument->slug) : '#' }}"
                   class="button link-button fs-14">{{ isset($nextDocument) ? ('❮ '. $nextDocument->title) : '' }}</a>

                <a href="{{ isset($previousDocument) ? route('document.show', $previousDocument->slug) : '#' }}"
                   class="button float-right link-button fs-14">{{ isset($previousDocument) ? ($previousDocument->title . ' ❯') : '' }} </a>
            </div>

        </main>

    </div>

@endsection

@push('scripts')
<script src="{{ url('/js/prism.js') }}" type="text/javascript"></script>
@endpush
