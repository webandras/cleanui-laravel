<section>
    <section class="public-post-grid">
        @foreach($posts as $post)
            <article class="post-item card">
                <a href="{{ route('blog.show', $post->slug) }}" class="no-underline">
                    <div class="relative cover-image-container">
                        <time class="badge fs-12 round-1 absolute topleft margin-left-1 margin-top-0-5 z-10">
                            {{ Carbon\Carbon::parse($post->created_at)->translatedFormat($dtFormat) }}
                        </time>
                        <img class="round-top hover-opacity" src="{{ asset($post->cover_image_url) }}"
                             alt="{{ $post->title }}">
                    </div>
                    <div class="padding-1">
                        <h2 class="margin-top-bottom-0 text-white fs-24">
                            {{ $post->title }}
                        </h2>
                        <p class="text-gray-10">
                            {{ substr($post->excerpt, 0, 128) . '...' }}
                        </p>
                    </div>
                </a>
            </article>
        @endforeach
    </section>
    @if (isset($posts))
        {{ $posts->links('global.components.pagination-livewire', ['pageName' => 'page']) }}
    @endif
</section>
