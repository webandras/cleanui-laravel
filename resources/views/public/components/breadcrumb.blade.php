<nav class="breadcrumb {{ isset($centerAlign) ? 'breadcrumb-center' : '' }}">
    <ol>
        <li>
            <a href="{{ $homeLink ?? route('frontpage') }}">
                <i class="fa fa-home" aria-hidden="true"></i>
                {{ $homeLabel ?? __('Home') }}
            </a>
        </li>
        <li>
            <i class="fa-solid fa-angle-right"></i>
        </li>
        <li>{{ $title }}</li>
    </ol>
</nav>
