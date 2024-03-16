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
                <li>{{ __('Manage Documentation') }}</li>
            </ol>
        </nav>

        <h1 class="h3 margin-top-bottom-0">{{ __('Manage Documentation') }}</h1>

        <div class="main-content">

            <!-- Create new post -->
            <a href="{{ route('document.create') }}"
               class="primary button"
               title="{{ __('Create new doc') }}">
                <i class="fa fa-plus" aria-hidden="true"></i>
                {{ __('New doc') }}
            </a>

            <livewire:admin.document.documents></livewire:admin.document.documents>

            <livewire:admin.document.delete title="{{ __('Delete document') }}"  :modalId="'m-delete-document'"></livewire:admin.document.delete>
        </div>
    </main>
@endsection

