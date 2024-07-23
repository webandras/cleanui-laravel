@extends('public.layouts.auth')

@section('content')
    <main class="card content-600">

        <div class="header">
            <h1 class="h3 text-white">{{ __('Register') }}</h1>
        </div>

        <div class="padding-1-5">
            @php $error = session('login_error') @endphp
            @isset($error)
                <div class="alert error" role="alert">
                    {{ $error }}
                </div>
            @endisset

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <label for="name" class="margin-top-0">{{ __('Name') }}</label>
                <input
                    id="name"
                    type="text"
                    class="@error('name') border border-dark-red @enderror"
                    name="name"
                    value="{{ old('name') }}"
                    required
                    autocomplete="name"
                    autofocus
                >

                @error('name')
                <span role="alert">
                    <strong class="text-red fs-14">{{ $message }}</strong>
                </span>
                @enderror

                <label for="email">{{ __('Email Address') }}</label>
                <input
                    id="email"
                    type="email"
                    class="@error('email') border border-dark-red @enderror"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                >

                @error('email')
                <span role="alert"><strong class="text-red fs-14">{{ $message }}</strong></span>
                @enderror

                <label for="password">{{ __('Password') }}</label>
                <input
                    id="password"
                    type="password"
                    class="@error('password') border border-dark-red @enderror"
                    name="password"
                    required
                    autocomplete="new-password"
                >

                @error('password')
                <span role="alert"><strong class="text-red fs-14">{{ $message }}</strong></span>
                @enderror

                <label for="password-confirm">{{ __('Confirm Password') }}</label>
                <input
                    id="password-confirm"
                    type="password"
                    name="password_confirmation"
                    required
                    autocomplete="new-password"
                >

                <button type="submit" class="primary margin-top-1-5 block increased-button-padding">{{ __('Register') }}</button>

                <hr>

                {{-- Login with Facebook --}}
                <a class="facebook-login-button button flex justify-center align-items-center text-center relative" href="{{ route('facebook.redirect') }}">
                    <img class="margin-right-0-5" style="height: 26px;" src="{{ asset('images/social/facebook.png') }}"
                         alt="Facebook logo"> {{ __('Sign in with Facebook') }}
                </a>

                {{-- Login with Google --}}
                <div>
                    <a class="google-login-button button flex justify-center align-items-center text-center relative" href="{{ route('google.redirect') }}">
                        <img class="margin-right-0-5" style="height: 26px;"
                             src="{{ asset('images/social/google.png') }}" alt="Google logo"> <span
                            class="text-center">{{ __('Sign in with Google') }}</span>
                    </a>
                </div>

            </form>
        </div>

    </main>
@endsection
