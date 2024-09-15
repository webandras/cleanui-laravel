@extends('public.layouts.frontpage')

@push('head-extra')
    <link href="{{ url('css/prism.css') }}" rel="stylesheet">
@endpush

@section('seo')
    <x-public::meta
        :title="__('Documentation')"
        :excerpt="__('This is a demo documentation page description')"
        :url="route('document.index')"
    ></x-public::meta>
@endsection


@section('content')
    <div x-data="{ showToc: true}" x-cloak class="main-container container relative">

        <article x-show="showToc" x-transition class="toc round">
            <h2 class="h4">{{ __('Table of Contents') }}</h2>

            <ul class="padding-right-left-0 no-bullets margin-top-0 fs-16">
                <li><a href="{{ route('document.index') }}" class="active">{{ __('Get Started') }}</a></li>
                @foreach($documents as $document)
                    <li><a href="{{ route('document.show', $document->slug) }}"
                           class="not-active">{{ $document->title }}</a>
                    </li>
                @endforeach
            </ul>
        </article>

        <main class="content round padding-top-0">
            <h1 class="text-center h1 margin-top-0 margin-bottom-0-5">{{ __('Documentation') }}</h1>
            <p class="bold fs-18 text-center text-muted">This is the index page of the documentation.</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc varius aliquam egestas. Cras posuere libero
                sed quam sollicitudin vestibulum. Cras pharetra, velit eu tristique viverra, lacus sem aliquet ligula,
                eu aliquet ipsum felis ut velit. Quisque sed vestibulum nunc, eu consequat velit. Donec vel mattis
                augue, ac eleifend metus. Integer imperdiet eleifend est, vel gravida quam vestibulum eget. Donec
                fringilla libero ac magna posuere, lobortis egestas elit pharetra. Fusce pretium ac metus non interdum.
                Suspendisse id erat placerat nunc vestibulum semper a et est. In facilisis nisi dolor, vitae
                pellentesque mauris venenatis ac. Aenean eget arcu nibh.
            </p>
        </main>

    </div>

@endsection
