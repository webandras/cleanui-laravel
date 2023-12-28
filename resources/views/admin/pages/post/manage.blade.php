@extends('admin.layouts.admin')

@section('content')

    <main class="padding-1">
        <nav class="breadcrumb breadcrumb-left">
            <ol>
                <li>
                    <a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
                </li>
                <li>
                    <i class="fa-solid fa-angle-right"></i>
                </li>
                <li>{{ __('Manage Posts') }}</li>
            </ol>
        </nav>

        <h1 class="h3 margin-top-bottom-0">{{ __('Manage posts') }}</h1>

        <div class="main-content">

            <!-- Create new post -->
            <a href="{{ route('post.create') }}"
               class="primary button"
               title="{{ __('Create new post') }}">
                <i class="fa fa-plus" aria-hidden="true"></i>
                {{ __('New post') }}
            </a>


            <table>
                <thead>
                <tr class="fs-14">
                    <th>#</th>
                    <th>{{ __('Article') }}</th>
                    <th>{{ __('Actions') }}</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $index = 1;
                    $currentPage = $posts->currentPage()
                @endphp
                @foreach($posts as $post)
                    <tr>
                        <td>
                            @if($currentPage > 1)
                                {{ ($currentPage - 1) * $posts->perPage() + $index++ }}.
                            @else
                                {{ $index++ }}.
                            @endif
                        </td>
                        <td>
                            <h2 class="padding-right-0-5 h3 margin-top-bottom-0">
                                {{ $post->title }}
                                @if ($post->is_highlighted)
                                    <i class="fa-regular fa-star goldenrod"
                                       title="{{ __('Highlighted post') }}"></i>
                                @endif
                            </h2>
                            <small>/{{ $post->slug }}</small>

                            <div class="flex flex-row margin-top-0-5">
                                <span
                                    class="badge fs-12 medium {{ $postStatusColors[$post->status] }}">{{ $postStatuses[$post->status] }}</span>
                                <span class="fs-12 medium">{{ $post->created_at }}</span>
                            </div>

                            <br>

                            @isset ($post->cover_image_url)
                                <img src="{{ asset($post->cover_image_url) }}" alt="{{__('Cover image preview') }}"
                                     class="hover-opacity border" width="140px">
                            @endisset
                            <p class="fs-16">{{ $post->excerpt ?? '' }}</p>

                            <hr class="divider">
                            <div class="padding-bottom-0-5">
                                @if($post->categories->count() > 0)
                                    @foreach($post->categories as $cat)
                                        <span
                                            class="badge fs-12 gray-60 text-white">{{ $cat->name }}</span>
                                    @endforeach
                                @else
                                    <p class="fs-14">{{__('No associated category.')}}</p>
                                @endif
                            </div>
                        </td>
                        <td>
                            <div class="flex flex-row">

                                @if(auth()->user()->hasRoles('super-administrator|administrator') )

                                    <!-- View post -->
                                    <a href="#"
                                       target="_blank"
                                       title="View post"
                                       class="button success margin-top-0"
                                    >
                                        <i class="fa-solid fa-eye"></i>
                                        {{ __('View') }}
                                    </a>

                                    <!-- Edit post -->
                                    <a href="{{ route('post.edit', $post->id) }}"
                                       class="button info margin-top-0"
                                       title="{{ __('Edit post') }}">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                        {{ __('Edit') }}
                                    </a>


                                    <!-- Delete post -->
                                    <livewire:admin.post.delete title="{{ __('Delete post') }}"
                                                                :post="$post"
                                                                :hasSmallButton="false"
                                                                :modalId="'m-delete-post-' . $post->id"
                                    >
                                    </livewire:admin.post.delete>
                                @endif
                            </div>

                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>

            @if (isset($posts))
                {{ $posts->links('global.components.pagination', [ 'pageName' => 'page']) }}
            @endif

        </div>
    </main>
@endsection
