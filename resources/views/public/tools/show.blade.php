@extends('layouts.app')
@section('title', ($tool->seo_title ?: $tool->title) . ' | HamzixTech')
@section('meta_description', $tool->seo_description ?: $tool->description)
@section('content')
    <section class="mx-auto max-w-4xl px-5 py-14 sm:px-8 sm:py-20">
        <a href="{{ route('tools.index') }}" class="text-sm font-semibold text-electric-blue">← All tools</a>
        <header class="public-page-hero mt-6 px-6 py-8 sm:px-8 sm:py-10" data-tilt>
            <p class="public-kicker">Developer utility</p>
            <h1 class="public-page-title text-4xl sm:text-5xl">{{ $tool->title }}</h1>
            <p class="public-page-description">{{ $tool->description }}</p>
            <p class="mt-5 text-xs font-medium text-muted-text dark:text-soft-slate">Private by default · Input is not saved
            </p>
        </header>
        <div class="public-workbench mt-8" data-tilt>
            @if (config('hamzixtech.ui_mode') === 'livewire')
                <livewire:public.tool-workbench :slug="$tool->slug" />
            @else
                @include('public.tools.simple-workbench')
            @endif
        </div>
        <p class="mt-4 text-xs text-muted-text dark:text-soft-slate">{{ $tool->instructions }}</p>
    </section>
@endsection
