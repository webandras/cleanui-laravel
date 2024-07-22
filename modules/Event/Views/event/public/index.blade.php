@extends('public.layouts.frontpage')

@section('seo')
    <x-public::meta
        :title="__('Upcoming Events')"
        :excerpt="__('Upcoming events')"
        :url="route('event.index')"
    ></x-public::meta>
@endsection

@section('content')

    <section class="event-calendar-container container margin-bottom-3">
        <h1 class="h2 margin-bottom-0 margin-top-0-5">{{ __('Upcoming Events') }}</h1>
        <section>
            <livewire:public.event.widget></livewire:public.event.widget>
            <hr>
        </section>
        <section>
            <livewire:public.event.calendar></livewire:public.event.calendar>
        </section>

    </section>
@endsection



