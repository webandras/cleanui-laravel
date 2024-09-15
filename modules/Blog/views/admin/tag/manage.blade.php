@extends('admin.layouts.admin')

@section('banner')
    <livewire:global.banner></livewire:global.banner>
@endsection

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
                <li>{{ __('Manage Tags') }}</li>
            </ol>
        </nav>

        <h1 class="h3 margin-top-bottom-0">{{ __('Manage tags') }}</h1>

        <div class="main-content margin-top-1">

            @php
                $activeTab = session('flash.activeTab') ?? 'Tags';
            @endphp

            <div x-data="tabsData( @js($activeTab) )" class="border border-40 round">

                <div class="bar roles-permissions-bar">
                    <a id="TagsTrigger"
                       href="#"
                       role="button"
                       aria-label="{{ __('Tags') }}"
                       class="bar-item tab-switcher"
                       @click="switchTab('Tags')"
                       :class="{'tab-switcher-active': tabId === 'Tags'}"
                    >
                        {{ __('Tags') }}
                    </a>

                    <a id="ArchiveTrigger"
                       href="#"
                       role="button"
                       aria-label="{{ __('Archive') }}"
                       class="bar-item tab-switcher"
                       @click="switchTab('Archive')"
                       :class="{'tab-switcher-active': tabId === 'Archive'}"
                    >
                        {{ __('Archive') }}
                    </a>
                </div>

                <div id="Tags" class="box tabs animate-opacity">
                    <livewire:admin.blog.tag.index></livewire:admin.blog.tag.index>
                </div>

                <div id="Archive" class="box tabs animate-opacity">
                    <livewire:admin.blog.tag.archive></livewire:admin.blog.tag.archive>
                </div>
            </div>

        </div>
    </main>
@endsection
