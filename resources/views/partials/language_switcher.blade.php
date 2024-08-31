<div x-data="dropdownData" class="dropdown" @click.outside="hideDropdown">
    <button @click="toggleDropdown" class="button transparent"
            style="width: 60px; display: flex; padding: 2px; margin-top: 0;">
        @foreach ($available_locales as $locale_name => $available_locale)
            @if ($available_locale === $current_locale)
                <div class="flex">
                    <img style="height: auto; width: 32px;"
                         src="{{ asset('images/flags/' . $available_locale . '-flag.png' ) }}"
                         alt="{{ $locale_name }}">
                    <div class="margin-left-0-5">
                        <i class="fa fa-caret-down flex"></i>
                    </div>
                </div>
            @endif
        @endforeach

    </button>
    <div x-cloak x-show="openDropdown" class="dropdown-content bar-block"
         style="width: 48px; min-width: 48px; margin-left: 3px; margin-top: 8px; background-color: transparent;">
        @foreach ($available_locales as $locale_name => $available_locale)
            @if ($available_locale !== $current_locale)
                <a class="bar-item" style="padding: 0" title="{{ $locale_name }}" href="{{ route('lang.index', $available_locale) }}">
                    <img src="{{ asset('images/flags/' . $available_locale . '-flag.png' ) }}"
                         alt="{{ $locale_name }}" style="width: 32px;">
                </a>
            @endif
        @endforeach
    </div>
</div>

