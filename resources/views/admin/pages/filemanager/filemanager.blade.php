@extends('admin.layouts.admin-filemanager')

@section('content')

    <main class="padding-1">
        <h1 class="h2">{{ __('File manager') }}</h1>
        <a class="btn btn-secondary" href="{{ route('dashboard') }}">{{ __('Back go dashboard') }}</a>
        <hr>
        <style>
            #fm {
                height: 800px;
            }

            .fm {
                padding: 0;
            }

            #fm .fm-modal .modal-dialog .modal-content {
                max-width: 600px;
                margin: 0 auto;
                background-color: rgba(255, 255, 255, 0.9);
                padding: 1em;
                border-radius: 0.25em;
                margin-top: 1em;
            }

            #fm .fm-navbar .row .col-auto .btn-group {
                margin-bottom: 1em;
            }
        </style>

        <div id="fm" style="height: 800px;"></div>
    </main>
@endsection




