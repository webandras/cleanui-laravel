@extends('public.layouts.frontpage')

@section('seo')
    <x-public::meta
        :title="$category->name . ' | ' . __('Category')"
        :excerpt="__('Category description here')"
        :url="route('blog.category', $category->slug)"
    ></x-public::meta>
@endsection

@section('content')

    @php $dtFormat = \App\Interface\Entities\Clean\PostInterface::DT_FORMAT; @endphp

    <div class="card white padding-bottom-3">

        <x-public::breadcrumb title="{{ $category->name }}" :centerAlign="true"></x-public::breadcrumb>

        <h1 class="text-center margin-0 h2">{{ __('Category: ') }}{{ $category->name }}</h1>

        <hr class="divider">

        <div class="public-post-grid">

            @foreach($posts as $post)
                <article class="post-item card primary-dark">

                    <a href="{{ route('blog.show', $post->slug) }}" class="no-underline">
                        <div class="relative cover-image-container">
                            <span
                                class="badge round-1 absolute topleft margin-left-0-5 margin-top-0-5">{{ Carbon\Carbon::parse($post->created_at)->translatedFormat($dtFormat) }}</span>
                            <img class="round-top"
                                 src="{{ asset($post->cover_image_url) ?? asset('/images/placeholder.png') }}"
                                 alt="{{ $post->title }}">
                        </div>
                        <div class="padding-left-right-0-5 padding-top-bottom-1">
                            <h2 class="margin-top-bottom-0 text-white fs-22">{{ $post->title }}</h2>
                        </div>
                    </a>

                </article>
            @endforeach
        </div>

        {{ $posts->links('global.components.pagination') }}

    </div>

@endsection
