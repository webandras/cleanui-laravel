<section>
    <div class="public-post-grid">
        @php
            // setlocale(LC_ALL, 'hu_HU.UTF-8');
            $dtFormat = 'Y. F j.';
        @endphp
        @foreach($posts as $post)
            <article class="post-item card">

                <a href="{{ route('blog.show', $post->slug) }}" class="no-underline">
                    <div class="relative cover-image-container">
                            <span
                                class="badge round-1 absolute bottomleft margin-left-0-5 margin-bottom-0-5">{{ Carbon\Carbon::parse($post->created_at)->translatedFormat($dtFormat) }}</span>
                        <img class="round-top" src="{{ asset($post->cover_image_url) }}" alt="{{ $post->title }}">
                    </div>
                    <div class="padding-1">
                        <h2 class="margin-top-bottom-0 text-white fs-20">{{ $post->title }}</h2>
                    </div>
                </a>

            </article>
        @endforeach
    </div>
    @if (isset($posts))
        {{ $posts->links('global.components.pagination-livewire', ['pageName' => 'page']) }}
    @endif
</section>
