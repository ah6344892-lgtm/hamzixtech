@extends('layouts.app')
@section('title', ($item->seo_title ?? $item->title) . ' | HamzixTech')
@section('meta_description', $item->seo_description ?? ($item->summary ?? $item->description))
@section('og_type', 'article')
@section('content')
    <article class="mx-auto max-w-7xl px-5 py-10 sm:px-8 sm:py-16">
        <a href="{{ $back }}"
            class="inline-flex items-center gap-2 text-sm font-semibold text-electric-blue transition hover:gap-3">← Back to
            {{ strtolower($type) . 's' }}</a>
        <header class="public-page-hero mt-6 px-6 py-9 sm:px-10 sm:py-12">
            <p class="public-kicker">{{ $type }}@if ($item->category)
                    · {{ $item->category->name }}
                @endif
            </p>
            <h1 class="public-page-title">{{ $item->title }}</h1>
            @if ($item->summary)
                <p class="public-page-description">{{ $item->summary }}</p>
            @endif
            <div class="mt-6 flex flex-wrap gap-2 text-xs font-medium">
                @if ($item->published_at)
                    <span
                        class="rounded-full border border-soft-border bg-white/70 px-3 py-1.5 dark:border-white/10 dark:bg-white/5">{{ $item->published_at->format('M j, Y') }}</span>
                    @endif@if ($item instanceof \App\Models\Tutorial)
                        <span
                            class="rounded-full border border-soft-border bg-white/70 px-3 py-1.5 dark:border-white/10 dark:bg-white/5">{{ ucfirst($item->difficulty) }}
                            ·
                            {{ $item->estimated_minutes ?: 'Self-paced' }}{{ $item->estimated_minutes ? ' min' : '' }}</span>
                        @endif@if ($item instanceof \App\Models\Template)
                            <span
                                class="rounded-full border border-soft-border bg-white/70 px-3 py-1.5 dark:border-white/10 dark:bg-white/5">{{ ucfirst($item->pricing_type) }}
                                resource</span>
                        @endif
            </div>
        </header>
        @php($cover = $item->main_image ?? ($item->featured_image ?? ($item->cover_image ?? ($item->thumbnail ?? null))))
        @if ($cover)
            <img src="{{ Storage::url($cover) }}"
                alt="{{ $item->main_image_alt ?? ($item->featured_image_alt ?? ($item->cover_image_alt ?? ($item->thumbnail_alt ?? ''))) }}"
                class="mt-7 max-h-[34rem] w-full rounded-3xl object-cover shadow-xl shadow-slate-900/10">
        @endif
        <div class="prose-content mx-auto mt-8 max-w-4xl rounded-2xl border border-soft-border bg-white p-6 text-base leading-8 text-muted-text shadow-sm sm:p-9 dark:border-white/10 dark:bg-slate-navy dark:text-soft-slate"
            data-tilt>{!! \Illuminate\Support\Str::markdown((string) ($item->content ?? $item->description), [
                'html_input' => 'strip',
                'allow_unsafe_links' => false,
            ]) !!}</div>
        @if ($item instanceof \App\Models\Project && $item->technologies)
            <div class="mt-8">
                <h2 class="font-semibold">Technologies</h2>
                <p class="mt-2 text-sm text-muted-text dark:text-soft-slate">{{ implode(' · ', $item->technologies) }}</p>
            </div>
        @endif
        @if ($item instanceof \App\Models\Tutorial)
            <div class="mt-6 text-sm text-muted-text dark:text-soft-slate">{{ ucfirst($item->difficulty) }}@if ($item->estimated_minutes)
                    · {{ $item->estimated_minutes }} minutes
                @endif
            </div>
        @endif
        @if ($item instanceof \App\Models\Template)
            <div class="mt-8 grid gap-4 rounded-2xl border border-soft-border p-6 sm:grid-cols-2 dark:border-white/10">
                <div>
                    <p class="text-sm text-muted-text dark:text-soft-slate">License</p>
                    <p class="font-medium">{{ $item->license ?: 'See template terms' }}</p>
                </div>
                <div>
                    <p class="text-sm text-muted-text dark:text-soft-slate">Version</p>
                    <p class="font-medium">{{ $item->version ?: 'Not specified' }}</p>
                </div>
                @foreach (['features' => 'Features', 'requirements' => 'Requirements', 'installation_instructions' => 'Installation'] as $field => $label)
                    @if ($item->$field)
                        <div class="sm:col-span-2">
                            <h2 class="font-semibold">{{ $label }}</h2>
                            <p class="mt-2 whitespace-pre-line text-sm leading-6 text-muted-text dark:text-soft-slate">
                                {{ $item->$field }}</p>
                        </div>
                    @endif
                @endforeach
            </div>
            <div class="mt-6 flex flex-wrap gap-3">
                @if ($item->demo_url)
                    <a href="{{ $item->demo_url }}" target="_blank" rel="noopener noreferrer"
                        class="rounded-lg bg-electric-blue px-4 py-2 font-semibold text-white">View demo</a>
                    @endif @if ($item->github_url)
                        <a href="{{ $item->github_url }}" target="_blank" rel="noopener noreferrer"
                            class="rounded-lg border border-soft-border px-4 py-2 font-semibold">Source code</a>
                        @endif @if ($item->download_path && $item->pricing_type === 'free')
                            <a href="{{ route('templates.download', $item) }}"
                                class="rounded-lg border border-soft-border px-4 py-2 font-semibold">Download</a>
                        @endif
            </div>
        @endif
        @if ($item instanceof \App\Models\Project)
            <div class="mt-7 flex flex-wrap gap-3">
                @if ($item->demo_url)
                    <a href="{{ $item->demo_url }}" target="_blank" rel="noopener noreferrer"
                        class="rounded-lg bg-electric-blue px-4 py-2 font-semibold text-white">Live demo</a>
                    @endif @if ($item->source_url)
                        <a href="{{ $item->source_url }}" target="_blank" rel="noopener noreferrer"
                            class="rounded-lg border border-soft-border px-4 py-2 font-semibold">Source</a>
                    @endif
            </div>
        @endif
        @if ($item->tags ?? false)
            <div class="mt-8 flex flex-wrap gap-2">
                @foreach ($item->tags as $tag)
                    @if ($item instanceof \App\Models\Post)
                        <a href="{{ route('blog.tag', $tag->slug) }}"
                        class="rounded-full bg-electric-blue/10 px-3 py-1 text-xs font-medium text-electric-blue">#{{ $tag->name }}</a>@else<span
                            class="rounded-full bg-electric-blue/10 px-3 py-1 text-xs font-medium text-electric-blue">#{{ $tag->name }}</span>
                    @endif
                @endforeach
            </div>
        @endif
    </article>
@endsection
