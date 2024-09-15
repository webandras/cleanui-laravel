@if ($errors->any())
    <section class="margin-top-0-5" {{ $attributes }}>
        <h3 class="fs-14 bold red round padding-left-right-1 padding-top-bottom-0-5"
             style="width: fit-content"
        >{{ __('Whoops! Something went wrong.') }}</h3>

        <ul class="margin-top-0-5">
            @foreach ($errors->all() as $error)
                <li class="text-red">{{ $error }}</li>
            @endforeach
        </ul>
    </section>
@endif
