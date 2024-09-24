@extends('public.layouts.frontpage')

@section('seo')
    <x-public::meta
        :title="__('Blog')"
        :excerpt="__('Blog description')"
        :url="route('blog.index')"
    ></x-public::meta>
@endsection

@section('content')
    <section class="card">
        <h1 class="text-left margin-top-0 margin-bottom-0-5 text-center">
            {{ __('Newest articles') }}
        </h1>

        @if ($newestPosts->count() === 0)
            <p>No posts in the database.</p>
        @else
            <section class="intro">
                <section class="left-panel">
                    <article class="card margin-bottom-0">
                        <a href="{{ route('blog.show', $newestPosts[0]->slug) }}" class="no-underline">
                            <figure class="relative cover-image-container margin-0">
                                <img class="round-top hover-opacity" src="{{ $newestPosts[0]->cover_image_url }}"
                                     alt="{{ $newestPosts[0]->title }}">
                            </figure>
                        </a>
                        <section class="padding-left-right-1">
                            <time class="date" datetime="{{ $newestPosts[0]->created_at }}">
                                {{ Carbon\Carbon::parse($newestPosts[0]->created_at)->translatedFormat($dtFormat) }}
                            </time>
                            <h2 class="margin-top-0 text-white margin-bottom-1">
                                <a href="{{ route('blog.show', $newestPosts[0]->slug) }}" class="no-underline">
                                    {{ $newestPosts[0]->title }}
                                </a>
                            </h2>
                            <p class="text-gray-10">
                                {{ $newestPosts[0]->excerpt ?? substr($newestPosts[0]->content, 0, 255) . '...' }}
                            </p>
                            <a href="{{ route('blog.show', $newestPosts[0]->slug) }}"
                               class="button read-more margin-top-0">
                                {{ __('Read more') }}<i class="fa-solid fa-angles-right margin-left-0-5"></i>
                            </a>
                        </section>
                        <br>
                    </article>
                </section>

                <div class="right-panel">
                    <section class="right-panel-1">
                        @for($i = 1; $i <= 2; $i++)
                            <article class="card">
                                <a href="{{ route('blog.show', $newestPosts[$i]->slug) }}" class="no-underline block">
                                    <figure class="relative cover-image-container margin-0">
                                        <img class="round-top hover-opacity"
                                             src="{{ asset($newestPosts[$i]->cover_image_url) ?? asset('/images/placeholder.png') }}"
                                             alt="{{ $newestPosts[0]->title }}"
                                        >
                                    </figure>
                                </a>
                                <div class="padding-0-5">
                                    <time class="date" datetime="{{ $newestPosts[0]->created_at }}">
                                        {{ Carbon\Carbon::parse($newestPosts[0]->created_at)->translatedFormat($dtFormat) }}
                                    </time>
                                    <h2 class="margin-top-bottom-0 fs-24">
                                        <a href="{{ route('blog.show', $newestPosts[$i]->slug) }}" class="no-underline">
                                            {{ $newestPosts[$i]->title }}
                                        </a>
                                    </h2>
                                    <br>
                                </div>
                            </article>
                        @endfor
                    </section>
                    <section class="right-panel-2">
                        <ul class="no-bullets">
                            @for($i = 3; $i < $newestPosts->count(); $i++)
                                <li>
                                    <article>
                                        <time class="date" datetime="{{ $newestPosts[0]->created_at }}">
                                            {{ Carbon\Carbon::parse($newestPosts[$i]->created_at)->translatedFormat($dtFormat) }}
                                        </time>
                                        <h3 class="fs-24">
                                            <a href="{{ route('blog.show', $newestPosts[$i]->slug) }}" class="no-underline">
                                                {{$newestPosts[$i]->title }}</a>
                                        </h3>
                                    </article>
                                </li>
                            @endfor
                        </ul>
                    </section>
                </div>

            </section>
        @endif

        <hr>

        <livewire:public.blog.post.post-grid></livewire:public.blog.post.post-grid>

        <section>
            <section class="most-popular-categories-title">
                <h2>
                    {{ __('Most popular categories') }}
                </h2>
                <aside class="separator"></aside>
            </section>
            @if ($categories->count() > 0)
                <nav class="categories-container">
                    @foreach($categories as $cat)
                        <a class="fs-16" href="{{ route('blog.category', $cat->slug) }}">
                            {{ $cat->name }}
                        </a>
                    @endforeach
                </nav>
            @else
                <p>
                    No categories in the database. Create one or run the seeder.
                </p>
            @endif
        </section>

        <hr>

        @if ($highlightedPosts->count() > 0)
            <section class="highlighted-posts-container">
                <section class="featured">
                    @foreach($highlightedPosts as $highlightedPost)
                        @if($highlightedPost->id === 1)
                            <article class="post-item white">
                                <a href="{{ route('blog.show', $highlightedPost->slug) }}" class="no-underline">
                                    <figure class="cover-image-container relative margin-0">
                                        <i class="fa-regular fa-star absolute margin-top-0-5 margin-left-0-5 topleft fs-24 gold"
                                           title="{{ __('Highlighted post') }}"></i>
                                        <img class="round card"
                                             src="{{ asset($highlightedPost->cover_image_url) ?? asset('/images/placeholder.png') }}"
                                             alt="{{ $highlightedPost->title }}">
                                    </figure>
                                    <h3 class="margin-bottom-0 margin-top-0-5">{{ $highlightedPost->title }}</h3>
                                </a>
                            </article>
                        @endif
                    @endforeach
                </section>

                <section class="highlighted">
                    @foreach($highlightedPosts as $highlightedPost)
                        @if($highlightedPost->is_highlighted === 1 && $highlightedPost->id !== 4)
                            <article class="highlighted-post-item">
                                <section class="width-65">
                                    <time datetime="{{ $newestPosts[0]->created_at }}">
                                        {{ Carbon\Carbon::parse($highlightedPost->created_at)->translatedFormat($dtFormat) }}
                                    </time>
                                    <h3>
                                        <a href="{{ route('blog.show', $highlightedPost->slug) }}">
                                            {{ $highlightedPost->title }}
                                        </a>
                                    </h3>
                                </section>

                                <a href="{{ route('blog.show', $highlightedPost->slug) }}"
                                   class="no-underline width-45">
                                    <figure class="relative cover-image-container margin-0">
                                        <img class="round"
                                             src="{{ asset($highlightedPost->cover_image_url) ?? asset('/images/placeholder.png') }}"
                                             alt="{{ $highlightedPost->title }}">
                                    </figure>
                                </a>
                            </article>
                        @endif
                    @endforeach
                </section>
            </section>
        @else
            <p>
                No highlighted posts in the database. Run the seeder.
            </p>
        @endif
    </section>
@endsection
