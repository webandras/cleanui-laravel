@extends('public.layouts.frontpage')

@section('seo')
    <x-public::meta
        :title="$tag->name . ' | ' . __('Tag')"
        :excerpt="__('Tags')"
        :url="route('blog.tag', $tag->slug)"
    ></x-public::meta>
@endsection

@section('content')
    <div class="card white">

        <x-public::breadcrumb title="{{ $tag->name }}" :centerAlign="true"></x-public::breadcrumb>

        <h1 class="text-center margin-0 h2">{{ __('Tag: ') }}{{ $tag->name }}</h1>

        <hr>

        <div class="public-post-grid">

            @foreach($posts as $post)
                <article class="post-item card primary-dark">

                    <a href="{{ route('blog.show', $post->slug) }}" class="no-underline">
                        <div class="relative cover-image-container">
                            <span
                                class="badge round-1 absolute topleft margin-left-1 margin-top-0-5">{{ Carbon\Carbon::parse($post->created_at)->translatedFormat($dtFormat) }}</span>
                            <img class="round-top"
                                 src="{{ asset($post->cover_image_url) ?? asset('/images/placeholder.png') }}"
                                 alt="{{ $post->title }}">
                        </div>
                        <div class="padding-left-right-1 padding-top-bottom-1">
                            <h2 class="margin-top-bottom-0 text-white fs-22">{{ $post->title }}</h2>
                            <p class="text-gray-10">{{ $post->excerpt }}</p>
                        </div>
                    </a>

                </article>
            @endforeach
        </div>

        {{ $posts->links('global.components.pagination') }}

    </div>

@endsection
