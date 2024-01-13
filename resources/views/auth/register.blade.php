@extends('auth.layouts.public')

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

                <label for="name">{{ __('Name') }}</label>
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

                <button type="submit" class="primary margin-top-1-5">{{ __('Register') }}</button>


                <hr class="divider">

                {{-- Login with Facebook --}}
                <div>
                    <a class="button primary" href="{{ route('facebook.redirect') }}"
                       style="background: #3B5499; color: #ffffff; padding: 10px; width: 100%; display: block;">
                        <i class="fa-brands fa-facebook-f"></i> Register with Facebook
                    </a>
                </div>

                {{-- Login with Google --}}
                <div>
                    <a class="button primary" href="{{ route('google.redirect') }}"
                       style="background: #217bff; color: #ffffff; padding: 10px; width: 100%; display: block;">
                        <i class="fa-brands fa-google"></i> Register with Google
                    </a>
                </div>

            </form>
        </div>

    </main>
@endsection
