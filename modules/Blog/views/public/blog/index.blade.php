@extends('public.layouts.frontpage')

@section('seo')
    <x-public::meta
        :title="__('Blog')"
        :excerpt="__('Blog description')"
        :url="route('blog.index')"
    ></x-public::meta>
@endsection


@section('content')
    <div class="card">

        <h1 class="text-left margin-top-0 margin-bottom-0-5">{{ __('Newest articles') }}</h1>

        @if ($newestPosts->count() === 0)
            <p>No posts in the database. Run the seeder.</p>
        @else
            <section class="intro">
                <div class="left-panel-1">
                    <article class="card margin-bottom-0">
                        <a href="{{ route('blog.show', $newestPosts[0]->slug) }}" class="no-underline">
                            <div class="relative cover-image-container">
                                <img class="round-top" src="{{ $newestPosts[0]->cover_image_url }}"
                                     alt="{{ $newestPosts[0]->title }}">
                            </div>
                        </a>
                        <div class="padding-left-right-1">
                            <div
                                class="date fs-14">{{ Carbon\Carbon::parse($newestPosts[0]->created_at)->translatedFormat($dtFormat) }}</div>
                            <h2 class="margin-top-0 h4 text-white fs-20 margin-bottom-45">
                                <a href="{{ route('blog.show', $newestPosts[0]->slug) }}" class="no-underline">
                                    {{ $newestPosts[0]->title }}
                                </a>
                            </h2>
                            <a href="{{ route('blog.show', $newestPosts[0]->slug) }}"
                               class="button read-more margin-top-0">
                                {{ __('Read more') }}<i class="fa-solid fa-angles-right margin-left-0-5"></i>
                            </a>
                        </div>
                    </article>

                </div>
                <div class="right-panel-2">

                    @for($i = 1; $i <= 2; $i++)
                        <article>
                            <a href="{{ route('blog.show', $newestPosts[$i]->slug) }}" class="no-underline">
                                <div class="relative cover-image-container card">
                                    <img class="round"
                                         src="{{ asset($newestPosts[$i]->cover_image_url) ?? asset('/images/placeholder.png') }}"
                                         alt="{{ $newestPosts[0]->title }}"
                                    >
                                </div>
                            </a>
                            <div class="padding-top-bottom-0-5">
                                <h2 class="margin-top-bottom-0 h4 fs-18">
                                    <a href="{{ route('blog.show', $newestPosts[$i]->slug) }}" class="no-underline">
                                        {{ $newestPosts[$i]->title }}
                                    </a>
                                </h2>
                            </div>

                        </article>
                    @endfor
                </div>
                <div class="side-panel-4">

                    <h2>{{ __('Additional articles') }}</h2>

                    <ul class="no-bullets">
                        @for($i = 3; $i < $newestPosts->count(); $i++)
                            <li>
                                <article>
                                    <div
                                        class="date fs-14">{{ Carbon\Carbon::parse($newestPosts[$i]->created_at)->translatedFormat($dtFormat) }}</div>
                                    <h3 class="fs-18">
                                        <a href="{{ route('blog.show', $newestPosts[$i]->slug) }}" class="no-underline">
                                            {{$newestPosts[$i]->title }}</a>
                                    </h3>
                                </article>
                            </li>
                        @endfor
                    </ul>

                </div>

            </section>

        @endif

        <hr>

        <livewire:public.blog.post.post-grid></livewire:public.blog.post.post-grid>


        <section>
            <div class="most-popular-categories-title">
                <h2>{{ __('Most popular categories') }}</h2>
                <div class="separator"></div>
            </div>
            @if ($categories->count() > 0)
            <nav class="categories-container">
                @foreach($categories as $cat)

                    <a class="fs-16" href="{{ route('blog.category', $cat->slug) }}">{{ $cat->name }}</a>
                @endforeach
            </nav>
            @else
            <p>No categories in the database. Run the seeder.</p>
            @endif
        </section>

        <hr>

        @if ($highlightedPosts->count() > 0)
        <section class="highlighted-posts-container">
            <div class="featured">
                @foreach($highlightedPosts as $highlightedPost)
                    @if($highlightedPost->id === 1)
                        <article class="post-item white">
                            <a href="{{ route('blog.show', $highlightedPost->slug) }}" class="no-underline">
                                <div class="cover-image-container relative">
                                    <i class="fa-regular fa-star absolute margin-top-0-5 margin-left-0-5 topleft fs-24 gold"
                                       title="{{ __('Highlighted post') }}"></i>
                                    <img class="round card"
                                         src="{{ asset($highlightedPost->cover_image_url) ?? asset('/images/placeholder.png') }}"
                                         alt="{{ $highlightedPost->title }}">
                                </div>
                                <div>
                                    <h3 class="margin-bottom-0 margin-top-0-5">{{ $highlightedPost->title }}</h3>
                                </div>
                            </a>
                        </article>
                    @endif
                @endforeach
            </div>


            <div class="highlighted">
                @foreach($highlightedPosts as $highlightedPost)
                    @if($highlightedPost->is_highlighted === 1 && $highlightedPost->id !== 4)
                        <article class="highlighted-post-item">
                            <div class="width-65">
                                <span
                                    class="">{{ Carbon\Carbon::parse($highlightedPost->created_at)->translatedFormat($dtFormat) }}</span>
                                <h3>
                                    <a href="{{ route('blog.show', $highlightedPost->slug) }}">
                                        {{ $highlightedPost->title }}
                                    </a>
                                </h3>
                            </div>

                            <a href="{{ route('blog.show', $highlightedPost->slug) }}"
                               class="no-underline width-45">
                                <div class="relative cover-image-container">
                                    <img class="round-top"
                                         src="{{ asset($highlightedPost->cover_image_url) ?? asset('/images/placeholder.png') }}"
                                         alt="{{ $highlightedPost->title }}">
                                </div>
                            </a>

                        </article>
                    @endif
                @endforeach
            </div>

        </section>
        @else
            <p>No highlighted posts in the database. Run the seeder.</p>
        @endif


    </div>

@endsection
