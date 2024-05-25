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
                <li>{{ __('My Account') }}</li>
            </ol>
        </nav>

        <div class="main-content">

            <h1 class="h2 margin-0">{{ __('My Account') }}</h1>

            <form action="{{ route('user.update', $user->id ) }}"
                  method="POST"
                  enctype="application/x-www-form-urlencoded"
                  accept-charset="UTF-8"
                  autocomplete="off"
                  class="content-600"
            >
                @method("PUT")
                @csrf

                <x-global::validation-errors/>

                <fieldset>
                    <!-- Name -->
                    <label for="name">{{ __('Name') }}<span class="text-red">*</span></label>
                    <input
                        type="text"
                        class="{{ $errors->has('name') ? 'border border-red' : '' }}"
                        name="name"
                        id="name"
                        value="{{ $user->name ?? old('name') }}"
                    >
                    <x-global::input-error for="name"/>


                    <!-- Email -->
                    <label for="email">{{ __('Email (can not be changed)') }}</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="{{ $user->email }}"
                        readonly
                    >
                    <x-global::input-error for="email"/>


                    <!-- Password -->
                    <label for="password">{{ __('New Password (optional)') }}</label>
                    <input
                        type="text"
                        class="{{ $errors->has('password') ? 'border border-red' : '' }}"
                        name="password"
                        id="password"
                        value="{{ old('password') }}"
                    >
                    <x-global::input-error for="password"/>


                    <div class="checkbox-container">
                        <label for="enable2fa">
                            <input name="enable2fa"
                                   id="enable2fa"
                                   type="checkbox"
                                   value="1"
                                {{ old('enable2fa', $user->enable_2fa !== 0 ? 'checked' : '') }}
                            >
                            {{ __('Enable Two Factor Authentication') }}
                        </label>

                        <x-global::input-error for="enable2fa"/>

                    </div>

                </fieldset>


                <hr>


                <fieldset id="settings">
                    <legend>
                        <h2 class="h4">{{ __('Your Preferences') }}</h2>
                    </legend>


                    <!-- Language -->
                    <label for="locale">{{ __('Your language') }}<span class="text-red">*</span></label>
                    <select
                        class="{{ $errors->has('preferences[locale]') ? 'border border-red' : '' }}"
                        aria-label="{{ __("Select your language") }}"
                        name="preferences[locale]"
                        id="locale"
                    >
                        @if(!isset($userPreferences))
                            @foreach ($languagesArray as $key => $value)
                                <option {{ $value === $defaultLocale ? "selected": "" }} value="{{ $value }}">{{ $key }}</option>
                            @endforeach
                        @else
                            @foreach ($languagesArray as $key => $value)
                                <option {{ $userPreferences->locale === $value ? "selected": "" }} value="{{ $value }}">{{ $key }}</option>
                            @endforeach
                        @endif
                    </select>

                    <x-global::input-error for="locale" />


                    <label class="bold">{{ __('Select the timezone') }}</label>

                    <select
                        class="{{ $errors->has('preferences[timezone]') ? 'border border-red' : '' }}"
                        aria-label="{{ __("Select the timezone") }}"
                        name="preferences[timezone]"
                        id="timezone"
                    >
                        @if(!isset($userPreferences))
                            @foreach ($timezoneIdentifiers as $value)
                                <option {{ $value === $defaultTimezone ? "selected" : "" }} value="{{ $value }}">{{ $value }}</option>
                            @endforeach
                        @else
                            @foreach ($timezoneIdentifiers as $value)
                                <option {{ $userPreferences->timezone === $value ? "selected" : "" }} value="{{ $value }}">{{ $value }}</option>
                            @endforeach
                        @endif;
                    </select>


                    <div class="checkbox-container">
                        <label for="darkmode">
                            <input name="preferences[darkmode]"
                                   id="darkmode"
                                   type="checkbox"
                                   value="1"
                                {{ old('preferences[darkmode]', (isset($userPreferences) && $userPreferences->darkmode === 1) ? 'checked' : '') }}
                            >
                            {{ __('Enable dark mode by default') }}
                        </label>

                        <x-global::input-error for="preferences.darkmode"/>
                    </div>


                </fieldset>

                <button type="submit" class="primary"><i class="fa-regular fa-floppy-disk margin-right-0-5"></i>{{ __("Save changes") }}</button>
            </form>

            <hr>

            <h2 class="h3">{{ __('Delete account') }}</h2>

            <div class="alert danger content-800">
                <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                {{ __('This action cannot be undone. It will permanently erase your account with all of your data.') }}
            </div>

                <div x-data="modalData">

                    <button @click="openModal()" class="danger">
                        <i class="fa-solid fa-trash-can" aria-hidden="true"></i>
                        <span>{{ __('Delete account?') }}</span>
                    </button>

                    <x-global::form-modal trigger="modal"
                                          title="{{ __('Are you sure you want to delete your account?') }}"
                                          id="delete-account-{{$user->id}}">

                        <form action="{{ route('user.account.delete', $user->id ) }}"
                              method="POST"
                              enctype="application/x-www-form-urlencoded"
                              accept-charset="UTF-8"
                              autocomplete="off"
                        >
                            @csrf
                            @method('DELETE')

                            <p>{{ __('Type in your password to delete your account. This action cannot be undone. ') }}</p>


                            <!-- Password -->
                            <label for="password-2">{{ __('Password') }}<span class="text-red">*</span></label>
                            <input
                                type="text"
                                name="password"
                                id="password-2"
                                value=""
                            >

                            <div class="actions">
                                <button type="submit" class="danger">{{ __('Delete account') }}</button>
                                <button type="button" class="danger alt" @click="closeModal()">
                                    {{ __('Cancel') }}
                                </button>
                            </div>

                        </form>

                    </x-global::form-modal>
                </div>

        </div>

    </main>
@endsection


@push('scripts')
    <script src="{{ url('assets/jquery/jquery-3.7.1.js') }}"></script>
    <script src="{{ url('assets/switcher/jquery.simpleswitch.js') }}"></script>
    <script src="{{ url('assets/tom-select/tom-select-2.2.2.js') }}"></script>

    <script nonce="{{ csp_nonce() }}">
        jQuery(document).ready(function ($) {
            // Switcher
            $('#enable2fa').simpleSwitch();
            $('#darkmode').simpleSwitch();


            new TomSelect("#timezone", {
                maxItems: 1,
                plugins: ['remove_button'],
            });

            new TomSelect("#locale", {
                maxItems: 1,
                plugins: ['remove_button'],
            });
        });
    </script>
@endpush
