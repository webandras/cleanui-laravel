@extends('public.layouts.public')

@section('seo')
    <x-public::meta
        :title="$post->title"
        :excerpt="$post->excerpt"
        :coverImage="$post->cover_image_url"
        :url="route('blog.show', $post->slug)"
    ></x-public::meta>
@endsection

@section('content')
    <article class="card white post-content-width">
        <div class="relative card-header post-header padding-left-right-2 padding-top-0-5">
            <h1 class="text-left margin-0 single-post-title">{{ $post->title }}</h1>

            <div class="flex post-header-meta">
                <div class="text-gray-60 post-date fs-14">
                    {{ Carbon\Carbon::parse($post->created_at)->translatedFormat($dtFormat) }}
                </div>
            </div>
        </div>

        <hr class="margin-top-0-5 margin-bottom-1 margin-right-left-2">

        <div class="card-body">

            <img src="{{ asset($post->cover_image_url) ?? asset('/images/placeholder.png') }}" alt="{{ $post->title }}"
                 class="round single-post-image">

            <div class="post-content">
                {!! $post->content !!}

                <hr>

                <div class="post-footer">
                    <!-- AddToAny -->
                    <x-public::share :className="''" :titleEnabled="true" title="{{ $post->title }}"></x-public::share>

                    <h4 class="margin-bottom-0">{{ __('Categories:') }}</h4>
                    <div class="flex flex-row margin-top-0-5">
                        @foreach($post->categories as $category)
                            <a href="{{ route('blog.category', $category->slug) }}"
                               class="badge round-1 fs-14 padding-0-25 margin-top-0-5">
                                <i class="fa-solid fa-folder-open"></i>
                                {{ $category->name }}</a>
                        @endforeach

                    </div>

                    <h4 class="margin-bottom-0">{{ __('Tags:') }}</h4>

                    <nav class="flex flex-row flex-wrap margin-top-0-5">
                        @foreach($post->tags as $tag)
                            <a href="{{ route('blog.tag', $tag->slug) }}">#{{ $tag->name }}</a>
                        @endforeach
                    </nav>

                </div>
            </div>

        </div>
    </article>

    <aside class="next-prev-navigation bar border border-20 round margin-top-bottom-1 post-content-width white">
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

    </aside>

@endsection

