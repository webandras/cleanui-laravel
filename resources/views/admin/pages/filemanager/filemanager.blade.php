@extends('admin.layouts.admin-filemanager')

@section('content')

    <main class="padding-1">
        <h1 class="h2">{{ __('File manager') }}</h1>
        <a class="btn btn-secondary" href="{{ route('dashboard') }}">{{ __('Back go dashboard') }}</a>
        <hr>

        <div id="fm" style="height: 800px;"></div>
    </main>
@endsection




