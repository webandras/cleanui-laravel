@extends('public.layouts.public')

@section('seo')
    <x-public::meta
        :title="$post->title"
        :excerpt="$post->excerpt"
        :coverImage="$post->cover_image_url"
        :slug="'info/' . $post->slug"
    ></x-public::meta>
@endsection

@section('content')

    @php
        // setlocale(LC_ALL, 'hu_HU.UTF-8');
        $dtFormat = 'Y. F j.';
    @endphp

    <x-public::breadcrumb :title="$post->title"></x-public::breadcrumb>

    <article class="card white post-content-width">

        <div class="relative card-header">
            <img src="{{ asset($post->cover_image_url) ?? asset('/images/placeholder.png') }}" alt="{{ $post->title }}"
                 class="round-top single-post-image">

        </div>


        <div class="card-body">
            <h1 class="text-left margin-0 padding-top-0-5 single-post-title">{{ $post->title }}</h1>

            <div class="flex post-header">
                <div class="text-gray-80 post-date">
                    {{ Carbon\Carbon::parse($post->created_at)->translatedFormat($dtFormat) }}
                </div>

                <!-- AddToAny -->
                <x-public::share :className="'a2a_buttons__small margin-top-0-5 margin-right-0-5'"
                                 :titleEnabled="false" title="{{ $post->title }}"></x-public::share>
            </div>
            <hr class="divider">

            <div class="post-content">
                {!! $post->content !!}

                <hr>

                <h4 class="margin-bottom-0">{{ __('Categories:') }}</h4>
                <div class="flex flex-row margin-top-0-5">
                    @foreach($post->categories as $category)
                        <a href="{{ route('blog.category', $category->slug) }}"
                           class="badge gray-60 text-gray-10 round-1 fs-14 semibold padding-0-5 margin-top-0-5">
                            <i class="fa-solid fa-folder-open"></i>
                            {{ $category->name }}</a>
                    @endforeach

                </div>

                <h4 class="margin-bottom-0">{{ __('Tags:') }}</h4>

                <nav class="flex flex-row flex-wrap fs-14 margin-top-0-5">
                    @foreach($post->tags as $tag)
                        <a href="{{ route('blog.tag', $tag->slug) }}">#{{ $tag->name }}</a>
                    @endforeach
                </nav>

                <!-- AddToAny -->
                <x-public::share :className="''" :titleEnabled="true" title="{{ $post->title }}"></x-public::share>
            </div>

        </div>
    </article>

    <aside>
        <div class="bar border round margin-top-bottom-1 post-content-width white">
            @if (isset($neighbouringPosts['next']))
                <a href="{{ route('blog.show', $neighbouringPosts['next']['slug'] ) }}"
                   class="button link-button text-primary"><i
                        class="fa-solid fa-chevron-left"></i> {{ $neighbouringPosts['next']['title'] }}</a>
            @endif

            @if (isset($neighbouringPosts['previous']))
                <a href="{{ route('blog.show', $neighbouringPosts['previous']['slug'] ) }}"
                   class="button float-right link-button">{{ $neighbouringPosts['previous']['title'] }} <i
                        class="fa-solid fa-chevron-right"></i></a>
            @endif

        </div>
    </aside>

@endsection

