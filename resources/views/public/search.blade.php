@extends('layouts.app')
@section('title', 'Search | HamzixTech')
@section('meta_description', 'Search published HamzixTech resources.')
@section('robots', 'noindex,follow')
@section('content')
    <section class="mx-auto max-w-5xl px-5 py-10 sm:px-8 sm:py-16">
        <header class="public-page-hero px-6 py-9 sm:px-9 sm:py-11" data-tilt>
            <p class="public-kicker">Search library</p>
            <h1 class="public-page-title text-4xl sm:text-5xl">Find your next useful idea.</h1>
            <p class="public-page-description">Search articles, tutorials, templates, tools, and project examples.</p>
            <form action="{{ route('search') }}" method="get" class="public-filter mt-7 flex flex-col gap-2 sm:flex-row">
                <label class="sr-only" for="search-query">Search</label><input id="search-query" name="q"
                    value="{{ $q }}" placeholder="Try “Laravel” or “responsive”"
                    class="min-w-0 flex-1 rounded-xl border-0 bg-transparent px-4 py-3 outline-none focus:ring-2 focus:ring-electric-blue dark:text-white"><select
                    name="type" class="rounded-xl border-0 bg-light-background px-4 py-3 dark:bg-deep-navy">
                    @foreach (['all' => 'Everything', 'posts' => 'Blog', 'tutorials' => 'Tutorials', 'templates' => 'Templates', 'tools' => 'Tools', 'projects' => 'Projects'] as $value => $label)
                        <option value="{{ $value }}" @selected($type === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                <flux:button type="submit" variant="primary" color="blue">Search</flux:button>
            </form>
        </header>
        <p class="mt-8 text-sm text-muted-text dark:text-soft-slate">{{ $results->count() }} result(s) for
            “{{ $q }}”</p>
        @if ($results->isEmpty())
            <div class="public-empty mt-4 text-center"><span
                    class="mx-auto flex size-11 items-center justify-center rounded-xl bg-electric-blue/10 text-electric-blue">
                    <flux:icon icon="magnifying-glass" variant="mini" />
                </span>
                <h2 class="mt-3 font-semibold">No matches found</h2>
                <p class="mt-1 text-sm text-muted-text dark:text-soft-slate">Try a shorter phrase or search another resource
                    type.</p>
        </div>@else<div
                class="mt-4 divide-y divide-soft-border overflow-hidden rounded-2xl border border-soft-border bg-white dark:divide-white/10 dark:border-white/10 dark:bg-slate-navy">
                @foreach ($results as $result)
                    <a href="{{ $result['url'] }}" class="block p-5 transition hover:bg-electric-blue/[.04] sm:p-6"
                        data-tilt>
                        <p class="text-[11px] font-bold uppercase tracking-[.13em] text-electric-blue">{{ $result['type'] }}
                        </p>
                        <h2 class="mt-1 font-semibold">{{ $result['title'] }}</h2>
                        <p class="mt-1 text-sm leading-6 text-muted-text dark:text-soft-slate">{{ $result['summary'] }}</p>
                    </a>
                @endforeach
            </div>
        @endif
    </section>
@endsection
